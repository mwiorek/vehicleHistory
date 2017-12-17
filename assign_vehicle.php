<?php 
require_once('./includes/application_top.php');

require_once(SMARTY_DIR . 'Smarty.class.php');

require(DIR_WS_CLASSES . 'user.php');
require(DIR_WS_CLASSES . FILENAME_DRIVERS_ENTRY);
require(DIR_WS_CLASSES . FILENAME_VEHICLE);


$errorStack = new errorStack; 
$csrf = new csrf();

if (!isset($_SESSION['users_id'])){
	$_SESSION['redirect_uri'] = $_SERVER['SCRIPT_NAME'];
	http_redirect(FILENAME_LOGIN);
}

$user = new user($_SESSION['users_id']);

if (!in_array('ADMIN', $user->getUserRole()) && !in_array('ADM', $user->getUserRole())){
	$errorStack->setError(302);
}

if (isset($_GET['users_id']) && $_GET['users_id'] != ''){
	if (!$user = new user($_GET['users_id'])){
		$errorStack->setError(229);
	}elseif(!in_array('DRIVER', $user->getUserRole())){
		$errorStack->setError(231);
	}
}else{
	$errorStack->setError(229);
}

$successful_update = false;
$available_vehicles = driversEntry::getAvailableVehicles();

if (isset($_POST['action']) && $_POST['action'] == 'assign_vehicle'){
	if (isset($_POST['registration_number']) && $_POST['registration_number'] != ''){
		if (!$vehicle = new vehicle($_POST['registration_number'])){
			$errorStack->setError(230);
		}elseif(!in_array($vehicle, $available_vehicles)){
			$errorStack->setError(232);
		}
	}else{
		$errorStack->setError(230);
	}

	if (!$errorStack->hasErrors()){
		try{
			$user->assignVehicle($vehicle->getRegNr());
			$successful_update = true;

		}catch(Exception $e){
			$errorStack->setError($e->getCode());
		}
	}
}

$CSRFToken = $csrf->generateCSRFToken(session_id());

$available_vehicles = driversEntry::getAvailableVehicles();
//reload vehicles after insert

require_once(DIR_WS_INCLUDES . 'application_bottom.php');

$errors = $errorStack->getErrors();

$smarty = new Smarty();
$smarty->assign('page_title', 'Assign User Vehicle');  

$smarty->assign('csrfToken', $CSRFToken);
$smarty->assign('errors', $errors);
$smarty->assign('successful_update', $successful_update);

$smarty->assign('user', $user);
$smarty->assign('available_vehicles', $available_vehicles);

$smarty->display('assign_vehicle.tpl');
