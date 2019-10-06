<?php
session_start();
require_once '../model/Vehicle.php';
require_once '../model/Sim.php';
require_once 'validate/CreateSimValidation.php';
require_once 'validate/UpdateSimValidation.php';

use Validate\CreateSimValidation;
use Validate\UpdateSimValidation;
use Model\Vehicle;
use Model\Sim;

$simobject = new Sim();
$Vehicleobject = new Vehicle();

if(!empty($_SESSION['author'])){
    if($_SESSION['author']->role==4){
        if (count($_GET)) {
            $data_get = $_GET;
            switch ($data_get['action']) {
                case 'index':
                    $simlist=$simobject->specialget();
                    include '../view/simview/indexsim.php';
                    break;
                case 'edit':
                    $sim=Sim::find($data_get['id']);
                    $vehiclelist=Vehicle::getAll();
                    include '../view/simview/updatesim.php';
                    break;
                case 'register':
                    $allvehicle=Vehicle::getAll();
                    $simlist=Sim::getall();
                    foreach ($allvehicle as $vehicle) {
                        $check=true;
                        foreach ($simlist as $sim) {
                            if($vehicle->id!=$sim->vehicle_id){
                                continue;
                            }
                            else{
                                $check=false;
                                break;
                            }
                        }
                        if($check==true){
                            $vehiclelist[]=$vehicle;
                        }
                    }
                    include '../view/simview/registersim.php';
                    break;
                case 'delete':
                    $sim= Sim::find($data_get['id']);
                    var_dump($sim);
                    exit();
                    break;
                default:
                    # code...
                    break;
            }
        } 
        else if(count($_POST)) {
            $data_post = $_POST;
            switch ($data_post['action']) {
                case 'store':
                    $validation =new CreateSimValidation();
                    $response = $validation->createsimrequest($data_post);
                    if(!$response['pass']){
                        $_SESSION['response']=$response;
                        $_SESSION['data_post']=$data_post;
                        header('Location:./SimController.php?action=register');
                    }
                    else{
                        //create session that announce successfull

                        $result=$simobject->insert($data_post);
                        if($result){
                            header('Location:./SimController.php?action=index');
                        }
                    }
                    break;
                case 'update':
                    $validation =new UpdateSimValidation();
                    $response = $validation->updatesimrequest($data_post);
                    if(!$response['pass']){
                        $_SESSION['response']=$response;
                        header('Location:./SimController.php?action=edit&id='.$data_post['id']);
                    }
                    else{
                        $result=$simobject->update($data_post);
                        if($result){
                            $_SESSION['announce']=array(
                                'attribute'=>'info',
                                'content'=>'update is successfull'
                            );
                            header('Location:./SimController.php?action=edit&id='.$data_post['id']);
                        }
                    }
                    break;

                default:
                    # code...
                    break;
            }
        }
    }else{
        include '../view/errorview/error404.php'; 
    }
}else{
    include '../view/userview/userlogin1.php';
}
?>