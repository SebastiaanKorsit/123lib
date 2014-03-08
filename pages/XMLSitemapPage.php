<?php

require_once '123lib/system/Page.php';
require_once '123lib/system/SEOPage.php';

class XMLSitemapPage extends Page {
     
    public function __construct($router) {
        Page::__construct($router, 'sitemap.xml.mustache');
    }
    
    private function getSEOPages() {
        $result = array();
        
        $paths = $this->router->getPaths();
        
        foreach ($paths as $path) {            
            $page = $this->router->resolve($path);
            
            if ($page instanceof SEOPage) {
                array_push($result, $page);
            }
        }
        
        return $result;
    }
    
    public function render($scope = array()) {
        return Page::render(array_merge(array(
            'pages' => $this->getSEOPages(),
        ), $scope));
    }
}
