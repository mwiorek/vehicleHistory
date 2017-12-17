<?php

require_once('./includes/application_top.php');

require_once(SMARTY_DIR . 'Smarty.class.php');

if (isset($_SESSION['users_id'])){
    http_redirect(FILENAME_DEFAULT);
}

require(DIR_WS_CLASSES . 'user.php');


$errorStack = new errorStack; 
$csrf = new csrf();

$input_email_address = (isset($_POST['email_address'])) ? $_POST['email_address'] : NULL;
$input_password = (isset($_POST['password'])) ? $_POST['password'] : NULL;


if (isset($_POST['action']) && ($_POST['action'] == 'login')){

    if (!isset($_POST['email_address']) || $_POST['email_address'] == ''){
        $errorStack->setError(207);
    }

    if (!isset($_POST['password']) || $_POST['password'] == ''){
        $errorStack->setError(208);
    }

    if (!$csrf->validateCSRFToken($_POST['csrfToken'])){
        $errorStack->setError(301);
    }

    if (!$errorStack->hasErrors()){

        try {
            user::authenticateUser($input_email_address, $input_password);

            $user = new user($_SESSION['users_id']);
            $user->updateLastLogin();

            http_redirect(FILENAME_DEFAULT);

        } catch (Exception $e) {
            $errorStack->setError($e->getCode());
        }
    }

}

$CSRFToken = $csrf->generateCSRFToken(session_id());

require_once(DIR_WS_INCLUDES . 'application_bottom.php');

$errors = $errorStack->getErrors();

$smarty = new Smarty();

$smarty->assign('page_title', "Login");

$smarty->assign('csrfToken', $CSRFToken);
$smarty->assign('email_address', $input_email_address);
$smarty->assign('errors', $errors);    
$smarty->display('login.tpl');