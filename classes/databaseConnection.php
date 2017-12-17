<?php

class databaseConnection{

	//update static varibles to your own database credentials
	//defined in db connection class as private static for security reasons

	static private $db_host = 'localhost';
	static private $db_user = 'root';
	static private $db_password = '';
	static private $db_database = 'test';

	static function connect(){
		global $mysqli;
		//using self:: instead of static:: to prevent late static binding

		$mysqli = new mysqli(self::$db_host, self::$db_user, self::$db_password, self::$db_database);
		if ($mysqli->connect_errno) {
		    return die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}else{
			return $mysqli;
		}

	}

	static function close(){
		global $mysqli;
		//Kill and close db connection

		/* determine our thread id */
		$thread_id = $mysqli->thread_id;
		/* Kill connection */
		$mysqli->kill($thread_id);
		/* close connection */
		$mysqli->close();
	}

}
