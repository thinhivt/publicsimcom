<?php
session_start();
require_once '../model/Vehicle.php';
require_once '../model/Statistic.php';
require_once '../model/Sim.php';
require_once '../model/Reference_Volume.php';

require_once 'validate/CreateVehicleValidation.php';
require_once 'validate/UpdateVehicleValidation.php';
require_once 'validate/CreateReferenceVolumeValidation.php';
require_once 'remotecontroller/VehicleController.php';

use RemoteController\VehicleController;

use Model\Vehicle;
use Model\Statistic;
use Model\Sim;
use Model\Reference_Volume;

use Validate\CreateVehicleValidation;
use Validate\UpdateVehicleValidation;
use Validate\CreateReferenceVolumeValidation;

$Statistic = new Statistic();
$Vehicleobject = new Vehicle();
$Simobject=new Sim();
$Reference_Volumesobject= new Reference_Volume();
$vehiclecontrollerobject= new VehicleController();

if(!empty($_SESSION['author'])){
    if (count($_GET)) {
        $data_get = $_GET;
        switch ($data_get['action']) {
            case 'index':
                if($_SESSION['author']->role>=3){
                    $vehiclelist = Vehicle::getAll();
                include '../view/vehicle/indexvehicle.php';
                }else{
                    include '../view/errorview/error404.php';
                }
                break;
            case 'statistic':
                if($_SESSION['author']->role==4){
                    $statisticlist = $Statistic->specialget();
                    include '../view/vehicle/indexstatistic.php';
                }else{
                    include '../view/errorview/error404.php';
                }
                break;
            case 'show':
                if($_SESSION['author']->role>=3){
                    $statisticlist=$Statistic->belongsto_ID($data_get['id']);
                    include '../view/vehicle/indexstatistic.php';
                }else{
                    include '../view/errorview/error404.php';
                }
                break;
            case 'detail':
                if($_SESSION['author']->role>=3){
                    $vehicle=$Vehicleobject->specialget($data_get['id']);
                    $reference_volumes=Reference_Volume::getwith($data_get['id']);
                    include '../view/vehicle/detailvehicle.php';
                }else{
                    header('Location:./DashboardController.php?action=index');
                }
                break;
            case 'statisticdelete':
                if($_SESSION['author']->role==4){
                    $statistic=Statistic::find($data_get['id']);
                    $result=$Statistic->softdelete($statistic);
                    if($result){
                        header('Location:./VehicleController.php?action=statistic');
                    }
                }else{
                    include '../view/errorview/error404.php';
                }
                break;
            case 'register':
                if($_SESSION['author']->role>=3){
                     include '../view/vehicle/createvehicle.php';
                    # code...
                }else{
                    include '../view/errorview/error404.php';
                }
                break;
            case 'edit':
                if($_SESSION['author']->role>=3){
                    $vehicle=Vehicle::find($data_get['id']);
                    include '../view/vehicle/updatevehicle.php';
                }else{
                    include '../view/errorview/error404.php';
                }
                break;
            case 'delete':
                if($_SESSION['author']->role>=3){
                  $vehicle=Vehicle::find($data_get['id']);
                    var_dump($vehicle);  
                }else{
                    include '../view/errorview/error404.php';
                }
                break;
            case 'create_ref':
                if($_SESSION['author']->role>=3){
                     $vehiclelist=Vehicle::getAll();
                    include '../view/vehicle/createreference_volume.php';
                }else{
                    include '../view/errorview/error404.php';
                }
                break;
            case 'interrupt':
                if($_SESSION['author']->role>=3){
                    $newstatus=$Statistic->getStatus($data_get['id']);
                   $maxpara=$Reference_Volumesobject->getMax($data_get['id']);
                   $merge= array(
                    'maxheight' => $maxpara->height,
                    'maxvolume'=>$maxpara->volume,
                    'currentheight'=>$newstatus->height,
                    'currentvolume'=>$newstatus->volume,
                    'percentage'=>round($newstatus->volume*100/$maxpara->volume)
                    );
                    echo json_encode($merge); 
                }else{
                    include '../view/errorview/error404.php';
                }
                break;
            case 'timing':
                if($_SESSION['author']->role>=3){
                    $data=$Statistic->getOption($data_get['id']);
                    echo json_encode($data);
                }else{
                    include '../view/errorview/error404.php';
                }
                break;
            default:
                include '../view/userview/userlogin1.php'; 
                break;
        }
    } else if (count($_POST)) {
        $data_post = $_POST;
        switch ($data_post['action']) {
            case 'store':
                if($_SESSION['author']->role>=3){
                   $validation =new CreateVehicleValidation();
                    $response = $validation->createvehiclerequest($data_post);
                    
                     if(!$response['pass']){
                        $_SESSION['response']=$response;
                        $_SESSION['data_post']=$data_post;
                        header('Location:./VehicleController.php?action=register');
                    }
                    else{
                        $result=$Vehicleobject->insert($data_post);
                        if($result){
                            $maxid=Vehicle::getmaxid();
                            $data_post['id']=$maxid->maxid;
                            $remoteresult=$vehiclecontrollerobject->insert($data_post);
                            if($remoteresult!=true){
                                $_SESSION['msg']=[
                                    'attr'=>'alert-danger',
                                    'cnt'=>'disconnect to remote database'
                                ];
                            }
                            header('Location:./VehicleController.php?action=index');
                        }
                    }  
                }else{
                    include '../view/errorview/error404.php';
                }
                break;
            case 'save':
                if($_SESSION['author']->role>=3){
                    $validation =new UpdateVehicleValidation();
                    $response = $validation->updatevehiclerequest($data_post);
                    if(!$response['pass']){
                        $_SESSION['response']=$response;
                        header('Location:./VehicleController.php?action=edit&id='.$data_post['id']);
                    }
                    else{
                        $result=$Vehicleobject->update($data_post);
                        if($result){
                            $remoteresult=$vehiclecontrollerobject->update($data_post);
                            if($remoteresult==true){
                                //session success
                                echo 'success';
                            }else{
                                 $_SESSION['msg']=[
                                    'attr'=>'alert-danger',
                                    'cnt'=>'disconnect to remote database'
                                ];
                            }
                            header('Location:./VehicleController.php?action=edit&id='.$data_post['id']);
                        }
                    } 
                }else{
                    include '../view/errorview/error404.php';
                }
                # code...
                break;
            case 'create_ref':
                if($_SESSION['author']->role>=3){
                     $validation =new CreateReferenceVolumeValidation();
                    $response = $validation->createreferencevolumerequest($data_post, $_FILES);
                    if(!$response['pass']){
                        $_SESSION['response']=$response;
                        $_SESSION['data_post']=$data_post;
                        header('Location:./VehicleController.php?action=create_ref');
                    }
                    else{
                       $data=$response['data']['datahandle'];
                       $check=true;
                       for ($i=1; $i <= count($data) ; $i++) { 
                         $result=$Reference_Volumesobject->insert($data[$i]);
                         if(!$result){
                            $check=false;
                            break;
                         }
                       }
                       if($check==true){
                        echo 'success';
                       }
                       else{
                        echo 'fails insert';
                       }
                       
                    }
                }else{
                    include '../view/errorview/error404.php';
                }
                break;
            case 'update_ref':
                if($_SESSION['author']->role>=3){
                    $validation =new CreateReferenceVolumeValidation();
                    $response = $validation->createreferencevolumerequest($data_post, $_FILES);
                    if(!$response['pass']){
                        $_SESSION['response']=$response;
                        header('Location:./VehicleController.php?action=detail&id='.$data_post['vehicle_id']);
                    }
                    else{
                       $result=$Reference_Volumesobject->forcedelete($data_post['vehicle_id']);
                       if($result){
                            $data=$response['data']['datahandle'];
                           $check=true;
                           for ($i=1; $i <= count($data) ; $i++) { 
                             $result=$Reference_Volumesobject->insert($data[$i]);
                             if(!$result){
                                $check=false;
                                break;
                             }
                           }
                           if($check==true){
                                $_SESSION['msg']=[
                                    'attr'=>'alert-success',
                                    'cnt'=>'update is successful!'
                                ];
                                header('Location:./VehicleController.php?action=detail&id='.$data_post['vehicle_id']);
                           }
                           else{
                                $_SESSION['msg']=[
                                    'attr'=>'alert-danger',
                                    'cnt'=>'update fails!'
                                ];
                                header('Location:./VehicleController.php?action=detail&id='.$data_post['vehicle_id']);
                            }
                        }
                       
                    } 
                }else{
                    include '../view/errorview/error404.php';
                }
                break;
            default:
                include '../view/userview/userlogin1.php'; 
                break;
        }
    }
}else{
    include '../view/userview/userlogin1.php'; 
}

?>