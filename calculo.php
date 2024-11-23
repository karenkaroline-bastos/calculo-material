<?php
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $dados = json_decode(file_get_contents("php://input"));

    $areaComodo = $dados -> comodoLargura * $dados -> comodoComprimento;
    $areaPiso = $dados -> pisoLargura * $dados -> pisoComprimento;

    $quantidadePiso = $areaComodo / $areaPiso;

    $margem = $quantidadePiso * ($dados -> margem / 100);

    $quantidadeTotal = $quantidadePiso + $margem;

    echo json_encode([
        "areaComodo" => $areaComodo,
        "areaPiso" => $areaPiso,
        "quantidade" => $quantidadePiso,
        "quantidadeMargem" => $margem,
        "quantidadeTotal" => $quantidadeTotal
    ]);


} else {
    echo json_encode(['erro' => 'Método não suportado. Use o POST']);
}
?>