<?php

require_once '123lib/api/Request.php';
require_once '123lib/utils/Price.php';

class Product {
    private $identifier, $value, $price, $stock, $color, $brand, $categories, $country, $name, $image, $tax;
    
    public function __construct($identifier, $value, $price, $stock, $color, $brand, $categories, $country, $name, $image, $tax) {
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
        $this->tax = $tax;
    }
    
    public function getLocation() {
        // Experimental!
        // Bether get this from a database for potential scaling...
        
        switch (strtolower($this->getBrand())) {
            case "itunes":
                return "//123ituneskaart.nl/itunes-kaart-" . $this->getValue()->getData() . "-euro";
            case "spotify":
                return "//123spotifygiftcard.nl/spotify-giftcard-" . $this->getValue()->getData() . "-euro";
            case "playstore":
                return "//123googleplaygiftcard.nl/playstore-giftcard-" . $this->getValue()->getData() . "-euro";
            default:
                return "/404";
        }
    }
    
    public function getRedeemLocation() {
        switch (strtolower($this->getBrand())) {
            case "itunes":
                return "//123ituneskaart.nl/verzilveren";
            case "spotify":
                return "//123spotifygiftcard.nl/verzilveren";
            case "playstore":
                return "//123googleplaygiftcard.nl/verzilveren";
            default:
                return "/404";
        }
    }
    
    public function getIdentifier() {
        return $this->identifier;
    }
    
    public function getValue() {
        return new Price($this->value);
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
        
        return $this->getBrand() . " giftcard " . $this->getValue()->getData() . " euro";
        
        //return $this->name;
    }
    
    public function getImage() {
        return $this->image;
    }
    
    public function isAvailable() {
        return $this->getStock() > 0;
    }
    
    public function getTaxPercentage() {
        return $this->tax;
    }
    
    public function getTaxAmount() {
        return new Price($this->value * $this->tax/100);
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
                    $v->country,
                    $v->name,
                    $v->image,
                    $v->tax
                );

                array_push($result, $p);
            }

            Product::$allProducts = $result;
        }
        
        return Product::$allProducts;
    }
} 