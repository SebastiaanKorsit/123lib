<?php

require_once 'Request.php';

class Product {
    public $id, $value, $price, $stock, $color, $brand, $country, $name, $image;
    
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