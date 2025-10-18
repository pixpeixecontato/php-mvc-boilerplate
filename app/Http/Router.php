<?php

namespace App\Http;

use Exception;

class Router
{
    private string $url;
    private array $routes;
    private Request $request;
    public function __construct(string $url)
    {
        $this->url = $url;
        $this->request = new Request();
    }
    public function get(string $path, callable $function)
    {
        $this->addRoute("GET", $path, $function);
    }
    public function post(string $path, callable $function)
    {
        $this->addRoute("POST", $path, $function);
    }
    public function put(string $path, callable $function)
    {
        $this->addRoute("PUT", $path, $function);
    }
    public function delete(string $path, callable $function)
    {
        $this->addRoute("DELETE", $path, $function);
    }
    public function dispatch(): void
    {
        try {
            $content = $this->getRoute();
            (new Response($content,200))->response();
        } catch (Exception $e) {
            (new Response($e->getMessage(), $e->getCode()))->response();
        }
    }
    private function getRoute(): string
    {
        $currentRoute = $this->getCurrentRoute();

        $function = $currentRoute["callable"];
        $vars = $currentRoute["currentVars"];

        return call_user_func_array($function, $vars);
    }
    private function getCurrentRoute()
    {
        $path = $this->request->getUri();
        $method = $this->request->getMethod();

        $xPath = explode("/", $path);

        $currentRoute = null;
        $methodNotAllowedError = false;
        foreach ($this->routes as $pathRoute => $route) {
            $xPathRoute = explode("/", $pathRoute);
            $variablesCount = count($route[$method]["vars"] ?? []);
            $xPathCopy = $xPath;
            $currentVariables = array_splice($xPathCopy,count($xPathCopy) - $variablesCount);
            $maxMatches = count($xPathRoute) - $variablesCount;
            if (count($xPath) == count($xPathRoute)) {
                $matches = 0;
                foreach ($xPathRoute as $key => $value) {
                    if ($xPathRoute[$key] == $xPath[$key]) 
                    {
                        $matches++;
                        if ($matches == $maxMatches) {
                            if (isset($route[$method])) {
                                $methodNotAllowedError = false;
                                $currentRoute = $route;
                                $currentRoute[$method]["currentVars"] = $currentVariables;
                                continue;
                            }
                            $methodNotAllowedError = true;
                        }
                    }
                }
            }
        }
        if ($methodNotAllowedError) {
            throw new Exception("Metodo não permitido", 405);
        }
        if (!$currentRoute) {
            throw new Exception("Rota não existente encontrada", 404);
        }
        return $currentRoute[$method]; 
    }
    private function addRoute(string $method, string $path, ?callable $function = null): void
    {
        $vars = $this->getVarsFromPath($path);
        $this->routes[$path][$method] = ["callable" => $function, "vars" => $vars];
    }
    private function getVarsFromPath(string $path): array
    {
        $xPath = explode("/", $path);
        $vars = array_filter($xPath, function ($item) {
            return str_contains($item, "{");
        });
        return array_values($vars);
    }
}
