<?php
    require_once "Server.php";
    require_once "Filter.php";
    
    class Url {
        public $scheme;
        public $host;
        public $path;
        public $query;
        public $minify;
        
        function __construct($url, $minify = false) {
            $this->minify = $minify;
            $this->parse($url);
            
            if ($this->host == "") {
                
                $prefix = Server::getHost();
                
                if (strpos($url, "/") != 0) { // $this->path veranderd naar $url. Mogelijke error trap
                    $prefix .= "/";
                }
                
                $this->parse($prefix.$url);
            }
            
            if ($this->scheme == "") {
                $this->scheme = "http";
            }
        }
        
        function parse($url) {
            $data = new Filter(parse_url(urldecode($url)));
            $this->scheme = $data->getString("scheme");
            $this->host = $data->getString("host");
            $this->path = rtrim($data->getString("path"), "/");
            
            
            $temp = array();
            parse_str($data->getString("query"), $temp);
            $this->query = $temp;
        }
        
        function addParameter($name, $value) {
            $this->query[$name] = (string)$value;
        }
        
        function removeParameter($name) {
            unset($this->query[$name]);
        }
        
        static function current() {
            $str = $_SERVER['REQUEST_URI'];
            
            $url = new Url($str);
            return $url;
        }
        
        function __toString() {
            if ($this->minify && $this->isLocal()) {
                $scheme = "";
                $host = "";
            } else {
                $scheme = $this->scheme."://";
                $host = $this->host;
            }
            $path = empty($this->path) ? "/" : $this->path;
            $query = (empty($this->query) ? "" : "?".http_build_query($this->query));

            return $scheme.$host.$path.$query;;
        }
        
        function encode() {
            return urlencode($this->__toString());
        } 
        
        function parts() {
            $parts = explode("/", $this->path);
            
            if (reset($parts) == "") {
                array_shift($parts);
            }
            if (end($parts) == "") {
                array_pop($parts);
            }
            if (end($parts) == "/") {
                array_pop($parts);
            }
            
            return $parts;
        }
        
        function isLocal() {
            return $this->scheme."://".$this->host == Server::getHost();
        }
        
        public static function compare($a, $b)
        {
            if ($a->host == $b->host && $a->path == $b->path) {
                return 0;
            } else {
                return 1;
            }
        }
    }
?>
