<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

// Cabeçalhos de segurança
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');

require_once '../../app/config/conexaodb.php';

// Função para limpar e sanitizar arrays
function limparArray($arr, $maxLength = 100) {
    if (!is_array($arr)) return [];
    return array_filter(array_map(function($item) use ($maxLength) {
        $item = trim($item);
        $item = substr($item, 0, $maxLength);
        return htmlspecialchars($item, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }, $arr));
}

// Função para exibir mensagens
function exibirMensagem($tipo, $mensagem, $redirecionarPara = '../../../frontend/src/pages/dashboard.php') {
    $corFundoCard = '#2c2c2c';
    $corBorda = $tipo === 'sucesso' ? '#28a745' : '#dc3545';
    $corTexto = '#ffffff';
    $corDestaque = $tipo === 'sucesso' ? '#28a745' : '#dc3545';

    // Se for sucesso e tiver URL de redirecionamento, faz redirect após 2 segundos
    if ($tipo === 'sucesso' && !empty($redirecionarPara)) {
        echo "<meta http-equiv='refresh' content='2;url={$redirecionarPara}'>";
    }

    echo "
    <style>
        body {
            background-color: #f0f0f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: {$corTexto};
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card-mensagem {
            background-color: {$corFundoCard};
            border: 2px solid {$corBorda};
            border-radius: 12px;
            padding: 30px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.6);
        }
        .card-mensagem h1 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: {$corDestaque};
        }
        .card-mensagem p {
            font-size: 1rem;
            margin-bottom: 20px;
            color: #e0e0e0;
        }
        .card-mensagem a {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            color: #ffffff;
            background-color: {$corDestaque};
            transition: background-color 0.3s ease;
        }
        .card-mensagem a:hover {
            filter: brightness(0.9);
        }
    </style>
    <div class='card-mensagem'>
        <h1>" . ($tipo === 'sucesso' ? 'Sucesso!' : 'Erro') . "</h1>
        <p>{$mensagem}</p>
        <a href='{$redirecionarPara}'>Acessar Dashboard</a>
    </div>
    ";
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método de requisição inválido.');
    }

    // Validação de sessão e usuário autenticado
    if (empty($_SESSION['usuario_id']) || !is_numeric($_SESSION['usuario_id'])) {
        throw new Exception('Usuário não autenticado. Faça login novamente.');
    }

    $usuario_id = (int) $_SESSION['usuario_id'];

    // Verifica se o perfil do usuário existe
    $stmtCheckPerfil = $pdo->prepare("SELECT COUNT(*) FROM dados_pessoais WHERE id = :usuario_id");
    $stmtCheckPerfil->execute([':usuario_id' => $usuario_id]);
    if ($stmtCheckPerfil->fetchColumn() == 0) {
        throw new Exception('Usuário não encontrado no sistema.');
    }

    // Sanitiza e limpa os dados recebidos
    $jogos = limparArray(filter_input(INPUT_POST, 'jogos', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY));
    $times = limparArray(filter_input(INPUT_POST, 'times', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY));
    $eventos = trim(filter_input(INPUT_POST, 'eventos', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $eventos = substr($eventos, 0, 255);
    $eventos = htmlspecialchars($eventos, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    if (empty($jogos) && empty($times) && empty($eventos)) {
        throw new Exception('Preencha pelo menos um dos campos do perfil.');
    }

    $pdo->beginTransaction();

    // Exclui dados antigos
    $stmtDeleteEventos = $pdo->prepare("DELETE FROM eventos WHERE perfil_id = :perfil_id");
    $stmtDeleteEventos->execute([':perfil_id' => $usuario_id]);

    $stmtDeleteJogos = $pdo->prepare("DELETE FROM perfil_jogo WHERE perfil_id = :perfil_id");
    $stmtDeleteJogos->execute([':perfil_id' => $usuario_id]);

    $stmtDeleteTimes = $pdo->prepare("DELETE FROM perfil_time WHERE perfil_id = :perfil_id");
    $stmtDeleteTimes->execute([':perfil_id' => $usuario_id]);

    // Insere novos dados
    if (!empty($eventos)) {
        $stmtEvento = $pdo->prepare("INSERT INTO eventos (perfil_id, evento) VALUES (:perfil_id, :evento)");
        $stmtEvento->execute([':perfil_id' => $usuario_id, ':evento' => $eventos]);
    }

    if (!empty($jogos)) {
        $stmtJogo = $pdo->prepare("INSERT INTO perfil_jogo (perfil_id, jogo) VALUES (:perfil_id, :jogo)");
        foreach ($jogos as $jogo) {
            $stmtJogo->execute([':perfil_id' => $usuario_id, ':jogo' => strtoupper($jogo)]);
        }
    }

    if (!empty($times)) {
        $stmtTime = $pdo->prepare("INSERT INTO perfil_time (perfil_id, time) VALUES (:perfil_id, :time)");
        foreach ($times as $time) {
            $stmtTime->execute([':perfil_id' => $usuario_id, ':time' => strtoupper($time)]);
        }
    }

    $pdo->commit();

    // Redireciona para o dashboard após sucesso
    $urlDashboard = '../../../frontend/src/pages/dashboard.php';
    exibirMensagem('sucesso', 'Perfil salvo com sucesso! Redirecionando...', $urlDashboard);

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $erro = htmlspecialchars($e->getMessage(), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    exibirMensagem('erro', $erro);
}
?>
