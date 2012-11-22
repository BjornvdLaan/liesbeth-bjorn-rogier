<?php

/**
 * This file includes all the necessary files
 * which are relevant for each run of the app
 */

# Load all exceptions
include(IKE_APP_DIR . '/classes/exceptions/load.php');

# Load declared interfaces
include(IKE_APP_DIR . '/classes/interface.DbComm.php');

# Load general classes
include(IKE_APP_DIR . '/classes/class.Constants.php');
include(IKE_APP_DIR . '/classes/class.ErrorHandling.php');
include(IKE_APP_DIR . '/classes/class.GETData.php');
include(IKE_APP_DIR . '/classes/class.HTMLDom.php');
include(IKE_APP_DIR . '/classes/class.Handler.php');
include(IKE_APP_DIR . '/classes/class.Module.php');
include(IKE_APP_DIR . '/classes/class.PhpMailer.php');
include(IKE_APP_DIR . '/classes/class.PreState.php');
include(IKE_APP_DIR . '/classes/class.Render.php');
include(IKE_APP_DIR . '/classes/class.User.php');
include(IKE_APP_DIR . '/classes/FacebookSDK/facebook.php');

new PreState();