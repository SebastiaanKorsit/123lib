<?php

require_once '123lib/system/Page.php';
require_once '123lib/system/SEOPage.php';

class RobotsPage extends Page {
    
    public function __construct($router) {
        Page::__construct($router, '123robots.mustache');
                
        $this->expose(array(
            'pages' => $this->getHiddenPages($router),
        ));
    }
    
    private function getHiddenPages($router) {
        $result = array();
        
        $paths = $router->getPaths();
        
        
        foreach ($paths as $path) {
            
            if ($path == '/robots.txt' || $path == '/sitemap.xml') {
                continue;
            }
            
            $page = $router->resolve($path);
            
            if (!($page instanceof SEOPage)) {
                array_push($result, $page);
            }
        }
        
        return $result;
    }
}