<?php
  namespace Handle;

  use Model\Vehicle;

  class VehicleValidate {
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
              $this->adderror($item, "{$item} is not required");
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
                case 'unique':
                  $result=Vehicle::checkexists($value, $rulevalue);
                  if($result){
                     $this->adderror($item, "{$item} has been exists");
                  }
                  break;
                case 'unique_except':
                  $result=Vehicle::except_exists($value, $rulevalue, $source['id']);
                  if($result){
                    $this->adderror($item," this {$item} has been exists");
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