<?php

/**
 * This file only includes the other ExceptionClasses and prevents the main
 * include file of cluttering
 */
include(ID_APP_DIR . '/classes/exceptions/InventIDException.php');
include(ID_APP_DIR . '/classes/exceptions/ShopNotFoundException.php');
include(ID_APP_DIR . '/classes/exceptions/DatabaseAccessException.php');
include(ID_APP_DIR . '/classes/exceptions/ClientInterfaceException.php');
include(ID_APP_DIR . '/classes/exceptions/PersonNotFoundException.php');
include(ID_APP_DIR . '/classes/exceptions/ProductNotFoundException.php');
include(ID_APP_DIR . '/classes/exceptions/OrderNotFoundException.php');
include(ID_APP_DIR . '/classes/exceptions/InvalidOrderConfirmationException.php');
include(ID_APP_DIR . '/classes/exceptions/PaymentNotFoundException.php');
include(ID_APP_DIR . '/classes/exceptions/RetryPaymentException.php');
include(ID_APP_DIR . '/classes/exceptions/OrderExpiredException.php');
include(ID_APP_DIR . '/classes/exceptions/IdealException.php');
include(ID_APP_DIR . '/classes/exceptions/TooMuchProductException.php');
include(ID_APP_DIR . '/classes/exceptions/TicketNotFoundException.php');
include(ID_APP_DIR . '/classes/exceptions/DatabaseConstraintViolationException.php');

