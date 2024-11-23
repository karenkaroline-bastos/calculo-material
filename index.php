<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculo de materiais</title>
    <!-- Link para o Bootstrap, que é uma biblioteca de CSS e JS para estilização e funcionalidades -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Link para o nosso arquivo CSS externo (estilos.css) -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Main é a área principal da página, aqui a gente utiliza flexbox para centralizar os elementos -->
<main class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <!-- Título da página -->
        <h1 class="text-center mt-md-2">Calculadora de Materiais</h1>

        <!-- Formulário com várias entradas de dados -->
        <div class="row g-2">
            <!-- Primeiro conjunto de campos para o "comôdo" -->
            <fieldset class="row g-2">
                <legend>Comôdo</legend>
                <div class="col-md-6">
                    <!-- Largura do comôdo -->
                    <label for="comodo-largura" class="form-label">Largura(m)</label>
                    <input type="number" class="form-control" id="comodo-largura" required>
                </div>
                <div class="col-md-6">
                    <!-- Comprimento do comôdo -->
                    <label for="comodo-comprimento" class="form-label">Comprimento(m)</label>
                    <input type="number" class="form-control" id="comodo-comprimento" required>
                </div>
            </fieldset>

            <!-- Segundo conjunto de campos para o "piso" -->
            <fieldset class="row g-2">
                <legend>Piso</legend>
                <div class="col-md-6">
                    <!-- Largura do piso -->
                    <label for="piso-largura" class="form-label">Largura(m)</label>
                    <input type="number" class="form-control" id="piso-largura" required>
                </div>
                <div class="col-md-6">
                    <!-- Comprimento do piso -->
                    <label for="piso-comprimento" class="form-label">Comprimento(m)</label>
                    <input type="number" class="form-control" id="piso-comprimento" required>
                </div>
            </fieldset>

            <!-- Campo para a margem em porcentagem -->
            <div class="col-md-12"> 
                <label for="margem" class="form-label">Margem(%)</label>
                <input type="number" class="form-control" id="margem" required>
            </div>

            <!-- Botão para acionar o cálculo -->
            <div class="col-md-12">
                <button class="btn btn-primary" id="btn-calcular" onclick="processar();">Calcular</button>
            </div>

            <!-- Aqui será mostrado o resultado do cálculo -->
            <div class="col-md-12">
                <div id="resultado" class="resultado"></div>
            </div>
        </div> 
    </div>
</main>

<!-- Inclusão do Bootstrap JS para funcionalidades interativas -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Script JavaScript para processar os dados e calcular o resultado -->
<script>
    // Função que será chamada quando o botão "Calcular" for clicado
    function processar(){
        // Coletando os valores inseridos pelo usuário nos campos de entrada
        const comodoLargura = document.getElementById("comodo-largura").value;
        const comodoComprimento = document.getElementById("comodo-comprimento").value;
        const pisoLargura = document.getElementById("piso-largura").value;
        const pisoComprimento = document.getElementById("piso-comprimento").value;
        const margem = document.getElementById("margem").value;

        // Verificando se os valores inseridos são válidos (maiores que 0)
        if(comodoLargura <= 0){
            alert("A largura do comôdo deve ser maior que 0");
            return;
        }
        if(comodoComprimento <= 0){
            alert("O comprimento do comôdo deve ser maior que 0");
            return;
        }
        if(pisoLargura <= 0){
            alert("A largura do piso deve ser maior que 0");
            return;
        }
        if(pisoComprimento <= 0){
            alert("O comprimento do piso deve ser maior que 0");
            return;
        }
        if(margem <= 0){
            alert("A margem deve ser maior que 0");
            return;
        }

        // Se todos os dados são válidos, criamos um objeto com as medidas
        const medidas = {
            comodoLargura,
            comodoComprimento,
            pisoLargura,
            pisoComprimento,
            margem
        }

        // Convertendo o objeto em uma string JSON, para enviar para o servidor
        const dados = JSON.stringify(medidas);

        // Enviando os dados para o servidor usando fetch (requisição HTTP do tipo POST)
        fetch('/calculo.php', {
            method: 'POST',
            headers: {'Content-Type':'application/json'},
            body: dados
        })
        .then(resposta => resposta.json())  // Quando o servidor responder, convertemos a resposta para JSON
        .then(resultado =>{
            let elementoResultado = document.getElementById("resultado");

            // Limpando o conteúdo do resultado anterior
            elementoResultado.innerHTML = '';

            // Montando o conteúdo que será exibido, com base na resposta do servidor
            const exibir =
                `<div>
                    <h4 class="text-center">Resultado</h4>
                    <p><strong>Área do comodo:</strong> ${resultado.areaComodo} m²</p>
                    <p><strong>Área do piso:</strong> ${resultado.areaPiso} m²</p>
                    <p><strong>Quantidade de piso:</strong> ${resultado.quantidade}</p>
                    <p><strong>Quantidade para margem:</strong> ${resultado.quantidadeMargem}</p>
                    <p><strong>Total a ser comprado:</strong> ${resultado.quantidadeTotal}</p>
                </div>`;

            // Inserindo o conteúdo na div com id "resultado"
            elementoResultado.innerHTML = exibir;
        })
        .catch(erro => {
            // Caso ocorra algum erro durante a requisição, exibimos uma mensagem de erro
            alert("Ocorreu um erro");
        });
    }
</script>

</body>
</html>
