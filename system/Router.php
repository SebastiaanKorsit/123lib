<?php

require_once '123lib/system/Url.php';

class Router {
    private $map = array();
    private $filesystemLoader = null;
    
    public function __construct($host, $filesystemLoader) {
        Router::$host = $host;
        $this->filesystemLoader = $filesystemLoader;
    }
    
    public function when($url, $pageCallback) {
        $this->map[$url] = $pageCallback;
    }
    
    public function getPaths() {
        return \array_keys($this->map);
    }
    
    public function resolve($url) {
        Router::$currentPage = $url;
        
        if (array_key_exists((string) $url, $this->map)) {
            $page = $this->map[(string) $url]($this);
            $page->setLocation($url);
            
            return $page;
        } else {
            return null;
        }
    }
    
    public function otherwise() {
        exit();
    }
    
    public function getFilesystemLoader() {
        return $this->filesystemLoader;
    }
    
    /*
        Info
    */
    private static $currentPage;
    
    public static function getCurrentPage() {
        return Router::$currentPage;
    }
    
    private static $host;
    
    public static function getHost() {
        return Router::$host;
    }
    
    static function redirect($url, $permanent = false) {
        
        header("Location: ".$url, true, $permanent ? 301 : 302);
        die();
    }
    
    static function forward($from, $to) {
        $to->minify = true;
        $from->addParameter("forward_url", (string)($to->encode()));
        Server::redirect($from);
    }
    
    static function noIndex() {
        header("X-Robots-Tag: noindex,nofollow");
    }
}
