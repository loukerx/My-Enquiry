<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Allmightytrader</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Mr+Dafoe' rel='stylesheet' type='text/css'>
        
        
        <script src="http://www.microsoftTranslator.com/ajax/v3/WidgetV3.ashx?siteData=ueOIGRSKkd965FeEGM5JtQ**" type="text/javascript"></script>
    <script type="text/javascript">
        
        document.onreadystatechange = function () {
            if (document.readyState == 'complete') {
                
                Microsoft.Translator.Widget.Translate('en', 'en', onProgress, onError, onComplete, onRestoreOriginal, 100000);
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
        
        
    </head>
    <body>
        <div class="wrap">
            <div class="content">
                <div class="logo">
                    <a href="index.php"><h1>Allmightytrader</h1></a>
                </div>
                <p>We have everything you want!</p>
                <div id="search_form" class="form">
                    <form method="post" action="searchResults.php" encType="multipart/form-data" id="contact-form" name="searchForm" class="">
                        <input id="keyword" type="text" name="keyword" placeholder="Please enter your keyword" tabindex="2" required>
                        <input type="submit" name="submit" id="contact-submit" value="Search">
                    </form>

                </div>
                <div class="footer">
                
                </div>
            </div>
        </div>
</body>
</html>

