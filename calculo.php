<?php
// Define o tipo de conteúdo da resposta como JSON. Isso informa ao cliente (navegador) que os dados retornados serão no formato JSON.
header('Content-Type: application/json');

// Verifica se a requisição feita para o servidor foi do tipo POST (usada para enviar dados para o servidor)
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Lê os dados enviados pela requisição e os converte de JSON para um objeto PHP
    $dados = json_decode(file_get_contents("php://input"));

    // Calcula a área do cômodo (largura * comprimento)
    $areaComodo = $dados -> comodoLargura * $dados -> comodoComprimento;

    // Calcula a área de um piso (largura * comprimento)
    $areaPiso = $dados -> pisoLargura * $dados -> pisoComprimento;

    // Calcula a quantidade de pisos necessários para cobrir a área do cômodo
    $quantidadePiso = $areaComodo / $areaPiso;

    // Calcula a quantidade de piso extra (margem) que será adicionada à quantidade total
    $margem = $quantidadePiso * ($dados -> margem / 100);

    // Calcula o total de pisos necessários, incluindo a margem adicional
    $quantidadeTotal = $quantidadePiso + $margem;

    // Usa a função ceil para arredondar os resultados para cima, garantindo que valores fracionados sejam arredondados para o número inteiro mais próximo
    // Retorna os resultados em formato JSON
    echo json_encode([
        "areaComodo" => ceil($areaComodo),  // Área do cômodo arredondada para cima
        "areaPiso" => ceil($areaPiso),      // Área do piso arredondada para cima
        "quantidade" => ceil($quantidadePiso),  // Quantidade de pisos necessária arredondada para cima
        "quantidadeMargem" => ceil($margem),    // Quantidade de pisos para margem arredondada para cima
        "quantidadeTotal" => ceil($quantidadeTotal)  // Quantidade total de pisos arredondada para cima
    ]);

} else {
    // Caso o método da requisição não seja POST, exibe uma mensagem de erro em formato JSON
    echo json_encode(['erro' => 'Método não suportado. Use o POST']);
}
?>