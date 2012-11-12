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
        switch (ID_APP_ENV) {
            case ENV_DEVELOPMENT: return 'development';
                break;
            case ENV_TESTING: return 'testing';
                break;
            case ENV_PRODUCTION: return 'production';
                break;
            default: return 'Burp!!';
        }
    }

    /**
     * Gets the current shop type
     * @return string
     */
    public static function type() {
        switch (ID_APP_TYPE) {
            case SHOP_TYPE_EXTERN: return 'extern';
                break;
            case SHOP_TYPE_INTERN: return 'intern';
                break;
            default: return 'Burp!!';
        }
    }

    /**
     * Gets the current authentication method
     * @return string
     */
    public static function auth() {
        switch (ID_AUTH_METHOD) {
            case AUTH_SSO: return 'SSO';
                break;
            case AUTH_CUSTOMER: return 'customer';
                break;
            default: return 'Burp!';
        }
    }

    public static function paymentStatus($i) {
        switch ($i) {
            case PAYMENT_EXPIRED:
                return 'verlopen';
                break;
            case PAYMENT_CANCELLED:
                return 'geannuleerd';
                break;
            case PAYMENT_FAILURE:
                return 'systeemfout';
                break;
            case PAYMENT_OPEN:
                return 'openstaand';
                break;
            case PAYMENT_PARTOPEN:
                return 'deels openstaand';
                break;
            case PAYMENT_SUCCESS:
                return 'voldaan';
                break;
        }
    }

}