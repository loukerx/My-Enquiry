<?php 
include_once 'MyXMLController.php';
include_once 'Hyperlink.php';

class Controller{

    private $xmlcontroller;
    private $hyperlink; 
	private $result;
	private $lastUrl;
    
    
    function __construct()
        {
                $this->xmlcontroller = new MyXMLController();
                $this->hyperlink = new Hyperlink(); 
        }
    

	function getWebpage($ori, $comurl, $get, $post){

		$path = $this->getPath($ori);	// get the path of xml file
		$filename = $this->getFileName($ori);	// get the xml which stores the original URLs and Uni strings

		$o = $this->getO($ori);	// get the original base URLs from xml file
		

        if(!empty($get)){
            $this->curl($get, null);
        }else{
            $url = $this->getURL($ori, $comurl);    // get the original URLs for requesting from original server
		    $this->curl($url, $post);
        }  
		
		$result = $this->getResult();
		// handling action when no result return from server
		if(empty($result)){
			return "Cannot reach the website!";
		}
		
		$o = $this->domainChange($o,$this->getLastUrl());  // assign the newest base URL if it is changed

		//  use file_get_contents() method if you do not have curl installed;
		//    $result = file_get_contents($url);
        
        

			// Use php dom document to edit the content of return page	
			$doc = new DOMDocument(); 
			@$doc->loadHTML($result);

			$doc = $this->correctCSS($doc, $o);
			$doc = $this->correctJS($doc, $o);
			$doc = $this->correctIMG($doc, $o);
			$doc = $this->correctIFRAME($doc, $o);
			$doc = $this->correctALINK($doc, $o, $path, $filename, $this->getRewriteBaseUrl($ori), $ori);
			$doc = $this->addJScode($doc, $this->getBaseUrl());
            $doc = $this->correctFORM($doc, $o, $path, $filename, $ori);

			// save the web page and return to browser`
			$html = $doc->saveHTML(); 
			return $html;
		
		/* These code are for storing the web page on our server and return the url for this page.
				$doc->saveHTMLFile('./companysites/'.$path.'/'.$comurl.'.html');
			
				return './companysites/'.$path.'/'.$comurl.'.html';
		*/    
	}

	function getPath($ori){
		return $ori;
	}
	
	function getFileName($ori){
		return $ori.".xml";
	}
	
	function getO($ori){
		return $this->hyperlink->getHlink($this->getPath($ori), $this->getFileName($ori), $ori);
	}
	
	function getURL($ori, $comurl){
		return $this->hyperlink->getHlink($this->getPath($ori), $this->getFileName($ori), $comurl);
	}
	
	function getBaseUrl(){
		$baseurl = "http://" . $_SERVER['HTTP_HOST']."/enquiry/";
		return $baseurl;
	}
	
	function getRewriteBaseUrl($ori){
		$rewriteBaseUrl = $this->getBaseUrl().'/content.php?o='.$ori.'&url='; 	// reform the URL
		return $rewriteBaseUrl;
	}
    
    function getActionUrl($ori, $method){
        $actionUrl = $this->getBaseUrl().'/webform.php?formMethod='.$method.'&o='.$ori.'&url=';
        return $actionUrl;
    }
	
	function setResult($result){
		$this->result = $result;
	}
	
	function getResult(){
		return $this->result;
	}
	
	function setLastUrl($lastUrl){
		$this->lastUrl = $lastUrl;
	}
	
