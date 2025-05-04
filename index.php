<!DOCTYPE html>
<html lang="pt-BR">

<head>    
    <title>Login</title>
    <meta charset="UTF-8">

    <!-- Compatibilidade com versões antigas do Internet Explorer -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Configuração de viewport para garantir responsividade em dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ============================ -->
    <!-- Bibliotecas de Estilo Externas -->
    <!-- ============================ -->

    <!-- Font Awesome: Biblioteca de ícones para enriquecer a interface -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Bootstrap 3.4.1: Framework CSS para criação de layouts responsivos e componentes prontos -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- ============================ -->
    <!-- Fontes Personalizadas -->
    <!-- ============================ -->

    <!-- Otimização de conexão para carregamento das fontes do Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Fonte Barlow Condensed: Variedade de estilos e pesos para personalização tipográfica -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- ============================ -->
    <!-- Estilos Personalizados do Projeto -->
    <!-- ============================ -->

    <!-- Estilos específicos da página de login -->
    <link rel="stylesheet" href="../Esports-Fanid/frontend/src/assets/css/index.css">

</head>

<body>

    <!-- ============================ -->
    <!-- Seção de Logo -->
    <!-- ============================ -->

    <div class="container container-logo">
        <h5>
            <img src="../Esports-Fanid/frontend/src/assets/img/Furia.png" alt="Logo FURIA"> FURIA
        </h5>
    </div>

    <!-- ============================ -->
    <!-- Seção do Formulário de Login -->
    <!-- ============================ -->

    <div class="container container-form">
        
        <form name="" method="POST" action="../Esports-Fanid/backend/app/pages/app-valida-login.php">
            
            <!-- Campo E-mail -->
            <label for="input-email-login">E-mail</label>
            <input type="text" name="email" id="input-email-login" required>

            <!-- Campo Senha -->
            <label for="input-senha-login">Senha</label>
            <input type="password" name="senha" id="input-senha-login" required>

            <!-- Botões do Formulário -->
            <button type="submit" id="btn-login">Enviar</button>
            <button type="reset" id="btn-login">Cancelar</button>
            <button type="submit" onclick="window.location.href='../Esports-Fanid/frontend/src/pages/perfil1.php';" id="btn-login">Cadastre-se</button>
        </form>
    </div>

</body>
</html>
