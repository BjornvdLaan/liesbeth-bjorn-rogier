<?php

/**
 * This is the abstract superclass for any main module
 * It defines some properties that will be required anyway
 * @author Rogier Slag
 * @version 1
 * @package Shop
 */
abstract class Module {

    protected $conn = NULL;
    protected $data = NULL;
    
    /**
     * Construct the module and set the data and database connection delegates
     * @param PDO $conn
     * @param Array $data
     */
    final public function __construct($conn, $data) {
        $this->conn = $conn;
        $this->data = $data;
    }
    
    /**
     * Fire the method based on the selected action
     */
    abstract public function fire($action);
}

?>
