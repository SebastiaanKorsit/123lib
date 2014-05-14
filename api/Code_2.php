<?php

require_once '123lib/api/Product.php';
require_once '123lib/utils/Collection.php';

class Code {
    private $product, $code;
    
    public function __construct($product, $code) {
        $this->product = $product;
        $this->code = $code;
    }
    
    public function getCode() {
        return $this->code;
    }
    
    public function getProduct() {
        return $this->product;
    }
    
    public static function get($transactionId) {
        $result = null;
        
        try {
            $request = new Request('/codes.php', array(
                'trx' => $transactionId,
            ));
            
            $data = $request->get();

            $result = array();

            $products = new Collection(Product::getAll());
            
            foreach ($data as $v) {
                array_push($result, new Code($products->findBy('getIdentifier', $v->product), $v->code));
            }
            
            
        } catch (Exception $e) {
            
        }
        
        return $result;
    }
}
