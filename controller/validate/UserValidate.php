<?php
  namespace Handle;

  // require_once '../../model/User.php';

  use Model\User;
  use Model\UserProfile;

  class UserValidate {
    private $pass=false,
            $error=array();
            // $olddata=array();
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
                case 'matches':
                  if(strcmp($value, $source[$rulevalue])!=0){
                      $this->adderror($item,"{$rulevalue} must matches {$item}");
                  }
                  break;
                case 'length':
                  if(strlen($value)!=$rulevalue){
                    $this->adderror($item,"{$item} must have {$rulevalue} characters");
                }
                case 'unique':
                  $result=User::checkexists($value, $rulevalue);
                  if($result){
                     $this->adderror($item, "{$item} has been exists");
                  }
                  break;
                case 'mimes':
                  if(!stripos($value, 'jpg')&&!stripos($value, 'jpeg')&&!stripos($value, 'png')&&!stripos($value,'gif')){
                     $this->adderror($item,"{$item} must be png, gif, jpg type");
                  }
                  break;
                case 'exists':
                  $result=User::checkexists($value, $rulevalue);
                  if(!$result){
                    $this->adderror($item,"{$item} is not exists");
                  }
                  break;
                case 'correct':
                 $result=User::checkexists($source[$rulevalue], $rulevalue);
                  if($result){
                      if(strcmp($result->password, $value)!=0){
                         $this->adderror($item,"{$item} is not correct");
                      }
                  }
                  break;
                case 'unique_except':
                  $result=User::except_exists($value, $rulevalue, $source['id']);
                  if($result){
                    $this->adderror($item," This {$item} has been exists");
                  }
                  break;
                case 'unique_except2':
                  $result=UserProfile::except_exists($value, $rulevalue, $source['id']);
                  if($result){
                    $this->adderror($item," This {$item} has been exists");
                  }
                  break;
                case 'unique_profile':
                  $result=UserProfile::checkexists($value, $rulevalue);
                  if($result){
                     $this->adderror($item, "{$item} has been exists");
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