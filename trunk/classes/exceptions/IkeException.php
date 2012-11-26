<?php

/**
 * @package Exceptions
 */

class IkeException extends Exception {
    
    protected $renderError;
    
    public function __construct($message = NULL, $code = 0, Exception $previous = NULL) {
        parent::__construct($message, $code, $previous);
    }
    
    public function renderError() {
        return $this->renderError;
    }
    
}