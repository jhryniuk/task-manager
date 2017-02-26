<?php

use Symfony\Component\Yaml\Yaml;

class Application
{
    /** @var Container */
    private $container;

    /** @var array */
    private $routes;

    public function __construct()
    {
        $this->container = Container::buildContainer();
    }

    public function loadParameters(string $path)
    {
        $data = Yaml::parse(file_get_contents($path));
        $parameters = $data['parameters'];

        foreach ($data['parameters'] as $name => $parameter) {
            $parameters[$name] = (getenv($name)!== false) ? getenv($name) : $parameter;
        }

        $this->container->registerParameters($parameters);
    }

    public function loadServices(string $path)
    {
        $data = Yaml::parse(file_get_contents($path));
        $this->container->registerServices($data['services']);
    }

    public function loadRoutes(string $path)
    {
        $data = Yaml::parse(file_get_contents($path));
        $this->routes = $data['routes'];
    }

    /**
     * @param string $uri
     * @throws Exception
     */
    public function handle(string $uri)
    {
        foreach ($this->routes as $pattern => $route) {
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = sprintf('/%s$/', $pattern);

            if (preg_match($pattern, $uri, $output_array)) {
                $params = array_slice($output_array, 1);
                $class = sprintf('\%s\Controller\%sController', $route['module'], $route['controller']);

                if (!class_exists($class)) {
                    throw new Exception(sprintf('Controller "%s" not found', $class));
                }

                $action = sprintf('%sAction', $route['action']);
                $controller = new $class($this->container);

                if (!method_exists($controller, $action)) {
                    throw new Exception(sprintf('Action "%s" not found', $action));
                }

                $response = $controller->$action($params);
            }
        }

        if (!isset($response)) {
            throw new Exception(sprintf('Route "%s" not found', $uri));
        }

        echo $response;
    }
}
