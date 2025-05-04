<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dados Pessoais</title>

    <!-- ============================ -->
    <!-- Configurações de Compatibilidade e Responsividade -->
    <!-- ============================ -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ============================ -->
    <!-- Bibliotecas de Estilo Externas -->
    <!-- ============================ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- ============================ -->
    <!-- Fontes Personalizadas -->
    <!-- ============================ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;700&display=swap" rel="stylesheet">

    <!-- ============================ -->
    <!-- Estilos Personalizados do Projeto -->
    <!-- ============================ -->
    <link rel="stylesheet" href="../assets/css/perfil.css">
    <style>
        /* Estilo geral do loader: ocupa toda a tela e posiciona no centro */
        #loader {
            position: fixed; /* Posição fixa para cobrir toda a tela */
            left: 0;
            top: 0;
            width: 100%; /* Ocupa a largura completa */
            height: 100%; /* Ocupa a altura completa */
            z-index: 9999; /* Prioridade para que apareça sobre outros elementos */
            background: #fff; /* Fundo branco */
            display: flex; /* Centraliza com Flexbox */
            align-items: center; /* Centralização vertical */
            justify-content: center; /* Centralização horizontal */
        }
        /* Estilo do spinner com animações de rotação e arco-íris */
        .loader-spinner {
            border: 16px solid #f3f3f3; /* Borda externa cinza claro */
            border-top: 12px solid; /* Borda superior colorida */
            border-radius: 50%; /* Forma circular */
            width: 80px; /* Largura do spinner */
            height: 80px; /* Altura do spinner */
            animation: spin 2s linear infinite, rainbow 4s linear infinite; /* Animações de rotação e mudança de cor */
        }
        /* Animação de rotação contínua do spinner */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* Efeito gradiente no spinner com tons de preto, cinza e branco */
        @keyframes rainbow {
            0%   { border-top-color: #000000; } /* Preto */
            25%  { border-top-color: #4b5563; } /* Cinza escuro */
            50%  { border-top-color: #9ca3af; } /* Cinza médio */
            75%  { border-top-color: #d1d5db; } /* Cinza claro */
            100% { border-top-color: #ffffff; } /* Branco */
        }
    </style>
</head>
<body>
<div id="loader">
    <div class="loader-spinner"></div> 
</div>
<br><br>
<div class="container container-logo">
    <h5>
        <img src="../assets/img/Furia.png"> FURIA
    </h5>
</div>

<div class="container">
    <h3>Dados Pessoais</h3>

    <form action="../../../backend/app/pages/app-valida-perfil1.php" method="post">

        <!-- ============================ -->
        <!-- Campo Nome Completo -->
        <!-- ============================ -->
        <div class="form-group">
            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>

        <!-- ============================ -->
        <!-- Campos de Documentos -->
        <!-- ============================ -->
        <div class="form-group">
            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf" class="form-control" placeholder="000.000.000-00" required>
        </div>

        <div class="form-group">
            <label for="rg">RG</label>
            <input type="text" id="rg" name="rg" class="form-control" required>
        </div>

        <!-- ============================ -->
        <!-- Data de Nascimento -->
        <!-- ============================ -->
        <div class="form-group">
            <label for="nascimento">Data de Nascimento</label>
            <input type="date" id="nascimento" name="nascimento" class="form-control" required>
        </div>

        <!-- ============================ -->
        <!-- Campo Sexo -->
        <!-- ============================ -->
        <div class="form-group">
            <label for="sexo">Sexo</label>
            <select id="sexo" name="sexo" class="select2" style="width: 100%;" required>
                <option value="">Selecione</option>
                <option value="masculino">Masculino</option>
                <option value="feminino">Feminino</option>
                <option value="outro">Outro</option>
                <option value="prefiro_nao_dizer">Prefiro não dizer</option>
            </select>
        </div>

        <!-- ============================ -->
        <!-- Campo Escolaridade -->
        <!-- ============================ -->
        <div class="form-group">
            <label for="escolaridade">Escolaridade</label>
            <select id="escolaridade" name="escolaridade" class="select2" style="width: 100%;" required>
                <option value="">Selecione</option>
                <option value="fundamental_incompleto">Ensino Fundamental Incompleto</option>
                <option value="fundamental_completo">Ensino Fundamental Completo</option>
                <option value="medio_incompleto">Ensino Médio Incompleto</option>
                <option value="medio_completo">Ensino Médio Completo</option>
                <option value="superior_incompleto">Ensino Superior Incompleto</option>
                <option value="superior_completo">Ensino Superior Completo</option>
                <option value="pos_graduacao">Pós-graduação</option>
                <option value="mestrado">Mestrado</option>
                <option value="doutorado">Doutorado</option>
            </select>
        </div>

        <!-- ============================ -->
        <!-- Campos de Endereço -->
        <!-- ============================ -->
        <div class="form-group">
            <label for="endereco">Endereço</label>
            <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Rua, número, complemento" required>
        </div>

        <div class="form-group">
            <label for="bairro">Bairro</label>
            <input type="text" id="bairro" name="bairro" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" class="select2" style="width: 100%;" required>
                <option value="">Selecione</option>
                <option value="AC">Acre (AC)</option>
                <option value="AL">Alagoas (AL)</option>
                <option value="AP">Amapá (AP)</option>
                <option value="AM">Amazonas (AM)</option>
                <option value="BA">Bahia (BA)</option>
                <option value="CE">Ceará (CE)</option>
                <option value="DF">Distrito Federal (DF)</option>
                <option value="ES">Espírito Santo (ES)</option>
                <option value="GO">Goiás (GO)</option>
                <option value="MA">Maranhão (MA)</option>
                <option value="MT">Mato Grosso (MT)</option>
                <option value="MS">Mato Grosso do Sul (MS)</option>
                <option value="MG">Minas Gerais (MG)</option>
                <option value="PA">Pará (PA)</option>
                <option value="PB">Paraíba (PB)</option>
                <option value="PR">Paraná (PR)</option>
                <option value="PE">Pernambuco (PE)</option>
                <option value="PI">Piauí (PI)</option>
                <option value="RJ">Rio de Janeiro (RJ)</option>
                <option value="RN">Rio Grande do Norte (RN)</option>
                <option value="RS">Rio Grande do Sul (RS)</option>
                <option value="RO">Rondônia (RO)</option>
                <option value="RR">Roraima (RR)</option>
                <option value="SC">Santa Catarina (SC)</option>
                <option value="SP">São Paulo (SP)</option>
                <option value="SE">Sergipe (SE)</option>
                <option value="TO">Tocantins (TO)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="cep">CEP</label>
            <input type="text" id="cep" name="cep" class="form-control" placeholder="00000-000" required>
        </div>

        <!-- ============================ -->
        <!-- Campo Telefone -->
        <!-- ============================ -->
        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" class="form-control" placeholder="(00) 00000-0000">
        </div>

        <!-- ============================ -->
        <!-- Campos de E-mail -->
        <!-- ============================ -->
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="exemplo@dominio.com" required>
        </div>

        <div class="form-group">
            <label for="confirmar_email">Confirmar E-mail</label>
            <input type="email" id="confirmar_email" name="confirmar_email" class="form-control" placeholder="Confirme seu e-mail" required>
        </div>

        <!-- ============================ -->
        <!-- Campos de Senha -->
        <!-- ============================ -->
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" class="form-control" placeholder="Digite sua senha" required>
        </div>

        <div class="form-group">
            <label for="confirmar_senha">Confirmar Senha</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control" placeholder="Confirme sua senha" required>
        </div>

        <!-- ============================ -->
        <!-- Botão de Submissão do Formulário -->
        <!-- ============================ -->
        <div class="container-btn-perfil">
            <button type="submit" class="btn">Salvar</button>
        </div>

    </form>
</div>

<!-- ============================ -->
<!-- Scripts Externos -->
<!-- ============================ -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Selecione uma opção",
            allowClear: true
        });
    });
</script>

<script>
        // A função é executada quando o DOM está totalmente carregado
        document.addEventListener("DOMContentLoaded", function () {
            // Quando a página estiver totalmente carregada
            window.onload = function () {
                // Define um tempo para ocultar o loader
                setTimeout(function () {
                    var loader = document.getElementById("loader");
                    loader.style.display = "none"; // Esconde o loader após 1 segundo
                }, 1000); // 1000 milissegundos = 1 segundo
            }
        });
    </script>

</body>
</html>
