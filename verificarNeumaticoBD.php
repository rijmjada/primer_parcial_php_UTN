<?php

/*Se recibe por POST el parámetro obj_neumatico, que será una cadena JSON (marca y
medidas), si coincide con algún registro de la base de datos (invocar al método traer) retornará los datos del
objeto (invocar al toJSON). Caso contrario, un JSON vacío ({}).*/


require_once("clases/neumaticoBD.php");

// Recibo los datos en formato json por Post
$obj_neumatico = $_POST["obj_neumatico"];

// Decodifico el json a un objecto StdClass
$obj_decode = json_decode($obj_neumatico);

// Genero una instancia de NeumaticoBD para acceder a sus metodos
$neumatico = new NeumaticoBD($obj_decode->marca, $obj_decode->medidas);

// Ejecuto el metodo Existe si da true invoco al metodo toJson caso contrario retorno "({})"
$neumatico->Existe($neumatico->Traer()) ? print($neumatico->toJSON()): print("({})");

?>