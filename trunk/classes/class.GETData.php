<?php

class GETData {

    protected $data;
    
    public function __construct() {
        $str = $_SERVER['REQUEST_URI'];
        $str = substr($str, strpos($str, '?') + 1);
        $array = explode('&', $str);

        foreach ($array as $value) {
            $value = explode('=', $value, 2);
            if (count($value) != 2)
                continue;

            $this->data[$value[0]] = $value[1];
        }
    }
    
    public function get($key) {
        if ( isset($this->data[$key])) {
            return $this->data[$key];
        }
        return NULL;
    }

}