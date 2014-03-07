<?php
require_once '123lib/system/Url.php';

class Server {
    private $router;
    
    public function __construct($router) {
        $this->router = $router;
    }
    
    public function request($path, $scope) {
        
        $page = $this->router->resolve(new Url($path));

        if ($page != null) { 

            echo $page->render($scope);

        } else {

            header('HTTP/1.0 404 Not Found');

            echo $this->router->otherwise()->render($scope);
        }
    }
}
