<?php

namespace TaskManager\Controller;

use Twig_Loader_Filesystem;
use Twig_Environment;

class BaseController
{
    private $twig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
        $this->twig = new Twig_Environment($loader);
    }

    public function render(string $name, array $array)
    {
        echo $this->twig->render($name, $array);
    }
}