<?php
require_once '../model/Sim.php';
require_once '../model/Vehicle.php';
use Model\Sim;
use Model\Vehicle;
$Simobject     = new Sim();
$Vehicleobject = new Vehicle();

if (count($_GET)) {
    $data_get = $_GET;
    switch ($data_get['action']) {
        case 'index':
            $vehiclelist = Vehicle::getAll();
            $clientlist  = Sim::getAll();
            include '../view/clientview/indexclient.php';
            exit();
            break;
        default:
            # code...
            break;
    }
} else if (count($_POST)) {
    $data_post = $_POST;
    switch ($data_post['action']) {
        case 'store':
            $user   = User::find($data_post['id']);
            $result = $userobject->update($data_post);
            break;
        case 'register':
            $result = $userobject->insert($data_post);
            break;
        case 'login':
            $user = User::checklogin($data_post);
            break;
        default:
            # code...
            break;
    }
}
?>