<?php

require __DIR__ .'/Converter.php';


use app\CSVConverter;


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
   <div class="topo">
  <h2>CATEGORIAS</h2>
  <div class="pesquisa">
    <input type="text"  id="pesquisa" name="pesquisa" placeholder="Pesquisar..." onkeyup="pesquisar()">
  </div>
</div>
    <nav>
      <a href="#" class="todos" onclick="filtro('todos', this); return false;">Todos</a>
      <a href="#" onclick="filtro('restaurante', this);return false;">Restaurantes</a>
      <a href="#" onclick="filtro('farmácia', this);return false;">Farmácias</a>
      <a href="#" onclick="filtro('loja', this);return false;">Lojas</a>
      <a href="#" onclick="filtro('serviços', this);return false;">Serviços</a>
      <a href="#" onclick="filtro('supermercado', this);return false;">Supermercados</a>
      <a href="#" onclick="filtro('lanchonete', this);return false;">Lanchonetes</a>
      <a href="#" onclick="filtro('hamburgueria', this);return false;">Hamburguerias</a>
      <a href="#" onclick="filtro('sorveteria', this);return false;">Sorveterias</a>
      <a href="#" onclick="filtro('pizzaria', this);return false;">Pizzarias</a>
      <a href="#" onclick="filtro('escola', this);return false;">Escolas</a>
      <a href="#" onclick="filtro('banco', this);return false;">Bancos</a>
      <a href="#" onclick="filtro('saude', this);return false;">Saúde</a>
      <a href="#" onclick="filtro('beleza', this);return false;">Beleza</a>
      <a href="#" onclick="filtro('agro', this);return false;">Agro</a>
      <a href="#" onclick="filtro('mercado', this);return false;">Mercado</a>

    </nav>
  </nav>
  </div>
  <div class = "container">

  <?php
  
  foreach ($comercios as $key => $data) {

    $categoria = strtolower($data->categoria);
    if($key > 0) {
        echo "<div class = 'container-single' data-categoria='{$categoria}'>";
        echo  "<h2> {$data->nome} </h2>";
        $categoria = ucfirst($data->categoria);
        echo  "<h3>{$categoria}</h3>";
        echo  "<hr>";
        if (trim(!empty($data->link)) && trim($data->link)!="#"){
        echo "<p><br><a href = '{$data->link}' class = 'botao' target = '_blank'>Acessar Site</a></p>";
        }
        echo "<p><br><br>{$data->endereco}<br></p>";
        if (trim(!empty($data->telefone)) && trim($data->telefone)!="#"){
        echo "<p>{$data->telefone}</p>";
        }
        else{
          echo"<p>Telefone indisponível</p>";
        }
        if (trim(!empty($data->horario)) && trim($data->horario)!="#"){
        echo "<p>{$data->horario}</p>";
        }
        else{
          echo"<p>Horário indisponível</p>";
        }
      echo "</div>";
      
    }
  }

  ?>
  </div>

  <script>
    function filtro(categoria, el, event) {
      if(event) event.preventDefault(); // previne scroll
          const cards = document.querySelectorAll(".container-single");
          const links = document.querySelectorAll(".categorias nav a");

     cards.forEach(card => {
         const cat = card.getAttribute("data-categoria");
         card.style.display = (categoria === "todos" || cat === categoria) ? "block" : "none";
        });

     links.forEach(link => link.classList.remove("ativo"));
     el.classList.add("ativo");
  }

     function pesquisar(){
        const texto = document.getElementById("pesquisa").value.toLowerCase();
        const cards = document.querySelectorAll(".container-single");

     cards.forEach(card=>{
        const nome = card.querySelector("h2").innerText.toLowerCase();

     if (nome.includes(texto)){
        card.style.display = "block";
    } else {
          card.style.display = "none";
          }
    });
  }
  </script>


</body>
<footer class = "footer">
  <p>© 2026 Guia Local - Novo Cruzeiro. Todos os direitos reservados.</p>
</footer>
</html>