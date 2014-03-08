<?php

class Collection {
    private $data;
    
    
    public function __construct($data) {
        $this->data = $data;
    }
    
    public function get() {
        return $data;
    }
    
    public function limitBy($size) {
        $this->data = array_slice($this->data, 0, $size);
    }
    
    public function findBy($property, $value) {
        
        foreach ($this->data as $item) {
            if (is_string($item->{$property}) ? strtolower($item->{$property}) == strtolower($value) : $item->{$property} == $value) {
                return $item;
            }
        }
        
        return null;
    }
    
    public function filterBy($property, $value) {
        $result = array();
        
        foreach ($this->data as $item) {

            if (is_string($item->{$property}) ? strtolower($item->{$property}) == strtolower($value) : $item->{$property} == $value) {
                array_push($result, $item);
            }
        }
        
        $this->data = $result;
    }
    
    public function sortBy($property) {
        // Todo
    }
}