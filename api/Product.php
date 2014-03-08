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
        return $this->id;
    }
    
    public function getValue() {
        return '&euro;'.$this->value;
    }
    
    public function getPrice() {
        return '&euro;'.floor($this->price).'<sup>'.(100 * ($this->price - floor($this->price))).'</sup>';
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
    
    // Static:
    private static $allProducts;
    public static function getAll() {
        
        if (Product::$allProducts == null) {
            
            
            $request = new Request('/products.php');
            $data = $request->get();

            $result = array();

            foreach ($data as $v) {
                $p = new Product;

                foreach ($v as $key => $value) {
                    $p->{$key} = $value;
                }

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