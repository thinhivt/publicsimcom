<?php 
	session_start();
	if(empty($_SESSION['author'])){
		include 'view/userview/userlogin1.php';
	}
	else{
		 header('Location:./controller/UserController.php?action=index');
	}
?>