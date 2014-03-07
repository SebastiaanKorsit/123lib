<?php

require_once '123lib/layout/mustache/autoload.php';

require_once '123lib/layout/mustache/VariableFilesystemLoader.php';
require_once '123lib/layout/mustache/ExtendedFilesystemLoader.php';

class Template {
    
    private $m = null;
    private $view;
    private $partials;
    
    public function __construct($view, $partials) {
        $this->view = $view;
        $this->partials = $partials;
        
    }
    
    public function render($scope = array()) {
        $baseDirs = array(
            dirname(__FILE__).'/partials',
            dirname(__FILE__).'/../../../views',
        );
        
        $this->m = new Mustache_Engine(
            array(
                'loader' => new ExtendedFilesystemLoader($baseDirs),
                'partials_loader' => new VariableFilesystemLoader($baseDirs),
                'partials' => $this->partials,
            )
        );
        
        return $this->m->render($this->view, $scope);
    }
}



