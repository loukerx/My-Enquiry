<?php

class MyXMLController{
	protected $xml_head = '<?xml version="1.0" encoding="UTF-8"?>';
	protected $links_node_b = '<hyperlinks>';
	protected $links_node_e = '</hyperlinks>';
	protected $unistr_node_b = '<unistr>';
	protected $unistr_node_e = '</unistr>';
	protected $origin_node_b = '<origin>';
	protected $origin_node_e = '</origin>';

	// Create folder and XML File if not exist
	function createXMLFile($path, $filename){
		if(!empty($path) && !empty($filename)){
			$abs_path = './companysites/'.$path.'/'.$filename;		

			if(!file_exists('./companysites/'.$path)){
				if(!mkdir('./companysites/'.$path, 0777, true)){
					die('Failed to create folder!');
				}
			}
			
			if(!file_exists($abs_path)){
				$handle = fopen($abs_path, 'w') or die('Cannot open file: '.$abs_path);
				fwrite($handle, $this->xml_head. PHP_EOL);
                fwrite($handle, $this->links_node_b. PHP_EOL);
                fwrite($handle, $this->links_node_e. PHP_EOL);
				fclose($handle);	
			}

			return true;	
		}
	}

	function appendToXMLFile($path, $filename, $node1, $unistrvalue, $originvalue){
		if(!empty($path) && !empty($filename) && !empty($node1) && !empty($unistrvalue) && !empty($originvalue)){
			$abs_path = './companysites/'.$path.'/'.$filename;
			if(!file_exists($abs_path)){$this->createXMLFile($path, $filename);}
			$xml = simplexml_load_file($abs_path);  
            
            foreach($xml->link as $link){
                $value = $link->value;
                if("$value" == "$originvalue"){
                    return false;
                }
            }
            
            $link = $xml->addChild("link");
			$link->addChild($node1, $unistrvalue);
		//	$ori = $link->addChild($node2);
            $link->value = $originvalue;
			$xml->asXML($abs_path);   
            return true;
		}else{
            return false;
        }
	} 

	// Only read file
	function readXMLFile($path, $filename){
		if(!empty($path) && !empty($filename)){
			$abs_path = './companysites/'.$path.'/'.$filename;		
			
			$handle = fopen($abs_path, 'r') or die('Cannot open file :'.$abs_path);
			$data = fread($handle, 4096);
			fclose($handle);
			return $data;
		}else{
			return false;
		}
	}

	// Delete a XML file
	function deleteXMLFile($path, $filename){
		$abs_path = './companysites/'.$path.'/'.$filename;
		unlink($abs_path);
	}

	// Search values  by key
	function searchOriginByKey($path, $filename, $key){
		if(!empty($path) && !empty($filename) &&!empty($key)){
                        $abs_path = './companysites/'.$path.'/'.$filename;
                        if(!file_exists($abs_path)){return "";}
			
			$xml = simplexml_load_file($abs_path);
			foreach($xml->link as $link){ 
                $unistr = $link->unistr;
                
                if("$unistr" == "$key"){
                    
                    $result = $link->value;
                    return $result;
                }
            }
            
		}else{
			return "";
		}	
	
	}
    
    // Search key by values
    function searchKeyByValue($path, $filename, $ovalue){
        if(!empty($path) && !empty($filename) && !empty($ovalue)){
                        $abs_path = './companysites/'.$path.'/'.$filename;
                        if(!file_exists($abs_path)){return "";}
            
            $xml = simplexml_load_file($abs_path);
            foreach($xml->link as $link){
                $value = $link->value;
                if("$value" == "$ovalue"){
                    $result = $link->unistr;
                    return $result;
                }
            }
            
        }else{
            return "";
        }    
    
    }


    
}

?>
