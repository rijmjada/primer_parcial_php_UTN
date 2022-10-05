<?php
/*
modificarNeumaticoBD.php: Se recibirán por POST los siguientes valores: neumatico_json (id, marca, medidas y
precio, en formato de cadena JSON) para modificar un neumático en la base de datos. Invocar al método
modificar.
Nota: El valor del id, será el id del neumático 'original', mientras que el resto de los valores serán los del
neumático a ser modificado.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/

require_once("clases/neumaticoBD.php");

// Recibo los datos en formato json por Post
$neumatico_json = $_POST["neumatico_json"];

// Decodifico el json a un objecto StdClass
$n_decode = json_decode($neumatico_json);

// Genero una instancia de NeumaticoBD para acceder a sus metodos
$neumatico = new NeumaticoBD($n_decode->marca, $n_decode->medidas, $n_decode->precio, $n_decode->id);

// Ejecuto la función
echo $neumatico->Modificar($neumatico);