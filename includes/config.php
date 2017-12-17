<?php

/*
The use of DIR_FS/DIR_WS, etc is taken from how osCommerce does directory mapping
https://github.com/osCommerce/oscommerce2/blob/23/catalog/includes/configure.php
*/

define('DIR_FS', str_replace("\\","/",getcwd()));
//File system directory (local)
//smarty template's hack for windows/*nix systems
//http://www.smarty.net/docs/en/installing.smarty.basic.tpl

define('DIR_WS', ''); // virtual file directory (webdirectories)

define('SMARTY_DIR', DIR_FS . '/Smarty/');

define('HTTP_SERVER', 'http://127.0.0.1'); 
define('HTTPS_SERVER', 'https://127.0.0.1'); 

define('SSL_ENABLED', true);

define('DIR_WS_MEDIA', 'media/');

define('DIR_WS_INCLUDES', 'includes/');

define('DIR_WS_CLASSES', 'classes/');

//DB credentials are defined in the databaseConnection Class /includes/classes/databaseConnection.php
define('APP_NAME', 'Fleet manager');
define('MAIL_FROM_EMAIL', 'no-reply@example.com');
define('MAIL_FROM_NAME', APP_NAME);

