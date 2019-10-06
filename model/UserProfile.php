<?php
	namespace Model;
	require_once 'Database.php';
	use Model\Database;
	use PDO;

	class UserProfile
	{
		private $id, $user_code, $position, $phone, $address, $gender, $role, $avatar, $user_id;
		public $created_at, $updated_at, $deleted_at;

		// construct class
		public function __construct()
		{
			//code construct here
		}
		
		//get All ok
		public static function getAll()
		{
			$connect = Database::connect();
			$query= 'SELECT * FROM userprofiles WHERE deleted_at IS NULL';
			$statement = $connect->prepare($query);
			$statement->execute();
			return $statement->fetchAll(PDO::FETCH_OBJ);
		}

		//Insert data ok
		public function insert($data, $user_id)
		{   $this->user_code=trim($data['user_code']);
			$this->position=trim($data['position']);
			$this->phone=trim($data['phone']);
			$this->address=trim($data['address']);
			$this->gender=$data['gender'];
			$this->role=$data['role'];
			$this->avatar=$data['avatar'];
			$this->user_id=$user_id;
			$this->created_at=date('Y/m/d H:i:s');
			
			try {

				$connect = Database::connect();
				$query='INSERT INTO userprofiles (user_code, position, phone, address, gender, role, avatar, user_id, created_at) VALUES (:user_code, :position, :phone, :address, :gender, :role, :avatar, :user_id, :created_at)';
				$statement = $connect->prepare($query);
				$statement->bindValue(':user_code', $this->user_code);
				$statement->bindValue(':position', $this->position);
				$statement->bindValue(':phone', $this->phone);
				$statement->bindValue(':address', $this->address);
		        $statement->bindValue(':gender', $this->gender);
		        $statement->bindValue(':avatar', $this->avatar);
		        $statement->bindValue(':role', $this->role);
		        $statement->bindValue(':user_id', $this->user_id);
		        $statement->bindValue(':created_at', $this->created_at);
		        return $statement->execute();

			} catch (\Exception $e) {

				echo $e;

			}
		}

		//find table where id ok
        public static function find($id){

        	try{

        		$connect=Database::connect();
        		$query='SELECT * from userprofiles WHERE user_id=:user_id AND deleted_at IS NULL';
        		$statement=$connect->prepare($query);
        		$statement->bindValue(':user_id',$id);
        		$statement->execute();
        		return $statement->fetch(PDO::FETCH_OBJ);

        	} catch(\Exception $e) {

				echo $e;

			}
        }

        // up date users where id
		public function update($data, $user_id)
		{
			$this->position=trim($data['position']);
			$this->phone=trim($data['phone']);
			$this->address=trim($data['address']);
			$this->gender=$data['gender'];
			$this->role=$data['role'];
			$this->avatar=$data['avatar'];
			$this->user_id=$user_id;
			$this->updated_at=date('Y/m/d H:i:s');
			try {

				$connect = Database::connect();
				$query='UPDATE userprofiles SET position =:position, gender = :gender, phone =:phone, address=:address, avatar=:avatar, role=:role, updated_at=:updated_at WHERE user_id = :user_id';
				$statement = $connect->prepare($query);
				$statement->bindValue(':position', $this->position);
				$statement->bindValue(':phone', $this->phone);
				$statement->bindValue(':address', $this->address);
		        $statement->bindValue(':gender', $this->gender);
		        $statement->bindValue(':avatar', $this->avatar);
		        $statement->bindValue(':role', $this->role);
		        $statement->bindValue(':user_id', $this->user_id);
		        $statement->bindValue(':updated_at', $this->updated_at);
		        return $statement->execute();

			} catch (\Exception $e) {

				echo $e;

			}
		}

		//force delete ok
		public function forcedelete($id){

			try {

				$connect =Database::connect();
				$query="DELETE FROM userprofiles WHERE id = :id";
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $id);
		        return $statement->execute();

			} catch (\Exception $e) {

				echo $e;

			}
		}

		public function softdelete($data){

			try{

				$this->deleted_at=date('Y/m/d H:i:s');
        		$connect=Database::connect();
        		$query='UPDATE userprofiles SET deleted_at = :deleted_at WHERE user_id = :id';
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
				$query="SELECT * FROM userprofiles WHERE {$rulevalue} =:{$rulevalue} AND deleted_at IS NULL";
				$statement = $connect->prepare($query);
				$statement->bindParam(":{$rulevalue}", $value);
		        $statement->execute();
		        return $statement->fetch(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}

		//function check except exist userprofile has this id
		public function except_exists($value, $rulevalue, $user_id){
			try {
				$connect =Database::connect();
				$query="SELECT * FROM userprofiles WHERE user_id <>:id AND {$rulevalue} =:{$rulevalue} AND deleted_at IS NULL";
				$statement = $connect->prepare($query);
				$statement->bindParam(":{$rulevalue}", $value);
			    $statement->bindParam(":id", $user_id);
		        $statement->execute();
		        return $statement->fetch(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//
		public function setphone($phone){

			$this->phone=$phone;

		}

		public function setaddress($address){

			$this->address=$address;

		}

		public function setgender($gender){

			$this->gender=$gender;

		}

		public function setrole($role){

			$this->role=$role;

		}

		public function setavatar($avatar){

			$this->avatar=$avatar;

		}

		public function setuser_id($user_id){

			$this->user_id=$user_id;

		}

		public function getphone(){

			return $this->phone;

		}

		public function getaddress(){

			return $this->address;
			
		}

		public function getgender(){

			return $this->gender;
			
		}

		public function getrole(){

			return $this->role;
			
		}

		public function getavatar(){

			return $this->avatar;
			
		}

		public function getuser_id(){

			return $this->user_id;
			
		}
	}
?>