<?php


/*eliminarNeumaticoBD.php: Recibe el parámetro neumatico_json (id, marca, medidas y precio, en formato de
cadena JSON) por POST y se deberá borrar el neumático (invocando al método eliminar).
Si se pudo borrar en la base de datos, invocar al método guardarJSON y pasarle cómo parámetro el valor
'./archivos/neumaticos_eliminados.json'.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.*/

require_once("clases/neumaticoBD.php");

$neumatico_json = $_POST["neumatico_json"];

$neumatico_decode = json_decode($neumatico_json);
$neumatico = new Neumatico($neumatico_decode->marca, $neumatico_decode->medidas, $neumatico_decode->precio);


if(NeumaticoBD::Eliminar($neumatico_decode->id))
{
    echo $neumatico->guardarJSON("archivos/neumaticos_eliminados.json");
}




?>