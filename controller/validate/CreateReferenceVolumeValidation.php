<?php
    namespace Validate;
    require_once 'ReferenceVolumeValidate.php';

    use Handle\ReferenceVolumeValidate;

    Class CreateReferenceVolumeValidation{
        public function createreferencevolumerequest($source, $file){
        	$validate=[
        		'vehicle_id'=>array(
        			'require'=>true,
        			'numeric'=>true
        		),
        		'csv'=>array(
        			'require'=>true,
        			'type'=>'csv',
        		)
        	];
            $raw=[
                'height'=>array(
                    'require'=>true,
                    'numeric'=>true
                ),
                'volume'=>array(
                    'require'=>true,
                    'numeric'=>true
                )
            ];
            $source['csv']=$file['csv']['name'];
        	$referencevolumevalidate= new ReferenceVolumeValidate;
        	$referencevolumevalidate->check($source, $validate);
            if($referencevolumevalidate->pass()){
               $referencevolumevalidate->handlecsvfile(array('value'=>$source['vehicle_id'],'key'=>'vehicle_id'), $file, $raw);
            }
        	return $response = array(
        		'pass' => $referencevolumevalidate->pass(),
        		'error'=> $referencevolumevalidate->errors(),
                'data'=>$referencevolumevalidate->datahandle()
        	);

        } 

    }
    
?>