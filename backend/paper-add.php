<?php
use Bibliotech\MyApi\Create\Create;
require_once __DIR__ . '/../vendor/autoload.php';

$create = new Create('bibliotech');
echo $create->add($_POST, $_FILES);
?>