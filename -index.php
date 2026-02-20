<?php

use app\CSVConverter;

require __DIR__ .'/Converter.php';

$comercios = [];

$fileContent = file('comercio.csv');

if (count($fileContent) == 0) {
    exit('Arquivo vazio');
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

foreach ($comercios as $data) {
    echo "<p>{$data->nome}</p>";
    echo "<p>{$data->telefone}</p>";
    echo "<p>{$data->categoria}</p>";
    echo "<p>{$data->endereco}</p>";
    echo "<p>{$data->horario}</p>";
    echo "<p>{$data->link}</p>";
    echo "<hr>";
}