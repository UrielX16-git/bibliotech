<?php
use Bibliotech\MyApi\Create\Create;
require_once __DIR__ . '/../vendor/autoload.php';

$create = new Create('bibliotech');
$nombre = $_GET['nombre'];
echo $create->checkName($nombre);
?>