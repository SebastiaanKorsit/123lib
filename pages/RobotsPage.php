<?php

require_once '123lib/system/Page.php';
require_once '123lib/system/SEOPage.php';

class RobotsPage extends Page {
    
    public function __construct($router) {
        Page::__construct($router, 'robots.txt.mustache');
    }
    
    private function getHiddenPages() {
        $result = array();
        
        $paths = $this->router->getPaths();
        
        
        foreach ($paths as $path) {
            
            if ($path == '/robots.txt' || $path == '/sitemap.xml') {
                continue;
            }
            
            $page = $this->router->resolve($path);
            
            if (!($page instanceof SEOPage)) {
                array_push($result, $page);
            }
        }
        
        return $result;
    }
    
    public function render($scope = array()) {
        header('Content-Type: text/plain');
        
        return Page::render(array_merge(array(
            'pages' => $this->getHiddenPages(),
        ), $scope));
    }
}