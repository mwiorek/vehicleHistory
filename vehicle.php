<?php

require_once('./includes/application_top.php');

require_once(SMARTY_DIR . 'Smarty.class.php');

require(DIR_WS_CLASSES . FILENAME_VEHICLE);

$errorStack = new errorStack; 
$csrf = new csrf();

if (!isset($_SESSION['users_id'])){
	$_SESSION['redirect_uri'] = $_SERVER['SCRIPT_NAME'];
	http_redirect(FILENAME_LOGIN);
}

$successful_update = false;

if (isset($_GET['reg_nr']) && $_GET['reg_nr'] != ''){
	$vehicle = new vehicle($_GET['reg_nr']);

	if (is_null($vehicle->getRegNr())){
		$vehicle = false;
	}
	
}

$registration_number = null;
$make = null;
$model = null;
$year = null;
$mileage = null;
// initialize variables to be able to use
// them as values in the form

if (isset($_POST['action']) && $_POST['action'] != 'toggle_status'){

	if (!$csrf->validateCSRFToken($_POST['csrfToken'])){
		$errorStack->setError(301);
	}
	if ($_POST['action'] == 'create'){
		if (isset($_POST['reg_nr']) && preg_match('/([A-Z,a-z]){3}([0-9]){3}/', $_POST['reg_nr'])){
			$registration_number = strtoupper($_POST['reg_nr']);
		}else{
			$errorStack->setError(217);
		}
	}
	

	if (isset($_POST['make']) && $_POST['make'] != ''){
		$make = $_POST['make'];
	}else{
		$errorStack->setError(218);
	}

	if (isset($_POST['model']) && $_POST['model'] != ''){
		$model = $_POST['model'];
	}else{
		$errorStack->setError(219);

	}

	if (isset($_POST['year']) && preg_match('/\d{4}/', $_POST['year'])){
		$year = $_POST['year'];
	}else{
		$errorStack->setError(220);

	}

	if (isset($_POST['mileage']) && preg_match('/\d+/', $_POST['mileage'])){
		if ($_POST['action'] == 'update' && $_POST['mileage'] < $vehicle->getMileage()){
			$errorStack->setError(224);
		}else{
			$mileage = $_POST['mileage'];	
		}
	}else{
		$errorStack->setError(221);

	}

	if (!$errorStack->hasErrors()){

		if ($_POST['action'] == 'create'){

			try{
				vehicle::createVehicle($registration_number, $make, $model, $year, $mileage);
				$vehicle = new vehicle($registration_number);
				http_redirect(FILENAME_DEFAULT);
			}catch (Exception $e){
				$errorStack->setError($e->getCode());
				//error_code 222 regnr already exists
			}

		}elseif ($_POST['action'] == 'update') {

			if ($vehicle && $vehicle->getRegNr() == $_GET['reg_nr']){

				try {

					if ($_POST['make'] != $vehicle->getMake()){
						$user->updateMake($_POST['make']);
					}

					if ($_POST['model'] != $vehicle->getModel()){
						$user->updateModel($_POST['model']);
					}
					if (preg_match("/\d{4}/", $_POST['year']) && $_POST['year'] != $vehicle->getYear()){
						$user->updateYear($_POST['year']);
					}

					if (preg_match("/\d+/", $_POST['mileage'])){
						$vehicle->updateMileage($_POST['mileage']);			
					}

					$successful_update = true;
					$vehicle = new vehicle($_GET['reg_nr']);
					//reload after update;

				} catch (Exception $e) {
					$errorStack->setError($e->getCode());
				}

			}else{
				$errorStack->setError(223);
				//vehicle object doesn't match regNr in _GET param
			}

		}

	}

}elseif(isset($_POST['action']) && $_POST['action'] == 'toggle_status'){

	if (isset($vehicle) && $vehicle->getRegNr() == $_GET['reg_nr']){
		if ($vehicle->getStatus()){
			$vehicle->decommisionVehicle();
		}else{
			$vehicle->recommisionVehicle();
		}
		$vehicle = new vehicle($_GET['reg_nr']);
		//reload after update;
	}else{
		$errorStack->setError(225);
	}

}

$CSRFToken = $csrf->generateCSRFToken(session_id());

require_once(DIR_WS_INCLUDES . 'application_bottom.php');

$errors = $errorStack->getErrors();

$smarty = new Smarty();
$smarty->assign('page_title', 'Vehicle Information');  

$smarty->assign('csrfToken', $CSRFToken);

$smarty->assign('errors', $errors);
$smarty->assign('successful_update', $successful_update);
if (isset($vehicle)){
	$smarty->assign('vehicle', $vehicle);
	$smarty->display('vehicles_edit.tpl');
}else{
	$smarty->assign('registration_number', $registration_number);
	$smarty->assign('make', $make);
	$smarty->assign('model', $model);
	$smarty->assign('year', $year);
	$smarty->assign('mileage', $mileage);

	$smarty->display('vehicles_new.tpl');
}