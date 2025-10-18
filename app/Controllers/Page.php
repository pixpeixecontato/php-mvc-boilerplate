<?php

namespace App\Controllers;

use App\View\View;

class Page
{
    public static function page(string $viewPath, array $vars = [], string $title = ""):string
    {
        $content = View::render($viewPath, $vars);
        return View::render("pages/page", [
            "content"=>$content,
            "title"=> ($title ?: $_ENV["PROJECT_NAME"])
        ]);
    }
}