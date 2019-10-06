<?php
    namespace Validate;
    require_once 'VehicleValidate.php';

    use Handle\VehicleValidate;

    Class CreateVehicleValidation{
        public function createvehiclerequest($source){
        	$validate=[
        		'name'=>array(
        			'require'=>'name',
        			'min'=>3,
        			'max'=>50,
        			'unique'=>'name'
        		),
        		'rfid'=>array(
        			'require'=>true,
        			'min'=>6,
        			'max'=>12,
        			'unique'=>'rfid'
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