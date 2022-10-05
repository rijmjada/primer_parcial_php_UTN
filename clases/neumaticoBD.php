<?php

require_once("neumatico.php");
require_once("AccesoDatos.php");
require_once("IParte1.php");
require_once("IParte2.php");
require_once("IParte3.php");
require_once("IParte4.php");




class NeumaticoBD extends Neumatico implements IParte1, IParte2, IParte3, IParte4
{
    #region Atributos
    protected int $id;
    protected string $pathFoto;
    #endregion

    #region Constructor
    public function __construct(string $_marca = "", string $_medidas = "", float $_precio = 0, int $_id = 0, string $_pathFoto = "")
    {
        parent::__construct($_marca, $_medidas, $_precio);

        $this->id = $_id;
        $this->pathFoto = $_pathFoto;
    }
    #endregion

    #region Metodos
    public function toJSON(): string
    {
        return json_encode($this);
    }

    public function set_foto(string $foto)
    {
        $this->pathFoto = $foto;
    }

    #region Interfaz IParte1
    public function Agregar(): bool
    {
        $retorno = false;
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->retornarConsulta("INSERT INTO neumaticos(id, marca, medidas, precio, foto) 
                                            VALUES (null, :marca, :medidas, :precio, :foto)");

            $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
            $consulta->bindValue(':medidas', $this->medidas, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->pathFoto, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $this->precio, PDO::PARAM_STR);



            $retorno = $consulta->execute();
        } catch (Exception $e) {
            print($e);
        } finally {
            return $retorno;
        }
    }

    public static function Traer(): array
    {
        $array_ret = array();

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM `neumaticos`");

        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_OBJ);

        $temp_array = $consulta->fetchAll();

        if ($temp_array != false)
            $array_ret = $temp_array;

        return $array_ret;
    }
    #endregion

    #region Interfaz Iparte2
    public function Modificar(): bool
    {
        $retorno = false;
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->retornarConsulta("UPDATE neumaticos SET marca=:marca,
                                                medidas=:medidas, precio=:precio, foto=:foto WHERE id=:id");

            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
            $consulta->bindValue(':medidas', $this->medidas, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);

            $retorno = $consulta->execute();
        } catch (Exception $e) {
            print($e);
        } finally {
            return $retorno;
        }
    }

    public static function Eliminar($id): bool
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->retornarConsulta("DELETE FROM `neumaticos` WHERE id=:id");

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        $consulta->execute();

        if ($consulta->rowCount() > 0)
            return true;
        else
            return false;
    }
    #endregion

    #region Interfaz IParte3
    /*retorna true, si la instancia actual está en el array de objetos de tipo NeumaticoBD que recibe
    como parámetro (comparar por marca y medidas). Caso contrario retorna false.*/
    public function Existe(array $neumaticos): bool
    {
        $ret = false;
        if ($neumaticos !== null) {
            foreach ($neumaticos as $item) {
                if (($item->marca == $this->marca) && ($item->medidas == $this->medidas)) {
                    $ret = true;
                    break;
                }
            }
        }
        return $ret;
    }

    #endregion

    #region Interfaz IParte4
    public function guardarEnArchivo(): string
    {
        $ret = new stdClass();
        $ret->bool = false;
        $ret->mensaje = "error";

        $path = "archivos/neumaticosbd_borrados.txt";
        $info_neumatico = $this->jsonSerialize();
        $new_ubicacion_nombre = "archivos/neumaticosBorrados/" . $info_neumatico->id . "." . $info_neumatico->marca . "." . "borrado" . date("his") . ".jpg"; 

        try {
            $file = fopen($path, "a");
            if ($file) {
                $info_neumatico_json = json_encode($info_neumatico);
                fwrite($file, $info_neumatico_json);
                move_uploaded_file($info_neumatico->pathFoto, $new_ubicacion_nombre);
            }
        } catch (Exception) {
            echo "Error al guardar el archivo";
        } finally {
            fclose($file);
        }

        return json_encode($ret);
    }
    #endregion


    #endregion

}
