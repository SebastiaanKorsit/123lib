<?php

require_once '123lib/api/Request.php';
require_once '123lib/utils/Price.php';

class Product {
    private $identifier, $value, $price, $stock, $color, $brand, $categories, $country, $name, $image;
    
    public function __construct($identifier, $value, $price, $stock, $color, $brand, $categories, $country, $name, $image) {
        $this->identifier = $identifier;
        $this->value = $value;
        $this->price = $price;
        $this->stock = $stock;
        $this->color = $color;
        $this->brand = $brand;
        $this->categories = $categories;
        $this->country = $country;
        $this->name = $name;
        $this->image = $image;
    }
    
    public function getLocation() {
        // Experimental!
        // Bether get this from a database for potential scaling...
        
        switch (strtolower($this->getBrand())) {
            case "itunes":
                return "//123ituneskaart.nl/itunes-kaart-" . $this->getValue() . "-euro";
            case "spotify":
                return "//123spotifygiftcard.nl/spotify-giftcard-" . $this->getValue() . "-euro";
            case "playstore":
                return "//123googleplaygiftcard.nl/playstore-giftcard-" . $this->getValue() . "-euro";
            default:
                return "/404";
        }
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
    
    public function getCategories() {
        return $this->categories;
    }
    
    public function getCountry() {
        return $this->country;
    }
    
    public function getName() {
        // Bether get this from a database:
        
        return $this->getBrand() . " giftcard " . $this->getValue() . " euro";
        
        //return $this->name;
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
                    $v->categories,
                    $v->types,
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