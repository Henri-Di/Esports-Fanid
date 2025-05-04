<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

// Cabeçalhos de segurança
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');

require_once '../../app/config/conexaodb.php'; // Arquivo de conexão com o banco de dados

// Função para limpar entrada do usuário (extra proteção)
function limparEntrada($dados) {
    return htmlspecialchars(trim($dados), ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

// Função para exibir mensagens
function exibirMensagem($tipo, $mensagem, $voltarPara = '../../../index.php') {
    $corFundoCard = '#2c2c2c';
    $corBorda = $tipo === 'sucesso' ? '#28a745' : '#dc3545';
    $corTexto = '#ffffff';
    $corDestaque = $tipo === 'sucesso' ? '#28a745' : '#dc3545';

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
        <a href='{$voltarPara}'>Voltar</a>
    </div>
    ";
    exit;
}

// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validação dos campos obrigatórios
    if (empty($_POST['email']) || empty($_POST['senha'])) {
        exibirMensagem('erro', 'Preencha todos os campos!', '../../../index.php');
    }

    // Limpeza e obtenção dos dados do formulário
    $email = limparEntrada($_POST['email']);
    $senha = $_POST['senha']; // senha não limpamos com htmlspecialchars porque será verificada

    // Validação extra do formato do e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exibirMensagem('erro', 'E-mail inválido!', '../../../index.php');
    }

    try {
        // Preparar a consulta (na tabela dados_pessoais)
        $sql = "SELECT id, nome, email, senha, primeiro_acesso FROM dados_pessoais WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Login bem-sucedido — salva informações na sessão
            $_SESSION['id'] = $usuario['id']; // Corrigido para 'id'
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];

            // Se for o primeiro acesso, redireciona para configuração de perfil
            if ($usuario['primeiro_acesso'] == 1) {
                $updateSql = "UPDATE dados_pessoais SET primeiro_acesso = 0 WHERE id = ?";
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->execute([$usuario['id']]);

                header("Location: /Projeto-Esports-Fanid/Esports-Fanid/backend/app/pages/app-upload-documento-perfil.php");
                exit;
            }

            // Redireciona para o painel principal
            header("Location: /Projeto-Esports-Fanid/Esports-Fanid/frontend/src/pages/dashboard.php ");
            exit;
        } else {
            // Mensagem genérica (não dizer se e-mail ou senha estão errados)
            exibirMensagem('erro', 'E-mail ou senha inválidos!', '../../../index.php');
        }

    } catch (PDOException $e) {
        // Em ambiente de produção não exiba o erro real do banco
        error_log("Erro no banco de dados (login): " . $e->getMessage()); // Log para admin
        exibirMensagem('erro', "Erro ao processar sua solicitação. Tente novamente mais tarde.", '../../../index.php');
    }
}
?>
