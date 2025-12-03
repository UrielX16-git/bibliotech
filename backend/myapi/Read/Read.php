<?php
namespace Bibliotech\MyApi\Read;

use Bibliotech\MyApi\DataBase;

class Read extends DataBase
{
    private $data = array();

    public function __construct($db, $user = 'root', $pass = '161202', $host = 'localhost')
    {
        parent::__construct($db, $user, $pass, $host);
    }

    public function list()
    {
        if ($result = $this->conexion->query("SELECT * FROM papers WHERE Borrado = 0")) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if (!is_null($rows)) {
                $this->data = $rows;
            }
            $result->free();
        } else {
            die('Query Error: ' . \mysqli_error($this->conexion));
        }
        $this->conexion->close();
        return \json_encode($this->data, JSON_PRETTY_PRINT);
    }

    public function search($search)
    {
        if (!empty($search)) {
            $sql = "SELECT * FROM papers WHERE (Nombre LIKE '%{$search}%' OR Autores LIKE '%{$search}%' OR Explicacion LIKE '%{$search}%' OR Fecha LIKE '%{$search}%') AND Borrado = 0";
            if ($result = $this->conexion->query($sql)) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                if (!\is_null($rows)) {
                    $this->data = $rows;
                }
                $result->free();
            } else {
                die('Query Error: ' . \mysqli_error($this->conexion));
            }
            $this->conexion->close();
            return \json_encode($this->data, JSON_PRETTY_PRINT);
        }
        return \json_encode([], JSON_PRETTY_PRINT);
    }
}
