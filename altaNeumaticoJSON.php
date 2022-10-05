<?php
/*
altaNeumaticoJSON.php: Se recibe por POST la marca, las medidas y el precio. Invocar al método guardarJSON y
pasarle './archivos/neumaticos.json' cómo parámetro.
*/
require_once("clases/Neumatico.php");


$marca = $_POST["marca"];
$medidas = $_POST["medidas"];
$precio = $_POST["precio"];

$neumatico = new Neumatico($marca, $medidas, $precio);

$neumatico->guardarJSON("archivos/neumaticos.json");
