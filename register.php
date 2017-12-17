<?php

require_once('./includes/application_top.php');

require_once(SMARTY_DIR . 'Smarty.class.php');

require(DIR_WS_CLASSES . 'user.php');

$errorStack = new errorStack;
$csrf = new csrf();

$name = NULL;
$email_address = NULL;

$show_admin = false;

if (isset($_SESSION['users_id'])){
	$logged_in_user = new user($_SESSION['users_id']);
	if (!in_array('ADMIN', $logged_in_user->getUserRole())){
		$errorStack->setError(302);
	}else{
		$show_admin = true;
	}
}  
	//not triggered if user isn't logged in

$roles = user::getAllRoles($show_admin);

if (isset($_POST['action']) && $_POST['action'] == 'register'){

	if (isset($_POST['name']) && ($_POST['name'] != '')){
		$name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
	}else{
		$errorStack->setError(203);
	}
	if (isset($_POST['email_address']) && ($_POST['email_address'] != '')){
		$email_address = $_POST['email_address'];
		
		if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)){
			$errorStack->setError(206);
		}else{
			$email_address = filter_var($_POST['email_address'], FILTER_SANITIZE_EMAIL);
			if (user::emailIsRegistered($email_address)){
				$errorStack->setError(204);
			}
		}
	}else{
		$errorStack->setError(206);
	}
	if (isset($_POST['password']) && ($_POST['password'] != '')){
		$password = $_POST['password'];
	}else{
		$errorStack->setError(208);
	}
	if (isset($_POST['password_confirmation']) && ($_POST['password_confirmation'] != '')){
		$password_confirmation = $_POST['password_confirmation'];
	}else{
		$errorStack->setError(209);
	}

	if ($password !== $password_confirmation){
		$errorStack->setError(210);
	}

	if (!$csrf->validateCSRFToken($_POST['csrfToken'])){
		$errorStack->setError(301);
	}

	
	if (!$errorStack->hasErrors()){
		//if all is clear create the new user
		try{
			$user = user::createUser($name, $email_address, $password);

			$email_random_boundary = mt_rand();
			$email_subject = 'Account Registered';

			$email_headers = "MIME-Version: 1.0" . "\r\n"; 
			//MIME to tell MIME-aware clients about MIME-type
			$email_headers .= "Content-type: multipart/alternative; boundary=" . $email_random_boundary . "\r\n";
			//multipart/alternative to handle attachments mail will include alternative types
			$email_headers .= "From: " . MAIL_FROM_EMAIL . "\r\n";
			$email_headers .= "Date: " . date("D M j H:i:s Y");

			$email_template = new Smarty;
			$email_template->assign('name', $user->getName());
			$email_template->assign('email_random_boundary', $email_random_boundary);
			$email_template_html = $email_template->fetch('register_email_html.tpl');
			$email_template_plain = $email_template->fetch('register_email_plain.tpl');


			mail($name . '<'.$email_address.'>', $email_subject, $email_template_html . $email_template_plain, $email_headers);
			
			
			foreach ($roles as $role) {
				if (isset($_POST['roles'])){
					if (in_array($role, $_POST['roles'])){
						//addRole
						$user->addRole($role);
					}
				}
			}

			http_redirect(FILENAME_DEFAULT);

		}catch (Exception $e){
			$errorStack->setError($e->getCode());
		}
	}

}

$CSRFToken = $csrf->generateCSRFToken(session_id());

require_once(DIR_WS_INCLUDES . 'application_bottom.php');

$errors = $errorStack->getErrors();

$smarty = new Smarty();

$smarty->assign('page_title', "Register Account");

$smarty->assign('csrfToken', $CSRFToken);
$smarty->assign('name', $name);
$smarty->assign('email_address', $email_address);
$smarty->assign('errors', $errors);	

$smarty->assign('roles', $roles);

if (isset($_SESSION['users_id'])){
	$smarty->display('register_user.tpl');
}else{
	$smarty->display('register.tpl');
}