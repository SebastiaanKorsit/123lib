<?php

require_once "system/Url.php";
require_once "Utils.php";

class FilterException extends Exception {}

class Filter implements ArrayAccess {

    protected $data;

    function __construct( $data ) {
        if(!is_array($data)) {
            throw new FilterException ("Only arrays are allowed here");
        }
        $this->data = $data;
    }

    function __get( $offset ) {
        throw new FilterException( "Don't use as an array, use functions ->string() ->int() etc: ['" . $offset . "']" );
    }
    function __set( $offset, $value ) {
        throw new FilterException( "Don't modify directly: ['" . $offset . "'] = \"" . $value . "\"" );
    }

    /* 
        Implement ArrayAccess:
    */
    
    function offsetExists( $offset ) {
        $d = $this->data;
        if (isset($d[$offset])) {
            return true;
        } else {
            return false;
        }
    }

    function offsetSet( $offset, $value ) {
        $this->data[$offset] = $value;
    }

    function offsetUnset( $offset ) {
        unset( $this->data[$offset] );
    }

    function offsetGet( $offset ) {
        throw new FilterException ("Don't use this object as an array, but were an array : ". $offset);
    }

    protected function getValue($key, $default) {

        if(is_array($this->data[$key])) {
            throw new FilterException ("must use the asArray() function");
        }
        
        if ($this->exists($key)) {
            return $this->data[$key];
        } else {
            return $default;
        }
    }
    
    public function setValue( $offset, $data ) {
        $this->offsetSet( $offset, $data );
    }

    
    /*
        Information:
    */
    
    function size() {
        return count($this->data);
    }
    
    function exists($key) {
        return $this->offsetExists($key);
    }


    /*
        Utilities:
    */
    
    function getString($key, $default = "") {
        return $this->getValue($key, $default);
    }
    
    function getAlphaNumeric($key, $default = "") {
        return Utils::filterAlphaNumeric($this->getValue($key, $default));
    }
    
    function getLink($key, $default = "home/") {
        return new Url($this->getValue($key, $default));
    }
    
    function getEmail($key, $default = "") {
        return Utils::filterEmail($this->getValue($key, $default));
    }
    
    function getHTML($key, $default = "") {
        return Utils::filterHTML($this->getValue($key, $default));
    }

    function getInteger($key, $default = 0) {
        return Utils::filterInteger($this->getValue($key, $default));
    }

    function getDouble($key, $default = 0.0) {
        return Utils::filterDouble($this->getValue($key, $default));
    }
    
    function getArray($key, $default = array()) {
        if(!$this->isArray($key)) {
            throw new FilterException("only use getArray() for arrays");
        }
        if ($this->exists($key)) {
            return new Filter($this->data[$key]);
        } else {
            return $default;
        }
    }
    
    function getAsArray($key, $default = array()) {
        if(!$this->isArray($key)) {
            throw new FilterException("only use getArray() for arrays");
        }
        if ($this->exists($key)) {
            return $this->data[$key];
        } else {
            return $default;
        }
    }
    
    /*  
        Validators:
    */

    function isEmpty($key) {
        return $this->exists($key) && strlen($this->data[$key]) == 0;
    }

    function isDouble($key) {
        return $this->exists($key) && is_numeric($this->data[$key]);
    }

    function isInteger($key) {

        if (!$this->exists($key)) {
            return false;
        } elseif (isDouble($this->data[$key])) {
            $int_value = intval($this->data[$key]);
            return $int_value == $this->data[$key];
        } elseif (strlen($this->data[$key]) == 0) {
            return true;
        }
        return false;
    }

    function isArray($key) {
        return $this->exists($key) && is_array($this->data[$key]);
    }
}
?>