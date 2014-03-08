<?php

require_once '123lib/api/Request.php';

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
        return '&euro;'.$this->value;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    public function getPriceAsInteger() {
        return floor($this->price);
    }
    
    public function getPriceDecimals() {
        return 100 * ($this->price - floor($this->price));
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
    
    public static function find($productID, $products = null) {
        
        if ($products == null) {
            $products = Product::getAll();
        }
        
        foreach ($products as $product) {
            if ($product->identifier == $productID) {
                return $product;
            }
        }
        
        return null;
    }
    
    public static function filter($property, $value, $products = null)
    {
        if ($products == null) {
            $products = Product::getAll();
        }
        
        $result = array();
        
        foreach ($products as $product) {

            if (is_string($product->{$property}) ? strtolower($product->{$property}) == strtolower($value) : $product->{$property} == $value) {
                array_push($result, $product);
            }
        }
        
        return $result;
    }
    
} 