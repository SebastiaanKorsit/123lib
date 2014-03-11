<?php

class Price {
    private $data;
    
    public function __construct($data) {
        $this->data = $data;
    }
    
    public function getUpper() {
        return (string) floor($this->data);
    }
    
    public function getLower() {
        $lower = (string) floor(($this->data - floor($this->data)) * 100);
        return strlen($lower) == 1 ? "0" . $lower : $lower;
    }
    
    public function getData() {
        return $this->data;
    }
    
    public function getPrice() {
        return new Price($this->count * $this->product->getPrice()->getData());
    }
}
