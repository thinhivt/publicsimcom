<?php
	namespace Model;
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
			$dns = "mysql:host=127.0.0.1;dbname=simcom";
		    $username = "root";
		    $password = "";

		    try {
		    	return new PDO($dns, $username,  $password);
		    } catch (Exception $e) {
		    	echo "Connect error {$e->getErrorMessage()}";
		    }
		}
	}
?>