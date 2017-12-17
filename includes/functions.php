<?php

function http_redirect($destination_script){

	header('Location: ' . $destination_script); //send client to destination

	session_write_close();	//close the current session
	exit(); //prevent further PHP output
}