<?php
include_once 'Controller.php';
include_once 'Hyperlink.php';

//get session
session_start();
echo "Views=". $_SESSION['toLanguage'];
  $toLanguage = $_SESSION['toLanguage'];

$ori = $_GET["o"];
$company=$_GET["company"];
$hyperlink = new Hyperlink();
$controller = new Controller();
$unistr = $hyperlink->getBeginUniqueStr($ori, $ori.".xml", $company,$hyperlink->getHlink("companyinfo","companylist.xml",$company));
$urllink = $controller->getWebpage($ori, $unistr, null, null);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
  
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enquiry POC</title>
    <link href='css/colorbox.css' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/jquery.colorbox.js"></script>
    
    <script src="http://www.microsoftTranslator.com/ajax/v3/WidgetV3.ashx?siteData=ueOIGRSKkd965FeEGM5JtQ**" type="text/javascript"></script>
    <script type="text/javascript">
       
        document.onreadystatechange = function () {
            if (document.readyState == 'complete') {
                var toLanguage= '<?php echo $toLanguage;?>';        
                Microsoft.Translator.Widget.Translate(null, toLanguage, onProgress, onError, onComplete, onRestoreOriginal, 5000);
                Microsoft.Translator.Widget.domTranslator.showHighlight = false;
                Microsoft.Translator.Widget.domTranslator.showTooltips = false;
            }
        }
        //You can use Microsoft.Translator.Widget.GetLanguagesForTranslate to map the language code with the language name
        function onProgress(value) {
            document.getElementById('counter').innerHTML = Math.round(value);
        }

        function onError(error) {
            alert("Translation Error: " + error);
        }

        function onComplete() {
            document.getElementById('counter').style.color = 'green';
        }
        //fires when the user clicks on the exit box of the floating widget
        function onRestoreOriginal() { 
            alert("The page was reverted to the original language. This message is not part of the widget.");
        }

    </script>
    
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <p id="float_box" class="float_box" style="display:none;top: 0;left: 0;width: 100px ;height: 20px;text-align:center;z-index:9999; font-size:10px; " onmouseleave="hideEnquiryOption()">
    <a id="popupbox" class="popupbox" href="" style="background: rgba(255,255,255,0.8); color:#3a57af;"><b> Make an enquiry</b></a>
    <script>
            jQuery('.popupbox').colorbox({iframe:true, innerWidth:640, innerHeight:480});
    </script>
    </p>
    <!--
    <div id='MicrosoftTranslatorWidget' class='Dark' style='color:white;background-color:#555555'></div><script type='text/javascript'>setTimeout(function(){{var s=document.createElement('script');s.type='text/javascript';s.charset='UTF-8';s.src=((location && location.href && location.href.indexOf('https') == 0)?'https://ssl.microsofttranslator.com':'http://www.microsofttranslator.com')+'/ajax/v3/WidgetV3.ashx?siteData=ueOIGRSKkd965FeEGM5JtQ**&ctf=True&ui=true&settings=Manual&from=en';var p=document.getElementsByTagName('head')[0]||document.documentElement;p.insertBefore(s,p.firstChild); }},0);</script>
    -->
    <div class="container">
       
                <?=$urllink?>
    </div>
    
   
      
 </body>
</html>
















