<?php
require_once '../model/Statistic.php';
require_once '../model/Sim.php';

use Model\Statistic;
use Model\Sim;

$Simobject = new Sim();
$Statistic = new Statistic();

if (count($_GET)) {
    $data = $_GET;
    $check=$Simobject->checkexists($data['val'][0],'code');
   if($check!=false){
   	$result=$Statistic->insert($data);
   	if($result){
   		echo "success";
   	}
   	else{
   		echo 'failure';
   	}
   }
   else{
   	echo 'fails';
   }
} 
?>