<?php

class Container implements ContainerInterface
{
    /** @var array */
    private $container = [];

    public static function buildContainer()
    {
        return new self();
    }

    public function get(string $name)
    {
        if (is_string($this->container[$name])) {
            return $this->container[$name];
        }

        return $this->container[$name]();
    }

    public function set(string $name, string $value)
    {
        if (array_key_exists($name, $this->container)) {
            return false;
        }
        $this->container[$name] = $value;

        return true;
    }

    public function has(string $name)
    {
        return array_key_exists($name, $this->container);
    }

    public function registerParameters(array $parameters)
    {
        foreach ($parameters as $name => $value) {
            $this->container[$name] = $value;
        }
    }

    public function registerServices(array $services)
    {
        foreach ($services as $name => $service) {
            $className = $service['class'];
            $arguments = isset($service['arguments']) ? $service['arguments'] : [];

            $arg = $this->getArguments($arguments);

            $r = new ReflectionClass($className);
            $obj = $r->newInstanceArgs($arg);

            $this->container[$name] = function () use ($obj) {
                return $obj;
            };
        }
    }

    private function getArguments(array $arguments)
    {
        foreach ($arguments as $argument) {
            if (substr($argument, 0, 1) == "@") {
                $arg[] = $this->container[substr($argument, 1)]();
            }
            if (substr($argument, 0, 1) == "%") {
                $arg[] = $this->container[substr($argument, 1)];
            }
        }

        return empty($arg) ? [] : $arg;
    }
}
