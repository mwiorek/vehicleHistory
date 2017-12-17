<?php

require_once('./includes/application_top.php');

require_once(SMARTY_DIR . 'Smarty.class.php');

require(DIR_WS_CLASSES . 'user.php');

$errorStack = new errorStack; 
$csrf = new csrf();

$user = new user($_SESSION['users_id']);

$url_params = "";

if (in_array('ADMIN', $user->getUserRole()) && isset($_GET['users_id']) && $_GET['users_id'] != ''){
	$user = new user($_GET['users_id']);
	$url_params = "?" . "users_id=" . $_GET['users_id'];
}

$successful_update = false;

if (isset($_POST['action']) && ($_POST['action'] == 'update')){

	if (!$csrf->validateCSRFToken($_POST['csrfToken'])){
		$errorStack->setError(301);
	}

	if (!isset($_POST['name']) || $_POST['name'] == ''){
		$errorStack->setError(203);
	}

	if (!isset($_POST['email_address']) || ($_POST['email_address'] == '')){
		//if new email is provided
		$errorStack->setError(207);
		
	}

	if ( (isset($_POST['old_password']) && $_POST['old_password'] != '') || (isset($_POST['new_password']) && $_POST['new_password'] != '') || (isset($_POST['new_password_confirmation']) && $_POST['new_password_confirmation'] != '')){
		//handle a password update
		$old_password = (isset($_POST['old_password'])) ? $_POST['old_password'] : NULL;

		if (!isset($old_password) || $old_password == ''){
			$errorStack->setError(211);
		}
		if (!isset($_POST['new_password']) || $_POST['new_password'] == ''){
			$errorStack->setError(212);
		}
		if (!isset($_POST['new_password_confirmation']) || $_POST['new_password_confirmation'] == ''){
			$errorStack->setError(209);
		}
		if ($_POST['new_password'] !== $_POST['new_password_confirmation']){
			$errorStack->setError(210);
		}

		try {
			user::authenticateUser($user->getEmailAddress(), $old_password);

		}catch (Exception $e){
			$errorStack->setError($e->getCode());
		}
		$trigger_password_update = true;

	}

	if (isset($_FILES['profile_image']) && ($_FILES['profile_image']['name'] != '')){
		$maxsize = 2000000; //2MB
		if($maxsize < $_FILES['profile_image']['size']){ 
			$error_message = 'The uploaded file is too large';
			$errorStack->setError(213);
		}elseif ($_FILES['profile_image']['error'] != UPLOAD_ERR_OK){

			switch ($_FILES['profile_image']['error']) {
				case 1:
				case 2:
				$errorStack->setError(213);
				break;
				case 3:
				case 4:
				case 6:
				$errorStack->setError(214);
				break;
			}
				// $error_codes = array(0 => "There is no error, the file uploaded with success", 
				// 	1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini", 
				// 	2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
				// 	3 => "The uploaded file was only partially uploaded", 
				// 	4 => "No file was uploaded", 
				// 	6 => "Missing a temporary folder" 
				// 	); 

		}elseif ($_FILES['profile_image']['error'] == UPLOAD_ERR_OK){

			if (in_array($_FILES['profile_image']['type'], array('image/jpg', 'image/jpeg', 'image/png', 'image/gif'))){

					//TODO
					//make sure image is image
				$ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);

				$org_im_filename = DIR_WS_MEDIA . 'profile_images/' . $user->getUserId() . '_org.' . $ext;

				move_uploaded_file(($_FILES['profile_image']['tmp_name']), $org_im_filename);

				$orignal_image = imagecreatefromstring(file_get_contents(DIR_WS_MEDIA . 
					'profile_images/' . $user->getUserId() . '_org.' . $ext));


				$thumbnail_filename = DIR_WS_MEDIA . 'profile_images/' . $user->getUserId() . '_tmp.' . $ext;
				$thumbnail_final_filename = DIR_WS_MEDIA . 'profile_images/' . $user->getUserId() . '.' . $ext;

					//Calculate new image size
				$max_bound = 250;
				$dimensions = getimagesize($org_im_filename);

					//$dimensions[0] = width
					//$dimensions[1] = height

				$ratio = $dimensions[1] / $dimensions[0];

				if ($ratio < 1){
						//landscape
					$new_height = $max_bound * $ratio;
					$new_width = $max_bound;

				}else{
						//portrait or squared
					$new_height = $max_bound;
					$new_width = $max_bound / $ratio; 
				}

				$thumbnail = imagecreatetruecolor($new_width, $new_height);

				imagecopyresampled($thumbnail , $orignal_image , 0, 0, 0, 0, $new_width, $new_height, $dimensions[0], $dimensions[1]);

				if ($_FILES['profile_image']['type'] == 'image/gif'){
					imagegif($thumbnail, $thumbnail_filename);
				}elseif ($_FILES['profile_image']['type'] == 'image/png') {
					imagepng($thumbnail, $thumbnail_filename);
				}else{
					imagejpeg($thumbnail, $thumbnail_filename, 100);
				}

				imagedestroy($orignal_image);
				unlink(DIR_WS_MEDIA . 'profile_images/' . $user->getUserId() . '_org.' . $ext);

			}else{
				$errorStack->setError(215);
			}

		}

	}

	if (!$errorStack->hasErrors()){

		$user_updated = false;

		try {
			if ($_POST['name'] != $user->getName()){
				$user->updateName($_POST['name']);
				$user_updated = true;
			}

			if ($_POST['email_address'] != $user->getEmailAddress()){

				if (!filter_var($_POST['email_address'], FILTER_VALIDATE_EMAIL)){
					$errorStack->setError(206);
				}else{
					$email_address = filter_var($_POST['email_address'], FILTER_SANITIZE_EMAIL);
					if (user::emailIsRegistered($email_address)){
						$errorStack->setError(205);
					}else{
						$user->updateEmailAddress($_POST['email_address']);
						$user_updated = true;
					}
				}
				
				
			}

			if (isset($trigger_password_update) && $trigger_password_update){
				$user->updatePassword($_POST['new_password']);
				$user_updated = true;
			}

			if (isset($_FILES['profile_image']) && ($_FILES['profile_image']['name'] != '')){
				rename($thumbnail_filename, $thumbnail_final_filename);

				$user->updateProfileImage($thumbnail_final_filename);
				$user_updated = true;
			}

			

			$show_admin = (in_array('ADMIN', $user->getUserRole()) || $user->getUserId() != $_SESSION['users_id']);
			foreach (user::getAllRoles($show_admin) as $role) {
				if (isset($_POST['roles'])){
					if (in_array($role, $_POST['roles']) && !in_array($role, $user->getUserRole()) ){
						//addRole
						$user->addRole($role);
						$user_updated = true;
						
					}elseif(!in_array($role, $_POST['roles']) && in_array($role, $user->getUserRole())){
						//removeRole
						$user->removeRole($role);
						$user_updated = true;
					}
					//else
					//nothing has changed do nothing
				}else{
					//if all roles are being removed
					if (in_array($role, $user->getUserRole())){
						//removeRole
						$user->removeRole($role);
						$user_updated = true;
					}
				}
			}

			if ($user_updated){
				$user->updateLastModified();
			}

			$successful_update = true;


		} catch (Exception $e) {
			$errorStack->setError($e->getCode());
		}
	}

}elseif(isset($_POST['action']) && $_POST['action'] == 'delete'){

	if (!$csrf->validateCSRFToken($_POST['csrfToken'])){
		$errorStack->setError(301);
	}

	if ($user->deleteUser()){
		if ($user->getUserId() != $_SESSION['users_id']){
			http_redirect(FILENAME_DEFAULT);
		}else{ 
			http_redirect(FILENAME_LOGOUT);
		}
	}
	else{
		$errorStack->setError(216);
		//unable to delete account
	}
}

$CSRFToken = $csrf->generateCSRFToken(session_id());

$user = new user($_SESSION['users_id']);

$roles = user::getAllRoles(in_array('ADMIN', $user->getUserRole()));

//reload user after action
if (in_array('ADMIN', $user->getUserRole()) && isset($_GET['users_id']) && $_GET['users_id'] != ''){
	$user = new user($_GET['users_id']);
	$roles = user::getAllRoles(true);
}

$user_to_roles = array();

foreach ($roles as $role) {
	$user_to_roles[$role] = (in_array($role, $user->getUserRole()));
}

require_once(DIR_WS_INCLUDES . 'application_bottom.php');

$errors = $errorStack->getErrors();

$smarty = new Smarty();
$smarty->assign('page_title', 'Settings');  

$smarty->assign('csrfToken', $CSRFToken);
$smarty->assign('url_params', $url_params);
$smarty->assign('user', $user);
$smarty->assign('user_to_roles', $user_to_roles);

$smarty->assign('errors', $errors);
$smarty->assign('successful_update', $successful_update);

$smarty->display('settings.tpl');