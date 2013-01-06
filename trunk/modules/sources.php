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
include(IKE_APP_DIR . '/classes/class.Cached.php');
include(IKE_APP_DIR . '/classes/class.Constants.php');
include(IKE_APP_DIR . '/classes/class.Echonest.php');
include(IKE_APP_DIR . '/classes/class.ErrorHandling.php');
include(IKE_APP_DIR . '/classes/class.GeneralRecommendations.php');
include(IKE_APP_DIR . '/classes/class.GETData.php');
include(IKE_APP_DIR . '/classes/class.HTMLDom.php');
include(IKE_APP_DIR . '/classes/class.Handler.php');
include(IKE_APP_DIR . '/classes/class.Module.php');
include(IKE_APP_DIR . '/classes/class.Render.php');
include(IKE_APP_DIR . '/classes/class.Song.php');
include(IKE_APP_DIR . '/classes/class.Spotify.php');
include(IKE_APP_DIR . '/classes/class.User.php');
include(IKE_APP_DIR . '/classes/class.UserRecommendations.php');
include(IKE_APP_DIR . '/classes/class.Weights.php');
include(IKE_APP_DIR . '/classes/class.Youtube.php');
include(IKE_APP_DIR . '/classes/FacebookSDK/facebook.php');
