<?php

/**
 * This file includes all the necessary files
 * which are relevant for each run of the app
 */
include(ID_APP_DIR . '/classes/class.ErrorHandling.php');
include(ID_APP_DIR . '/classes/class.Constants.php');
include(ID_APP_DIR . '/classes/class.Render.php');
include(ID_APP_DIR . '/classes/class.PreState.php');
include(ID_APP_DIR . '/classes/class.CommLoadBal.php');
include(ID_APP_DIR . '/classes/class.HTMLDom.php');
include(ID_APP_DIR . '/classes/class.Layout.php');
include(ID_APP_DIR . '/classes/class.ShopData.php');
include(ID_APP_DIR . '/classes/class.Input.php');
include(ID_APP_DIR . '/classes/class.Handler.php');
include(ID_APP_DIR . '/classes/class.PhpMailer.php');
include(ID_APP_DIR . '/classes/class.GETData.php');
include(ID_APP_DIR . '/classes/class.Zip.php');

include(ID_APP_DIR . '/classes/interface.DbComm.php');
include(ID_APP_DIR . '/classes/interfaces/interfaceForLogin.php');

# Load ticket classes
include(ID_APP_DIR . '/classes/tickets/class.Ticket.php');
include(ID_APP_DIR . '/classes/tickets/class.ETicket.php');
include(ID_APP_DIR . '/classes/tickets/class.RfidTicket.php');
include(ID_APP_DIR . '/classes/tickets/class.HardCopyTicket.php');


# Load app classes
include ( ID_APP_DIR . '/classes/class.Module.php');
include ( ID_APP_DIR . '/classes/class.shopHelperClass.php');
include ( ID_APP_DIR . '/classes/class.Person.php');
include ( ID_APP_DIR . '/classes/class.Product.php');
include ( ID_APP_DIR . '/classes/class.Order.php');
include ( ID_APP_DIR . '/classes/class.Payment.php');

# Load payment methods
include(ID_APP_DIR . '/classes/iDeal/class.IDealRequest.php');
include(ID_APP_DIR . '/classes/iDeal/class.DirectoryRequest.php');
include(ID_APP_DIR . '/classes/iDeal/class.TransactionRequest.php');
include(ID_APP_DIR . '/classes/iDeal/class.StatusRequest.php');
include(ID_APP_DIR . '/classes/iDeal/class.IDealCodeGenerator.php');

# Load all exceptions
include(ID_APP_DIR . '/classes/exceptions/load.php');

new PreState();