<?php

require_once('./includes/application_top.php');

require_once(SMARTY_DIR . 'Smarty.class.php');


require(DIR_WS_CLASSES . 'user.php');
require(DIR_WS_CLASSES . FILENAME_VEHICLE);
require(DIR_WS_CLASSES . FILENAME_DRIVERS_ENTRY);


if (!isset($_SESSION['users_id'])){
	$_SESSION['redirect_uri'] = $_SERVER['SCRIPT_NAME'];
	http_redirect(FILENAME_LOGIN);
}

$user = new user($_SESSION['users_id']);

$user_list = user::getAllUsers(); 
$vehicle_list = vehicle::listAllVehicles()

$available_drivers = driversEntry::getAvailableDrivers(); 
$active_drivers = driversEntry::getActiveDriverRows();
$available_vehicles = driversEntry::getAvailableVehicles();

$active_vehicles = $user->getActiveVehicles();
$assigned_vehicles = $user->getAssignedVehicles();

$smarty = new Smarty();
$smarty->assign('page_title', "Dashboard");
$smarty->assign('sub_title', $user->getName() . " - Role(s): " . implode(', ', $user->getUserRole()));

$smarty->assign('user_roles', $user->getUserRole());

//ADMIN
$smarty->assign('user_list', $user_list);

//ADM + ADMIN
$smarty->assign('available_drivers', $available_drivers);
$smarty->assign('active_drivers', $active_drivers);

$smarty->assign('available_vehicles', $available_vehicles);

$smarty->assign('active_vehicles', $active_vehicles);
$smarty->assign('assigned_vehicles', $assigned_vehicles);

$smarty->assign('all_vehicle_list', $vehicle_list);

$smarty->display('index.tpl');	
