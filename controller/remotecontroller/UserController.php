<?php
	namespace RemoteController;
	require_once '../model/remotemodel/User.php';

	use RemoteModel\User;
    
	class UserController
	{   
		
		//getall user at remote database
		public function getAll(){
			return User::getAll();
		}
		//insert usercontroller into remote database;
		public function insert($data){
			$remoteuser =new User();
			$result=$remoteuser->insert($data);
			return $result;
		}	
		//
		public function update($data){
			$remoteuser =new User();
			$result=$remoteuser->update($data);
			return $result;
		}
		//delete record at remoteuser table
		public function delete(){

		}

	}
?>