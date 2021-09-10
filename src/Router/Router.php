<?php

namespace App\Router;

/**
 * Class Router
 * @package App\Router
 */
class Router
{

    private $url;
    /**
     * Contient l'ensemble des routes de l'application sous forme de tableau
     * Contains all the routes of the application in tabular form
     * @var array
     */
    private $routes = [];
    private $namedRoutes = [];

    /**
     * Initialisation de l'url
     * Initialization of the url
     * Router constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Définit la méthode en get
     * Defines the method in get
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function get($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    /**
     * Définit la méthode en post
     * Defines the method in post
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function post($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    /**
     * Permet de détecter les url selon la méthode avec le chemin +  un callable (une closure appelable)
     * Allows to detect urls according to the method with the path + a callable (a callable closure)
     * @param $path
     * @param $callable
     * @param $name
     * @param $method
     * @return Route
     */
    private function add($path, $callable, $name, $method)
    {
        // on initialise la route || we initialize the route
        $route = new Route($path, $callable);
        // On pousse dans le tableau des routes indexés par la méthode || We push in the array of routes indexed by the method
        $this->routes[$method][] = $route;
        if (is_string($callable) && $name === null) {
            $name = $callable;
        }
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    /**
     * Vérifie que l'url saisie correspond à une des routes
     * Check that the url entered corresponds to one of the routes
     * @return mixed
     * @throws RouterException
     */
    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }
        throw new RouterException('No matching routes');
    }

    /**
     * Vérifie si une route correspond aux paramètres envoyés
     * Checks if a route matches the parameters sent
     * @param $name
     * @param array $params
     * @return mixed
     * @throws RouterException
     */
    public function url($name, $params = [])
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new RouterException('No route matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }

}