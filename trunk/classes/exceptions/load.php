<?php

/**
 * This file only includes the other ExceptionClasses and prevents the main
 * include file of cluttering
 */
include(IKE_APP_DIR . '/classes/exceptions/IkeException.php');
include(IKE_APP_DIR . '/classes/exceptions/DatabaseConstraintViolationException.php');
include(IKE_APP_DIR . '/classes/exceptions/DatabaseAccessException.php');