<?php
    namespace Validate;
    require_once 'UserValidate.php';

    use Handle\UserValidate;

    Class CreateUserValidation{
        public function createuserrequest($source){
        	$validate=[
        		'name'=>array(
        			'require'=>true,
        			'min'=>3,
        			'max'=>50
        		),

        		'email'=>array(
        			'require'=>true,
        			'unique'=>'email'
        		),

        		'password'=>array(
        			'require'=>true,
        			'length'=>4
        		),

        		'confirmpassword'=>array(
        			'require'=>true,
        			'matches'=>'password'
        		),

        		'phone'=> array(
        			'require'=>true,
                    'unique_profile'=>'phone'
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
        		'avatar'=> array(
        			'require' => true,
        			'mimes'=>true
        		),
                'user_code'=>array(
                    'require'=>true,
                    'length'=>3,
                    'unique_profile'=>'user_code'
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