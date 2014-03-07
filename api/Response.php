<?php

require_once "Filter.php";
require_once "system/Server.php";
require_once "system/Url.php";

class Response {
    
    private $data = array("status" => true);
    
    public function validate($default_url = "/home/?action=oops") {
        $param = new \Filter($_GET);
        if ($param->exists("forward_url")) {
            /* @var $url Url */
            $url = $this->data["status"] ? $param->getLink("forward_url") : ($param->exists("return_url") ? $param->getLink("return_url") : new \Url($default_url));
            if ($this->data["status"] && is_array($_GET["forward_param"])) {
                foreach ($_GET["forward_param"] as $key => $value) {
                    $url->addParameter($key, $value);
                }
            }
            \Server::redirect($url);
        } else {
            echo $this->jsonSerialize();
        }
    }
    
    public function isValid() {
        return $this->data["status"];
    }
    
    public function data($arr) {
        $this->data["data"] = $arr;
    }
    
    public function error($message) {
        $this->data["status"] = false;
        $this->data["error"] = array("message" => $message);
    }
    
    public function assert($condition, $message) {
        if (!$condition && $this->data["status"]) {
            $this->error($message);
        }
    }
    
    public function jsonSerialize() {
        return json_encode($this->data);
    }
    
    public function __toString() {
        return $this->jsonSerialize();
    }
}

?>
