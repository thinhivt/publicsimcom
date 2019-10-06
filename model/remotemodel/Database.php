<?php
	namespace RemoteModel;
	use PDO;
	use Exception;
	/**
	 * Database
	 */
	class Database
	{
		
		public function __construct()
		{
			# code...
		}

		public static function connect()
		{
			$dns = "mysql:host=27.66.5.207;dbname=petrol";
		    $username = "petrol_native";
		    $password = "Nguyenhien@123";
		    
		    try {
		    	return new PDO($dns, $username, $password);
		    } catch (Exception $e) {
		    	echo "Connect error {$e->getErrorMessage()}";
		    }
		}
	}
?>