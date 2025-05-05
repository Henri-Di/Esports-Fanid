<?php
session_start();

if (!isset($_SESSION['id'])) {
    die("Usuário não autenticado.");
}

$user_id = $_SESSION['id'];

require_once "../../../backend/app/config/conexaodb.php";

// Consultar os dados do usuário
$sql = "SELECT nome, cpf, rg, nascimento, sexo, escolaridade, endereco, bairro, cidade, estado, cep, telefone, email
        FROM dados_pessoais
        WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch();

if (!$user) {
    die("Usuário não encontrado.");
}

// Consultar todos os jogos de interesse do usuário
$sql_jogo = "SELECT * FROM perfil_jogo WHERE perfil_id = :perfil_id";
$stmt_jogo = $pdo->prepare($sql_jogo);
$stmt_jogo->execute([':perfil_id' => $user_id]);
$jogos = $stmt_jogo->fetchAll();

// Consultar todos os times favoritos do usuário
$sql_time = "SELECT * FROM perfil_time WHERE perfil_id = :perfil_id";
$stmt_time = $pdo->prepare($sql_time);
$stmt_time->execute([':perfil_id' => $user_id]);
$times = $stmt_time->fetchAll();

// Consultar eventos recentes do usuário
$sql_eventos = "SELECT evento, criado_em FROM eventos WHERE perfil_id = :perfil_id ORDER BY criado_em DESC";
$stmt_eventos = $pdo->prepare($sql_eventos);
$stmt_eventos->execute([':perfil_id' => $user_id]);
$eventos = $stmt_eventos->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../../frontend/src/assets/css/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .scrollable-table { overflow-x: auto; }
        .scrollable-table table { width: 100%; border-collapse: collapse; }
        .scrollable-table th, .scrollable-table td { border: 1px solid #ddd; padding: 8px; }
        .text-center { text-align: center; }
        .pagination { margin-top: 10px; }
        .pagination button { margin: 0 5px; padding: 5px 10px; }

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

    <div class="sidebar">
        <div class="container container-logo">
    <h5>
        <img src="../assets/img/Furia.png"> FURIA
    </h5>
</div>
        <div class="logo">
            <h2>Dashboard</h2>
        </div>
        <ul>
            <li><a href="../../../frontend/src/pages/dashboard.php">Início</a></li>
            <li><a href="../../../frontend/src/pages/perfil2.php">Perfil</a></li>
            <li><a href="#">Eventos</a></li>
            <li><a href="../../../backend/app/pages/app-valida-logout.php">Sair</a></li>
        </ul>
    </div>

    <div class="content">
    <p id="" style="color: #000000; font-weight: 600; font-size: 1rem; padding-bottom: 20px;">BEM-VINDO, <?php echo $_SESSION['nome']; ?></p>
        <div class="header">
            <div class="search-bar">
            <form id="search-form">
                <select id="search-category">
                    <option value="futebol">Futebo: Time, Jogadores, Campeonatos, Classificação, Pontuação...</option>
                    <option value="games">Games: Eventos, Plataformas, Preços, Genêros, Popularidade...</option>
        </select>
        <input type="text" id="search" placeholder="Buscar futebol ou games">
        <button type="submit" id="search-btn">Buscar</button>
                </form>
            </div>
        </div>

        <div class="search-results-container">
            <div class="search-results" id="search-results">
                <!-- Resultados serão mostrados aqui -->
            </div>
        </div>

        <div class="profile-info">
            <div class="profile-section">
                <h3>Jogos de Interesse</h3>
                <div class="profile-data">
                    <?php if (count($jogos) > 0): ?>
                        <?php foreach ($jogos as $jogo): ?>
                            <div class="item">
                                <p><strong></strong> <?php echo htmlspecialchars($jogo['jogo']); ?></p>
                                <hr>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum jogo cadastrado.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="profile-section">
                <h3>Times Favoritos</h3>
                <div class="profile-data">
                    <?php if (count($times) > 0): ?>
                        <?php foreach ($times as $time): ?>
                            <div class="item">
                                <p><strong></strong> <?php echo htmlspecialchars($time['time']); ?></p>
                                <hr>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum time cadastrado.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="profile-section">
                <h3>Eventos Recentes</h3>
                <ul>
                    <?php if (count($eventos) > 0): ?>
                        <?php foreach ($eventos as $evento): ?>
                            <li>
                                <p><?php echo htmlspecialchars($evento['evento']); ?></p>
                                <small>Data: <?php echo strftime('%d de %B de %Y', strtotime($evento['criado_em'])); ?></small>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum evento encontrado.</p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('search-form');
    const searchInput = document.getElementById('search');
    const searchCategory = document.getElementById('search-category');
    const resultsContainer = document.getElementById('search-results');

    const futebolSection = document.createElement('div');
    futebolSection.classList.add('result-section');
    const gameSection = document.createElement('div');
    gameSection.classList.add('result-section');

    resultsContainer.appendChild(futebolSection);
    resultsContainer.appendChild(gameSection);

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        const searchTerm = searchInput.value.trim();
        const category = searchCategory.value;

        // Limpa tudo antes de nova busca
        resultsContainer.innerHTML = '';
        futebolSection.innerHTML = '';
        gameSection.innerHTML = '';

        if (searchTerm === '') {
            resultsContainer.innerHTML = '<p>Digite um termo para buscar.</p>';
            return;
        }

        if (category === 'futebol') {
            futebolSection.innerHTML = '<p>Buscando resultados de Futebol...</p>';
            resultsContainer.appendChild(futebolSection);

            const apiFutebol = `../../../backend/app/pages/app-buscar-times.php?name=${encodeURIComponent(searchTerm)}`;

            fetch(apiFutebol)
            .then(res => res.ok ? res.json() : Promise.reject('Erro na API de futebol'))
            .then(futebolData => {
                futebolSection.innerHTML = '<h3>Resultados de Futebol</h3>';
                if (futebolData && futebolData.competicao) {
                    const comp = futebolData.competicao;
                    const jogos = futebolData.ultimos_jogos;
                    const jogosPorPagina = 5;
                    let paginaAtual = 1;

                    function exibirJogos(pagina) {
                        const offset = (pagina - 1) * jogosPorPagina;
                        const jogosPagina = jogos.slice(offset, offset + jogosPorPagina);

                        let futebolHTML = `
                            <div class="result">
                                <h4>${comp.name}</h4>
                                <p><strong>País:</strong> ${comp.area.name}</p>
                                <p><strong>Temporada:</strong> ${comp.currentSeason ? comp.currentSeason.startDate : 'Não disponível'}</p>
                                <p><strong>Tipo:</strong> ${comp.plan}</p>

                                <h5>Últimos Jogos</h5>
                                ${jogosPagina.length > 0 ? `
                                    <div class="scrollable-table">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Casa</th>
                                                    <th class="text-center">Placar</th>
                                                    <th>Fora</th>
                                                    <th>Data</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${jogosPagina.map(match => `
                                                    <tr>
                                                        <td>${match.homeTeam.name}</td>
                                                        <td class="text-center"><strong>${match.score.fullTime.home}</strong> - <strong>${match.score.fullTime.away}</strong></td>
                                                        <td>${match.awayTeam.name}</td>
                                                        <td>${match.utcDate.split('T')[0]}</td>
                                                    </tr>
                                                `).join('')}
                                            </tbody>
                                        </table>
                                    </div>
                                ` : '<p>Sem jogos recentes disponíveis.</p>'}
                            </div>
                        `;

                        futebolSection.innerHTML = '<h3>Resultados de Futebol</h3>' + futebolHTML;

                        const totalPaginas = Math.ceil(jogos.length / jogosPorPagina);
                        const pagination = document.createElement('div');
                        pagination.classList.add('pagination');

                        if (pagina > 1) {
                            const prevBtn = document.createElement('button');
                            prevBtn.textContent = 'Anterior';
                            prevBtn.onclick = () => exibirJogos(pagina - 1);
                            pagination.appendChild(prevBtn);
                        }

                        if (pagina < totalPaginas) {
                            const nextBtn = document.createElement('button');
                            nextBtn.textContent = 'Próxima';
                            nextBtn.onclick = () => exibirJogos(pagina + 1);
                            pagination.appendChild(nextBtn);
                        }

                        futebolSection.appendChild(pagination);
                    }

                    exibirJogos(paginaAtual);
                } else {
                    futebolSection.innerHTML += '<p>Nenhum time ou campeonato encontrado.</p>';
                }

            })
            .catch(error => {
                console.error(error);
                resultsContainer.innerHTML = '<p>Erro ao buscar os resultados. Tente novamente.</p>';
            });

        } else if (category === 'games') {
            gameSection.innerHTML = '<p>Buscando resultados de Games...</p>';
            resultsContainer.appendChild(gameSection);

            const searchTermEncoded = encodeURIComponent(searchTerm); // Codifica o termo de busca

            const apiGamePHP = `../../../backend/app/pages/app-buscar-games.php?name=${searchTermEncoded}`;

            fetch(apiGamePHP)
            .then(res => res.ok ? res.json() : Promise.reject('Erro na API de games'))
            .then(gameData => {
                if (gameData.error) {
                    gameSection.innerHTML = `<p>${gameData.error}</p>`;
                    return;
                }

                gameSection.innerHTML = '<h3>Resultados de Games</h3>';
                if (gameData && gameData.length > 0) {
                    const gamesHTML = gameData.map(game => `
                        <div class="result">
                            <h4>${game.nome}</h4>
                            <p><strong>Gêneros:</strong> ${game.generos}</p>
                            <p><strong>Plataformas:</strong> ${game.plataformas}</p>
                            <p><strong>Descrição:</strong> ${game.descricao}</p>
                            <a href="${game.link}" target="_blank">Ver mais</a>
                        </div>
                    `).join('');
                    gameSection.innerHTML += gamesHTML;
                } else {
                    gameSection.innerHTML += '<p>Nenhum jogo encontrado.</p>';
                }
            })
            .catch(error => {
                console.error(error);
                gameSection.innerHTML = '<p>Erro ao buscar os resultados de games. Tente novamente.</p>';
            });
        }
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
