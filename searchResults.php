<?php 
include_once 'Hyperlink.php';

$hyperlink = new Hyperlink();

$realestate=array("Domain"=>"http://www.domain.com.au/", "RealEstate.com.au"=>"http://www.realestate.com.au/", "RealEstate.com"=>"http://www.realestate.com/", "Zillow"=>"http://www.zillow.com/", "Realtor"=>"http://www.realtor.com/");
$education=array("University of Technology, Sydney"=>"https://www.uts.edu.au/","University of Sydney"=>"http://sydney.edu.au/","Macquarie University"=>"http://www.mq.edu.au/","University of Western Sydney"=>"http://www.uws.edu.au/","Curtin University"=>"http://sydney.curtin.edu.au/");
$education_img=array("University of Technology, Sydney"=>"university_of_technology_sydney.jpg","University of Sydney"=>"university_of_sydney.jpg","Macquarie University"=>"macquarie_university.jpg","University of Western Sydney"=>"university_of_western_sydney.png","Curtin University"=>"university_of_curtin.jpg");
$education_sum=array("University of Technology, Sydney"=>"The University of Technology, Sydney (UTS) is a university in the CBD of Sydney, Australia. It was ranked in the 401th-500th bracket and 17th-19th in Australia in the 2013 Academic Ranking of World Universities.[1] The university was founded in its current form in 1988, although its origins trace back to the 1870s. It is part of the Australian Technology Network of universities and has the fifth largest enrolment in Sydney.","University of Sydney"=>"The University of Sydney (commonly referred to as Sydney University, Sydney Uni, USyd, or Sydney) is an Australian public university in Sydney. Founded in 1850, it is Australia's first university and is regarded as one of its most prestigious, ranked as the 27th most reputable university in the world.","Macquarie University"=>"Macquarie University is an Australian public teaching and research university in Macquarie Park, New South Wales. Macquarie is ranked in the 201st-300th bracket and 8th-9th in Australia in the 2013 Academic Ranking of World Universities.[3] Founded in 1964 by the New South Wales Government, it was the third university to be established in the metropolitan area of Sydney.","University of Western Sydney"=>"The University of Western Sydney, also known as UWS, is a multi-campus university in the Greater Western region of Sydney, New South Wales, Australia.","Curtin University"=>"Curtin University (formerly known as Curtin University of Technology) is a research intensive public university based in Perth, Western Australia. The University is named after the 14th Prime Minister of Australia, John Curtin and is the largest university in Western Australia, with over 40,000 students (as of 2012).");
$flight=array("Virgin Australia"=>"http://www.virginaustralia.com/au/en","Jet Star"=>"http://www.jetstar.com/au/en/home","Tiger Air"=>"http://www.tigerair.com/au/en/","Qantas"=>"http://www.qantas.com.au/");
$keyword = $_POST["keyword"];
$results = array();
$results_img = array();
$results_sum = array();
if($keyword == "realestate"){
        $results = $realestate;
	
}

if($keyword == "education"){
        $results = $education;
	$results_img = $education_img;
	$results_sum = $education_sum;
}

if($keyword == "flight"){
        $results = $flight;
}

//set session 
session_start();
// store session data
$_SESSION['toLanguage']="zh-CHS";
echo "Views=". $_SESSION['toLanguage'];
?>

<html>
<head>
	<title>Search Results</title>
<link href='css/search_results.css' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){$('#search_field').load('index.php #search_form');});
</script>

<script src="http://www.microsoftTranslator.com/ajax/v3/WidgetV3.ashx?siteData=ueOIGRSKkd965FeEGM5JtQ**" type="text/javascript"></script>
    <script type="text/javascript">
        
        document.onreadystatechange = function () {
            if (document.readyState == 'complete') {
                
                Microsoft.Translator.Widget.Translate(null, 'en', onProgress, onError, onComplete, onRestoreOriginal, 100000);
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
  $(document).ready(function(){

          $("a").click(function(){
          //var myValue = $("#cn").attr('href');




            var td = event.srcElement;
            console.log(td);
          //  alert("line number：" + (td.parentElement.rowIndex + 1) + ",content:" + td.innerText); 
          });

        });

    </script>



</head>
<body>
<a href="#zh-CHS">Chinese Simplified</a>
<table id="LanguageMenu" border="0"> 
<tbody>
<tr> <td><a tabindex="-1"  href="#ar">Arabic</a></td>
 <td><a tabindex="-1"  href="#sk">Slovak</a></td></tr>
<tr> <td><a tabindex="-1" href="#zh-CHS" id ="cn">Chinese Simplified</a></td>
 <td><a tabindex="-1"  href="#fr">French</a></td></tr>
<tr> <td><a tabindex="-1" href="#zh-CHT">Chinese Traditional</a></td>
 <td><a tabindex="-1"  href="#ja">Japanese</a></td></tr>
</tbody></table>

	<div id="search_field" class="form">
        		
	</div>
	<div id="results">
		<?php
			if(count($results) == 0){echo "No results found";}
			foreach($results as $name=>$link){
            $unistr = $hyperlink->getUniqueStr("companyinfo", "companylist.xml", $link);
		?>
		<div class="result_content">
			<div class="result_img"><a class="result_link" href="enquiry.php?o=<?php echo "$unistr"?>&company=<?php echo "$unistr"?>" target="_blank"><img class="img_style" src="images/<?php echo $results_img[$name];?>"></img></a></div>
			<div class="result_des">
			<a class="result_link" href="enquiry.php?o=<?php echo "$unistr"?>&company=<?php echo "$unistr"?>" target="_blank"><?php echo "$name"?></a>
			<p class="result_summary"><?php echo $results_sum[$name]?></p>
			</div>
		</div>
		<?php
			
			}
		?>
	</div>
</body>
</html>
