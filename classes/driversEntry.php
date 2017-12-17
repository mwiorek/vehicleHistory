<?php

class driversEntry{

	private $entry_id;
	private $driver;
	private $vehicle;
	private $date_assigned;
	private $date_checked_out;
	private $date_returned;
	private $mileage_start;
	private $mileage_end;

	function driversEntry($entry_id){
		//constructor
		global $mysqli;

		$stmt = $mysqli->prepare("SELECT entry_id, users_id, registration_number, date_assigned, date_checked_out, date_returned, mileage_start, mileage_end FROM " . TABLE_DRIVER_IN_VEHICLES . " WHERE entry_id = ?");

		$entry_id = $mysqli->real_escape_string($entry_id);

		$stmt->bind_param('s', $entry_id);

		if (!$stmt->execute()){
				//Error
			trigger_error('The query execution failed; MySQL said ('.$stmt->errno.') '.$stmt->error, E_USER_ERROR);
		}

		$stmt->store_result();
		$stmt->bind_result($entry_id, $users_id, $registration_number, $date_assigned, $date_checked_out, $date_returned, $mileage_start, $mileage_end);

		if ($stmt->fetch()) {
			$this->entry_id = $entry_id;
			$this->driver = new user($users_id);
			$this->vehicle = new vehicle($registration_number);
			$this->date_assigned = $date_assigned;
			$this->date_checked_out = $date_checked_out;
			$this->date_returned = $date_returned;
			$this->mileage_start = $mileage_start;
			$this->mileage_end = $mileage_end;
		}

		$stmt->close();

		return $this;

	}

	function getEntryId(){
		return $this->entry_id;
	}

	function getUserId(){
		return $this->driver->getUserId();
	}

	function getUserName(){
		return $this->driver->getName();
	}

	function getProfileImage(){
		return $this->driver->getProfileImage();
	}
	
	function getRegNr(){
		return $this->vehicle->getRegNr();
	}

	function getVehicleMileage(){
		return $this->vehicle->getMileage();
	}

	function getDateAssigned(){
		return $this->date_assigned;
	}

	function getDateCheckedOut(){
		return $this->date_checked_out;
	}
	
	function checkOutVehicle(){
		$today = date("Y-m-d H:i:s");
		$this->updateField('date_checked_out', $today);
	}

	function returnVehicle($mileage_end){
		global $mysqli;

		$mysqli->autocommit(false);
		$mysqli->begin_transaction();

		$today = date("Y-m-d H:i:s");

		if (
			$this->updateField('date_returned', $today) 
			&& $this->updateField('mileage_end', $mileage_end)
			&& $this->vehicle->updateMileage($mileage_end)
			){
			$mysqli->commit();
			return true;
		}else{
			$mysqli->rollback();
			return false;
		}

	}

	private function updateField($field_name, $field_value){
		global $mysqli;

		$value = $mysqli->real_escape_string($field_value);

		$update_field_stmt = $mysqli->prepare("UPDATE " . TABLE_DRIVER_IN_VEHICLES . " set " . $field_name . " = ? WHERE entry_id = " . $this->entry_id);

		$update_field_stmt->bind_param('s', $field_value);

		if (!$update_field_stmt->execute()){
			//Error
			trigger_error('The query execution failed; MySQL said ('.$update_field_stmt->errno.') '.$update_field_stmt->error, E_USER_ERROR);
		}

		$rows_updated = $update_field_stmt->affected_rows;

		$update_field_stmt->close();

		if ($rows_updated > 0){
			return true;
		}

		return false;
	}

	static function addDriversEntry($users_id, $registration_number){
		global $mysqli;

		if (!$vehicle = new vehicle($registration_number)){
			throw new Exception("Illegal Argument", 302);
		}

		$stmt = $mysqli->prepare("INSERT INTO " . TABLE_DRIVER_IN_VEHICLES . " (users_id, registration_number, date_assigned, mileage_start) VALUES (?, ?, ?, ?)");
		$users_id = $mysqli->real_escape_string($users_id);

		$registration_number = $mysqli->real_escape_string($registration_number);
		$today = date("Y-m-d H:i:s");
		$mileage_start = $mysqli->real_escape_string($vehicle->getMileage());

		$stmt->bind_param('dssd', $users_id, $registration_number, $today, $mileage_start);

		if (!$stmt->execute()){
			//Error
			trigger_error('The query execution failed; MySQL said ('.$stmt->errno.') '.$stmt->error, E_USER_ERROR);
		}

		$entry_instered = $stmt->affected_rows;

		$stmt->close();

		if ($entry_instered > 0){
			return true;
		} else {
			return false;
		}
	}

