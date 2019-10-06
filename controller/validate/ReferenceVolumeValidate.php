<?php
namespace Handle;

// use Model\ReferenceVolume;

class ReferenceVolumeValidate
{
    private $pass = false, $error = array(), $data;
    public function __construct()
    {
        #code;
    }
    public function check($source, $validate = array())
    {
        foreach ($validate as $item => $rules) {
            foreach ($rules as $rule => $rulevalue) {
                $value = trim($source[$item]);
                if ($rule === 'require' && empty($value)) {
                    $this->adderror($item, "{$item} is not required");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'numeric':
                            if (!is_numeric($value)) {
                                $this->adderror($item, "Vehicle is not valid");
                            }
                            break;
                        case 'type':
                            $value = explode(".", $value);
                            if (count($value) >= 2) {
                                $type = $value[count($value) - 1];
                                if (strcmp("csv", $type) != 0) {
                                    $this->adderror($item, "{$item} must be CSV file");
                                }
                                
                            } else {
                                $this->adderror($item, "File upload is not valid");
                            }
                            break;
                    }
                }
            }
        }
        if (empty($this->error)) {
            $this->pass = true;
        }
        return $this;
    }

    public function handlecsvfile($source, $file, $raw)
    {
        
        $csv = file($file["csv"]['tmp_name']);
        for ($i = 0; $i < count($csv); $i++) {
            $data[] = explode(",", $csv[$i]);
        }
        foreach ($raw as $item=>$rules) {

          for ($j = 0; $j < count($data[0]); $j++) {
             if(strcmp(trim($data[0][$j]), trim($item))==0){
              $fields[]=trim($data[0][$j]);
              $sequence[]=$j;
             }
            }
        }
        $fields[]=$source['key'];
        if(empty($sequence)){
          $this->data=false;
        }
        else{
          for ($i=1; $i <count($data) ; $i++) { 
            for ($j=0; $j <count($sequence) ; $j++) { 
              $datahandle[$i][$j]=$data[$i][$sequence[$j]];
            }
            $datahandle[$i][]= $source['value'];
            $this->data=array(
              'fields'=>$fields,
              'datahandle'=>$datahandle
            );
          }
        }
    }

    public function datahandle(){
      return $this->data;
    }

    private function adderror($item, $error)
    {
        $this->error[$item] = $error;
    }

    public function pass()
    {
        return $this->pass;
    }

    public function errors()
    {
        return $this->error;
    }
}
?>