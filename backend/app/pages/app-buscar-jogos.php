<?php
header('Content-Type: application/json');

// Recupera o nome do jogo da URL
$name = $_GET['name'] ?? '';

// Se o nome do jogo estiver vazio, retorna uma resposta vazia
if (empty($name)) {
    echo json_encode(['error' => 'Por favor, insira um nome de jogo para a busca.']);
    exit;
}

// Defina sua chave de API da GiantBomb (verifique se está válida no site!)
$apiKey = 'dc787e9d30f00ba93160c02fa23058d9a35371fb';

// Monta a URL da API de busca
$apiUrl = 'https://www.giantbomb.com/api/search/?'
    . 'api_key=' . urlencode($apiKey)
    . '&format=json'
    . '&query=' . urlencode($name)
    . '&resources=game';

// Inicializa cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

// Adiciona headers obrigatórios
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: PHP-GiantBomb-Client/1.0',
    'Accept: application/json'
]);

// Executa a requisição
$response = curl_exec($ch);

// Verifica erros cURL
if (curl_errno($ch)) {
    echo json_encode(['error' => 'Erro ao acessar a API GiantBomb: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Verifica o código HTTP da resposta
if ($httpCode !== 200) {
    echo json_encode(['error' => 'Erro na resposta da API GiantBomb. Código HTTP: ' . $httpCode]);
    exit;
}

// Decodifica o JSON
$data = json_decode($response, true);

// Validação de resposta
if (json_last_error() !== JSON_ERROR_NONE || empty($data['results'])) {
    echo json_encode(['error' => 'Nenhum jogo encontrado ou erro ao processar a resposta.']);
    exit;
}

// Filtra e organiza os dados relevantes
$formatados = array_map(function ($game) {
    return [
        'nome'       => $game['name'] ?? '',
        'generos'    => isset($game['genres']) ? implode(', ', array_column($game['genres'], 'name')) : 'Desconhecido',
        'plataformas'=> isset($game['platforms']) ? implode(', ', array_column($game['platforms'], 'name')) : 'Desconhecido',
        'descricao'  => $game['deck'] ?? 'Sem descrição.',
        'link'       => $game['site_detail_url'] ?? ''
    ];
}, $data['results']);

// Exibe os dados formatados em JSON
echo json_encode($formatados);
?>
