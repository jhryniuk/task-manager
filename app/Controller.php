<?php

class Controller
{
    protected $container;

    /**
     * Controller constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function get(string $name)
    {
        if (is_string($this->container[$name])) {
            return $this->container[$name];
        }

        return $this->container[$name]();
    }

    public function render(string $name, array $array = [])
    {
        $templateEngine = $this->get('twig');

        return $templateEngine->render($name, $array);
    }
}
