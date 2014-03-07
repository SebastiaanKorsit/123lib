<?php

require_once 'layout/Template.php';
require_once 'system/Router.php';

class Page {
    private $template;
    private $location;
    
    public $view;
    public $partials;
    protected $title;
    protected $name;
    protected $scope;
    
    public function __construct($view, $partials = array()) {
        $this->template = new Template($view, $partials);
        $this->view = $view;
        $this->partials = $partials;
        
        $this->scope = array(
            'page' => $this,
            'host' => Router::getHost(),
        );
    }
    
    protected function expose($scope) {
        $this->scope = array_merge($this->scope, $scope);
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function render($scope = array()) {
        return Template::render(array_merge($this->scope, $scope));
    }
}
