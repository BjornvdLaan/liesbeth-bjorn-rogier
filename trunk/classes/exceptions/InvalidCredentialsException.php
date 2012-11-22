<?php

class InvalidCredentialsException extends IkeException {
    
    public function __construct($message, $code, $previous) {
        parent::__construct($message, $code, $previous);
    }
    
}