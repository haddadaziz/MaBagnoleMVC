<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use App\Controllers\HomeController;

$controller = new HomeController();
$controller->index();
?>