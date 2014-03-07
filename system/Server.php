<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Server
 *
 * @author Tim
 */



class Server {
    static function init() {
        /*
         * for every file in sitemap where acceptIndex == true
         *  acceptIndex
         * else
         *  denyIndex
         */
    }
    
    static function getHost() {
        return "http://123ituneskaart.nl";
    }

    static function redirect($url, $permanent = false) {
        
        header("Location: ".$url, true, $permanent ? 301 : 302);
        die();
    }
    
    static function forward($from, $to) {
        $to->minify = true;
        $from->addParameter("forward_url", (string)($to->encode()));
        Server::redirect($from);
    }
    
    static function noIndex() {
        header("X-Robots-Tag: noindex,nofollow");
    }
}



?>
