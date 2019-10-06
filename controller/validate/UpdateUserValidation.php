<?php
    namespace Validate;
    require_once 'UserValidate.php';

    use Handle\UserValidate;

    Class UpdateUserValidation{
        public function updateuserrequest($source){
        	$validate=[
        		'name'=>array(
        			'require'=>true,
        			'min'=>3,
        			'max'=>50
        		),
        		'email'=>array(
        			'require'=>true,
                    'unique_except'=>'email'
        		),
        		'phone'=> array(
        			'require'=>true,
                    'unique_except2'=>'phone'
        		),

        		'gender'=>array(
        			'require'=>true
        		),

        		'address'=>array(
        			'require' => true
        		),
        		'role'=>array(
        			'require'=>true
        		),
                'user_code'=>array(
                    'require'=>true,
                    'unique_except2'=>'user_code'
                ),
                'position'=>array(
                    'require'=>true,
                    'min'=>4,
                    'max'=>30
                )
        	];
        	$uservalidate= new UserValidate;
        	$uservalidation=$uservalidate->check($source, $validate);
        	return $response = array(
        		'pass' => $uservalidate->pass(),
        		'error'=>$uservalidate->errors()
        	 );

        } 
    }
    
?>