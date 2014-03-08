<?php

require_once '123lib/layout/mustache/autoload.php';

require_once '123lib/layout/mustache/VariableFilesystemLoader.php';
require_once '123lib/layout/mustache/ExtendedFilesystemLoader.php';

class Template {
    
    private $m = null;
    private $view;
    private $partials;
    private $router;
    private $loader;
    private $partialsLoader;
    
    public function __construct($router, $view, $partials) {
        $this->view = $view;
        $this->partials = $partials;
        $this->loader = $router->getFilesystemLoader();
        $this->partialsLoader = $router->getVariableFilesystemLoader();
    }
    
    public function render($scope = array()) {
        
        $this->m = new Mustache_Engine(
            array(
                'loader' => $this->loader,
                'partials_loader' => $this->partialsLoader,
                'partials' => $this->partials,
            )
        );
        
        return $this->m->render($this->view, $scope);
    }
}



