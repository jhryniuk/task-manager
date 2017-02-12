<?php

class Application
{
    /** @var Container */
    private $container;

    /** @var array */
    private $routes;

    public function __construct($environment = 'prod')
    {
        $this->container = Container::buildContainer();
        $this->container->set('env', $environment);
    }

    public function loadParameters(string $path)
    {
        $data = yaml_parse_file($path);
        $this->container->registerParameters($data['parameters']);
    }

    public function loadServices(string $path)
    {
        $data = yaml_parse_file($path);
        $this->container->registerServices($data['services']);
    }

    public function loadRoutes(string $path)
    {
        $data = yaml_parse_file($path);
        $this->routes = $data['routes'];
    }

    /**
     * @param string $uri
     * @throws Exception
     */
    public function handle(string $uri)
    {
        foreach ($this->routes as $name => $route) {

            $pattern = str_replace('/', '\/', $route['pattern']);
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
