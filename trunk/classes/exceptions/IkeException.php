<?php

class IkeException extends Exception {
    
    protected $renderError;
    
    public function __construct($message, $code, $previous) {
        parent::__construct($message, $code, $previous);
    }
    
    public function renderError() {
        return $this->renderError;
    }
    
}