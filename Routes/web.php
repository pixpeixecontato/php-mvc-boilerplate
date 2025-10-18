<?php

use App\Http\Router;
use App\Controllers\Login;

$router = new Router($_ENV["SERVER_HOST"]);




$router->get("/", fn () => Login::index());


$router->get("/exemple/{id}", function($id = 1) {
    return "<h1>id: $id</h1>";
});






$router->dispatch();