	function getLastUrl(){
		return $this->lastUrl;
	}
	
	
	function curl($url, $post){
		//using curl is more better than file_get_contents, recommended!
		$agent= 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/532.2 (KHTML, like Gecko) ChromePlus/4.0.222.3 Chrome/4.0.222.3 Safari/532.2';
		
		$ch = curl_init();	
		curl_setopt($ch, CURLOPT_URL, $url); 	// indicate the URL
		curl_setopt($ch, CURLOPT_HEADER, 0);	
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	// for requesting HTTPS website
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);  
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent); 	// set the browser agent
        
        if(!empty($post)){
        curl_setopt($ch, CURLOPT_POST, count($post));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
		 
		$result = curl_exec($ch);
		$this->setResult($result);
		$lastUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);	// get the newest base URL from returned result
		$this->setLastUrl($lastUrl);
		curl_close($ch);
	}

	function domainChange($oridomain,$newlink){
		$parsedurl = parse_url($newlink);
		$newdomain = $parsedurl['scheme'].'://'.$parsedurl['host'].'/';
	   // if($newdomain == $oridomain){
	//        return $oridomain;
	//    }else{
	//        
		return $newdomain;
	//    }
	}

	function correctCSS($doc, $o){
		// correct the css style, make it refer to original server not ours
			foreach($doc->getElementsByTagName('link') as $link) {
			$hlink = $link->getAttribute('href');
			if(!preg_match('#^//#i', $hlink)){	// do not change the source link if it starts with "//" because it refer to original server 
				$href = preg_replace('#^/#', '', $hlink);  // remove the link 
				$href = preg_match('#^http#i', $href) ? $href : $o.$href;	// if the link starts with "http", then no changes will be performed. If not, then join the base URL to the link. 
				$link->setAttribute('href', $href);	// put the link back
				}
			}
			
			return $doc;
	}
	
	function correctJS($doc, $o){
		// correct the javascript, make it refer to original server not ours
			foreach($doc->getElementsByTagName('script') as $link) {
				$src = $link->getAttribute('src');
				if(!empty($src) && !preg_match('#^//#i', $src)){	// no action will be performed if the src link is empty or starts with "//"
					$href = preg_replace('#^/#', '', $src); 	// remove the src link
					$href = preg_match('#^http#i', $href) ? $href : $o.$href;	// if the link starts with "http", then no changes will be performed. If not, then join the base URL to the link. 
					$link->setAttribute('src', $href); 	// put the src link back
				}
			}
			
			return $doc;
	}
	
	function correctIMG($doc, $o){
		// correct the images file, make it refer to original server not ours, the same with above
			foreach($doc->getElementsByTagName('img') as $link) {
				$src = $link->getAttribute('src');
				if(!empty($src) && !preg_match('#^//#i', $src)){
					$href = preg_replace('#^/#', '', $src);
					$href = preg_match('#^http#i', $href) ? $href : $o.$href;
					$link->setAttribute('src', $href);
				}
			}
			
			return $doc;
	
	}
	
	function correctIFRAME($doc, $o){
		// correct the iframe src, make it refer to original server not ours, the same with above
			foreach($doc->getElementsByTagName('iframe') as $link) {
				$src = $link->getAttribute('src');
				if(!empty($src) && !preg_match('#^//#i', $src)){
					$href = preg_replace('#^/#', '', $src);
					$href = preg_match('#^http#i', $href) ? $href : $o.$href;
					$link->setAttribute('src', $href);
				}
			}
		
		return $doc;
	}
	
	function correctALINK($doc, $o, $path, $filename, $rewriteBaseUrl, $ori){
		// hardcore the hyperlinks and enable the function of poping up window and refer to our server when user click the link
			$i = 1;
			foreach($doc->getElementsByTagName('a') as $link) {
				$hlink = $link->getAttribute('href');
				if(!preg_match('#^\##i', $hlink) && !preg_match('#^javascript\:#i', $hlink)){    
					$href = preg_replace('#^/#', '', $hlink); 
					$href = preg_match('#^http#i', $href) ? $href : $o.$href;
					$link->setAttribute('href', $href); 
					$unistr = $this->hyperlink->getUniqueStr($path, $filename, $href);	// get the uni string
					$href = $rewriteBaseUrl.$unistr;
					$link->setAttribute('rev', $href);	// the rev attribute for storing the hardcored url
					$link->setAttribute('onmouseenter','showEnquiryOption("popup_win_'.$i.'","'.$ori.'","'.$unistr.'")');	// enable the popup function.
					$link->setAttribute('id','popup_win_'.$i);
					$link->setAttribute('onclick','redirectUrl("popup_win_'.$i.'"); return false;');	// redirect to our server when user click the url
					$i++; 
				}   
			}
			
			return $doc;
	}
    
    function correctFORM($doc, $o, $path, $filename, $ori){
         $i = 1;
            foreach($doc->getElementsByTagName('form') as $link) {
                $method = $link->getAttribute('method');
                if(empty($method)){
                    $method = 'get';
                }
                
                
                
                $hlink = $link->getAttribute('action');
//                if(!preg_match('#^javascript\:#i', $hlink)){    
                    $href = preg_replace('#^/#', '', $hlink); 
                    $href = preg_match('#^http#i', $href) ? $href : $o.$href;
                    $unistr = $this->hyperlink->getUniqueStr($path, $filename, $href);    // get the uni string
                    $href = $this->getActionUrl($ori, $method).$unistr;
                    
                    while ($link->hasAttributes()){
                        $link->removeAttributeNode($link->attributes->item(0));   
                    }
                    $link->setAttribute('method', 'post');
                    $link->setAttribute('action', $href); 
                    $i++; 
 //               }   
            }
            
            return $doc;
        
    }
	
	function addJScode($doc, $baseurl){
			$head = $doc->getElementsByTagName('head')->item(0);

			// insert our javascript to the web page
			$js = $doc->createElement( 'script');
			$js->setAttribute( 'src', $baseurl.'/js/enquiry.js');
			$js->setAttribute( 'type', 'text/javascript');
			$head->appendChild($js);

			$jquery = $doc->createElement('script');
			$jquery->setAttribute('src', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
			$jquery->setAttribute( 'type', 'text/javascript');
			$head->appendChild($jquery);
			
			return $doc;
	}

}
?> 
