<?php
class SessionHandler2 { 
    
    
    public static function start() { return session_start(); }



    public static function stop() { return session_destroy(); } 
    
    public static function isEmpty($name) { 
        return empty($_SESSION[$name]);
    }
    
    public static function set($name, $value) {
        
        // if(is_object($value) && get_class($value) == "Core"){
            
        //     SessionHandlerV2::set('adminPassword', $_COOKIE["adminPassword"]);
        //     SessionHandlerV2::set('user_type', $_COOKIE["user_type"]);
        //     $_SESSION[$name] = $value->toArray(); $_SESSION[$name]['ob_h'] = 1; 
        // } else if(is_object($value)) {
        //      $_SESSION[$name] = get_object_vars($value); $_SESSION[$name]['ob_h'] = 1; 
        // } else {
        //      $_SESSION[$name] = $value;
        // }
    }
    public static function get($key) {


    } 
}      
