<?php

class UserNotFoundException extends IkeException {
    
    public function __construct($message = NULL, $code = 0, Exception $previous = NULL) {
        parent::__construct($message, $code, $previous);
    }
    
}