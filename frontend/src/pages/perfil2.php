<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>

    <!-- ============================ -->
    <!-- Configurações de Compatibilidade e Responsividade -->
    <!-- ============================ -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ============================ -->
    <!-- Bibliotecas de Estilo Externas -->
    <!-- ============================ -->
    <!-- Font Awesome: Biblioteca de ícones para enriquecer a interface -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap 3.4.1: Framework CSS para criação de layouts responsivos e componentes prontos -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Select2 CSS: Estilização aprimorada para elementos select -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- ============================ -->
    <!-- Fontes Personalizadas -->
    <!-- ============================ -->
    <!-- Otimização de conexão para carregamento das fontes do Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Fonte Barlow Condensed: Variedade de estilos e pesos para personalização tipográfica -->
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
    <h3>Perfil do Usuário</h3>

    <form action="../../../backend/app/pages/app-valida-perfil2.php" method="post">

        <!-- ============================ -->
        <!-- Seleção de Jogos Favoritos -->
        <!-- ============================ -->
        <div class="form-group">
            <label for="jogos">Jogos Favoritos</label>
            <select id="jogos" name="jogos[]" multiple class="select2" style="width: 100%;">
                <option value="fifa">FIFA</option>
                <option value="valorant">Valorant</option>
                <option value="csgo">CS:GO</option>
                <option value="fortnite">Fortnite</option>
                <option value="lol">League of Legends</option>
                <option value="dota2">Dota 2</option>
                <option value="pubg">PUBG</option>
                <option value="overwatch">Overwatch</option>
                <option value="apex">Apex Legends</option>
                <option value="rocketleague">Rocket League</option>
                <option value="minecraft">Minecraft</option>
                <option value="eldenring">Elden Ring</option>
                <option value="gta5">Grand Theft Auto V</option>
                <option value="thewitcher3">The Witcher 3</option>
                <option value="cyberpunk2077">Cyberpunk 2077</option>
                <option value="amongus">Among Us</option>
                <option value="fallguys">Fall Guys</option>
                <option value="roblox">Roblox</option>
                <option value="callofduty">Call of Duty</option>
                <option value="assassinscreed">Assassin's Creed</option>
                <option value="zelda">The Legend of Zelda</option>
                <option value="mariokart">Mario Kart</option>
                <option value="animalcrossing">Animal Crossing</option>
                <option value="pokemon">Pokémon</option>
                <option value="halo">Halo</option>
                <option value="godofwar">God of War</option>
                <option value="spiderman">Spider-Man</option>
                <option value="residentevil">Resident Evil</option>
                <option value="finalfantasy">Final Fantasy</option>
                <option value="metalgear">Metal Gear Solid</option>
                <option value="darksouls">Dark Souls</option>
                <option value="bloodborne">Bloodborne</option>
                <option value="horizon">Horizon Zero Dawn</option>
                <option value="reddead">Red Dead Redemption</option>
                <option value="bioshock">Bioshock</option>
                <option value="massEffect">Mass Effect</option>
                <option value="skyrim">Skyrim</option>
                <option value="doom">DOOM</option>
                <option value="tetris">Tetris</option>
                <option value="pacman">Pac-Man</option>
                <option value="streetfighter">Street Fighter</option>
                <option value="tekken">Tekken</option>
                <option value="mortalKombat">Mortal Kombat</option>
                <option value="nba2k">NBA 2K</option>
                <option value="pes">eFootball PES</option>
                <option value="granTurismo">Gran Turismo</option>
                <option value="forza">Forza Horizon</option>
                <option value="sims">The Sims</option>
                <option value="simcity">SimCity</option>
                <option value="civilization">Civilization</option>
                <option value="ageofempires">Age of Empires</option>
                <option value="starcraft">StarCraft</option>
                <option value="diablo">Diablo</option>
                <option value="hearthstone">Hearthstone</option>
            </select>
        </div>

        <!-- ============================ -->
        <!-- Seleção de Times Favoritos -->
        <!-- ============================ -->
        <div class="form-group">
            <label for="times">Times Favoritos</label>
            <select id="times" name="times[]" multiple class="select2" style="width: 100%;">
                <optgroup label="Série A 2025">
                    <option value="atletico_mg">Atlético Mineiro</option>
                    <option value="bahia">Bahia</option>
                    <option value="botafogo">Botafogo</option>
                    <option value="ceara">Ceará</option>
                    <option value="corinthians">Corinthians</option>
                    <option value="cruzeiro">Cruzeiro</option>
                    <option value="flamengo">Flamengo</option>
                    <option value="fluminense">Fluminense</option>
                    <option value="fortaleza">Fortaleza</option>
                    <option value="gremio">Grêmio</option>
                    <option value="internacional">Internacional</option>
                    <option value="juventude">Juventude</option>
                    <option value="mirassol">Mirassol</option>
                    <option value="palmeiras">Palmeiras</option>
                    <option value="red_bull_bragantino">Red Bull Bragantino</option>
                    <option value="santos">Santos</option>
                    <option value="sao_paulo">São Paulo</option>
                    <option value="sport_recife">Sport Recife</option>
                    <option value="vasco_da_gama">Vasco da Gama</option>
                    <option value="vitoria">Vitória</option>
                </optgroup>
                <optgroup label="Série B 2025">
                    <option value="america_mg">América Mineiro</option>
                    <option value="amazonas">Amazonas</option>
                    <option value="athletic">Athletic</option>
                    <option value="atletico_go">Atlético Goianiense</option>
                    <option value="athletico_pr">Athletico Paranaense</option>
                    <option value="avai">Avaí</option>
                    <option value="botafogo_sp">Botafogo-SP</option>
                    <option value="chapecoense">Chapecoense</option>
                    <option value="crb">CRB</option>
                    <option value="criciuma">Criciúma</option>
                    <option value="cuiaba">Cuiabá</option>
                    <option value="ferroviaria">Ferroviária</option>
                    <option value="goias">Goiás</option>
                    <option value="novorizontino">Novorizontino</option>
                    <option value="operario_pr">Operário-PR</option>
                    <option value="paysandu">Paysandu</option>
                    <option value="remo">Remo</option>
                    <option value="vila_nova">Vila Nova</option>
                    <option value="volta_redonda">Volta Redonda</option>
                </optgroup>
            </select>
        </div>

        <!-- ============================ -->
        <!-- Campo para Eventos Frequentados -->
        <!-- ============================ -->
        <div class="form-group">
            <label for="eventos">Eventos Frequentados</label>
            <textarea id="eventos" name="eventos" class="form-control" rows="3" placeholder="Descreva os eventos que você costuma frequentar."></textarea>
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
            placeholder: "Selecione uma ou mais opções",
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
