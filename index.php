<?php


  $caminho = __DIR__ . '/estabelecimentos.db';
  $db = new PDO ("sqlite:{$caminho}");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  $tipoFiltro = $_GET['tipo'] ?? '';

  $tipos = ['Restaurante', 'Farmácia', 'Supermercado','Loja', 'Serviço','Lanchonete','Hamburgueria','Bar','Sorveteria','Pizzaria','Escola','Banco','Saude','Beleza','Agro','Mercado','Tecnologia'];

  if ($tipoFiltro && in_array($tipoFiltro, $tipos)) {
    $stmt = $db->prepare("SELECT * FROM estabelecimentos WHERE tipo = :tipo ORDER BY nome");
    $stmt->execute([':tipo' => $tipoFiltro]);
    $estabelecimentos = $stmt->fetchAll();
} else {
    $estabelecimentos = $db->query("SELECT * FROM estabelecimentos ORDER BY tipo, nome")->fetchAll();
}

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
<nav class="filtros">
    <a href="?" <?php echo !$tipoFiltro ? 'class="ativo"' : '' ?>>Todos</a>
    <?php foreach ($tipos as $tipo): ?>
        <a href="?tipo=<?php echo urlencode($tipo); ?>" <?php echo $tipoFiltro === $tipo ? 'class="ativo"' : ''; ?>>
            <?php echo $tipo; ?>
        </a>
    <?php endforeach ?>
</nav>
  </div>
  <div class = "container">
 <?php if (empty($estabelecimentos)): ?>
        <p class="vazio">Nenhum estabelecimento encontrado.</p>
    <?php else: ?>
        <?php foreach ($estabelecimentos as $estabelecimento): ?>
            <div class="container-single">
                <div class="card-header">
                    <h2><?php echo $estabelecimento['nome']; ?></h2>
                    <br>
                <span class="badge"><?php echo $estabelecimento['tipo']; ?></span>
                <hr>
                </div>
                <?php if ($estabelecimento['link']&& trim($estabelecimento['link'])!="#"): ?>
                    <a href="<?php echo $estabelecimento['link']; ?>" target="_blank" class="botao">Acessar o site</a>
                        <?php endif ?>
                
                <p class="info"><br><?php echo $estabelecimento['endereco']; ?></p>
                <?php if ($estabelecimento['telefone']): ?>
                    <p class="info"><?php echo $estabelecimento['telefone']; ?></p>
                <?php endif ?>
                <?php if ($estabelecimento['horario']): ?>
                    <p class="info"><?php echo $estabelecimento['horario']; ?></p>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    <?php endif ?>
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