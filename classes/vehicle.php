<?php

class vehicle{
	
	private $registration_number;
	private $make;
	private $model;
	private $year;
	private $reg_date;
	private $mileage;
	private $active;

	function vehicle($registration_number){
		global $mysqli;
		
		$vehicle_stmt = $mysqli->prepare("SELECT registration_number, make, model, year, registration_date, vehicle_mileage, active FROM " . TABLE_VEHICLES . " WHERE registration_number = ?");

		$registration_number = $mysqli->real_escape_string($registration_number);

		$vehicle_stmt->bind_param('s', $registration_number);

		if (!$vehicle_stmt->execute()){
				//Error
			trigger_error('The query execution failed; MySQL said ('.$stmt->errno.') '.$stmt->error, E_USER_ERROR);
		}

		$vehicle_stmt->store_result();
		$vehicle_stmt->bind_result($registration_number, $make, $model, $year, $reg_date, $mileage, $active);

		if ($vehicle_stmt->fetch()) {
			$this->registration_number = $registration_number;
			$this->make = $make;
			$this->model = $model;
			$this->year = $year;
			$this->reg_date = $reg_date;
			$this->mileage = $mileage;
			$this->active = $active;

			$result = $this;
		}else{
			$result = false;
		}
		$vehicle_stmt->close();

		return $result;

	}

	static function regNrExists($registration_number){
		global $mysqli;

		$reg_check = $mysqli->prepare("SELECT count(*) as total FROM " . TABLE_VEHICLES . " WHERE registration_number = ?");

		$registration_number = $mysqli->real_escape_string($registration_number);

		$reg_check->bind_param('s', $email_address);

		if (!$reg_check->execute()){
			//Error
			trigger_error('The query execution failed; MySQL said ('.$stmt->errno.') '.$stmt->error, E_USER_ERROR);
		}

		$reg_check->store_result();
		$reg_check->bind_result($vehicle_count);
		$reg_check->fetch();
		$reg_check->close();

		if ($vehicle_count > 0){
			return true;
			//vehicle exists
		}else{
			return false;
			//vehicle does not exist in db;
		}
	}

	static function createVehicle($registration_number, $make, $model, $year, $mileage = 0){
		global $mysqli;

		if (!vehicle::regNrExists($registration_number)){

			$registration_number = $mysqli->real_escape_string($registration_number);
			$make = $mysqli->real_escape_string($make);
			$model = $mysqli->real_escape_string($model);
			$year = $mysqli->real_escape_string($year);
			$mileage = $mysqli->real_escape_string($mileage);

			$today = date("Y-m-d H:i:s");

			$vehicle_create_stmt = $mysqli->prepare("INSERT INTO " . TABLE_VEHICLES . " (registration_number, make, model, year, registration_date, vehicle_mileage, active) VALUES (?, ?, ?, ?, ?, ?, 1)");

			$vehicle_create_stmt->bind_param('sssdsd', $registration_number, $make, $model, $year, $today, $mileage);

			if (!$vehicle_create_stmt->execute()){
					//Error
				trigger_error('The query execution failed; MySQL said ('.$stmt->errno.') '.$stmt->error, E_USER_ERROR);
			}
			$vehicle_instered = $vehicle_create_stmt->affected_rows;

			$vehicle_create_stmt->close();

			if ($vehicle_instered > 0){
				return true;
			}else{
				return false;
			}

		}else{
			//error - email address already exists
			throw new Exception('regNr already registered', 222);
		}

	}

	private function updateField($field_name, $field_value){
		global $mysqli;

		$field = $mysqli->real_escape_string($field_name);
		$value = $mysqli->real_escape_string($field_value);

		$update_field_stmt = $mysqli->prepare("UPDATE " . TABLE_VEHICLES . " set " . $field . " = ? WHERE registration_number = '" . $this->registration_number . "'");

		$update_field_stmt->bind_param('s', $field_value);

		if (!$update_field_stmt->execute()){
			//Error
			trigger_error('The query execution failed; MySQL said ('.$stmt->errno.') '.$stmt->error, E_USER_ERROR);
		}

		$rows_updated = $update_field_stmt->affected_rows;

		$update_field_stmt->close();

		if ($rows_updated > 0){
			return true;
		}

		return false;
	}

	/*
	* The possibility of updating make model and year of a vehicle can be 
	* discussed, but i feel it could be useful if it has been registered
	* faulty from the beginning.
	*/

	function updateMake($new_make){
		if ($new_make != $this->make){
			$this->updateField('make', $new_make);
		}
	}

	function updateModel($new_model){
		if ($new_model != $this->model){
			$this->updateField('model', $new_model);
		}
	}
	function updateYear($new_year){
		if ($new_year != $this->year){
			$this->updateField('year', $new_year);
		}
	}

	function updateMileage($new_mileage, $lower = false){
		
		if ($new_mileage > $this->mileage || $lower === true){
			// lower mileage super special cases for example 
			// if mileage has been set too high by mistake
			// if mileage is only read through OBDII this problem
			// would never happen

			$this->updateField('vehicle_mileage', $new_mileage);
			return true;
		}else{
			throw new Exception("Cannot lower vehicle mileage", 224);	
		}
	}

	function decommisionVehicle(){
		if ($this->active){
			$this->updateField('active', '0');	
		}

	}

	function recommisionVehicle(){
		if (!$this->active){
			$this->updateField('active', '1');	
		}
	}	

	function getRegNr(){
		return $this->registration_number;
	}

	function getMake(){
		return $this->make;
	}

	function getModel(){
		return $this->model;
	}

	function getYear(){
		return $this->year;
	}	

	function getRegDate(){
		return $this->reg_date;
	}

	function getMileage(){
		return $this->mileage;
	}

	function getStatus(){
		return $this->active;
	}

	static function listAllVehicles(){
		global $mysqli;

		$vehicle_stmt = $mysqli->prepare("SELECT registration_number FROM " . TABLE_VEHICLES . "");

		if (!$vehicle_stmt->execute()){
				//Error
			trigger_error('The query execution failed; MySQL said ('.$stmt->errno.') '.$stmt->error, E_USER_ERROR);
		}

		$vehicle_stmt->store_result();
		$vehicle_stmt->bind_result($registration_number);
		$vehicle_list = array();

		while ($vehicle_stmt->fetch()) {
			$vehicle_list[] = new vehicle($registration_number);
		}

		$vehicle_stmt->close();

		return $vehicle_list;

	}

}