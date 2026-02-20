<?php

use app\CSVConverter;

require __DIR__ .'/Converter.php';

$comercios = [];

$fileContent = file('comercio.csv');

if (count($fileContent) == 0) {
    exit('Arquivo vazio');
}

if (empty(trim($fileContent[0]))) {
    exit('Primeira linha vazia');
}

foreach($fileContent as $content) {
    $linha = explode(';', $content);
    $comercios[] = new CSVConverter(
        nome:$linha[0],
        categoria:$linha[4], 
        telefone:$linha[1], 
        endereco:$linha[2], 
        link:$linha[3], 
        horario:$linha[5]
    );
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Guia-Local</title>
</head>
<body>
  <div class = "header">
    <h1>Guia Local - Novo Cruzeiro</h1>
    <h2>Comércios da Cidade</h2>
  </div>
  <div class = "center" >
  <nav class = "categorias">
    <h2>CATEGORIAS</h2>
    <nav>
      <a class = "todos">Todos</a>
      <a>Restaurantes</a>
      <a>Farmácias</a>
      <a>Lojas</a>
      <a>Serviços</a>
      <a>Supermercados</a>
      <a>...</a>

    </nav>
  </nav>
  </div>
  <div class = "container">

  <?php
  
  foreach ($comercios as $key => $data) {

    $categoria = ucfirst($data->categoria);
    if($key > 0) {
    
        echo "<div class = 'container-single'>";
        echo  "<h2> {$data->nome} </h2>";
        echo  "<h3>{$categoria}</h3>";
        echo  "<hr>";
        echo "<p><br><a href = '{$data->link}' class = 'botao' target = '_blank'>Acessar Site</a><br><br>{$data->endereco}<br>{$data->telefone} <br>{$data->horario}</p>";
      echo "</div>";

    }
  }

  ?>
  </div>
</body>
<footer class = "footer">
  <p>© 2026 Guia Local - Novo Cruzeiro. Todos os direitos reservados.</p>
</footer>
</html>