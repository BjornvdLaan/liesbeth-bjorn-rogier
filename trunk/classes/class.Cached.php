<?php

class Cached {

    private static $instance = NULL;

    public static function getInstance() {
        if (self::$instance !== NULL) {
            return self::$instance;
        }

        $x = new Memcache();
        $x->connect('localhost');
        self::$instance = $x;
        
        return self::$instance;
    }

}