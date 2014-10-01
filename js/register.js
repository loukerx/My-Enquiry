$(document).ready(function() {
    
    //if submit button is clicked
    $('#submit').click(function () {        
        
        //Get the data from all the fields
        var first_name = $('input[name=first_name]');
        var last_name = $('input[name=last_name]');
        var password = $('input[name=password]');
        var password_confirm = $('input[name=password_confirm]');     
        var email = $('input[name=email]');

        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (first_name.val()=='') {
            first_name.addClass('hightlight');
            return false;
        } else first_name.removeClass('hightlight');
        
        if (last_name.val()=='') {
            last_name.addClass('hightlight');
            return false;
        } else last_name.removeClass('hightlight');
        
        if (phone.val()=='') {
            phone.addClass('hightlight');
            return false;
        } else phone.removeClass('hightlight');
        
        if (password.val()=='') {
            password.addClass('hightlight');
            return false;
        } else password.removeClass('hightlight');
        
        if (password_confirm.val()=='') {
            password_confirm.addClass('hightlight');
            return false;
        } else password_confirm.removeClass('hightlight');
        
        if(password.val() != password_confirm.val()){
            return false;
        }
        
        if (email.val()=='') {
            email.addClass('hightlight');
            return false;
        } else email.removeClass('hightlight');
        
        //organize the data properly
        var data = "nodeidnum=<?php echo $nodeidnum;?>&company=<?php echo $company?>&target=<?php echo $target;?>" + '&name=' + name.val() + '&title=' + title.val() + '&phone=' + phone.val() + '&mobile=' + mobile.val() + '&fax=' + fax.val() + '&email=' + email.val();
    
        
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "processRegister.php",    
            
            //GET method is used
            type: "GET",

            //pass the data            
            data: data,        
            
            //Do not cache the page
            cache: true,
            
            //success
            success: function (html) {                
                //if process.php returned 1/true (send mail success)
                //if (html=='1') {                    
                    //hide the form
                    //$('.form').fadeOut('slow');                    
                    
                    //show the success message
                    //$('.done').fadeIn('slow');
                    
                    window.location.replace("form.php?nodeidnum=<?php echo $nodeidnum;?>&company=<?php echo $company?>&target=<?php echo $target;?>"); 
                //if process.php returned 0/false (send mail failed)
                //} else alert('Sorry, unexpected error. Please try again later.');                
            }        
        });
        
        //cancel the submit button default behaviours
        return false;
    });    
});    