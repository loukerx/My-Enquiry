    var i = 1;
    
    function addEnquiry(company,target){
        var ef = document.getElementById('enquiry_fields');
        var divForm = document.createElement("div");
        divForm.id = 'enquiry_div_'+i;
        divForm.className = "div_form";
        ef.appendChild(divForm);
        if(logged_in){
            $('#'+divForm.id).load('enquiry/form.php?nodeidnum='+i+'&company='+company+'&target='+target); 
        }else{
            $('#'+divForm.id).load('enquiry/register.php?nodeidnum='+i+'&company='+company+'&target='+target);
        }
//        $('#'+divForm.id).load('form.php?nodeidnum='+i+'&company='+company+'&target='+target);
//        divForm.innerHTML = "<form id='enquiry_form_"+i+"' ><div id='enquiry_form_top_"+i+"' class='form_top'><div id='form_top_company_"+i+"' class='form_top_company'><label>COMPANY INFORMATION</label><br><label>Name:</label><br><label>Address:</label><br><label>Website:"+company+"</label></div><div id='form_top_personal_"+i+"' class='form_top_personal'><label>YOUR PERSONAL INFORMATION</label><br><label>Contact Name:</label><br><label>Title:</label><br><label>Phone:</label><br><label>Mobile</label><br><label>Fax:</label><br><label>Email:</label></div></div><div id='enquiry_form_content_"+i+"' class='form_content'><label>Your enquiries:</label><br><textarea id='form_content_enquiries' rows='4' cols='50' >Product: "+target+"</textarea></div><div id='enquiry_form_bottom_"+i+"' class='form_bottom'><button id='enquiry_form_delete_"+i+"' type='button' onClick='form_delete("+i+");'>Delete</button><button id='enquiry_form_submit_"+i+"' type='button' onClick='form_submit("+i+");'>Submit</button></div></form>"
        
        i++;
    }

    function form_delete(divid){
        var divr = document.getElementById('enquiry_div_'+divid);
        divr.parentNode.removeChild(divr);

    }

    function form_submit(Id) {

        //alert (dataString);return false;
        $.ajax({
          type: "POST",
          url: "action.php",
          data: $('#enquiry_form_'+Id).serialize(),
          success: function(msg) {
            $('#enquiry_form_content_'+Id).html(msg);
            $('#enquiry_form_submit_'+Id).remove();
            }
        });
        return false;

    }