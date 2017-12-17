<?php 
require_once('./includes/application_top.php');

require_once(SMARTY_DIR . 'Smarty.class.php');

require(DIR_WS_CLASSES . 'user.php');
require(DIR_WS_CLASSES . FILENAME_VEHICLE);
require(DIR_WS_CLASSES . FILENAME_DRIVERS_ENTRY);

$errorStack = new errorStack; 
$csrf = new csrf();

if (!isset($_SESSION['users_id'])){
	$_SESSION['redirect_uri'] = $_SERVER['SCRIPT_NAME'];
	http_redirect(FILENAME_LOGIN);
}

$user = new user($_SESSION['users_id']);

if (isset($_GET['entry_id']) && $_GET['entry_id'] != ''){
	if (!$entry = new driversEntry($_GET['entry_id'])){
		$errorStack->setError(229);
	}else{
		if($entry->getUserId() != $user->getUserId()){
			$errorStack->setError(302);
		}
	}
}else{
	$errorStack->setError(229);
}

$successful_return = false;

if(isset($_POST['action']) && $_POST['action'] == 'return'){
	if (!isset($_POST['mileage_end']) || !preg_match('/\d+/', $_POST['mileage_end'])){
		$errorStack->setError(221);
	}

	if (!$errorStack->hasErrors()){
		
		try{
			if ($entry->returnVehicle($_POST['mileage_end'])){
				$successful_return = true;
			}
		}catch(Exception $e){
			$errorStack->setError($e->getCode());
		}
	}
}



$CSRFToken = $csrf->generateCSRFToken(session_id());
require_once(DIR_WS_INCLUDES . 'application_bottom.php');

$errors = $errorStack->getErrors();
if (!$successful_return){
	$smarty = new Smarty();
	$smarty->assign('page_title', 'Return Vehicle');  
	$smarty->assign('csrfToken', $CSRFToken);
	$smarty->assign('errors', $errors);
	if (isset($entry)){
		$smarty->assign('entry', $entry);
	}
	$smarty->display('return_vehicle.tpl');
}else{
	http_redirect(FILENAME_DEFAULT);
	//nothing to see here on success
}