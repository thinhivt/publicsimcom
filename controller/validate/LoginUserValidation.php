<?php
    namespace Validate;
    require_once 'UserValidate.php';

    use Handle\UserValidate;

    Class LoginUserValidation{
        public function loginuserrequest($source){
        	$validate=[
        		'email'=>array(
        			'require'=>true,
                    'exists'=>'email'
        		),

        		'password'=>array(
        			'require'=>true,
                    'correct'=>'email'
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