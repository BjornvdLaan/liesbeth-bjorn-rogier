<?php

/**
 * This class is included to handle any errors found
 * within the source code. It sets the error and logging
 * levels accordingly
 * @author Rogier Slag
 * @version 1
 * @package Environment
 */
class errorHandling {

    /**
     * Sets the specific values for production use
     */
    public function production() {
        ini_set('display_startup_errors', 0);
        ini_set('display_errors', 0);
    }

    /**
     * Sets the specific values for the testing phase
     */
    public function testing() {
        ini_set('display_startup_errors', 1);
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        define('DEBUG', true);
    }

    /**
     * Sets the specific values for the development phase
     */
    public function development() {
        error_reporting(-1);
    }

}

switch (IKE_APP_ENV) {
    case ENV_DEVELOPMENT:
        errorHandling::production();
        errorHandling::testing();
        errorHandling::development();
        break;
    case ENV_TESTING:
        errorHandling::production();
        errorHandling::testing();
        break;
    case ENV_PRODUCTION:
        errorHandling::production();
        break;

    default:
        die('Error in errorHandling class!');
        break;
}