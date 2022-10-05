<?php

/*
Se recibe el parámetro neumatico_json (id, marca, medidas, precio y pathFoto
en formato de cadena JSON) por POST. Se deberá borrar el neumático (invocando al método eliminar).
Si se pudo borrar en la base de datos, invocar al método guardarEnArchivo.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
Si se invoca por GET (sin parámetros), se mostrarán en una tabla (HTML) la información de todos los neumáticos
borrados y sus respectivas imagenes.
*/

require_once("clases/neumaticoBD.php");

$neumatico_json = $_POST["neumatico_json"];

// Decodifico el json a un objecto StdClass
$n_decode = json_decode($neumatico_json);

// Genero una instancia de NeumaticoBD para acceder a sus metodos
$neumatico = new NeumaticoBD($n_decode->marca, $n_decode->medidas, $n_decode->precio, $n_decode->id, $n_decode->pathFoto);
