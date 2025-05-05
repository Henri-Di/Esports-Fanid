<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

// Cabeçalhos de segurança
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');

// Função para exibir mensagens (igual do login)
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

// Destroi a sessão com segurança
$_SESSION = []; // Limpa o array da sessão

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy(); // Destroi a sessão

// Exibe a mensagem de logout com link de volta para login
exibirMensagem('sucesso', 'Você saiu da sua conta com sucesso!', '../../../index.php');
?>
