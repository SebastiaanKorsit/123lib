<?php
require_once '123lib/system/Url.php';

class Server {
    private $router;
    
    public function __construct($host, $router) {
        $this->router = $router;
        Server::$host = $host;
    }
    
    private static $host;
    
    public static function getHost() {
        return new Url(Server::$host);
    }
    
    public function request($path, $scope) {
        
        $page = $router->resolve(new Url($path));

        if ($page != null) { 

            echo $page->render($scope);

        } else {

            header('HTTP/1.0 404 Not Found');

            echo $router->otherwise()->render($scope);
        }
    }
}
