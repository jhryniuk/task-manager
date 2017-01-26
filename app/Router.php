<?php

class Router
{
    /** @var array */
    private static $routes = [
        '/' => [
            'module'      => 'TaskManager',
            'controller'  => 'Task',
            'action'      => 'index'
        ],
        '/tasks' => [
            'module'      => 'TaskManager',
            'controller'  => 'Task',
            'action'      => 'index'
        ],
        '/tasks/(\d+)' => [
            'module'      => 'TaskManager',
            'controller'  => 'Task',
            'action'      => 'show'
        ],
        '/tasks/new' => [
            'module'      => 'TaskManager',
            'controller'  => 'Task',
            'action'      => 'create'
        ]
    ];

    public static function handle(string $uri)
    {
        foreach (self::$routes as $pattern => $route) {

            $pattern = str_replace('/', '\/', $pattern);
            $pattern = sprintf('/%s$/', $pattern);

            if (preg_match($pattern, $uri, $output_array)) {
                $params = array_slice($output_array,1);
                $class = sprintf('\%s\Controller\%sController', $route['module'], $route['controller']);
                $action = sprintf('%sAction', $route['action']);
                $controller = new $class();
                $controller->$action($params);
            }
        }
    }
}
