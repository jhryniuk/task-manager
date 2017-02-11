<?php

interface ContainerInterface
{
    /**
     * @param string $name
     * @return string|object
     */
    public function get(string $name);

    /**
     * @param string $name
     * @return boolean
     */
    public function has(string $name);

    /**
     * @param array $parameters
     */
    public function registerParameters(array $parameters);

    /**
     * @param array $services
     */
    public function registerServices(array $services);
}