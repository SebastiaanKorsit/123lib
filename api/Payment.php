<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Payment
 *
 * @author Work
 */

require_once '123lib/api/Code.php';
require_once '123lib/utils/Price.php';
    
class Payment {
    private $id, $trx, $status, $name, $email, $date, $codes;
    
    public function __construct($id, $trx, $status, $name, $email, $date, $codes) {
        $this->id = $id;
        $this->trx = $trx;
        $this->status = $status;
        $this->name = $name;
        $this->email = $email;
        $this->date = $date;
        $this->codes = $codes != null ? $codes : array();
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getTransactionId() {
        return $this->trx;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getDate() {
        return $this->date;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getStatus() {
        return $this->status;
    }
    
    public function getCodes() {
        return $this->codes;
    }
    
    public function getServiceTaxPercentage() {
        return 21;
    }
    
    public function getServiceTaxAmount() {
        return new Price($this->getServiceCosts()->getData() * $this->getServiceTaxPercentage() / 100);
    }
    
    public function getServiceCosts() {
        $result = 0;
        foreach ($this->codes as $code) {
            $product = $code->getProduct();
            $result += $product->getPrice()->getData() - $product->getValue()->getData();
        }
        return new Price($result);
    }
    
    public function getTotalTaxAmount() {
        $result = 0;
        foreach ($this->codes as $code) {
            $product = $code->getProduct();
            $result += $product->getTaxAmount()->getData();
        }
        
        $result += $this->getServiceTaxAmount()->getData();
        return new Price($result);
    }
    
    public function getTotalPrice() {
        $result = 0;
        foreach ($this->codes as $code) {
            $product = $code->getProduct();
            $result += $product->getPrice()->getData();
        }
        
        return new Price($result);
    }
    
    
    public static function get($transactionId) {
        
        try {
            $request = new Request('/payment.php', array(
                'trx' => $transactionId,
            ));
            
            $data = $request->get();
            
            
            return new Payment($data->id, $transactionId, $data->status, $data->name, $data->email, $data->date, Code::get($transactionId));
            
            
        } catch (Exception $e) {
            
        }
        
        return null;
    }
}
