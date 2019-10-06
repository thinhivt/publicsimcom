<?php
	namespace Model;
	require_once 'Database.php';
	use Model\Database;
	use PDO;

	class Reference_Volume
	{
		private $height, $volume, $vehicle_id;
		public $created_at, $updated_at, $deleted_at;
		public function __construct(){
			#when call this class, this function is loaded
		}
		//create reference value of volume that belongs to height parameter into database
		public function insert($data){
			$this->height=$data[0];
			$this->volume=$data[1];
			$this->vehicle_id=$data[2];
			$this->created_at=date('Y/m/d H:i:s');
			try {
				$connect = Database::connect();
				$query='INSERT INTO reference_volumes (height, volume, vehicle_id, created_at) VALUES (:height, :volume, :vehicle_id, :created_at)';
				$statement = $connect->prepare($query);
				$statement->bindValue(':height', $this->height);
				$statement->bindValue(':volume', $this->volume);
				$statement->bindValue(':vehicle_id', $this->vehicle_id);
		        $statement->bindValue(':created_at', $this->created_at);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//update data for this reference volume
		public function update($data){
			$this->setvalue($data);
			$this->updated_at=date('Y/m/d H:i:s');
			$this->id=$data['id'];
			try {
				$connect = Database::connect();
				$query='UPDATE reference_volumes SET height = :height, volume =:volume, vehicle_id =:vehicle_id, updated_at=:updated_at WHERE id = :id';
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $this->id);   
		        $statement->bindParam(':height', $this->height);
		        $statement->bindParam(':volume', $this->volume);
		        $statement->bindParam(':vehicle_id', $this->vehicle_id);
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
				$query='SELECT * FROM reference_volumes WHERE id =:id AND deleted_at IS NULL';
				$statement=$connect->prepare($query);
				$statement=$bindParam(':id', $id);
				$statement->execute();
				return $statement->fetch(PDO::FETCH_OBJ);
			}
			catch (\Exception $e) {
				echo $e;
			}
		}
		public static function getall(){
			try {
				$connect = Database::connect();
				$query= 'SELECT * FROM reference_volumes WHERE deleted_at IS NULL';
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
				$this->deleted_at=date('Y/m/d || H:i:s');
        		$connect=Database::connect();
        		$query='UPDATE reference_volumes SET deleted_at = :deleted_at WHERE id = :id';
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
				$query="DELETE FROM reference_volumes WHERE vehicle_id = :id";
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $id);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//query multiple table
		public static function getwith($id){
			try {
				$connect = Database::connect();
				$query= 'SELECT * FROM reference_volumes WHERE vehicle_id=:id AND deleted_at IS NULL';
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $id);
				$statement->execute();
				return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		public function getMax($id){
			try {
				$connect = Database::connect();
				$query= 'SELECT * FROM reference_volumes WHERE vehicle_id=:id AND deleted_at IS NULL ORDER BY height DESC LIMIT 1';
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $id);
				$statement->execute();
				return $statement->fetch(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		
	}
?>