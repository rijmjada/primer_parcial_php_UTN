<?php
/*
listadoNeumaticosJSON.php: (GET) Se mostrará el listado de todos los neumáticos en formato JSON (traerJSON).
Pasarle './archivos/neumaticos.json' cómo parámetro.
*/

require_once("clases/Neumatico.php");

$json_listado = json_encode(Neumatico::traerJSON("archivos/neumaticos.json"));

echo $json_listado;