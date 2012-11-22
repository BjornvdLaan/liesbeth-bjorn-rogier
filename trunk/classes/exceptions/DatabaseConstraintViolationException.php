<?php

/**
 * @author Rogier Slag
 * @version 1
 * @package Exceptions
 * This exception is thrown if the system could not successfully connect to 
 * the central database system
 */
class DatabaseConstraintViolationException extends IkeException {

    public function __construct($message = null, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);

        $this->message = "This action cannot be committed because it would violate a database constraint";
        $this->renderError = 0;
    }

}