<?php

namespace App\Router;

class Route
{

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    /**
     * Route constructor.
     * @param $path
     * @param $callable
     */
    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    /**
     * Permet d'enchainer les paramètres // Allows you to chain parameters
     * @param $param
     * @param $regex
     * @return $this
     */
    public function with($param, $regex)
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        //var_dump($this);
        return $this;
    }

    /**
     * Vérifie qu'une route correspond à l'url // Check that a route matches the url
     * @param $url
     * @return bool
     */
    public function match($url): bool
    {
        $url = trim($url, '/');
        //var_dump($url);
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        //var_dump($matches);
        $this->matches = $matches;
        return true;
    }

    /**
     * Vérifie si le paramètre correspond à un de mes paramètres contraints // Check if the parameter matches one of my constrained parameters
     * @param $match
     * @return string
     */
    private function paramMatch($match): string
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    /**
     * Appelle le callable (closure) // Call the callable (closure)
     * @return false|mixed
     */
    public function call()
    {
        if (is_string($this->callable)) {
            $params = explode('@', $this->callable);
            $controller = "App\\Controller\\" . $params[0];
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    /**
     * Transforme les paramètres de l'url // Transform url parameters
     * @param $params
     * @return string|string[]
     */
    public function getUrl($params)
    {
        $path = $this->path;
        foreach ($params as $k => $v) {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

}