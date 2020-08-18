<?php

namespace App;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;

class App
{
    private $request;
    private $requestContext;
    private $router;
    private $routes;
    private $controller;
    private $arguments;
    private $basePath;
    private $container = [];

    public static $instance = null;

    private function __construct($basePath = null)
    {
        $this->basePath = $basePath;
        $this->setRequest();
        $this->setRequestContext();
        $this->setRouter();

        $this->routes = $this->router->getRouteCollection();
    }

    public static function getInstance($basePath = null)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static($basePath);
        }

        return static::$instance;
    }


    private function setRequest()
    {
        $this->request = Request::createFromGlobals();
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    private function setRequestContext()
    {
        $this->requestContext = new RequestContext();
        $this->requestContext->fromRequest($this->request);
    }

    /**
     * @return mixed
     */
    public function getRequestContext()
    {
        return $this->requestContext;
    }

    private function setRouter()
    {
        $fileLocator = new FileLocator(array(__DIR__));
        $this->router = new Router(
            new YamlFileLoader($fileLocator),
            $this->basePath . '/config/routes.yaml',
            array('cache_dir' => $this->basePath . '/storage/cache')
        );
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return (new ControllerResolver())->getController($this->request);
    }

    /**
     * @param $controller
     * @return mixed
     */
    public function getArguments($controller)
    {
        return (new ArgumentResolver())->getArguments($this->request, $controller);
    }

    public function run()
    {
        $matcher = new UrlMatcher($this->routes, $this->requestContext);

        try {
            $this->request->attributes->add($matcher->match($this->request->getPathInfo()));
            $this->controller = $this->getController();
            $this->arguments = $this->getArguments($this->controller);
            $response = call_user_func_array($this->controller, $this->arguments);
        } catch (Exception $e) {
            exit('Выброшено исключение: ' . $e->getMessage());
        }

        $response->send();
    }

    public function add($key, $object)
    {
        $this->container[$key] = $object;
        return $object;
    }

    public function get($key)
    {
        if (isset($this->container[$key])) {
            return $this->container[$key];
        }
        return null;
    }
}