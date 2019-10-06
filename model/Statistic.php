<?php
	namespace Model;
	require_once 'Database.php';
	use Model\Database;
	use PDO;

	class Statistic
	{
		private $id, $sim_code, $height;
		public $created_at, $updated_at, $deleted_at;
		public function __construct(){
			#code constuct here!
		}
		public function insert($data){
			$this->sim_code=$data['val'][0];
			$this->height=$data['val'][1];
			$this->created_at=date('Y/m/d H:i:s');
			try {
				$connect = Database::connect();
				$query='INSERT INTO statistics (height, sim_code, created_at) VALUES (:height, :sim_code, :created_at)';
				$statement = $connect->prepare($query);
				$statement->bindParam(':sim_code', $this->sim_code);
		        $statement->bindParam(':height', $this->height);
		        $statement->bindParam(':created_at', $this->created_at);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//update data for this statistic
		public function update($data){
			$this->setvalue($data);
			$this->updated_at=date('Y/m/d || H:i:s');
			$this->id=$data['id'];
			try {
				$connect = Database::connect();
				$query='UPDATE statistics SET sim_code = :sim_code, height =:height, updated_at=:updated_at WHERE id = :id';
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $this->id);   
		        $statement->bindParam(':sim_code', $this->sim_code);
		        $statement->bindParam(':height', $this->height);
		        $statement->bindParam(':updated_at', $this->updated_at);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//find vehicle information where id
		public static function find($id){
			try{
				$connect=Database::connect();
				$query='SELECT * FROM statistics WHERE id =:id AND deleted_at IS NULL';
				$statement=$connect->prepare($query);
				$statement->bindParam(':id', $id);
				$statement->execute();
				return $statement->fetch(PDO::FETCH_OBJ);
			}
			catch (\Exception $e) {
				echo $e;
			}
		}
		public static function getAll(){
			try {
				$connect = Database::connect();
				$query= 'SELECT * FROM statistics WHERE deleted_at IS NULL';
				$statement = $connect->prepare($query);
				$statement->execute();
				return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//one record will be softdelete where id
        public function softdelete($data){
        	try{
				$this->deleted_at=date('Y/m/d || H:i:s');
        		$connect=Database::connect();
        		$query='UPDATE statistics SET deleted_at = :deleted_at WHERE id = :id';
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
				$query="DELETE FROM statistics WHERE id = :id";
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $id);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//set value for private properties
		private function setvalue($data){
			$this->sim_code=$data['sim_code'];
			$this->height=$data['height'];
		}
		//set value for private properties
		private function setpropertise($data){
			$this->sim_code=$data['val'][0];
			$this->height=$data['val'][1];
		}
		//select multitable
		public function specialget(){
			try {
				$connect = Database::connect();
				$query= 'SELECT statistics.id, statistics.height, statistics.created_at, vehicles.id AS vehicle_id, vehicles.name, reference_volumes.volume  FROM statistics JOIN sims ON sims.code= statistics.sim_code JOIN vehicles ON sims.vehicle_id= vehicles.id JOIN reference_volumes ON vehicles.id= reference_volumes.vehicle_id AND reference_volumes.height=statistics.height WHERE statistics.deleted_at IS NULL';
				$statement = $connect->prepare($query);
				$statement->execute();
				return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//
		public function belongsto_ID($id){
			try {
				$connect = Database::connect();
				$query= 'SELECT statistics.id, statistics.height, statistics.created_at, vehicles.name, reference_volumes.volume  FROM statistics JOIN sims ON sims.code= statistics.sim_code JOIN vehicles ON sims.vehicle_id= vehicles.id JOIN reference_volumes ON vehicles.id= reference_volumes.vehicle_id AND reference_volumes.height=statistics.height WHERE vehicles.id=:id AND statistics.deleted_at IS NULL '; 
				$statement = $connect->prepare($query);
				$statement->bindParam(':id',$id);
				$statement->execute();
				return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//
		public function getStatus($id){
			try {
				$connect = Database::connect();
				$query= 'SELECT statistics.id, statistics.height, statistics.created_at, vehicles.name, reference_volumes.volume  FROM statistics JOIN sims ON sims.code= statistics.sim_code JOIN vehicles ON sims.vehicle_id= vehicles.id JOIN reference_volumes ON vehicles.id= reference_volumes.vehicle_id AND reference_volumes.height=statistics.height WHERE vehicles.id=:id AND statistics.deleted_at IS NULL ORDER BY statistics.id DESC LIMIT 1 '; 
				$statement = $connect->prepare($query);
				$statement->bindParam(':id',$id);
				$statement->execute();
				return $statement->fetch(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//
		public function getOption($id){
			try {
				$connect = Database::connect();
				$query= 'SELECT statistics.height, statistics.created_at, reference_volumes.volume  FROM statistics JOIN sims ON sims.code= statistics.sim_code JOIN vehicles ON sims.vehicle_id= vehicles.id JOIN reference_volumes ON vehicles.id= reference_volumes.vehicle_id AND reference_volumes.height=statistics.height WHERE vehicles.id=:id AND statistics.deleted_at IS NULL ORDER BY statistics.id DESC LIMIT 100 '; 
				$statement = $connect->prepare($query);
				$statement->bindParam(':id',$id);
				$statement->execute();
				return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
	}
?>