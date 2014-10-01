<?php
include_once 'MyXMLController.php';

class Hyperlink{
	
    public $xmlcontroller;
    
    function __construct()
        {
                $this->xmlcontroller = new MyXMLController();
        }

        
    function getBeginUniqueStr($path, $filename, $uniquestr,$hlink){
        $this->xmlcontroller->appendToXMLFile($path, $filename,'unistr', $uniquestr, $hlink);
        return $uniquestr;
    }    
    

	function getUniqueStr($path, $filename, $hlink){
		$uniqueStr = uniqid('hlink_');
		$flag = $this->xmlcontroller->appendToXMLFile($path, $filename,'unistr', $uniqueStr, $hlink);
        if($flag){
            return $uniqueStr;
        }else{
            $result = $this->xmlcontroller->searchKeyByValue($path, $filename, $hlink);
            if(empty($result)){
            die("empty key");
            }
            return $result;
        }
		
		
	}

	function getHlink($path, $filename, $uniStr){
        
		$result = $this->xmlcontroller->searchOriginByKey($path, $filename, $uniStr);	
        if(empty($result)){
            die("empty unistr");
        }
        return $result;
	}

}




?>
