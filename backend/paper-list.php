<?php
use Bibliotech\MyApi\Read\Read;
require_once __DIR__ . '/../vendor/autoload.php';

$papers = new Read('bibliotech');
echo $papers->list();
?>