<?php
namespace Bibliotech\MyApi\Stats;

use Bibliotech\MyApi\DataBase;

require_once __DIR__ . '/../DataBase.php';

class Stats extends DataBase
{

    public function __construct($dbName, $user = null, $pass = null, $host = null)
    {
        $user = $user ?: getenv('DB_USER') ?: 'root';
        $pass = $pass ?: getenv('DB_PASSWORD') ?: 'root';
        $host = $host ?: getenv('DB_HOST') ?: 'localhost';
        parent::__construct($dbName, $user, $pass, $host);
    }

    public function obtenerDescargasPorTipo()
    {
        $sql = "SELECT p.Tipo, COUNT(d.id) as total 
                FROM descargas d 
                JOIN papers p ON d.paper_id = p.ID 
                GROUP BY p.Tipo";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerDescargasPorHora()
    {
        $sql = "SELECT HOUR(fecha) as hora, COUNT(id) as total 
                FROM descargas 
                GROUP BY HOUR(fecha) 
                ORDER BY hora";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPapersMasDescargados()
    {
        $sql = "SELECT p.Nombre, COUNT(d.id) as total 
                FROM descargas d 
                JOIN papers p ON d.paper_id = p.ID 
                GROUP BY p.ID 
                ORDER BY total DESC 
                LIMIT 5";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerUsuariosMasActivos()
    {
        $sql = "SELECT u.nombre, COUNT(d.id) as total 
                FROM descargas d 
                JOIN logindb u ON d.usuario_id = u.id 
                GROUP BY u.id 
                ORDER BY total DESC 
                LIMIT 5";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
