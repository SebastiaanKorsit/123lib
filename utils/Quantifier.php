<?php

class Quantifier implements JsonSerializable  {
    private $count;
    private $product;
    
    public function __construct($product, $count = 0) {
        $this->product = $product;
        $this->count = $count;
    }
    
    public function addOne() {
        $this->count += 1;
    }
    
    public function removeOne() {
        $this->count -= 1;
    }
    
    public function setCount($count) {
        $this->count = $count;
    }
    
    public function getCount() {
        return $this->count;
    }
    
    public function getProduct() {
        return $this->product;
    }

    public function jsonSerialize() {
        return array(
            'count' => $this->count,
            'product' => $this->product,
        );
    }

}
