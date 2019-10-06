<?php
	namespace RemoteModel;
	require_once 'Database.php';
	use RemoteModel\Database;
	use PDO;

	class Vehicle
	{
		private $id, $name, $rfid;
		public $created_at, $updated_at, $deleted_at;
		
		//code construct class remote Vehilce
		public function __construct()
		{
			//set parameter for properties
		}
		
	    //get all data from to ThongKe table in database
		public static function getAll(){
			try {
				$connect = Database::connect();
				$query= 'SELECT * FROM vehicles WHERE deleted_at IS NULL';
				$statement = $connect->prepare($query);
				$statement->execute();
				return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}

		}
		// 
		//find record into vehicles where id=reference data
		public static function find($id){
			try{
				$connect = Database::connect();
				$query= 'SELECT * FROM vehicles WHERE id =:id';
				$statement=$connect->prepare($query);
				$statement->bindParam(':id', $id);
				$statement->execute();
				return $statement->fetch(PDO::FETCH_OBJ);
			}
			catch (\Exception $e) {
				echo $e;
			}
		}
		//create remoter vehilce account into remote database
		public function insert($data){
			$this->id=$data['id'];
			$this->name=$data['name'];
			$this->rfid=$data['rfid'];
			$this->created_at=date('Y/m/d H:i:s');
			try {
				$connect = Database::connect();
				// var_dump($connect);
				// die();
				$query='INSERT INTO vehicles (id, name, rfid, created_at) VALUES (:id, :name, :rfid, :created_at)';
				$statement = $connect->prepare($query);
				$statement->bindValue(':id', $this->id);
				$statement->bindValue(':name', $this->name);
		        $statement->bindValue(':rfid', $this->rfid);
		        $statement->bindValue(':created_at', $this->created_at);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
		// update sim
        public function update($data){
        	$this->id=$data['id'];
        	$this->name=$data['name'];
			$this->rfid=$data['rfid'];
			$this->updated_at=date('Y/m/d H:i:s');
			try {
				$connect = Database::connect();
				$query='UPDATE vehicles SET name = :name, rfid =:rfid, updated_at=:updated_at WHERE id = :id';
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $this->id);   
				$statement->bindParam(':name', $this->name);   
		        $statement->bindParam(':rfid', $this->rfid);
		        $statement->bindParam(':updated_at',$this->updated_at);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
        }
		public function forcedelete($id){
			try {
				$connect =Database::connect();
				$query="DELETE FROM vehicles WHERE id = :id";
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $id);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
		// softdelete vehicle when id that passed
		public function softdelete($id){
			try {
				$connect =Database::connect();
				$query="UPDATE vehicles SET update_at =:update_at WHERE id =:id";
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $id);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
	}
?>