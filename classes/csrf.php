<?php

class csrf{ 

	public function randomString($len = 40){

		$string = '';
		$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';

		for ($i = 0; $i < (int)$len; $i++){
			$string .= substr($characters, mt_rand(0, strlen($characters)), 1); 
		}

		return $string;
	}

	private function csrfHash($token){
		
		$tokenHash = hash('sha1', implode($token));
		$csrfEncoded = base64_encode($tokenHash);

		return $csrfEncoded;

	}

	public function generateCSRFToken($sid){
		
		$_SESSION['csrf'] = array(
			'time' => time(),
			'salt' => $this->randomString(),
			'sid' => session_id()
		);	

		$token = $this->csrfHash($_SESSION['csrf']);

		return $token;
	}	

	public function validateCSRFToken($tokenHash){

		if (isset($_SESSION['csrf'])){

			if ($_SESSION['csrf']['sid'] == session_id()){
				//sid is the same as in csrf token				
				if ($tokenHash == $this->csrfHash($_SESSION['csrf'])){
					return true;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}


	}


}