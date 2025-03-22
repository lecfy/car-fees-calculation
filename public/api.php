<?php
define('APP_ROOT', dirname(__DIR__));

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require APP_ROOT . '/vendor/autoload.php';

$requestData = json_decode(file_get_contents('php://input'), true);

$controller = new \App\Controllers\CalculationController();
$controller->processApiRequest();