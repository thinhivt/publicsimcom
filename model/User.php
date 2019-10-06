<?php
	namespace Model;
	require_once 'Database.php';
	use Model\Database;
	use PDO;

	class User
	{
		private $id, $name, $email, $password;
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
			$query= 'SELECT * FROM users WHERE deleted_at IS NULL';
			$statement = $connect->prepare($query);
			$statement->execute();
			return $statement->fetchAll(PDO::FETCH_OBJ);
		}
		// get user role
		public static function getuser($role)
		{
			$connect = Database::connect();
			$query= 'SELECT users.* FROM users JOIN userprofiles ON users.id=userprofiles.user_id WHERE userprofiles.role <=:role AND users.deleted_at IS NULL';
			$statement = $connect->prepare($query);
			$statement->bindValue(':role', $role);
			$statement->execute();
			return $statement->fetchAll(PDO::FETCH_OBJ);
		}
		//Insert data ok
		public function insert($data)
		{   
			$this->email=trim($data['email']);
			$this->name=trim($data['name']);
			$this->password=trim($data['password']);
			$this->created_at=date('Y/m/d H:i:s');
			try {
				$connect = Database::connect();
				$query='INSERT INTO users (name, email, password, created_at) VALUES (:name, :email, :password, :created_at)';
				$statement = $connect->prepare($query);
				$statement->bindValue(':email', $this->email);
		        $statement->bindValue(':password', $this->password);
		        $statement->bindValue(':name', $this->name);
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
        		$query='SELECT * from users WHERE id=:id AND deleted_at IS NULL';
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

			$this->name=trim($data['name']);
			$this->email=trim($data['email']);
			$this->updated_at=date('Y/m/d H:i:s');
			$this->id=$data['id'];
			try {

				$connect = Database::connect();
				$query='UPDATE users SET email = :email, name=:name, updated_at=:updated_at WHERE id = :id';
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $this->id);   
		        $statement->bindParam(':email', $this->email);
		        $statement->bindParam(':name',$this->name);
		        $statement->bindParam(':updated_at', $this->updated_at);
		        return $statement->execute();

			} catch (\Exception $e) {

				echo $e;
			}
		}
		//force delete ok
		public function forcedelete($id){

			try {

				$connect =Database::connect();
				$query="DELETE FROM users WHERE id = :id";
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $id);
		        return $statement->execute();

			} catch (\Exception $e) {

				echo $e;

			}
		}

		public function softdelete($data){

			try{
				
				$this->deleted_at=date('Y/m/d || H:i:s');
        		$connect=Database::connect();
        		$query='UPDATE users SET deleted_at = :deleted_at WHERE id = :id';
        		$statement=$connect->prepare($query);
        		$statement->bindParam(':deleted_at',$this->deleted_at);
        		$statement->bindParam(':id', $data->id);
        		return $statement->execute();

        	} catch(\Exception $e) {

				echo $e;

			}
		}
		//get author information not finish	
		public  static function getauthor($email){

			try{
        		$connect=Database::connect();
        		$query='SELECT users.name, users.email, userprofiles.avatar, userprofiles.role FROM users JOIN userprofiles ON users.id = userprofiles.user_id WHERE email=:email AND users.deleted_at IS NULL';
        		$statement=$connect->prepare($query);
        		$statement->bindParam(':email',$email);
        		$statement->execute();
        		return $statement->fetch(PDO::FETCH_OBJ);

        	} catch(\Exception $e) {

				echo $e;

			}

		}
		// save data when update
		public function save(){

			try {

				$connect = Database::connect();
				$query='UPDATE users SET email = :email, password =:password, name=:name, updated_at=:updated_at WHERE id = :id';
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $this->id);   
		        $statement->bindParam(':email', $this->email);
		        $statement->bindParam(':password',$this->password);
		        $statement->bindParam(':name',$this->name);
		        $statement->bindParam(':updated_at', $this->updated_at);
		        $statement->execute();

			} catch (\Exception $e) {

				echo $e;

			}
		}

		public static function maxid(){

			try {

				$connect = Database::connect();
				$query='SELECT MAX(id) as max FROM users';
				$statement = $connect->prepare($query);
		        $statement->execute();
		        return $statement->fetch(PDO::FETCH_OBJ);

			} catch (\Exception $e) {

				echo $e;

			}
		}
		//
        public function checkexists($value, $rulevalue){
			try {
				$connect =Database::connect();
				$query="SELECT * FROM users WHERE {$rulevalue} =:{$rulevalue} AND deleted_at IS NULL";
				$statement = $connect->prepare($query);
				$statement->bindParam(":{$rulevalue}", $value);
		        $statement->execute();
		        return $statement->fetch(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}
		}
		//
		public function setname($name){

			$this->name=$name;

		}
		
		//function check except exist user has this id
		public function except_exists($value, $rulevalue, $id){
			try {
				$connect =Database::connect();
				$query="SELECT * FROM users WHERE id <>:id AND {$rulevalue} =:{$rulevalue} AND deleted_at IS NULL";
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
		public function setemail($email){

			$this->email=$email;

		}
		//
		public function setpassword($password){

			$this->password=$password;

		}
		//
		public function getname(){

			return $this->name;

		}
 		//
		public function getemail(){

			return $this->email;

		}
		//
		public function getpassword(){

			return $this->password;

		}



	}
?>