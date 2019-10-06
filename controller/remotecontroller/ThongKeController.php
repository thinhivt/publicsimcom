<?php
	namespace RemoteController;
	require_once '../model/remotemodel/ThongKe.php';

	use RemoteModel\ThongKe;
    
	class ThongKeController
	{   
		//construct thongkecontroller class
		public function __construct(){
			
		}
		//get all record control
		public function getAll(){
			$thongkeobject = new ThongKe();
			return ThongKe::getAll();
		}
		//insert record into thongke table in controller
		public function insert($data){
			$thongkeobject = new ThongKe();
			$result=$thongkeobject->insert($data);
			return $result;
		}	
		//update record into thongke table in controller
		public function update($data){
			$thongkeobject = new ThongKe();
			$result=$thongkeobject->update($data);
			return $result;
		}
		//
		public function getlinkremote($vehicle_name){
			$thongkeobject = new ThongKe();
			$result=$thongkeobject->specialget($vehicle_name);
			return $result;
		}
		//Delete record 
		public function delete(){

		}


	}
?>