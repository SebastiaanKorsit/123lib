<?php

require_once '123lib/system/Page.php';
require_once '123lib/system/SEOPage.php';

class SitemapPage extends Page {
    
    public function __construct($router) {
        Page::__construct($router, '123sitemap.mustache');
                
        $this->expose(array(
            'pages' => $this->getSEOPages($router),
        ));
    }
    
    private function getSEOPages($router) {
        $result = array();
        
        $paths = $router->getPaths();
        
        foreach ($paths as $path) {
            
            if ($path == '/robots.txt' || $path == '/sitemap.xml') {
                continue;
            }
            
            $page = $router->resolve($path);
            
            if ($page instanceof SEOPage) {
                array_push($result, $page);
            }
        }
        
        return $result;
    }
}
