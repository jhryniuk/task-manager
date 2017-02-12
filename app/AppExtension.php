<?php

class AppExtension extends \Twig_Extension
{
    /** @var string */
    private $environment;

    /**
     * @param string $environment
     */
    public function __construct($environment = 'prod')
    {
        $this->environment = $environment;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('env', array($this, 'setEnvironment')),
        );
    }

    public function setEnvironment($url)
    {
        switch ($this->environment) {
            case 'prod':
                return $url;
                break;
            case 'dev':
                return sprintf('/index_dev.php%s', $url);
                break;
            default:
                return $url;
                break;
        }
    }
}
