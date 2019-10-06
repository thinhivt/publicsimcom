<?php
	namespace RemoteModel;
	require_once 'Database.php';
	use RemoteModel\Database;
	use PDO;

	class ThongKe
	{
		private $id, $time, $hoten, $rfid, $name, $solit;
		
		//code construct class Sim
		public function __construct()
		{
			//set parameter for properties
		}
		
	    //get all data from to ThongKe table in database
		public static function getAll(){
			try {
				$connect = Database::connect();
				$query= 'SELECT * FROM thongkes';
				$statement = $connect->prepare($query);
				$statement->execute();
				return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}

		}
		//find record into thongkes where id=reference data
		public static function find($id){
			try{
				$connect = Database::connect();
				$query= 'SELECT * FROM thongkes WHERE id =:id';
				$statement=$connect->prepare($query);
				$statement->bindParam(':id', $id);
				$statement->execute();
				return $statement->fetch(PDO::FETCH_OBJ);
			}
			catch (\Exception $e) {
				echo $e;
			}
		}
		//special get 
		public static function specialget($vehicle_name){
			try {
				$connect = Database::connect();
				$query= "SELECT * FROM thongkes WHERE name =:vehicle_name ORDER BY id DESC limit 10";
				$statement = $connect->prepare($query);
				$statement->bindParam(':vehicle_name', $vehicle_name);
				$statement->execute();
				return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//create sim account into database
		public function insert($data){
			$this->hoten=$data['user_name'];
			$this->rfid=$data['rfid'];
			$this->name=$data['name'];
			$this->solit=$data['volume'];
			$this->time=date('Y-m-d H:i:s');
		
			try {
				$connect = Database::connect();
				$query='INSERT INTO thongkes (time, hoten, rfid, name, solit) VALUES (:time, :hoten, :rfid, :name, :solit)';
				$statement = $connect->prepare($query);
				$statement->bindValue(':time', $this->time);
		        $statement->bindValue(':hoten', $this->hoten);
		        $statement->bindValue(':rfid', $this->rfid);
		        $statement->bindValue(':name', $this->solit);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
		// update sim
        public function update($data){
        	$this->hoten=$data['user_name'];
			$this->rfid=$data['rfid'];
			$this->name=$data['name'];
			$this->solit=$data['volume'];
			$this->time=date('Y/m/d H:i:s');
			try {
				$connect = Database::connect();
				$query='UPDATE thongkes SET time = :time, hoten =:hoten, rfid=:rfid, name=:name, WHERE id = :id';
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $this->id);   
				$statement->bindParam(':time', $this->time);   
		        $statement->bindParam(':hoten', $this->hoten);
		        $statement->bindParam(':rfid',$this->rfid);
		        $statement->bindParam(':name',$this->name);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
        }
		public function forcedelete($id){
			try {
				$connect =Database::connect();
				$query="DELETE FROM thongkes WHERE id = :id";
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $id);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
	}
?>