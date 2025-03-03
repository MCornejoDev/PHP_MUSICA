<?php

function get_controller_name($uri_segment)
{
    if (empty($uri_segment)) {
        return defined('CONTROLLER_DEFAULT') ? CONTROLLER_DEFAULT : null;
    }

    $controller_name = ucfirst($uri_segment) . 'Controller';
    $controller_path = __DIR__ . '/Http/Controllers/' . $controller_name . '.php';

    return file_exists($controller_path) ? $controller_name : null;
}

function load_controller(?string $name_controller = null)
{
    if (is_null($name_controller)) {
        $name_controller = 'BaseController';
    }

    // Incluye el namespace completo
    $namespace = 'App\Http\Controllers\\';
    $controller_class = $namespace . $name_controller;

    return new $controller_class();
}

// Procesa URI y obtiene nombre del controlador
$uri = explode("/", trim($_SERVER["REQUEST_URI"], "/"));
$name_controller = get_controller_name($uri[0] ?? null);
$controller = load_controller($name_controller);

// Determina la acción o método a ejecutar
$action = $uri[1] ?? (defined('ACTION_DEFAULT') ? ACTION_DEFAULT : null);

if (!$action || !method_exists($controller, $action)) {
    $action = 'error404';
}

// Ejecuta el método en el controlador
$controller->$action();
