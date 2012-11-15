<?php

/**
 * This class handles the conversion
 * between constants and their string
 * representation
 * @author Rogier Slag
 * @version 1
 * @package Environment
 */
class Constants {

    /**
     * Gets the current environment
     * @return string
     */
    public static function env() {
        switch (IKE_APP_ENV) {
            case ENV_DEVELOPMENT: return 'development';
                break;
            case ENV_TESTING: return 'testing';
                break;
            case ENV_PRODUCTION: return 'production';
                break;
            default: return 'Burp!!';
        }
    }
}