<?php
session_start();
require_once '../model/Vehicle.php';
require_once '../model/VehicleUser.php';
require_once '../model/User.php';
require_once '../model/Statistic.php';
require_once '../model/UserProfile.php';

require_once 'validate/CreateUserValidation.php';
require_once 'validate/UpdateUserValidation.php';
require_once 'validate/LoginUserValidation.php';
require_once 'validate/CreateVehicleUserValidation.php';
require_once 'remotecontroller/UserController.php';
require_once 'remotecontroller/ThongKeController.php';

use RemoteController\UserController;
use RemoteController\ThongKeController;

use Model\UserProfile;
use Model\User;
use Model\Vehicle;
use Model\VehicleUser;
use Model\Statistic;

use Validate\UpdateUserValidation;
use Validate\CreateUserValidation;
use Validate\LoginUserValidation;
use Validate\CreateVehicleUserValidation;

$Statistic            = new Statistic();
$userobject           = new User();
$userprofileobject    = new UserProfile();
$vehicleuserobject    = new VehicleUser();
$usercontrollerobject = new UserController();
$ThongkeControllerobject= new ThongKeController();
//get handle
if (count($_GET)) {
    $data_get = $_GET;
    if(!empty($_SESSION['author'])){
       switch ($data_get['action']) {
            case 'index':
                if($_SESSION['author']->role>=2){
                    $userlist=User::getuser($_SESSION['author']->role);
                    include '../view/userview/indexuser.php'; 
                }else{
                    include '../view/errorview/error404.php'; 
                }
                break;
            case 'info':
                if ($_SESSION['author']->role >= 3) {
                    $user        = User::find($data_get['id']);
                    $userprofile = UserProfile::find($data_get['id']);
                    include '../view/userview/detailuser.php';
                } else {
                   include '../view/errorview/error404.php'; 
                }
                break;
            case 'setup':
                // var_dump($data_get['id']);
                // die();
                if ($_SESSION['author']->role >= 2) {
                    $vehiclelist        = array();
                    $user               = User::find($data_get['id']);
                    $userprofile        = UserProfile::find($data_get['id']);
                    $vehicles           = Vehicle::getAll();
                    $workingvehiclelist = VehicleUser::getoperating();
                    foreach ($vehicles as $vehicle) {
                        $check = true;
                        foreach ($workingvehiclelist as $workingvehicle) {
                            if ($vehicle->id == $workingvehicle->vehicle_id) {
                                $check = false;
                            }
                        }
                        if ($check == true) {
                            $vehiclelist[] = $vehicle;
                        }
                    }
                    include '../view/userview/vehicleuser.php';
                } else {
                    include '../view/errorview/error404.php'; 
                }
                break;
            case 'delete':
                if ($_SESSION['author']->role >= 3) {
                    $user = User::find($data_get['id']);
                    $userprofileobject->softdelete($user);
                    $userobject->softdelete($user);
                    header('Location:./UserController.php?action=index');
                } else {
                    include '../view/errorview/error404.php'; 
                }
                break;
            case 'edit':
                if ($_SESSION['author']->role >= 3) {
                    $user        = User::find($data_get['id']);
                    $userprofile = UserProfile::find($data_get['id']);
                    include '../view/userview/updateuser.php';
                } else {
                    include '../view/errorview/error404.php'; 
                }
                break;
            case 'register':
                if ($_SESSION['author']->role >= 3) {
                    include '../view/userview/registeruser.php';
                }
                break;
            case 'logout':
                session_destroy();
                include '../index.php';
                break;
            default:
                include '../view/userview/userlogin1.php';
                break;
        } 
    }
    else{
        include '../view/userview/userlogin1.php';
    }
}
//post handle
else if (count($_POST)) {
    $data_post = $_POST;
    if (isset($_FILES['avatar']['name'])) {
        $data_post['avatar'] = $_FILES['avatar']['name'];
    }
    switch ($data_post['action']) {
        case 'update':
            if(!empty($_SESSION['author'])){
               if ($_SESSION['author']->role >= 3) {
                    $validation           = new UpdateUserValidation();
                    $response             = $validation->updateuserrequest($data_post);
                    $_SESSION['response'] = $response;
                    if (!$response['pass']) {
                        header('Location:./UserController.php?action=edit&id=' . $data_post['id']);
                    } else {
                            $user = User::find($data_post['id']);
                            if ($user->id == $data_post['id']) {
                                $result = $userobject->update($data_post);
                                if ($result) {
                                    
                                    if (($_FILES['avatar']['error'] == 0)) {
                                        
                                        $names    = $_FILES['avatar']['name'];
                                        $names    = explode('.', $names);
                                        $lastname = $names[count($names) - 1];
                                        $newname  = time() . '.' . $lastname;
                                        $tmp_name = $_FILES['avatar']['tmp_name'];
                                        $path     = '../public/assets/images/avatars/' . $newname;
                                        $result   = move_uploaded_file($tmp_name, $path);
                                        if ($result) {
                                            
                                            $userprofile = UserProfile::find($user->id);
                                            $avatar      = $userprofile->avatar;
                                            $avatar      = substr($avatar, 3);
                                            if (file_exists($avatar)) {
                                                
                                                unlink($avatar);
                                                
                                            }
                                            $data_post['avatar'] = '..' . '/' . $path;
                                            $result              = $userprofileobject->update($data_post, $user->id);
                                            if ($result) {
                                                
                                                $data_post['user_id']=$user->id;
                                                $remoteresult=$usercontrollerobject->update($data_post);
                                                if($remoteresult!=true){
                                                    $_SESSION['msg']=[
                                                        'attr'=>'alert-danger',
                                                        'cnt'=>'create remote user is not successful!'
                                                    ];
                                                }
                                                
                                            }
                                        }
                                        
                                    } else {
                                        $userprofile         = UserProfile::find($user->id);
                                        $data_post['avatar'] = $userprofile->avatar;
                                        $result              = $userprofileobject->update($data_post, $user->id);
                                        if ($result) {
                                            $data_post['user_id']=$user->id;
                                            $remoteresult=$usercontrollerobject->update($data_post);
                                            if($remoteresult!=true){
                                                $_SESSION['msg']=[
                                                    'attr'=>'alert-danger',
                                                    'cnt'=>'create remote user is not successful!'
                                                ];
                                            }
                                        }
                                    }
                                }
                            }
                        header('Location:./UserController.php?action=edit&id=' . $data_post['id']);
                    }
                }else{
                    include '../view/errorview/error404.php';
                } 
            }else{
                include '../view/userview/userlogin1.php';
            }
            break;
        case 'create':
            if(!empty($_SESSION['author'])){
                if ($_SESSION['author']->role >= 3) {
                    $validation = new CreateUserValidation();
                    $response   = $validation->createuserrequest($data_post);
                    if (!$response['pass']) {
                        include '../view/userview/registeruser.php';
                    } else {
                        $result = $userobject->insert($data_post);
                        if ($result) {
                            if (isset($_FILES)) {
                                $names    = $_FILES['avatar']['name'];
                                $names    = explode('.', $names);
                                $lastname = $names[count($names) - 1];
                                $newname  = time() . '.' . $lastname;
                                $tmp_name = $_FILES['avatar']['tmp_name'];
                                $path     = '../public/assets/images/avatars/' . $newname;
                                $result   = move_uploaded_file($tmp_name, $path);
                                if ($result) {
                                    $data_post['avatar'] = '..' . '/' . $path;
                                    $user_id             = User::maxid()->max;
                                    $result              = $userprofileobject->insert($data_post, $user_id);
                                    if($result){
                                       $data_post['user_id']=$user_id;
                                       $remoteresult=$usercontrollerobject->insert($data_post);
                                       if($remoteresult!=true){
                                          $_SESSION['msg']=[
                                            'attr'=>'alert-danger',
                                            'cnt'=>'create remote user is not successful!'
                                          ];
                                        }
                                    }
                                }
                            }
                        } else {
                            include '../view/errorview/error404.php';
                        }
                        header('Location:./UserController.php?action=index');
                    }
                } else {
                    include '../view/errorview/error404.php';
                }
            }else{
                include '../view/userview/userlogin1.php';
            }
            break;
        case 'login':
            $validation = new LoginUserValidation();
            $response   = $validation->loginuserrequest($data_post);
            if (!$response['pass']) {
                $_SESSION['response'] = $response;
                header('Location:../index.php');
            } else {
                $profile            = User::getauthor($data_post['email']);
                $_SESSION['author'] = $profile;
                header('Location:./DashboardController.php?action=index');
            }
            break;
        case 'setup':
            if(!empty($_SESSION['author'])){
                if ($_SESSION['author']->role >= 2) {
                    $validation = new CreateVehicleUserValidation();
                    $response   = $validation->createvehicleuserrequest($data_post);
                    if (!$response['pass']) {
                        $_SESSION['response'] = $response;
                        header('Location:./UserController.php?action=setup&id=' . $data_post['user_id']);
                    } else {
                        //
                        $sensorpara = $Statistic->getStatus($data_post['vehicle_id']);
                        $created_at = strtotime($sensorpara->created_at);
                        $now        = strtotime(date('Y/m/d H:i:s'));
                        if (time() - $created_at <= 80) {
                            $data_post['fuel_start'] = $sensorpara->volume;
                            $data_post['started_at'] = date('Y/m/d H:i:s');
                            $result                  = $vehicleuserobject->insert($data_post);
                            if ($result) {
                                header('Location:./UserController.php?action=index');
                            } else {
                                $_SESSION['response']['error']['msg'] = 'Disconnection or sensor has been failed';
                                header('Location:./UserController.php?action=setup&id=' . $data_post['user_id']);
                            }
                            
                        } else {
                            $_SESSION['response']['error']['msg'] = 'Disconnection or sensor has been failed';
                            header('Location:./UserController.php?action=setup&id=' . $data_post['user_id']);
                        }
                    }
                } else {
                    include '../view/errorview/error404.php';
                }
            }else{
                include '../view/userview/userlogin1.php'; 
            }
            break;
        case 'workshift':
            if(!empty($_SESSION['author'])){
                $vehicleuser            = VehicleUser::find($data_post['id']);
                $vehiclestatus          = $Statistic->getStatus($vehicleuser->vehicle_id);
                $vehiclepours=$ThongkeControllerobject->getlinkremote($vehiclestatus->name);
                $data_post['fuel_add']=0;
                foreach ($vehiclepours as $pourtime) {
                    if(strtotime($pourtime->time)>strtotime($vehicleuser->created_at)){
                    $data_post['fuel_add']+=$pourtime->solit;
                    }
                }
                // 
                $data_post['fuel_add']=round($data_post['fuel_add']);
                $data_post['fuel_stop'] = $vehiclestatus->volume;
                $result                 = $vehicleuserobject->update($data_post);
                if (!$result) {
                    $_SESSION['msg'] = array(
                        'attr' => 'alert-danger',
                        'cnt' => 'Update is failure'
                    );
                    header('Location:./DashboardController.php?action=index');
                } else {
                    $_SESSION['msg'] = array(
                        'attr' => 'alert-success',
                        'cnt' => 'Update is successful'
                    );
                    header('Location:./DashboardController.php?action=index');
                }
            }else{
                include '../view/userview/userlogin1.php'; 
            }
            break;
        default:
            include '../view/userview/userlogin1.php'; 
            break;
    }
}else {
    include '../view/userview/userlogin1.php'; 
}
?>