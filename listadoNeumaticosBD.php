<?php

/*
listadoNeumaticosBD.php: (GET) Se mostrará el listado completo de los neumaticos (obtenidos de la base de
datos) en una tabla (HTML con cabecera). Invocar al método traer.
Nota: Si se recibe el parámetro tabla con el valor mostrar, retornará los datos en una tabla (HTML con cabecera),
preparar la tabla para que muestre la imagen, si es que la tiene.
Si el parámetro no es pasado o no contiene el valor mostrar, retornará el array de objetos con formato JSON.
*/
require_once("clases/NeumaticoBD.php");

$tabla = $_GET["tabla"];


if ($tabla == "mostrar") {
    $array_neumaticos = NeumaticoBD::Traer();

    $str = "<table>
<tr>
    <th>Id</th>
    <th>Marca</th>
    <th>Medidas</th>
    <th>Precio</th>
    <th>Foto</th>
</tr> ";

    foreach ($array_neumaticos as $item) {
        $str .= " 
            <tr>
                <td>$item->id</td>
                <td>$item->marca</td>
                <td>$item->medidas</td>
                <td>$item->precio</td>
                <td> <img src='neumaticos/imagenes/$item->foto' width='50px' height='50px'/> </td>
            </tr>";
    }

    echo $str;
}
else
{
    echo json_encode(NeumaticoBD::Traer());
}
