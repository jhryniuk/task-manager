<?php

class Application
{
    /** @var Container */
    private $container;

    /** @var array */
    private $routes;

    public function __construct()
    {
        $this->container = new Container();
        $this->loadServices();
    }

    public function loadParameters(string $path)
    {
        $data = yaml_parse_file($path);
        foreach ($data['parameters'] as $name => $value) {
            $this->container[$name] = $value;
        }
    }

    public function loadRoutes(string $path)
    {
        $data = yaml_parse_file($path);
        $this->routes = $data['routes'];
    }

    public function loadServices()
    {
        $this->container['twig'] = function () {
            foreach ($this->container['templates'] as $template) {
                $templates[] = sprintf('%s/../%s', __DIR__, $template);
            }
            $loader = new Twig_Loader_Filesystem(isset($templates) ? $templates : []);

            return new Twig_Environment($loader);
        };

        $this->container['task_storage_in_xml'] = function () {
            return new TaskManager\Storage\InXml\TaskStorage($this->container['xml_location']);
        };

        $this->container['task_storage_in_memory'] = function () {
            return new TaskManager\Storage\InMemory\TaskStorage();
        };
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
                $params = array_slice($output_array,1);
                $class = sprintf('\%s\Controller\%sController', $route['module'], $route['controller']);

                if (!class_exists($class)) {
                    throw new Exception(sprintf('Controller "%s" not found', $class));
                }

                $action = sprintf('%sAction', $route['action']);
                $controller = new $class($this->container);

                if (!method_exists($controller, $action)) {
                    throw new Exception(sprintf('Action "%s" not found', $action));
                }

                echo $controller->$action($params);
            }
        }
    }
}
