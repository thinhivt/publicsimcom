<?php
	namespace RemoteController;
	require_once '../model/remotemodel/Vehicle.php';

	use RemoteModel\Vehicle;
    
	class VehicleController
	{
		//
		public function insert($data){
			$remotevehicle = new Vehicle();
			$result=$remotevehicle->insert($data);
			return $result;
		}	
		//
		public function update($data){
			$remotevehicle = new Vehicle();
			$result=$remotevehicle->update($data);
			return $result;
		}
		// get all vehicles in remote database
		public function getAll(){

			$remotevehiclelist=Vehicle::getAll();
			return $remotevehiclelist;
		}
	}
?>