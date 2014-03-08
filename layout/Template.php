<?php

require_once '123lib/layout/mustache/autoload.php';

require_once '123lib/layout/mustache/VariableFilesystemLoader.php';
require_once '123lib/layout/mustache/ExtendedFilesystemLoader.php';

class Template {
    
    private $m = null;
    private $view;
    private $partials;
    private $filesystemloader;
    
    public function __construct($filesystemloader, $view, $partials) {
        $this->view = $view;
        $this->partials = $partials;
        $this->filesystemloader = $filesystemloader;
    }
    
    public function render($scope = array()) {
        $baseDirs = array(
            dirname(__FILE__).'/partials',
            dirname(__FILE__).'/../../../views',
        );
        
        $this->m = new Mustache_Engine(
            array(
                'loader' => $this->filesystemloader,
                'partials_loader' => $this->filesystemloader,
                'partials' => $this->partials,
            )
        );
        
        return $this->m->render($this->view, $scope);
    }
}



