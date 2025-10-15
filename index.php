<?php

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use App\Controllers\Login;

$login = new Login();
echo $login->index();
// if ($userHasSession) {
    
// } else {
    
// }