<?php
	namespace Model;
	require_once 'Database.php';
	use Model\Database;
	use PDO;

	class Sim
	{
		private $id, $code, $phone_number, $network_operator, $vehicle_id;
		public $created_at, $updated_at, $deleted_at;
		
		//code construct class Sim
		public function __construct()
		{
			//set parameter for properties
		}
		
	    //get all data from to Sim table in database
		public static function getall(){
			try {
				$connect = Database::connect();
				$query= 'SELECT * FROM sims WHERE deleted_at IS NULL';
				$statement = $connect->prepare($query);
				$statement->execute();
				return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}

		}
		//find sim where id
		public static function find($id){
			try{
				$connect = Database::connect();
				$query= 'SELECT sims.*, vehicles.name AS vehicle_name FROM sims JOIN vehicles ON vehicles.id =sims.vehicle_id WHERE sims.id=:id AND sims.deleted_at IS NULL';
				$statement=$connect->prepare($query);
				$statement->bindParam(':id', $id);
				$statement->execute();
				return $statement->fetch(PDO::FETCH_OBJ);
			}
			catch (\Exception $e) {
				echo $e;
			}
		}
		//create sim account into database
		public function insert($data){
			$this->code=$data['code'];
			$this->phone_number=$data['phone_number'];
			$this->network_operator=$data['network_operator'];
			$this->vehicle_id=$data['vehicle_id'];
			$this->created_at=date('Y/m/d H:i:s');
		
			try {
				$connect = Database::connect();
				$query='INSERT INTO sims (code, phone_number, network_operator, vehicle_id, created_at) VALUES (:code, :phone_number, :network_operator, :vehicle_id, :created_at)';
				$statement = $connect->prepare($query);
				$statement->bindValue(':code', $this->code);
		        $statement->bindValue(':phone_number', $this->phone_number);
		        $statement->bindValue(':network_operator', $this->network_operator);
		        $statement->bindValue(':vehicle_id', $this->vehicle_id);
		        $statement->bindValue(':created_at', $this->created_at);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
		// update sim
        public function update($data){
        	$this->code=$data['code'];
			$this->phone_number=$data['phone_number'];
			$this->network_operator=$data['network_operator'];
			$this->vehicle_id=$data['vehicle_id'];
			$this->updated_at=date('Y/m/d H:i:s');
			$this->id=$data['id'];
			try {
				$connect = Database::connect();
				$query='UPDATE sims SET code = :code, phone_number =:phone_number, network_operator=:network_operator, updated_at=:updated_at WHERE id = :id';
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $this->id);   
		        $statement->bindParam(':code', $this->code);
		        $statement->bindParam(':phone_number',$this->phone_number);
		        $statement->bindParam(':network_operator',$this->network_operator);
		        $statement->bindParam(':updated_at', $this->updated_at);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
        }
        //one record will be softdelete where id
        public function softdelete(){
        	try{
				$this->deleted_at=date('Y/m/d H:i:s');
        		$connect=Database::connect();
        		$query='UPDATE sims SET deleted_at = :deleted_at WHERE id = :id';
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
				$query="DELETE FROM sims WHERE id = :id";
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $id);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//function check sim_code has been exists
		public function checkexists($value, $rulevalue){
			try {
				$connect =Database::connect();
				$query="SELECT * FROM sims WHERE {$rulevalue} =:{$rulevalue} AND deleted_at IS NULL";
				$statement = $connect->prepare($query);
				$statement->bindParam(":{$rulevalue}", $value);
		        $statement->execute();
		        return $statement->fetch(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//function check except exist sim has this id
		public function except_exists($value, $rulevalue, $id){
			try {
				$connect =Database::connect();
				$query="SELECT * FROM sims WHERE id <>:id AND {$rulevalue} =:{$rulevalue} AND deleted_at IS NULL";
				$statement = $connect->prepare($query);
				$statement->bindParam(":{$rulevalue}", $value);
			    $statement->bindParam(":id", $id);
		        $statement->execute();
		        return $statement->fetch(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//Query multiple table
		public function specialget(){
			try {
				$connect = Database::connect();
				$query= 'SELECT sims.*, vehicles.name, vehicles.id AS vehicle_id FROM sims JOIN vehicles ON sims.vehicle_id=vehicles.id';
				$statement = $connect->prepare($query);
				$statement->execute();
				return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		
	}
?>