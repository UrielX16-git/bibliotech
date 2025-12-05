<?php
namespace Bibliotech\MyApi\Create;

use Bibliotech\MyApi\DataBase;

class Create extends DataBase
{
    public function __construct($db, $user = 'root', $pass = '161202', $host = 'localhost')
    {
        parent::__construct($db, $user, $pass, $host);
    }

    public function add($params, $files)
    {
        $data = array(
            'status' => 'error',
            'message' => 'Error desconocido'
        );

        // Probar que el nombre no exista
        $check = json_decode($this->checkName($params['nombre']));
        if ($check->status == 'error') {
            $data['message'] = $check->message;
            return json_encode($data, JSON_PRETTY_PRINT);
        }

        // Limpiar nombre
        $cleanName = $this->SustituirCaracteres($params['nombre']);

        $imgDir = __DIR__ . '/../../../archivos/img/';
        $paperDir = __DIR__ . '/../../../archivos/papers/';

        if (isset($files['imagen']) && $files['imagen']['error'] === UPLOAD_ERR_OK) {
            $imgExt = pathinfo($files['imagen']['name'], PATHINFO_EXTENSION);
            $imgName = $cleanName . '.' . $imgExt;
            $imgPath = $imgDir . $imgName;
            $dbImgPath = '../archivos/img/' . $imgName;

            if (!move_uploaded_file($files['imagen']['tmp_name'], $imgPath)) {
                $data['message'] = "Error al mover la imagen a: $imgPath";
                return json_encode($data, JSON_PRETTY_PRINT);
            }
        } else {
            // Sin imagen
            $dbImgPath = '../archivos/img/default.png';
        }

        if ($files['paper']['error'] !== UPLOAD_ERR_OK) {
            $data['message'] = 'Error en subida de PDF. Código: ' . $files['paper']['error'];
            return json_encode($data, JSON_PRETTY_PRINT);
        }
        $paperName = $cleanName . '.pdf';
        $paperPath = $paperDir . $paperName;
        $dbPaperPath = '../archivos/papers/' . $paperName;

        if (!move_uploaded_file($files['paper']['tmp_name'], $paperPath)) {
            $data['message'] = 'Error al subir el documento PDF';
            return json_encode($data, JSON_PRETTY_PRINT);
        }

        // Insertar a DB
        $this->conexion->set_charset("utf8");
        $sql = "INSERT INTO papers (Nombre, Autores, Fecha, Explicacion, Imagen, Borrado) VALUES (
            '{$params['nombre']}',
            '{$params['autores']}',
            '{$params['fecha']}',
            '{$params['explicacion']}',
            '{$dbImgPath}',
            0
        )";

        $sql = "INSERT INTO papers (Nombre, Autores, Fecha, Explicacion, Imagen, Archivo, Tipo, Borrado) VALUES (
            '{$params['nombre']}',
            '{$params['autores']}',
            '{$params['fecha']}',
            '{$params['explicacion']}',
            '{$dbImgPath}',
            '{$dbPaperPath}',
            '{$params['tipo']}',
            0
        )";

        if ($this->conexion->query($sql)) {
            $data['status'] = "success";
            $data['message'] = "Paper agregado correctamente";
        }

        $this->conexion->close();
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function checkName($nombre)
    {
        $data = array(
            'status' => 'error',
            'message' => 'Ya existe un paper con ese nombre'
        );
        if (!empty($nombre)) {
            $sql = "SELECT * FROM papers WHERE Nombre = '{$nombre}' AND Borrado = 0";
            $result = $this->conexion->query($sql);

            if ($result->num_rows == 0) {
                $data['status'] = "success";
                $data['message'] = "Nombre disponible";
            }
            $result->free();
        }
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    private function SustituirCaracteres($string)
    {
        $string = str_replace(' ', '_', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
}
