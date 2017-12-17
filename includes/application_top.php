<?php
require_once('includes/config.php'); //load config values

if (SSL_ENABLED && !$_SERVER['HTTPS']){
	header("Location: " . HTTPS_SERVER . $_SERVER['REQUEST_URI']);
}


require_once(DIR_WS_INCLUDES . 'filename.php');

require_once(DIR_WS_INCLUDES . FILENAME_FUNCTIONS);

require_once(DIR_WS_INCLUDES . FILENAME_DATABASE_TABLES);


require_once(DIR_WS_CLASSES . FILENAME_ERRORSTACK);

require_once(DIR_WS_CLASSES . FILENAME_DB_CONNECTION);

require_once(DIR_WS_CLASSES . FILENAME_CSRF);

require_once(DIR_WS_INCLUDES . FILENAME_ERROR_NAMES);

databaseConnection::connect();
//connect once for entire page load
//global $mysqli variable will be used

session_start();