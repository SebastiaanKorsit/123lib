<?php

require_once '123lib/system/Page.php';

class SEOPage extends Page {    
    private $depencies;
    
    public function __construct($view, $partials = array()) {
        Page::__construct($view, $partials);
        
        /* Manage depencies: */
        
        $this->depencies = array();
        
        $this->addDepency(dirname(__FILE__).'/../../views/'.$this->view);
        
        foreach ($this->partials as $fname) {
            $this->addDepency(dirname(__FILE__).'/../../views/'.$fname);
        }
    }
    
    protected function addDepency($path) {
        array_push($this->depencies, $path);
    }
    
    // Sitemap properties:
    public function getChangeFrequency() {
        $t = $this->getPreviousLastModified();
        $d = time() - $t;
        
        if ($d > 7*24*60*60) {
            $cf = 'monthly';
        } if ($d > 2*24*60*60) {
            $cf = 'weekly';
        } else if ($d > 12*60*60) {
            $cf = 'daily';
        } else {
            return $this->getPreviousChangeFrequency();
        }
        
        ModificationHistory::set('CF:'.$this->getLocation(), $cf);
        return $cf;
    }

    private function getPreviousChangeFrequency() {
        return ModificationHistory::get('CF:'.$this->getLocation());
    }
    
    private function getPreviousLastModified() {
        return ModificationHistory::get('LM:'.$this->getLocation());
    }
    
    public function getLastModified() {
        
        // Determine the most recent modification in one of the depencies:
        $lastTimestamp = 0;
        
        foreach ($this->depencies as $dep) {
            $timestamp = filemtime($dep);
            
            if ($timestamp > $lastTimestamp) {
                $lastTimestamp = $timestamp;
            }
        }
        
        ModificationHistory::set('LM:'.$this->getLocation(), $lastTimestamp);
        
        return date('c', $lastTimestamp);
    }

    public function getPriority() {
        return .5;
    }
}


class ModificationHistory {
    private static $data;
    
    public static function load() {
        if (ModificationHistory::$data == null) {
            if (!file_exists('modification-history.json')) {
                ModificationHistory::$data = array();
                ModificationHistory::update();
            }
            ModificationHistory::$data = json_decode(file_get_contents('modification-history.json'), true);
        }
    }
    
    public static function get($key) {
        ModificationHistory::load();
        
        return array_key_exists($key, ModificationHistory::$data) ? ModificationHistory::$data[$key] : null;
    }
    
    public static function set($key, $value) {
        ModificationHistory::load();
        
        if (ModificationHistory::$data == null) {
            ModificationHistory::$data = array();
        }
        
        ModificationHistory::$data[$key] = $value;
        ModificationHistory::update();
    }
    
    public static function update() {
        file_put_contents('modification-history.json', json_encode(ModificationHistory::$data));
    }
}