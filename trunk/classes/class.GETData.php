<?php

/**
 * This class handles the conversion of getdata. It uses a singleton.
 * @package Environment
 */
class GETData {

    /**
     * Holds the instance
     * @var GETData 
     */
    private static $instance;
    
    /**
     * The variable which holds the transformed getdata
     * @var array
     */
    protected $data = array();
    
    /**
     * Gets (or creates) the instance of GETData
     * @return GETData
     */
    public static function getInstance() {
        if ( self::$instance !== NULL ) {
            return self::$instance;
        }
        
        self::$instance = new GETData();
        return self::$instance;
    }
    
    /**
     * Constructs the object and transform the getdata to the object
     */
    private function __construct() {
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
    
    /**
     * Gets the value of the key. 
     * @param string|int $key the key to search for
     * @return string|null Resulting string or NULL if not found
     */
    public function get($key) {
        if ( isset($this->data[$key])) {
            return $this->data[$key];
        }
        return NULL;
    }

}