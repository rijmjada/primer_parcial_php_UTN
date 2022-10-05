<?php

class Neumatico implements JsonSerializable
{

    #region Atributos
    protected string $marca;
    protected string $medidas;
    protected float $precio;
    #endregion

    #region Constructor
    public function __construct(string $_marca, string $_medidas, float $_precio)
    {
        $this->marca = $_marca;
        $this->medidas = $_medidas;
        $this->precio = $_precio;
    }
    #endregion

    #region Metodos
    public function toJSON(): string
    {
        return json_encode($this);
    }

    public function guardarJSON($path) 
    {
        $ret = new stdClass;
        $ret->exito = false;
        $ret->mensaje = "error";

        $array_neumaticos = Neumatico::traerJSON($path);
        array_push($array_neumaticos, $this);

        try {
            $file = fopen($path, "w");
            if ($file) {
                $json = json_encode($array_neumaticos);
                fwrite($file, $json);

                $ret->exito = true;
                $ret->mensaje = "todo ok";
            }
        } catch (Exception) {
            echo "Error al guardar el archivo";
        } finally {
            fclose($file);
            return json_encode($ret);
        }
    }

    public static function traerJSON($path): array
    {
        $neumaticos = array();
        try {
            $json = file_get_contents($path);
            if ($json) {
                $decode_json = json_decode($json, true);
                foreach ($decode_json as $item) {
                    $usuario = new Neumatico($item["marca"], $item["medidas"], $item["precio"]);
                    array_push($neumaticos, $usuario);
                }
            }
        } catch (Exception) {
            echo "Ocurrio un error en TraerTodosJSON()";
        } finally {
            return $neumaticos;
        }
    }

    /*
    Nota: Si el neumático está registrado (comparar por marca y medidas), retornará true y el mensaje indicará la
    sumatoria de precios de aquellos neumáticos registrados con la misma marca y las mismas medidas del
    neumático recibido por parámetro. Caso contrario, retornará false, y en el mensaje se informará de lo acontecido.*/
    public static function verificarNeumaticoJSON($neumatico)
    {
        $ret = new stdClass();
        $ret->exito = false;
        $ret->mensaje = "Producto NO encontrado";
        $contador = 0;

        $array_neumaticos = Neumatico::TraerJSON("archivos/neumaticos.json");

        foreach ($array_neumaticos as $item) {
            if ($item->marca === $neumatico->marca) {
                if ($item->medidas === $neumatico->medidas) {
                    $ret->exito = true;
                    $ret->mensaje = "Producto encontrado";
                    $contador += 1;
                }
            }
        }

        if ($ret->exito == true)
            $ret->mensaje = "La cantidad de neumaticos con misma marca y medida son : {$contador}";

        return json_encode($ret);
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    #endregion
}
