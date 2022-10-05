<?php

require_once("clases/neumaticoBD.php");
/*
agregarNeumaticoSinFoto.php: Se recibe por POST el parámetro neumático_json (marca, medidas y precio), en
formato de cadena JSON. Se invocará al método agregar.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/


$ret = new stdClass();
$ret->exito = false;
$ret->mensaje = "error";


$neumatico_json = $_POST["neumatico_json"];


$neumatico = json_decode($neumatico_json);
$neumaticoBD = new NeumaticoBD($neumatico->marca, $neumatico->medidas, $neumatico->precio);

if ($neumaticoBD->Agregar()) {
    $ret->exito = true;
    $ret->mensaje = "tod ok";
}

echo json_encode($ret);
