<?php
require_once __DIR__ . '/backend/vendor/autoload.php';

use Bibliotech\MyApi\Read\Read;

try {
    $read = new Read('bibliotech');
    echo "Connection successful.\n";
    echo "Listing papers:\n";
    echo $read->list();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
