<?php
// -----------------------------
// CONFIGURAÇÕES INICIAIS
// -----------------------------

// Exibir ou ocultar o formulário de envio
$exibir_formulario = true;

// Configurações de segurança para o upload
$allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf']; // Extensões permitidas
$max_file_size = 5 * 1024 * 1024; // Tamanho máximo do arquivo (5MB)

// Diretório de upload
$upload_dir = __DIR__ . '/../uploads';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Função para obter a extensão do arquivo
function get_file_extension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

// Função para exibir mensagens de erro
function mostrar_erro($mensagem) {
    global $exibir_formulario, $mensagem_erro;
    $exibir_formulario = false;
    $mensagem_erro = "<div class='mensagem erro fade-in'><h3>❌ Erro</h3><p>" . htmlspecialchars($mensagem) . "</p><button onclick='recarregar()'>Tentar novamente</button></div>";
}

// Inicializa variáveis de mensagem
$mensagem_sucesso = '';
$mensagem_erro = '';

// -----------------------------
// PROCESSAMENTO DO UPLOAD
// -----------------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['documento'])) {
    $exibir_formulario = false;
    $file = $_FILES['documento'];

    // Verifica se houve erro no upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        mostrar_erro('Falha no upload do arquivo. Verifique e tente novamente.');
    }

    // Verifica se o arquivo excede o tamanho permitido
    if ($file['size'] > $max_file_size) {
        mostrar_erro('Arquivo excede o tamanho máximo permitido (5MB).');
    }

    // Verifica se a extensão é permitida
    $ext = get_file_extension($file['name']);
    if (!in_array($ext, $allowed_extensions)) {
        mostrar_erro('Tipo de arquivo não permitido.');
    }

    // Gera um nome único para o arquivo e define o caminho de destino
    $new_filename = uniqid('doc_') . '.' . $ext;
    $target_path = rtrim($upload_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $new_filename;

    // Move o arquivo enviado para o diretório de uploads
    if (!move_uploaded_file($file['tmp_name'], $target_path)) {
        mostrar_erro('Não foi possível salvar o arquivo. Tente novamente.');
    }

    // -----------------------------
    // PROCESSAMENTO OCR (TESSERACT)
    // -----------------------------

    ob_start();
    echo "<div class='mensagem sucesso fade-in'><h3>✔️ Sucesso</h3><p>Arquivo enviado com sucesso.</p>";

    // Se for PDF, converte a primeira página para imagem PNG
    if ($ext === 'pdf') {
        $image_output = $target_path . '.png';
        $cmd_convert = "convert -density 300 " . escapeshellarg($target_path) . "[0] -quality 100 " . escapeshellarg($image_output);
        shell_exec($cmd_convert);
        $ocr_input = $image_output;
    } else {
        $ocr_input = $target_path;
    }

    // Caminho do Tesseract OCR
    $tesseract_path = "C:\\Program Files\\Tesseract-OCR\\tesseract.exe";
    if (!file_exists($tesseract_path)) {
        mostrar_erro('O sistema de leitura de documento não está disponível no momento.');
    }

    // Configura o comando do Tesseract OCR
    $output_txt_file = $target_path . '_ocr';
    $ocr_input = str_replace('\\', '/', $ocr_input);
    $output_txt_file = str_replace('\\', '/', $output_txt_file);
    $cmd_tesseract = '"' . $tesseract_path . '" ' . escapeshellarg($ocr_input) . ' ' . escapeshellarg($output_txt_file) . ' -l por txt';
    shell_exec($cmd_tesseract);

    // Verifica se o arquivo de texto foi gerado com sucesso
    $ocr_txt_path = $output_txt_file . '.txt';
    if (!file_exists($ocr_txt_path)) {
        mostrar_erro('Erro ao processar o documento. Tente novamente.');
    }

    // Lê o texto extraído
    $ocr_text = file_get_contents($ocr_txt_path);

    // Exibe o texto extraído e tenta validar se é um documento
    echo "<h3>Validação do Documento:</h3>";
    echo "<pre>" . htmlspecialchars($ocr_text) . "</pre>";

    if (stripos($ocr_text, 'CPF') !== false || stripos($ocr_text, 'NOME') !== false) {
        echo "<p class='valido'>✔️ Possível documento válido detectado.</p>";

        // Redireciona para a página desejada após o sucesso
        header("Location: /Projeto-Esports-Fanid/Esports-Fanid/frontend/src/pages/perfil2.php"); // Substitua pelo caminho correto
        exit; // Garantir que o código pare aqui
    } else {
        echo "<p class='invalido'>❌ Não foi possível validar a identidade no documento.</p>";
    }

    echo "<button onclick='recarregar()'>Tentar novamente</button></div>";
    $mensagem_sucesso = ob_get_clean();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Upload de Documento (RG/CNH)</title>

<!-- Estilos CSS -->
<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    min-height: 100vh;
    background-color: #f7f7f7;
    font-family: 'Roboto', sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    color: #333;
}

