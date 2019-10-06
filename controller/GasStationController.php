<?php
session_start();

require_once 'remotecontroller/ThongKeController.php';

use RemoteController\ThongKeController;

$thongkecontrollerobject= new ThongKeController();
if (count($_GET)) {
    $data_get = $_GET;
    switch ($data_get['action']) {
        case 'index':
            $statisticlist=$thongkecontrollerobject->getAll();
            include '../view/gasstationview/history.php';
            break;
        default:
            # code...
            break;
    }
} else if (count($_POST)) {
    $data_post = $_POST;
    switch ($data_post['action']) {
        case 'store':
            
            break;
        default:
            # code...
            break;
    }
}
?>