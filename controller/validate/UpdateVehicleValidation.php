<?php
    namespace Validate;
    require_once 'VehicleValidate.php';

    use Handle\VehicleValidate;

    Class UpdateVehicleValidation{
        public function updatevehiclerequest($source){
        	$validate=[
        		'name'=>array(
        			'require'=>'name',
        			'min'=>3,
        			'max'=>50,
                    'unique_except'=>'name'
        		),
        		'rfid'=>array(
        			'require'=>true,
        			'min'=>6,
        			'max'=>12,
                    'unique_except'=>'rfid'
        		)
        	];
        	$vehiclevalidate= new VehicleValidate;
        	$vehiclevalidation=$vehiclevalidate->check($source, $validate);
        	return $response = array(
        		'pass' => $vehiclevalidate->pass(),
        		'error'=>$vehiclevalidate->errors()
        	 );

        } 
    }
    
?>