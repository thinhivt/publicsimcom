<?php
	namespace RemoteModel;
	require_once 'Database.php';
	use RemoteModel\Database;
	use PDO;

	class User
	{
		private $id, $hoten, $maso, $password, $donvi, $sdt, $email;
		
		//code construct class Sim
		public function __construct()
		{
			
		}
		
	    //get all data from to ThongKe table in database
		public static function getall(){
			try {
				$connect = Database::connect();
				$query= 'SELECT * FROM users';
				$statement = $connect->prepare($query);
				$statement->execute();
				return $statement->fetchAll(PDO::FETCH_OBJ);
			} catch (\Exception $e) {
				echo $e;
			}

		}
		//find record into users where id=reference data
		public static function find($id){
			try{
				$connect = Database::connect();
				$query= 'SELECT * FROM users WHERE id =:id';
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
			$this->id=$data['user_id'];
			$this->hoten=$data['name'];
			$this->email=$data['email'];
			$this->maso=$data['user_code'];
			$this->password=$data['password'];
			$this->donvi=$data['position'];
			$this->sdt=$data['phone'];
			try {
				$connect = Database::connect();
				$query='INSERT INTO users (id, hoten, maso, password, donvi, sdt, email) VALUES (:id, :hoten, :maso, :password, :donvi, :sdt , :email)';
				$statement = $connect->prepare($query);
				$statement->bindValue(':id', $this->id);
				$statement->bindValue(':hoten', $this->hoten);
		        $statement->bindValue(':maso', $this->maso);
		        $statement->bindValue(':password', $this->password);
		        $statement->bindValue(':donvi', $this->donvi);
		        $statement->bindValue(':sdt', $this->sdt);
		        $statement->bindValue(':email', $this->email);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
		// update user where user code
        public function update($data){
        	$this->id=$data['user_id'];
        	$this->hoten=$data['name'];
        	$this->maso=$data['user_code'];
			$this->email=$data['email'];
			$this->donvi=$data['position'];
			$this->sdt=$data['phone'];
			var_dump($this);
			try {
				$connect = Database::connect();
				$query='UPDATE users SET hoten = :hoten, email =:email, donvi =:donvi, sdt =:sdt, maso= :maso WHERE id =:id';
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $this->id);  
				$statement->bindParam(':hoten', $this->hoten);   
				$statement->bindParam(':email', $this->email);   
		        $statement->bindParam(':donvi', $this->donvi);
		        $statement->bindParam(':maso', $this->maso);
		        $statement->bindParam(':sdt', $this->sdt);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
        }
		public function forcedelete($user_code){
			try {
				$connect =Database::connect();
				$query="DELETE FROM users WHERE maso = :maso";
				$statement = $connect->prepare($query);
				$statement->bindParam(':id', $user_code);
		        return $statement->execute();
			} catch (\Exception $e) {
				echo $e;
			}
		}
	}
?>