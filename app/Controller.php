<?php

class Controller
{
    /** @var Container */
    private $container;

    /**
     * Controller constructor.
     * @param $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get(string $name)
    {
        return $this->container->get($name);
    }

    public function render(string $name, array $array = [])
    {
        /** @var Twig_Environment $templateEngine */
        $templateEngine = $this->get('twig');
        $appExtension = $this->get('app_extension');
        $templateEngine->addExtension($appExtension);

        return $templateEngine->render($name, $array);
    }
}
