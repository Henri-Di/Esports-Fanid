<?php
session_start();
require_once '../../app/config/conexaodb.php';

function limparEntrada($entrada) {
    return htmlspecialchars(trim($entrada));
}

function exibirMensagem($tipo, $mensagem) {
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
        <a href='../../../index.php'>Realizar Acesso</a>
    </div>
    ";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = limparEntrada($_POST['nome']);
    $cpf = limparEntrada($_POST['cpf']);
    $rg = limparEntrada($_POST['rg']);
    $nascimento = limparEntrada($_POST['nascimento']);
    $sexo = limparEntrada($_POST['sexo']);
    $escolaridade = limparEntrada($_POST['escolaridade']);
    $endereco = limparEntrada($_POST['endereco']);
    $bairro = limparEntrada($_POST['bairro']);
    $cidade = limparEntrada($_POST['cidade']);
    $estado = limparEntrada($_POST['estado']);
    $cep = limparEntrada($_POST['cep']);
    $telefone = limparEntrada($_POST['telefone']);
    $email = limparEntrada($_POST['email']);
    $senha = limparEntrada($_POST['senha']);
    $confirmar_senha = limparEntrada($_POST['confirmar_senha']);

    $_SESSION['dados'] = $_POST;

    // === VALIDAÇÕES ENUM ===
    $sexos_validos = ['masculino', 'feminino', 'outro', 'prefiro_nao_dizer'];
    $escolaridades_validas = [
        'fundamental_incompleto', 'fundamental_completo',
        'medio_incompleto', 'medio_completo',
        'superior_incompleto', 'superior_completo',
        'pos_graduacao', 'mestrado', 'doutorado'
    ];
    $estados_validos = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA',
        'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO',
        'RR', 'SC', 'SP', 'SE', 'TO'];

    if (!in_array($sexo, $sexos_validos)) {
        exibirMensagem('erro', "Valor de 'sexo' inválido.");
        exit();
    }
    if (!in_array($escolaridade, $escolaridades_validas)) {
        exibirMensagem('erro', "Valor de 'escolaridade' inválido.");
        exit();
    }
    if (!in_array($estado, $estados_validos)) {
        exibirMensagem('erro', "Valor de 'estado' inválido.");
        exit();
    }

    // === VALIDAÇÕES SENHA ===
    if ($senha !== $confirmar_senha) {
        exibirMensagem('erro', "As senhas não coincidem.");
        exit();
    }
    if (strlen($senha) < 6) {
        exibirMensagem('erro', "A senha deve ter pelo menos 6 caracteres.");
        exit();
    }

    try {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Se telefone vier vazio, setar NULL
        $telefone = !empty($telefone) ? $telefone : null;

        $sql = "INSERT INTO dados_pessoais 
                (nome, cpf, rg, nascimento, sexo, escolaridade, endereco, bairro, cidade, estado, cep, telefone, email, senha)
                VALUES (:nome, :cpf, :rg, :nascimento, :sexo, :escolaridade, :endereco, :bairro, :cidade, :estado, :cep, :telefone, :email, :senha)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':rg', $rg);
        $stmt->bindParam(':nascimento', $nascimento);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':escolaridade', $escolaridade);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hash);

        $stmt->execute();

        unset($_SESSION['dados']); // limpa sessão ao salvar com sucesso
        exibirMensagem('sucesso', "Dados pessoais salvos com sucesso!");
        exit();

    } catch (PDOException $e) {
        exibirMensagem('erro', "Erro ao salvar os dados: " . $e->getMessage());
        exit();
    }
}
?>
