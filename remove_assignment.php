<?php 
require_once('./includes/application_top.php');

require_once(SMARTY_DIR . 'Smarty.class.php');

require(DIR_WS_CLASSES . 'user.php');
require(DIR_WS_CLASSES . FILENAME_VEHICLE);
require(DIR_WS_CLASSES . FILENAME_DRIVERS_ENTRY);

$errorStack = new errorStack; 

if (!isset($_SESSION['users_id'])){
	$_SESSION['redirect_uri'] = $_SERVER['SCRIPT_NAME'];
	http_redirect(FILENAME_LOGIN);
}

$user = new user($_SESSION['users_id']);

if (!in_array('ADMIN', $user->getUserRole()) && !in_array('ADM', $user->getUserRole())){
	$errorStack->setError(302);
}

if (isset($_GET['entry_id']) && $_GET['entry_id'] != ''){
	if (!$entry = new driversEntry($_GET['entry_id'])){
		$errorStack->setError(229);
	}
}else{
	$errorStack->setError(229);
}

if (!$errorStack->hasErrors()){
	try{
		$entry->removeDriversEntry();
	}catch(Exception $e){
		$errorStack->setError($e->getCode());
	}
}


require_once(DIR_WS_INCLUDES . 'application_bottom.php');

$errors = $errorStack->getErrors();
if ($errorStack->hasErrors()){
	$smarty = new Smarty();
	$smarty->assign('page_title', 'Remove Vehicle Assignment');  

	$smarty->assign('errors', $errors);

	$smarty->display('remove_assignment.tpl');
}else{
	http_redirect(FILENAME_DEFAULT);
	//go back to index on success, nothing to see here!
}