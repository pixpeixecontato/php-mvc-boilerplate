<?php

namespace App\View;

class View
{
    public static function render(string $viewPath,array $vars = []): string
    {
        $content = self::getContent($viewPath);
        $keysVars = array_keys($vars);
        $keysVars = array_map(function($item){
            return "{{".$item."}}";
        },$keysVars);
        return str_replace($keysVars, array_values($vars),$content);
    }
    private static function getContent(string $viewPath):string
    {
        $viewPath = __DIR__ . "/resources/$viewPath.view.html";
        return file_exists($viewPath) ? file_get_contents($viewPath) : "";
    }
}