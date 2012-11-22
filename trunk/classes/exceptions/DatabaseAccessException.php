<?php

/**
 * @author Rogier Slag
 * @version 1
 * @package Exceptions
 * This exception is thrown if the system could not successfully connect to 
 * the central database system
 */
class DatabaseAccessException extends IkeException {

    public function __construct($message = null, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);

        $this->message = 'Currently no databaseconnection to the central system is possible.';
        $this->renderError = 0;
    }

}