<?php

/*
Se recibirán por POST los valores: marca, medidas, precio y la foto para registrar un
neumático en la base de datos.
Verificar la previa existencia del neumático invocando al método existe. Se le pasará como parámetro el array
que retorna el método traer.
Si el neumático ya existe en la base de datos, se retornará un mensaje que indique lo acontecido.
Si el neumático no existe, se invocará al método agregar. La imagen se guardará en “./neumaticos/imagenes/”,
con el nombre formado por el marca punto hora, minutos y segundos del alta (Ejemplo: pirelli.105905.jpg).
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/

require_once("clases/neumaticoBD.php");

$ret = new stdClass();
$ret->bool = false;
$ret->mensaje = "error";


$marca = $_POST["marca"];
$medidas = $_POST["medidas"];
$precio = $_POST["precio"];
$foto = $_FILES["foto"];

// Genero una instancia de NeumaticoBD para acceder a sus metodos
$neumatico = new NeumaticoBD($marca, $medidas, $precio);

// Verifico que el neumatico no exista en la base de datos
if ($neumatico->Existe(NeumaticoBD::Traer())) {
    echo "El neumatico ya existe en la base de datos";
} else {
    $path_formato_foto = "neumaticos/" . $marca . "." . date("his") . ".jpg";    // Ruta y nombre de la imagen
    $neumatico->set_foto = $path_formato_foto;    // Asigno la ruta de la imagen a la instancia antes de guardarla en la base de datos

    // Agrego la instancia a la base de datos && Muevo el archivo a la carpeta solicitada
    if (($neumatico->Agregar()) && (move_uploaded_file($foto["tmp_name"], $path_formato_foto))) {
        $ret->bool = true;
        $ret->mensaje = "Todo Ok";
    }
    echo json_encode($ret);
}
