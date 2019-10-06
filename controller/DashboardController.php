<?php
session_start();

require_once '../model/Vehicle.php';
require_once '../model/Statistic.php';
require_once '../model/Sim.php';
require_once '../model/Reference_Volume.php';
require_once '../model/VehicleUser.php';

require_once 'validate/CreateVehicleValidation.php';
require_once 'validate/UpdateVehicleValidation.php';
require_once 'validate/CreateReferenceVolumeValidation.php';
require_once 'remotecontroller/ThongKeController.php';

use RemoteController\ThongKeController;

use Model\Vehicle;
use Model\Statistic;
use Model\Sim;
use Model\Reference_Volume;
use Model\VehicleUser;

use Validate\CreateVehicleValidation;
use Validate\UpdateVehicleValidation;
use Validate\CreateReferenceVolumeValidation;

$Statistic = new Statistic();
$Vehicleobject = new Vehicle();
$Simobject=new Sim();
$Reference_Volumesobject= new Reference_Volume();
$VehicleUserobject= new VehicleUser();
$ThongkeControllerobject= new ThongKeController();

if (count($_GET)) {
    $data_get = $_GET;
    if(!empty($_SESSION['author'])){
        switch ($data_get['action']) {
            case 'index':
                if($_SESSION['author']->role>=2){
                    $vehiclelist=Vehicle::gethave();
                    $combinestatus=array();
                    foreach ($vehiclelist as $vehicle) {
                        if($Statistic->getStatus($vehicle->id)!=false) {
                            $vehiclestatus= $Statistic->getStatus($vehicle->id);
                        }
                        else{
                            $vehiclestatus=null;
                        }
                        if($Reference_Volumesobject->getMax($vehicle->id)!=false) {
                            $vehiclemax=$Reference_Volumesobject->getMax($vehicle->id);
                        }
                        else{
                            $vehiclemax=null;
                        }
                        $temp=[
                            'id'=>$vehicle->id,
                            'name'=>$vehicle->name,
                            'volume'=>isset($vehiclestatus->volume)? $vehiclestatus->volume: 'Unknown',
                            'height'=>isset($vehiclestatus->height)? $vehiclestatus->height: 'Unknown',
                            'created_at'=>isset($vehiclestatus->created_at)? $vehiclestatus->created_at: 'Unknown',
                            'pecentage'=>(isset($vehiclemax->volume)&& isset($vehiclestatus->volume))? round(100*$vehiclestatus->volume/$vehiclemax->volume):'0'
                        ];
                        switch ($temp['pecentage']) {
                            case ($temp['pecentage']>=70):
                               $temp['color']='#4eb94f';
                                break;
                            case ($temp['pecentage']<70 && $temp['pecentage']>=30):
                               $temp['color']='#edb505';
                                break;
                            case ($temp['pecentage']<30 && $temp['pecentage']):
                               $temp['color']='#d04f4f';
                                break;
                        }
                        $combinestatus[]=(object)$temp;
                    }
                    $vehicleuserlist= $VehicleUserobject->specialget();
                    foreach ($vehicleuserlist as $vehicleuser) {
                        if($Statistic->getStatus($vehicleuser->vehicle_id)!=false) {
                            $vehiclestatus= $Statistic->getStatus($vehicleuser->vehicle_id);
                            $temp1=[
                                'id'=>$vehicleuser->id,
                                'vehicle_name'=>$vehicleuser->vehicle_name,
                                'driver'=>$vehicleuser->user_name
                            ];
                            if(time()-strtotime($vehiclestatus->created_at)<=80){
                                $hour_tmp=round((time()-strtotime($vehicleuser->created_at))/3600);
                                $minute_tmp=round(((time()-strtotime($vehicleuser->created_at))%3600)/60);
                                $temp1['duration'] =($minute_tmp<10)? $hour_tmp.'giờ'.'0'.$minute_tmp.'phút': $hour_tmp.'giờ'.$minute_tmp.'phút';
                                $temp1['fuel']=$vehicleuser->fuel_start-$vehiclestatus->volume;
                            }
                            else{
                                $temp1['duration']='Lỗi thiết bị';
                                $temp1['fuel']='Lỗi thiết bị';
                            }
                        }
                        $parameterlist[]=(object)$temp1;
                    }
                    if(empty($parameterlist)){
                        $parameterlist=array();
                    }
                    include '../view/dashboard/dashboard.php';
                }else{
                    include '../view/clientview/indexclient.php';  
                }
                break;
                case 'interrupt':
                    if($_SESSION['author']->role>=2){
                        $vehiclelist=Vehicle::getAll();
                        $combinestatus=array();
                        foreach ($vehiclelist as $vehicle) {
                            if($Statistic->getStatus($vehicle->id)!=false) {
                                $vehiclestatus= $Statistic->getStatus($vehicle->id);
                            }
                            else{
                                $vehiclestatus=null;
                            }
                            if($Reference_Volumesobject->getMax($vehicle->id)!=false) {
                                $vehiclemax=$Reference_Volumesobject->getMax($vehicle->id);
                            }
                            else{
                                $vehiclemax=null;
                            }
                            $temp=[
                                'id'=>$vehicle->id,
                                'name'=>$vehicle->name,
                                'volume'=>isset($vehiclestatus->volume)? $vehiclestatus->volume: 'Unknown',
                                'height'=>isset($vehiclestatus->height)? $vehiclestatus->height: 'Unknown',
                                'created_at'=>isset($vehiclestatus->created_at)? $vehiclestatus->created_at: 'Unknown',
                                'pecentage'=>(isset($vehiclemax->volume)&& isset($vehiclestatus->volume))? round(100*$vehiclestatus->volume/$vehiclemax->volume):'0'
                            ];
                            switch ($temp['pecentage']) {
                                case ($temp['pecentage']>=70):
                                   $temp['color']='#4eb94f';
                                    break;
                                case ($temp['pecentage']<70 && $temp['pecentage']>=30):
                                   $temp['color']='#edb505';
                                    break;
                                case ($temp['pecentage']<30 && $temp['pecentage']):
                                   $temp['color']='#d04f4f';
                                    break;
                            }
                            $combinestatus[]=(object)$temp;
                        }
                        $combinestatus=json_encode($combinestatus);
                        echo $combinestatus;
                    }
                    break;
                case 'workshift':
                    if($_SESSION['author']->role>=2){
                        $vehicleuserlist= $VehicleUserobject->specialget();
                        foreach ($vehicleuserlist as $vehicleuser) {
                            if($Statistic->getStatus($vehicleuser->vehicle_id)!=false) {
                                $vehiclestatus= $Statistic->getStatus($vehicleuser->vehicle_id);
                                $temp1=[
                                    'vehicle_name'=>$vehicleuser->vehicle_name,
                                    'driver'=>$vehicleuser->user_name
                                ];
                                // 
                                 $vehiclepours=$ThongkeControllerobject->getlinkremote($vehicleuser->vehicle_name);
                                $temp1['fuel_add']=0;
                                foreach ($vehiclepours as $pourtime) {
                                    if(strtotime($pourtime->time)>strtotime($vehicleuser->created_at)){
                                        $temp1['fuel_add']+=$pourtime->solit;
                                    }
                                }
                                $temp1['fuel_add']=round($temp1['fuel_add']);
                                // 
                                if(time()-strtotime($vehiclestatus->created_at)<=80){
                                    $hour_tmp=round((time()-strtotime($vehicleuser->created_at))/3600);
                                    $minute_tmp=round(((time()-strtotime($vehicleuser->created_at))%3600)/60);
                                    $temp1['duration'] =($minute_tmp<10)? $hour_tmp.'giờ'.'0'.$minute_tmp.'phút': $hour_tmp.'giờ'.$minute_tmp.'phút';
                                    $temp1['fuel']=$vehicleuser->fuel_start-$vehiclestatus->volume+$temp1['fuel_add'];

                                }
                                else{
                                    $temp1['duration']='Lỗi thiết bị';
                                    $temp1['fuel']='Lỗi thiết bị';
                                }
                                
                            }
                            $parameterlist[]=(object)$temp1;
                        }
                        if(empty($parameterlist)){
                            $parameterlist=array();
                        }
                        echo json_encode($parameterlist);
                    }
                    break;
            default:
                include '../view/userview/userlogin1.php';
                break;
        }
    }else{
        include '../view/userview/userlogin1.php';  
    }
} 
else if(count($_POST)) {
    $data_post = $_POST;
    switch ($data_post['action']) {
        case 'test':
            # code...
            break;

        default:
            # code...
            break;
    }
}
?>