<?php

Class errorStack{
	var $errors;

	function errorStack(){
		$this->reset();
	}

	function reset(){
		$this->errors = array();
	}

	function setError($error_code){
		global $mysqli;

		//sqlInjection safe with prepare and execute statements
		if ($statement = $mysqli->prepare("SELECT error_name FROM errors WHERE error_code = " . $error_code )) {
		    
			//execute select query
			$statement->execute();
			//store_reult to make sure mysqli does not allocate unnessary amount of memory
			$statement->store_result();
			//bind result to variables
		    $statement->bind_result($error_name);

			while ($statement->fetch()) {
		        $this->errors[$error_code] = $error_name;
		    }

		    $statement->close();
		}else{
			$this->errors[$error_code] = 'ERROR_NAME_UNDEFINED_ERROR_CODE';
		}

	}

	function hasError($error_code){
		$found_error = false;
		if ($this->hasErrors()){

			if (array_key_exists($error_code, $this->errors)){
				$found_error = true;
			}
		}
		return $found_error;
		
	}

	function hasErrors(){
		
		if ((is_array($this->errors) && (sizeof($this->errors) > 0))){
			return true;
		}else{
			return false;
		}
		
		
	}

	function getErrors(){
		if ($this->hasErrors()){
			return $this->errors;
		}else{
			return false;
		}
		
	}

	function getError($error_code){
		$found_error = false;
		if (!is_null($error_code) && $this->hasErrors()){
			if (array_key_exists($error_code, $this->errors)){
				$found_error = $this->errors[$error_code];
			}
		}
		
		return $found_error;
		
	}

}
