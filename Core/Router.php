<?php
/**
 * class Router
 */
class Router
{   
    /**
     * the routes table , store the infomation about all routes
     *
     * @var array
     */
    protected $routes = [];

    /**
     * the params about a route
     *
     * @var array
     */
    protected $params = [];

    /**
     * make a given route to a reg, and add it to the routes array(table)
     *
     * @param [string] $route
     * @param [array] $params
     * @return void
     */
    public function add($route, $params = [])
    {
        //find / in $route, and convert it to \/, you need to use \\ represent \
        $route = preg_replace('/\//', '\\/', $route);
        //find {} and anything between it, convert to part of the reg
        //maybe convert variables better?
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        //convert variables with custom regexpressions eg:{id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        //make $route a full reg
        $route = '/^' . $route . '$/i';
        //var_dump($route);
        //exit();
        $this->routes[$route] = $params;
    }

    /**
     * get all the routes in the routes table
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * mathch the requested url and the routes in routes table
     *
     * @param [string] $url
     * @return [boolean] whether the url is matched with the routes
     */
    public function match($url)
    {
        //foreach all reg in $this->routes
        foreach($this->routes as $route => $params) {
            //check if this reg matches with $url
            if (preg_match($route, $url, $matches)) {
                //if matches, foreach $matches to get controller and action, $matches maybe
                //empty
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        //before $params maybe empty
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * get the params about current route
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}