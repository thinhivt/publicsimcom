<?php
  namespace Handle;

  use Model\VehicleUser;

  class VehicleUserValidate {
    private $pass=false,
            $error=array();
    public function __construct(){
        #code;
    }
    public function check($source, $validate=array()){
       foreach ($validate as $item => $rules) {
         foreach ($rules as $rule => $rulevalue) {
            $value=trim($source[$item]);
            if($rule==='require'&& empty($value)){
              $this->adderror($item, "This data is not required");
            }
            else if(!empty($value)){
              switch ($rule) {
                case 'min':
                  if(strlen($value)<$rulevalue){
                    $this->adderror($item,"{$item} must be a minimum of {$rulevalue} character.");
                  }
                  break;
                case 'max':
                  if(strlen($value)>$rulevalue){
                    $this->adderror($item,"{$item} must be a maximum of {$rulevalue} character.");
                  }
                  break;
                case 'length':
                  if(strlen($value)!=$rulevalue){
                    $this->adderror($item,"{$item} must have {$rulevalue} characters");
                  }
                  break;
                case 'numeric':
                  if(!is_numeric($value)){
                    $this->adderror($item,"This data is not valid");
                  }
                  break;
              }
            }
         }
       }
        if(empty($this->error)){
            $this->pass=true;
        }
        return $this;
    }
    private function adderror($item,$error){
        $this->error[$item]=$error;
    }
    public function pass(){
        return $this->pass;
    }
    public function errors(){
        return $this->error;
    }
  }
?>