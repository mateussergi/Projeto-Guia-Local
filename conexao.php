<?php

try{
  $conn = new PDO ("sqlite:C:/laragon/www/guia_local/estabelecimentos.db");
    echo"Conectado com sucesso!";
}
catch(PDOException $e){
  echo"Erro: " . $e->getmessage();
}

?>