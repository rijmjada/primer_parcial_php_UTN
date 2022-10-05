<?php
/*
verificarNeumaticoJSON.php: Se recibe por POST la marca y las medidas.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) (agregar el mensaje obtenido del método
verificarNeumaticoJSON).
*/

$marca = $_POST["marca"];
$medidas = $_POST["medidas"];

require_once("clases/Neumatico.php");


$neumatico = new Neumatico($marca, $medidas, 0);

echo Neumatico::verificarNeumaticoJSON($neumatico);

