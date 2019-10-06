<?php
    namespace Validate;
    require_once 'VehicleUser.php';

    use Handle\VehicleUserValidate;

    Class UpdateVehicleUserValidation{
        public function updatevehicleuserrequest($source){
        	$validate=[
        		'vehicle_id'=>array(
                    'require'=>true,
                    'numeric'=>true
                ),
                'User_id'=>array(
                    'require' =>true,
                    'numeric'=>true
                )
        	];
        	$vehicleuservalidate= new VehicleUserValidate;
        	$vehicleuservalidate->check($source, $validate);
        	return $response = array(
        		'pass' => $vehicleuservalidate->pass(),
        		'error'=>$vehicleuservalidate->errors()
        	 );

        } 
    }
    
?>