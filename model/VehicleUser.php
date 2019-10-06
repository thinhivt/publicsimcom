<?php
	namespace Model;
	require_once 'Database.php';
	use Model\Database;
	use PDO;

	class VehicleUser {
		private $id, $user_id, $vehicle_id, $started_at, $stopped_at, $fuel_start, $fuel_add, $fuel_stop, $work_consumption;
		public $created_at, $updated_at, $deleted_at;
		
		public function __construct()
		{
			//code construct here
		}
		//get All ok
		public static function getAll()
		{
			$connect = Database::connect();
			$query= 'SELECT * FROM vehicle_users WHERE deleted_at IS NULL';
			$statement = $connect->prepare($query);
			$statement->execute();
			return $statement->fetchAll(PDO::FETCH_OBJ);
		}
		//Insert data ok
		public function insert($data)
		{   
			$this->user_id=trim($data['user_id']);
			$this->vehicle_id=trim($data['vehicle_id']);
			$this->started_at=trim($data['started_at']);
			$this->fuel_start=trim($data['fuel_start']);
			$this->created_at=date('Y/m/d H:i:s');
			try {
				$connect = Database::connect();
				$query='INSERT INTO vehicle_users (user_id, vehicle_id, started_at, fuel_start, created_at) VALUES (:user_id, :vehicle_id, :started_at, :fuel_start, :created_at)';
				$statement = $connect->prepare($query);
				$statement->bindParam(':user_id', $this->user_id);
		        $statement->bindParam(':vehicle_id', $this->vehicle_id);
		        $statement->bindParam(':started_at', $this->started_at);
		        $statement->bindParam(':fuel_start', $this->fuel_start);
		        $statement->bindParam(':created_at', $this->created_at);
		        return $statement->execute();
			} catch (\Exception $e) {

				echo $e;

			}
		}
		//find table where id ok
        public static function find($id){
        	try{
        		$connect=Database::connect();
        		$query='SELECT * from vehicle_users WHERE id=:id AND deleted_at IS NULL';
        		$statement=$connect->prepare($query);
        		$statement->bindParam(':id',$id);
        		$statement->execute();
        		return $statement->fetch(PDO::FETCH_OBJ);
        	} catch(\Exception $e) {
				echo $e;
			}
        }
        // up date users where id
		public function update($data){
			$this->id=($data['id']);
			$this->stopped_at=date('Y/m/d H:i:s');
			$this->fuel_add=$data['fuel_add'];
			$this->fuel_stop=trim($data['fuel_stop']);
			$this->updated_at=date('Y/m/d H:i:s');
			// var_dump($this);
			// die();
			try {

				$connect = Database::connect();
				$query='UPDATE vehicle_users SET fuel_add=:fuel_add, stopped_at=:stopped_at, fuel_stop =:fuel_stop, updated_at=:updated_at WHERE id = :id';
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $this->id);   
				$statement->bindParam(':fuel_add', $this->fuel_add);   
		        $statement->bindParam(':stopped_at', $this->stopped_at);
		        $statement->bindParam(':fuel_stop', $this->fuel_stop);
		     	$statement->bindParam(':updated_at', $this->updated_at);
		        return $statement->execute();
			} catch (\Exception $e) {

				echo $e;
			}
		}
	// force delete 
		public function forcedelete($id){

			try {

				$connect =Database::connect();
				$query="DELETE FROM vehicle_users WHERE id = :id";
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $id);
		        return $statement->execute();

			} catch (\Exception $e) {

				echo $e;

			}
		}
		//softdelete ok
		public function softdelete($data){

			try{
				
				$this->deleted_at=date('Y/m/d H:i:s');
        		$connect=Database::connect();
        		$query='UPDATE vehicle_users SET deleted_at = :deleted_at WHERE id = :id';
        		$statement=$connect->prepare($query);
        		$statement->bindParam(':deleted_at',$this->deleted_at);
        		$statement->bindParam(':id', $data->id);
        		return $statement->execute();

        	} catch(\Exception $e) {

				echo $e;

			}
		}
		//
        public function checkexists($value, $rulevalue){
			try {
				$connect =Database::connect();
				$query="SELECT * FROM vehicle_users WHERE {$rulevalue} =:{$rulevalue} AND deleted_at IS NULL";
				$statement = $connect->prepare($query);
				$statement->bindParam(":{$rulevalue}", $value);
		        $statement->execute();
		        return $statement->fetch(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		// function check except exist user has this id
		public function except_exists($value, $rulevalue, $id){
			try {
				$connect =Database::connect();
				$query="SELECT * FROM vehicle_users WHERE id <>:id AND {$rulevalue} =:{$rulevalue} AND deleted_at IS NULL";
				$statement = $connect->prepare($query);
				$statement->bindParam(":{$rulevalue}", $value);
			    $statement->bindParam(":id", $id);
		        $statement->execute();
		        return $statement->fetch(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//
		public function specialget(){
			try {
				$connect =Database::connect();
				$query="SELECT vehicle_users.*, users.name AS user_name, vehicles.name AS vehicle_name FROM vehicle_users JOIN users ON vehicle_users.user_id= users.id jOIN vehicles ON vehicles.id= vehicle_users.vehicle_id WHERE vehicle_users.updated_at IS NULL AND vehicle_users.deleted_at IS NULL";
				$statement = $connect->prepare($query);
		        $statement->execute();
		        return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {

				echo $e;

			}
		}
		//
		public static function getoperating(){
			try {
				$connect =Database::connect();
				$query="SELECT * FROM vehicle_users WHERE deleted_at IS NULL AND updated_at IS NULL";
				$statement = $connect->prepare($query);
		        $statement->execute();
		        return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {

				echo $e;

			}
		}
	}
?>