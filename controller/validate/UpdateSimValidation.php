<?php
    namespace Validate;
    require_once 'SimValidate.php';

    use Handle\SimValidate;

    Class UpdateSimValidation{
        public function updatesimrequest($source){
        	$validate=[
        		'phone_number'=>array(
                    'require'=>true,
                    'unique_except'=>'phone_number'
                ),
                'network_operator'=>array(
                    'require' =>true,
                 ),
                'code'=>array(
                    'require'=>true,
                    'length'=>3,
                    'unique_except'=>'code'
                ),
                'vehicle_id'=>array(
                    'require' =>true
                )
        	];
        	$simvalidate= new SimValidate;
        	$simvalidation=$simvalidate->check($source, $validate);
        	return $response = array(
        		'pass' => $simvalidate->pass(),
        		'error'=>$simvalidate->errors()
        	 );

        } 
    }
    
?>