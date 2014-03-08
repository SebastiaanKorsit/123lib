<?php

class Collection {
    private $data;
    
    
    public function __construct($data) {
        $this->data = $data;
    }
    
    public function get() {
        return $this->data;
    }
    
    public function limitBy($size) {
        $this->data = array_slice($this->data, 0, $size);
    }
    
    public function findBy($property, $value) {
        
        foreach ($this->data as $item) {
            $match = $item->{$property}();
            
            if (is_string($match) ? strtolower($match) == strtolower($value) : $item->{$match} == $value) {
                return $item;
            }
        }
        
        return null;
    }
    
    public function filterBy($property, $value) {
        $result = array();
        
        foreach ($this->data as $item) {
            $match = $item->{$property}();
            
            if (is_string($match) ? strtolower($match) == strtolower($value) : $match == $value) {
                array_push($result, $item);
            }
        }
        
        $this->data = $result;
    }
    
    public function sortBy($property) {
        // Todo
    }
}