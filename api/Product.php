<?php

require_once '123lib/api/Request.php';
require_once '123lib/utils/Price.php';

class Product {
    private $identifier, $value, $price, $stock, $color, $brand, $category, $country, $name, $image;
    
    public function __construct($identifier, $value, $price, $stock, $color, $brand, $category, $country, $name, $image) {
        $this->identifier = $identifier;
        $this->value = $value;
        $this->price = $price;
        $this->stock = $stock;
        $this->color = $color;
        $this->brand = $brand;
        $this->category = $category;
        $this->country = $country;
        $this->name = $name;
        $this->image = $image;
    }
    
    public function getIdentifier() {
        return $this->identifier;
    }
    
    public function getValue() {
        return $this->value;
    }
    
    public function getPrice() {
        return new Price($this->price);
    }
    
    public function getStock() {
        return $this->stock;
    }
    
    public function getColor() {
        return $this->color;
    }
    public function getBrand() {
        return $this->brand;
    }
    
    public function getCategory() {
        return $this->category;
    }
    
    public function getCountry() {
        return $this->country;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getImage() {
        return $this->image;
    }
    
    public function isAvailable() {
        return $this->getStock() > 0;
    }
    // Static:
    private static $allProducts;
    public static function getAll() {
        
        if (Product::$allProducts == null) {
            
            
            $request = new Request('/products.php');
            $data = $request->get();

            $result = array();

            foreach ($data as $v) {
                $p = new Product(
                    $v->identifier,
                    $v->value,
                    $v->price,
                    $v->stock,
                    $v->color,
                    $v->brand,
                    $v->category,
                    $v->country,
                    $v->name,
                    $v->image
                );

                array_push($result, $p);
            }

            Product::$allProducts = $result;
        }
        
        return Product::$allProducts;
    }
} 