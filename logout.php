<?php
	
	require_once('./includes/application_top.php');
	session_destroy();
	require_once(DIR_WS_INCLUDES . 'application_bottom.php');
	
	http_redirect(FILENAME_DEFAULT);
	
?>