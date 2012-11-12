<?php

/**
 * @author Rogier Slag
 * @version 1
 * @package ShopException
 * This exception is thrown if the system could not successfully connect to 
 * the central database system
 */
class DatabaseConstraintViolationException extends InventIDException {

    public function __construct($message = null, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);

        $this->renderError = 2099;
    }

}