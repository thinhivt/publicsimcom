<?php
	namespace Model;
	require_once 'Database.php';
	use Model\Database;
	use PDO;

	class Vehicle
	{
		private $name, $rfid;
		public $created_at, $updated_at, $deleted_at;
		public function __construct(){

		}
		//create vehicle into database
		public function insert($data){
			$this->name=trim($data['name']);
			$this->rfid=trim($data['rfid']);
			$this->created_at=date('Y/m/d H:i:s');
			try {
				$connect = Database::connect();
				$query='INSERT INTO vehicles (name, rfid, created_at) VALUES (:name, :rfid, :created_at)';
				$statement = $connect->prepare($query);
				$statement->bindValue(':name', $this->name);
				$statement->bindValue(':rfid', $this->rfid);
		        $statement->bindValue(':created_at', $this->created_at);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//update data for this vehicle
		public function update($data){
			$this->name=trim($data['name']);
			$this->rfid=trim($data['rfid']);
			$this->updated_at=date('Y/m/d H:i:s');
			$this->id=$data['id'];
			try {
				$connect = Database::connect();
				$query='UPDATE vehicles SET name = :name, rfid=:rfid, updated_at=:updated_at WHERE id = :id';
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $this->id);   
		        $statement->bindParam(':name', $this->name);
		        $statement->bindParam(':rfid', $this->rfid);
		        $statement->bindParam(':updated_at', $this->updated_at);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//find vehicle information where id
		public function find($id){
			try{
				$connect=Database::connect();
				$query='SELECT * FROM vehicles WHERE id =:id AND deleted_at IS NULL';
				$statement=$connect->prepare($query);
				$statement->bindParam(':id', $id);
				$statement->execute();
				return $statement->fetch(PDO::FETCH_OBJ);
			}
			catch (\Exception $e) {
				echo $e;
			}
		}
		// Get all vehicles
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
		//get vehicles tha have sim
		public static function gethave(){
			try {
				$connect = Database::connect();
				$query= 'SELECT vehicles.*, sims.phone_number AS phone FROM vehicles JOIN sims ON vehicles.id= sims.vehicle_id  WHERE vehicles.deleted_at IS NULL';
				$statement = $connect->prepare($query);
				$statement->execute();
				return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}	
		}
		//one record will be softdelete where id
        public function softdelete(){
        	try{
				$this->deleted_at=date('Y/m/d H:i:s');
        		$connect=Database::connect();
        		$query='UPDATE vehicles SET deleted_at = :deleted_at WHERE id = :id';
        		$statement=$connect->prepare($query);
        		$statement->bindParam(':deleted_at',$this->deleted_at);
        		$statement->bindParam(':id', $data->id);
        		return $statement->execute();
        	} catch(\Exception $e) {
				echo $e;
			}
        }
        //force delete ok
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
		//function check except exist sim has this id
		public function except_exists($value, $rulevalue, $id){
			try {
				$connect =Database::connect();
				$query="SELECT * FROM vehicles WHERE id <>:id AND {$rulevalue} =:{$rulevalue} AND deleted_at IS NULL";
				$statement = $connect->prepare($query);
				$statement->bindParam(":{$rulevalue}", $value);
			    $statement->bindParam(":id", $id);
		        $statement->execute();
		        return $statement->fetch(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//check $data exists inside vehicle table
		public function checkexists($value, $rulevalue){
			try {
				$connect =Database::connect();
				$query="SELECT * FROM vehicles WHERE {$rulevalue} =:{$rulevalue} AND deleted_at IS NULL";
				$statement = $connect->prepare($query);
				$statement->bindParam(":{$rulevalue}", $value);
		        $statement->execute();
		        return $statement->fetch(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		/*multiple Query*/
		//
		public function specialget($id){
			try {
				$connect = Database::connect();
				$query= 'SELECT vehicles.*, sims.phone_number AS phone FROM vehicles JOIN sims ON vehicles.id= sims.vehicle_id  WHERE vehicles.id=:id AND vehicles.deleted_at IS NULL';
				$statement = $connect->prepare($query);
				$statement->bindParam(":id", $id);
				$statement->execute();
				return $statement->fetch(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//
		public static function getmaxid(){
			try {
				$connect = Database::connect();
				$query= 'SELECT MAX(id) AS maxid FROM vehicles WHERE deleted_at IS NULL';
				$statement = $connect->prepare($query);
				$statement->execute();
				return $statement->fetch(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
	}
?>