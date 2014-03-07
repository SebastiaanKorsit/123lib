<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utils
 *
 * @author Tim
 */
class Utils {
    
    
    
    public static function post($url, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, '3');
        return curl_exec($ch);
    }
    
    public static function get($url, $data) {
        $ch = curl_init();
        $query = http_build_query($data);
        //return $url.(empty($query) ? "" : "?".$query);
        curl_setopt($ch, CURLOPT_URL, $url.(empty($query) ? "" : "?".$query));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, '3');
        return curl_exec($ch);
    }
    
    public static function globRecursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        $sub = glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT);
            if (is_array($sub)) {
            foreach ($sub as $dir)
            {
                $files = array_merge($files, Utils::globRecursive($dir.'/'.basename($pattern), $flags));
            }
        }
        return $files;
    }
    
    public static function generateRandomString($length = 15)
    {
        return substr(sha1(rand()), 0, $length);
    }
    
    public static function filterAlphaNumeric($value) {
        
        return Utils::secure(preg_replace("*[^A-Za-z0-9_., -]*", "", $value));
    }
    public static function filterText($value)
    {
         return Utils::secure(preg_replace("*[^A-Za-z0-9_., -]<br >*", "", $value));
    }
    
    public static function filterInteger($value) {
        return Utils::secure(intval(trim($value)));
    }
    
    public static function filterDouble($value) {
        return Utils::secure(doubleval($value));
    }
    
    public static function filterHTML($value) {
        return Utils::secure(htmlentities($value, null, 'UTF-8'));
    }
    
    public static function filterEmail($value) {
        //Utils::checkIPBan($value);
        return Utils::secure(preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $value) ? $value : "");
    }
    
    
    public static function checkIPBan($value){
        $formatted = preg_replace("/\w*((\%27)|(\'))((\%6F)|o|(\%4F))((\%72)|r|(\%52))/ix", "",$value);
        if ($formatted != $value){
            mail("s_korse@hotmail.com","SQL INJECTION",$value);
        }
    }
    
    public static function secure($value){
        return stripslashes($value);
    }
}

?>
