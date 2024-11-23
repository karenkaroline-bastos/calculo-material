<?php
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $dados = json_decode(file_get_contents("php://input"));

    $areaComodo = $dados -> comodoLargura * $dados -> comodoComprimento;
    $areaPiso = $dados -> pisoLargura * $dados -> pisoComprimento;

    $quantidadePiso = $areaComodo / $areaPiso;

    $margem = $quantidadePiso * ($dados -> margem / 100);

    $quantidadeTotal = $quantidadePiso + $margem;

    // ceil - Arredondando números para cima
    echo json_encode([
        "areaComodo" => ceil($areaComodo),
        "areaPiso" => ceil($areaPiso),
        "quantidade" => ceil($quantidadePiso),
        "quantidadeMargem" => ceil($margem),
        "quantidadeTotal" => ceil($quantidadeTotal)
    ]);


} else {
    echo json_encode(['erro' => 'Método não suportado. Use o POST']);
}
?>