.wrapper {
    width: 100%;
    max-width: 700px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.container-logo {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    text-align: center;
    margin-top: 20px;
    margin-bottom: 20px;
}

.container-logo img {
    height: 40px;
    width: auto;
}

.container-logo h5 {
    font-weight: 700;
    font-size: 2rem;
    color: #333;
}

.container, .mensagem {
    width: 100%;
    padding: 35px;
    text-align: center;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

input[type="file"] {
    display: block;
    width: 100%;
    padding: 14px;
    border-radius: 10px;
    border: 2px dashed #ccc;
    background-color: #fafafa;
    cursor: pointer;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

input[type="file"]:hover {
    border-color: #333;
    background-color: #f0f0f0;
}

button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 10px;
    background: #111;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);
}

button:hover {
    background: #333;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4);
}

pre {
    text-align: left;
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #ddd;
    max-height: 300px;
    overflow-y: auto;
}

.mensagem {
    opacity: 0;
    transform: scale(0.95);
    animation: fadeIn 0.6s forwards;
}

@keyframes fadeIn {
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.mensagem.sucesso {
    border-left: 6px solid #27ae60;
    background-color: #eafaf1;
}

.mensagem.erro {
    border-left: 6px solid #e74c3c;
    background-color: #fdecea;
}

.mensagem h3 {
    font-size: 22px;
    margin-bottom: 12px;
    font-weight: bold;
}

.mensagem.sucesso h3 {
    color: #27ae60;
}

.mensagem.erro h3 {
    color: #e74c3c;
}

.mensagem p {
    font-size: 16px;
    margin: 10px 0;
}

p.valido {
    color: #27ae60;
    font-weight: bold;
}

p.invalido {
    color: #e74c3c;
    font-weight: bold;
}

@media (max-width: 600px) {
    .container-logo {
        flex-direction: column;
        gap: 10px;
    }

    .container-logo h5 {
        font-size: 1.8rem;
    }

    .container-logo img {
        height: 2.8rem;
    }
}
</style>

<!-- Script de recarregamento da página -->
<script>
function recarregar() {
    window.location.href = window.location.pathname;
}
</script>
</head>
<body>

<div class="wrapper">
    <div class="container-logo">
        <img src="../../../frontend/src/assets/img/Furia.png" alt="Logo FURIA">
        <h5>FURIA</h5>
    </div>

    <?php if ($exibir_formulario): ?>
    <div class="container">
        <h2>Envie seu documento (RG ou CNH)</h2>
        <form action="../../../backend/app/pages/app-upload-documento-perfil.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="documento" accept=".jpg,.jpeg,.png,.pdf" required>
            <button type="submit">Enviar</button>
        </form>
    </div>
    <?php endif; ?>

    <?php
    if (!empty($mensagem_sucesso)) echo $mensagem_sucesso;
    if (!empty($mensagem_erro)) echo $mensagem_erro;
    ?>
</div>

</body>
</html>
