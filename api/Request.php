<?php

class Request {
    private $data;
    private $path;
    private $url;
    
    public function __construct($path, $data = array()) {
        $this->url = 'http://123giftcard.nl/api';
        $this->path = $path;
        $this->data = $data;
    }
    
    public function get($fresh = false) {
        
        $ch = curl_init();
        
        $query = http_build_query($this->data);
        
        curl_setopt($ch, CURLOPT_URL, $this->url.$this->path.(empty($query) ? "" : "?".$query));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, '5');
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, $fresh);
        
        
        $response = json_decode(curl_exec($ch));
        

        
        if ($response->status) {
            return $response->data;
        } else {
            throw new Exception('API Request error in "http://123giftcard.nl/api'.$this->path.'": '.json_encode($this->response));
        }
    }
}
