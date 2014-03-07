<?php

require_once 'mustache.php-2.5.1/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();

require_once 'FileLoader.php';

class Template {
    
    private $m = null;
    private $view;
    private $partials;
    
    public function __construct($view, $partials) {
        $this->view = $view;
        $this->partials = $partials;
        
    }
    
    public function render($scope = array()) {
        
        $this->m = new Mustache_Engine(
            array(
                'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/../../views'),
                'partials_loader' => new FileLoader(dirname(__FILE__) . '/../../views'),
                'partials' => $this->partials,
            )
        );
        
        return $this->m->render($this->view, $scope);
    }
}



