function save_for_later(id){	
	jQuery('#loader_'+id).hide();
	jQuery('#sloader_'+id).show();	
		
	setCookie("Product_ids",id,"2");		
	var get_setcookie = getCookie('random_user_id');	
	if( get_setcookie === null){
	var rondom_number =	Date.now();
	setCookie("random_user_id",rondom_number,"2");
	}
	console.log(id);	
	var form_data = {
	  action : "wsflla_register_ajax_requests_save_to_later",
	  id : id
	 }
	
	jQuery.ajax({
		 type : "POST",
		 url : my_ajax_object.ajax_url,
		 data : form_data,
		 success: function(html) {
			 jQuery('#view_loader_'+id).show();
			 jQuery('#sloader_'+id).hide();
			 location.reload(); 
			 console.log(html);					 
		},
	}); 
}

/* jQuery(document).ready(function(){
	
	 jQuery('#loader_'+ids).on('click', function(){		
		var ids = jQuery(this).attr('potsids');
		//alert(ids);
		 var prod_id =[];		 
		jQuery.each(jQuery('#loader_'+ids), function(){
				prod_id.push(jQuery(this).attr('potsids'));
			}); 
			
		//alert(prod_id);
		//console.log(prod_id); 
	});	 
	
}); */



/* Cookie functions  */

 function setCookie(name,value,days) {
	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days*24*60*60*1000));
		expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
 function getCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
 function eraseCookie(name) {   
	document.cookie = name+'=; Max-Age=-99999999;';  
}

/* Cookie function End  */


function add_to_cart(id){
	
	var form_data = {
	  action : "wsflla_register_ajax_requests_remove_save_to_later",
	  id : id,
	  move_to_cart: id
	 }
	jQuery.ajax({
		 type : "POST",
		 url : my_ajax_object.ajax_url,
		 data : form_data,
		 success: function(html) {
			 
			 console.log(html);
			 location.reload();
		},
	}); 
	
}

function delete_record(id){
    
    var r = confirm("Are You Sure You Want to Delete");
    if (r == true) {
        
      var form_data = {
	  action : "wsflla_register_ajax_requests_remove_save_to_later",
	  id : id,
	  delete_record: id
	 }
	jQuery.ajax({
		 type : "POST",
		 url : my_ajax_object.ajax_url,
		 data : form_data,
		 success: function(html) {
			 
			 console.log(html);
			 location.reload();
		},
	}); 
    }
	
	
}

function activate_kbiz(){

    var email = jQuery('#requested_email').val();
    var site_url = jQuery('#site_url').val();
	var form_data = {
	  action: 'wsflla_request_activation_token',
		nonce: my_ajax_object.activation_nonce,
		email: email,
		site_url: site_url
	 }

    if(validateEmail(email)){

    	jQuery.ajax({
		 type : "POST",
		 url : my_ajax_object.ajax_url,
		 data : form_data,
		 success: function(response) {
			 if (!response.success || !response.data || !response.data.token) {
				 alert(response.data && response.data.message ? response.data.message : 'Activation request failed.');
				 return;
			 }
			 jQuery('#token_field').val(response.data.token); 
			 document.getElementById("request_activation").submit();
		 },
		 error: function(xhr) {
			 var response = xhr.responseJSON;
			 alert(response && response.data && response.data.message ? response.data.message : 'Activation request failed.');
		 }
	}); 
    }
	
}

function validateEmail(emailField){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if (reg.test(emailField) == false) 
        {
            alert('Invalid Email Address');
            return false;
        }

        return true;

}

function submit_check_form(){

	setTimeout(function(){ document.getElementById("form_submit_checkbox").click(); }, 1000);
	
}



