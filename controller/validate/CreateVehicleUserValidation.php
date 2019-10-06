<?php
    namespace Validate;
    require_once 'VehicleUserValidate.php';

    use Handle\VehicleUserValidate;

    Class CreateVehicleUserValidation{
        public function createvehicleuserrequest($source){
        	$validate=[
        		'vehicle_id'=>array(
                    'require'=>true,
                    'unique_except'=>'phone_number'
                ),
                'user_id'=>array(
                    'require' =>true
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