	function removeDriversEntry(){
		global $mysqli;

		$stmt = $mysqli->prepare("DELETE FROM " . TABLE_DRIVER_IN_VEHICLES . " WHERE entry_id = ?");
		
		$entry_id = $mysqli->real_escape_string($this->getEntryId());
		
		$stmt->bind_param('d', $entry_id);

		if (!$stmt->execute()){
			//Error
			trigger_error('The query execution failed; MySQL said ('.$stmt->errno.') '.$stmt->error, E_USER_ERROR);
		}
		
		$stmt->close();



	}

	static function getActiveDriverRows(){
		global $mysqli;

		$drivers_stmt = $mysqli->prepare("SELECT dv.entry_id FROM " . TABLE_USERS . " u, " . TABLE_USERS_ROLES . " ur, " . TABLE_DRIVER_IN_VEHICLES . " dv WHERE ur.role = 'DRIVER' and ur.users_id = u.users_id AND dv.users_id = u.users_id AND dv.date_returned IS NULL");

		if (!$drivers_stmt->execute()){
			//Error
			trigger_error('The query execution failed; MySQL said ('.$drivers_stmt->errno.') '.$drivers_stmt->error, E_USER_ERROR);
		}

		$drivers_stmt->store_result();
		$drivers_stmt->bind_result($driver);

		$active_drivers = array();
		while ($drivers_stmt->fetch()){
			$active_drivers[] = new driversEntry($driver);
		}
		$drivers_stmt->close();

		return $active_drivers;	

	}

	static function getAvailableDrivers(){
		global $mysqli;

		$drivers_stmt = $mysqli->prepare("SELECT distinct u.users_id FROM " . TABLE_USERS . " u, " . TABLE_USERS_ROLES . " ur, " . TABLE_DRIVER_IN_VEHICLES . " dv WHERE ur.role = 'DRIVER' AND ur.users_id = u.users_id AND ( u.users_id NOT IN (SELECT dv.users_id FROM " . TABLE_DRIVER_IN_VEHICLES . " dv WHERE dv.date_returned IS NULL) OR (u.users_id NOT IN (SELECT dv.users_id FROM " . TABLE_DRIVER_IN_VEHICLES . " dv)) )");

		if (!$drivers_stmt->execute()){
			//Error
			trigger_error('The query execution failed; MySQL said ('.$drivers_stmt->errno.') '.$drivers_stmt->error, E_USER_ERROR);
		}

		$drivers_stmt->store_result();
		$drivers_stmt->bind_result($driver_id);

		$available_drivers = array();
		while ($drivers_stmt->fetch()){
			$available_drivers[] = new user($driver_id);
		}
		$drivers_stmt->close();

		return $available_drivers;	

	}

	static function getAvailableVehicles(){
		global $mysqli;

		$vehicles_stmt = $mysqli->prepare("SELECT distinct v.registration_number FROM " . TABLE_VEHICLES . " v, " . TABLE_DRIVER_IN_VEHICLES . " dv WHERE v.active = '1' AND ((dv.registration_number = v.registration_number AND (dv.registration_number NOT IN (SELECT dv.registration_number FROM " . TABLE_DRIVER_IN_VEHICLES . " dv WHERE dv.date_returned IS NULL))) OR (v.registration_number NOT IN (SELECT dv.registration_number FROM " . TABLE_DRIVER_IN_VEHICLES . " dv)))");
		if (!$vehicles_stmt->execute()){
			//Error
			trigger_error('The query execution failed; MySQL said ('.$vehicles_stmt->errno.') '.$vehicles_stmt->error, E_USER_ERROR);
		}

		$vehicles_stmt->store_result();
		$vehicles_stmt->bind_result($registration_number);

		$available_vehicles = array();
		while ($vehicles_stmt->fetch()){
			$available_vehicles[] = new vehicle($registration_number);
		}
		$vehicles_stmt->close();

		return $available_vehicles;	
	}

}