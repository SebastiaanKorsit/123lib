<?php

require_once '123lib/layout/mustache/autoload.php';

require_once '123lib/layout/mustache/VariableFilesystemLoader.php';
require_once '123lib/layout/mustache/ExtendedFilesystemLoader.php';

class Template {
    
    private $m = null;
    private $view;
    private $partials;
    private $router;
    
    public function __construct($router, $view, $partials) {
        $this->view = $view;
        $this->partials = $partials;
        $this->router = $router;
    }
    
    public function render($scope = array()) {
        
        $this->m = new Mustache_Engine(
            array(
                'loader' => $this->router->getFilesystemLoader(),
                'partials_loader' => $this->router->getVariableFilesystemLoader(),
                'partials' => $this->partials,
            )
        );
        
        return $this->m->render($this->view, $scope);
    }
}



