<?php
// ERROR_CODES

define('ERROR_NAME_CSRF_TOKEN_ERROR', 'Session error please try again.');
define('ERROR_NAME_PERMISSION_DENIED', 'You do not have permission to perform this task');

define('ERROR_NAME_UNDEFINED_ERROR_CODE', 'Unknown error');
define('ERROR_NAME_LOGIN_EMAIL_NOT_FOUND', sprintf('The provided email address not register in our database, <a class="alert-link" href="%s">register an account</a> instead or provide a registered email address', FILENAME_REGISTER));
define('ERROR_NAME_PASSWORD_INCORRECT', 'Password is incorrect');
define('ERROR_NAME_NOT_VALID_NAME', 'Please enter a valid name');
define('ERROR_NAME_REGISTER_USER_EMAIL_ALREADY_EXISTS', sprintf('Email address already exists in our database, <a class="alert-link" href="%s">log in</a> instead or provide a different email address', FILENAME_LOGIN));
define('ERROR_NAME_ACCOUNT_SETTINGS_EMAIL_ALREADY_EXISTS', 'Email address is already registered to another user, please provide a unique email address');
define('ERROR_NAME_NOT_VALID_EMAIL_ADDRESS', 'Please enter a valid email address');
define('ERROR_NAME_NO_EMAIL_ADDRESS', 'Please enter a valid email address');
define('ERROR_NAME_NO_PASSWORD_PROVIDED', 'You need to provide a password');
define('ERROR_NAME_NO_PASSWORD_CONFIRMATION_PROVIDED', 'You need to provide a password confirmation that matches your original password');
define('ERROR_NAME_PASSWORDS_DO_NOT_MATCH', 'Your passwords do not match.');
define('ERROR_NAME_NO_OLD_PASSWORD_PROVIDED', 'You need to provide your current password');
define('ERROR_NAME_NO_NEW_PASSWORD_PROVIDED', 'Please provide a new password');
define('ERROR_NAME_UPLOADED_IMAGE_TOO_LARGE', 'Upload image too large');
define('ERROR_NAME_FILE_UPLOAD_ERROR', 'A problem occurred with the upload');
define('ERROR_NAME_IMAGE_FORMAT_NOT_SUPPORTED', 'This image format is not supported, try again with .jpg, .jpeg, .gif or .png');
define('ERROR_NAME_UNABLE_TO_DELETE_ACCOUNT', 'The account cannot be deleted');
define('ERROR_NAME_NO_REG', 'Please provide a valid swedish registration number');
define('ERROR_NAME_NO_MAKE', 'Please provide a vehicle make');
define('ERROR_NAME_NO_MODEL', 'Please provide a vehicle model');
define('ERROR_NAME_NO_VALID_YEAR', 'Please provide a valid year (4 digits)');
define('ERROR_NAME_NO_VALID_MILEAGE', 'Please provide a valid mileage reading (only digits)');
define('ERROR_NAME_REGNR_ALREADY_EXISTS', 'A vehicle with this registration number is already registered');
define('ERROR_NAME_VEHICLE_OBJ_DOES_NOT_MATCH_HEADER_INFO', 'Trying to update incorrect vehicle');
define('ERROR_NAME_CANNOT_LOWER_MILEAGE', 'The mileage of a vehicle cannot be lowered');
define('ERROR_NAME_VEHICLE_STATUS_WAS_NOT_CHANGED', 'Vehicle status was not changed');
define('ERROR_NAME_ROLE_DOESNT_EXISTS', 'The provided role does not exists');
define('ERROR_NAME_THIS_IS_THE_ONLY_ADMIN', 'There needs to be at least one Admin account');
define('ERROR_NAME_ILLEGAL_ARGUMENT', 'Illegal argument provided.');
define('ERROR_NAME_NO_USER_PROVIDED', 'Please make sure a valid user is provided');
define('ERROR_NAME_VEHICLE_WASNT_FOUND', 'No vehicle was found');
define('ERROR_NAME_USER_ISNT_DRIVER', 'This user is not a driver');
define('ERROR_NAME_VEHICLE_IS_BUSY', 'Vehicle is already in use');