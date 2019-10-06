<?php
//
/*
*/
if(isset($_GET)){
	$controller=$_GET['ctl'];
	$function =$_GET['ftn'];
	$parameter=$_GET['par'];
	require_once '../controller/UserController.php';
	use ../Controller\UserController;
	var_dump(UserController::testcontroller());
	exit();
}else if (isset($_POST)) {
	var_dump($_POST);
}
?>
