var company = "";
var target = "";
function showEnquiryOption(e, web,link){
    company = web;
    target = link; 
    var x = 0;
    var y = 0;
	x = getOffset( document.getElementById(e) ).left;
	y = getOffset( document.getElementById(e) ).top;    
	document.getElementById("float_box").style.position = 'absolute';
	document.getElementById("float_box").style.left = x-100+'px';
	document.getElementById("float_box").style.top = y+'px';
	document.getElementById("float_box").style.display = 'block';
    document.getElementById("popupbox").href = '/enquiry/form.php?nodeidnum=1&company='+company+'&target='+target;
}

function hideEnquiryOption(){
	 document.getElementById("float_box").style.display = 'none';

}

function getOffset( el ) {
    var _x = 0;
    var _y = 0;  
    while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
        _x += el.offsetLeft;
        _y += el.offsetTop;   
        el = el.offsetParent;
    }
    return { top: _y, left: _x};
}

function redirectUrl(aid){
   window.location.href = document.getElementById(aid).rev; 
}




