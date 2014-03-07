<?php
require_once 'Url.php';

class Router {
    private $map = array();
    
    public function route($url, $pageCallback) {
        $this->map[$url] = $pageCallback;
    }
    
    public function getPaths() {
        return \array_keys($this->map);
    }
    
    public function resolve($url) {
        Router::$currentPage = $url;
        
        if (array_key_exists($url, $this->map)) {
            $page = $this->map[$url]();
            $page->setLocation($url);
            
            return $page;
        } else {
            return null;
        }
    }
    
    /*
        Info
    */
    private static $currentPage;
    
    
    public static function getCurrentPage() {
        return Router::$currentPage;
    }
    
    public static function getHost() {
        return new Url($_SERVER['REQUEST_URI']);
    }
}
