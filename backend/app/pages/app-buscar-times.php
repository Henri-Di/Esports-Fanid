<?php
header('Content-Type: application/json; charset=utf-8');

function enviarErro($mensagem, $codigo = 400, $detalhes = []) {
    http_response_code($codigo);
    echo json_encode(array_merge(['error' => $mensagem], $detalhes), JSON_UNESCAPED_UNICODE);
    exit;
}

function executarCurl($url) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_HTTPHEADER => [
            'X-Auth-Token: 6c329b713d4e4f73b982ea36eb5c8f1b',
            'Content-Type: application/json',
            'Accept-Language: pt-BR'
        ]
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        $erro_curl = curl_error($ch);
        curl_close($ch);
        enviarErro('Erro na conexão com a API', 500, ['detalhes' => $erro_curl]);
    }

    curl_close($ch);

    if ($http_code !== 200) {
        enviarErro('Erro na resposta da API', $http_code, ['url' => $url, 'response' => $response]);
    }

    $dados = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        enviarErro('Resposta da API não é um JSON válido', 500, ['url' => $url]);
    }

    return $dados;
}

function formatarDataBrasileira($dataIso) {
    // Exemplo de $dataIso: "2023-12-01T18:00:00Z"
    $dataHora = date_create($dataIso);
    if ($dataHora) {
        return date_format($dataHora, 'd/m/Y');
    }
    return $dataIso; // Se não conseguir converter, devolve como veio
}

// Busca COMPETIÇÕES no Brasil
$apiUrlCompetitions = "https://api.football-data.org/v4/competitions?areas=2072";
$dadosCompetitions = executarCurl($apiUrlCompetitions);

// Verifica se encontrou competições
if (empty($dadosCompetitions['competitions'])) {
    enviarErro('Nenhuma competição encontrada no Brasil', 404);
}

// Trabalha com a primeira competição encontrada
$competition = $dadosCompetitions['competitions'][0];
$competitionCode = $competition['code'];

// Formata datas da competição (se existirem)
if (isset($competition['currentSeason']['startDate'])) {
    $competition['currentSeason']['startDate'] = formatarDataBrasileira($competition['currentSeason']['startDate']);
}
if (isset($competition['currentSeason']['endDate'])) {
    $competition['currentSeason']['endDate'] = formatarDataBrasileira($competition['currentSeason']['endDate']);
}

// Busca TIMES da competição
$apiUrlTeams = "https://api.football-data.org/v4/competitions/$competitionCode/teams";
$dadosTeams = executarCurl($apiUrlTeams);

// Busca ÚLTIMOS JOGOS (5)
$apiUrlMatches = "https://api.football-data.org/v4/competitions/$competitionCode/matches?status=FINISHED&limit=5";
$dadosMatches = executarCurl($apiUrlMatches);

// Formata datas dos jogos
if (isset($dadosMatches['matches']) && is_array($dadosMatches['matches'])) {
    foreach ($dadosMatches['matches'] as &$match) {
        if (isset($match['utcDate'])) {
            $match['utcDate'] = formatarDataBrasileira($match['utcDate']);
        }
    }
}

// Busca CLASSIFICAÇÃO
$apiUrlStandings = "https://api.football-data.org/v4/competitions/$competitionCode/standings";
$dadosStandings = executarCurl($apiUrlStandings);

// Monta resposta combinada
$respostaFinal = [
    'competicao' => $competition,
    'times' => $dadosTeams['teams'] ?? [],
    'ultimos_jogos' => $dadosMatches['matches'] ?? [],
    'classificacao' => $dadosStandings['standings'] ?? []
];

// Retorna a resposta final
http_response_code(200);
echo json_encode($respostaFinal, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
