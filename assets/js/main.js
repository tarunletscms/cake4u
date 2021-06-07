var $=jQuery.noConflict();
var bmwajaxurl=$('meta[name="bmw_adminajax"]').attr('content');


// //affiliate url copy button
// var copyUrlBtn = document.querySelector('#copy_btn');  
// copyUrlBtn.addEventListener('click', function(event) {  
//   // Select the email link anchor text  
//   var Link = document.querySelector('#affiliate_Url');  
//   var range = document.createRange();  
//   range.selectNode(Link);  
//   window.getSelection().addRange(range);  

//   try {  
//     var successful = document.execCommand('copy');  
//     var msg = successful ? 'successful' : 'unsuccessful';  
//     console.log('Copy email command was ' + msg);  
//   } catch(err) {  
//     console.log('Oops, unable to copy');  
//   }  
//   window.getSelection().removeAllRanges();  
// });




$('#auto_add_bmw_user_fill').click(function(e){
	e.preventDefault();
	
	var number=$('#number').val();
	var sponsor=$('#sponsor').val();
	var epin=$('#epin').val();
	var position=$('#position').val();

	$.ajax({
	    type: 'POST',
	    url: bmwajaxurl,
	    data: {
	        'action': 'bmw_auto_add',
	        'number': number,
	        'sponsor': sponsor,
	        'epin': epin,
	        'position': position,
	    },
	    success: function (data) {
	    	$('.bmw_username_message').html('');
	    	var obj = $.parseJSON(data);
	    	if(obj.status==false){
	    		$('.bmw_username_message').html(obj.message);
	    		$('#bmw_username').val('');
	    	} else{
	    		$('.bmw_username_message').html(obj.message);
	    		
	    	}
	        return false;
	    }
	});
});


// user name exist check
$('#bmw_username').blur(function(){

	var username=$('#bmw_username').val();

	$.ajax({
	    type: 'POST',
	    url: bmwajaxurl,
	    data: {
	        'action': 'bmw_username_exist',
	        'username': username,
	    },
	    success: function (data) {
	    	$('#bmw_username').addClass('let-m-0');
	    	$('.bmw_username_message').html('');
	    	var obj = $.parseJSON(data);
	    	if(obj.status==false){
	    		$('.bmw_username_message').html(obj.message);
	    		$('#bmw_username').val('');
	    	} else{
	    		$('.bmw_username_message').html(obj.message);
	    		
	    	}
	        return false;
	    }
	});

});




// user email exist check
$('#bmw_email').blur(function(){

	var email=$('#bmw_email').val();
	$.ajax({
	    type: 'POST',
	    url: bmwajaxurl,
	    data: {
	        'action': 'bmw_email_exist',
	        'email': email,
	    },
	    success: function (data) {
	    	$('#bmw_email').addClass('let-m-0');
	    	$('.bmw_email_message').html('');
	    	var obj = $.parseJSON(data);
	    	if(obj.status==false){
	    		$('.bmw_email_message').html(obj.message);
	    		$('#bmw_email').val('');
	    	} else{
	    		$('.bmw_email_message').html(obj.message);
	    		
	    	}
	        return false;
	    }
	});

});
//sponsor check
$('#bmw_sponsor_id').blur(function(){
	$.ajax({
	    type: 'POST',
	    url: bmwajaxurl,
	    data: {
	        'action': 'bmw_sponsor_exist',
	        'sponsor': $(this).val(),
	    },
	    success: function (data) {
	    	$('#bmw_sponsor_id').addClass('let-m-0');
	    	$('.bmw_sponsor_message').html('');
	    	var obj = $.parseJSON(data);
	    	if(obj.status==false){
	    		$('.bmw_sponsor_message').html(obj.message);
	    		$('#bmw_sponsor_id').val('');
	    	} else{
	    		$('.bmw_sponsor_message').html(obj.message);
	    		
	    	}
	        return false;
	    }
	});

});
//parent check
$('#bmw_parent').blur(function(){
	$.ajax({
	    type: 'POST',
	    url: bmwajaxurl,
	    data: {
	        'action': 'bmw_parent_exist',
	        'parent': $(this).val(),
	        'sponsor': $('#bmw_sponsor_id').val(),
	    },
	    success: function (data) {
	    	$('#bmw_parent').addClass('let-m-0');
	    	$('.bmw_parent_message').html('');
	    	var obj = $.parseJSON(data);
	    	if(obj.status==false){
	    		$('.bmw_parent_message').html(obj.message);
	    		$('#bmw_parent').val('');
	    	} else{
	    		$("input[name=bmw_position][value=left]").removeAttr('disabled', 'disabled');
	    		$("input[name=bmw_position][value=right]").removeAttr('disabled', 'disabled');
	    		$("input[name=bmw_position][value=right]").parent().removeClass('checked');
	    		$("input[name=bmw_position][value=left]").parent().removeClass('checked');
	    		if(obj.position){
	    			if(obj.position=='left')
	    			{
	    			$("input[name=bmw_position][value=right]").parent().addClass('checked');
	    			$("input[name=bmw_position][value=left]").parent().removeClass('checked');
	    			$("input[name=bmw_position][value=right]").attr('checked', 'checked');
	    			$("input[name=bmw_position][value=left]").attr('disabled', 'disabled');
	    			}else if(obj.position=='right'){
	    			$("input[name=bmw_position][value=right]").parent().removeClass('checked');
	    			$("input[name=bmw_position][value=left]").parent().addClass('checked');
	    			$("input[name=bmw_position][value=left]").attr('checked', 'checked');
	    			$("input[name=bmw_position][value=right]").attr('disabled', 'disabled');
	    			}
	    		}
	    		$('.bmw_parent_message').html(obj.message);
	    		
	    	}
	        return false;
	    }
	});

});


// user password exist check
$('#bmw_confirm_password').blur(function(){

	var password=$('#bmw_password').val();
	var confirm_password=$('#bmw_confirm_password').val();

	$.ajax({
	    type: 'POST',
	    url: bmwajaxurl,
	    data: {
	        'action': 'bmw_password_validation',
	        'password': password,
	        'confirm_password': confirm_password,
	    },
	    success: function (data) {
	    	$('#bmw_confirm_password').addClass('let-m-0');
	    	$('.bmw_confirm_password_message').html('');
	    	var obj = $.parseJSON(data);
	    	if(obj.status==false){
	    		$('.bmw_confirm_password_message').html(obj.message);
	    		$('#bmw_confirm_password').val('');
	    		$('#bmw_password').val('');
	    	} else {
	    		$('.bmw_confirm_password_message').html(obj.message);
	    		
	    	}
	        return false;
	    }
	});

});


// Register form submit

$("#bmw_register_form").submit(function(e) {
	e.preventDefault(); 
    var form = $(this);
    var urlw= $(this.redirect_URL);
    var postdata=form.serialize();
    $.ajax({
           type: "POST",
           url: bmwajaxurl,
           data: postdata,
           beforeSend: function () {
              $('.let-loader-layer').addClass("let-visible");
            },
           success: function(data)
           {
           	var obj = $.parseJSON(data);
           	if(obj.status==false){
           		$.each(obj.error , function (key, value) {
				    $('.'+key).prev('input').addClass('let-m-0');
				    $('.'+key).addClass('let-text-danger');
				    $('.'+key).html(value);
				});
           		 $('.let-loader-layer').removeClass("let-visible");
           	} else{
           		window.location.href =urlw.val();
           		$('#bmw_user_success_message').html(obj.message);
           		$('#bmw_register_form').remove();
           	}

           }
         });
     return false;
});
$("#bmw_login_form").submit(function(e) {
	e.preventDefault(); 
    var form = $(this);
    var postdata=form.serialize();
    $.ajax({
           type: "POST",
           url: bmwajaxurl,
           data: postdata,
           success: function(data)
           {
           	var obj = $.parseJSON(data);
           	if(obj.status==false){
           		$.each(obj.error , function (key, value) {
				    $('.'+key).html('<span style="color:red;">'+value+'</span>');
				});

           	} else{
           		$('#bmw_user_success_message').html(obj.message);
           		$('#bmw_register_form').remove();
           	}

           }
         });
     return false;
});

$("#bmw_join_form").submit(function(e) {
	e.preventDefault(); 
    var join_form = $(this);
    var postjoindata=join_form.serialize();
    $.ajax({
           type: "POST",
           url: bmwajaxurl,
           data: postjoindata,
           success: function(data)
           {
           	var obj = $.parseJSON(data);
           	if(obj.status==false){
           		$.each(obj.error , function (key, value) {
				    $('.'+key).prev('input').addClass('let-m-0');
				    $('.'+key).addClass('let-text-danger');
				    $('.'+key).html(value);
				});

           	} else{
           		location.reload();
           	}

           }
         });
     return false;
});


$('#downlines-search').click(function(e){
	e.preventDefault();
	$('.search-message').html('');
	var username=$('#downlines-username').val();
	if(username==''){
		$('.search-message').html('<span style="color:red;">Username could not be empty.</span>');
		return false;
	}

	$.ajax({
	    type: 'POST',
	    url: bmwajaxurl,
	    data: {
	        'action': 'bmw_username_downline_search',
	        'username': username,
	    },
	    success: function (data) {
	    	$('.search-message').html('');
	    	var obj = $.parseJSON(data);
	    	if(obj.status==true){
	    		$('.search-message').html(obj.message);
	    		$( "#downlines-usersearch" ).submit();
	    	} else{
	    		$('.search-message').html(obj.message);
	    		
	    	}
	        return false;
	    }
	});

	return false;
});
$('.bmw-get-otp').click(function(e){
	e.preventDefault();
	var phone=$('#bmw_phone').val();
	var country_code=$('#bmw-country-code').val();
	if(phone==''){
		$('.bmw_phone_message').addClass('let-text-danger').html('Phone number could not be empty.');
		return false;
	}
	if(country_code==''){
		$('.bmw_phone_message').addClass('let-text-danger').html('Please choose country code.');
		return false;
	}

	$.ajax({
	    type: 'POST',
	    url: bmwajaxurl,
	    data: {
	        'action': 'bmw_get_otp_action',
	        'phone': phone,
	        'country_code': country_code,
	    },
	    beforeSend: function () {
              $('.let-loader-layer').addClass("let-visible");
            },
	    success: function (data){
	    	 console.log(data);
              $('.let-loader-layer').removeClass("let-visible");
	    	 var obj = $.parseJSON(data);
              if(obj.status==true){
		    	$('#bmw-get-otp').remove();
		    	$('#otp_confirm_section').removeClass('let-d-none').fadeIn();
	    			$('.bmw_phone_message').removeClass('let-text-danger').addClass('let-text-success').css('margin-top','-10px').html(obj.message);
	    		}else{
	    			$('.bmw_phone_message').addClass('let-text-danger').html(obj.message);
	    		}
	    	}
	});

	return false;
});
$('#bmw-verify-otp').click(function(e){
	e.preventDefault();
	var otp=$('#bmw_otp_field').val();
	if(otp==''){
		$('.bmw_phone_message').addClass('let-text-danger').html('Phone number could not be empty.');
		return false;
	}
	var phone =$('#bmw-country-code').val()+$('#bmw_phone').val();
	$.ajax({
	    type: 'POST',
	    url: bmwajaxurl,
	    data: {
	        'action': 'bmw_verify_otp_action',
	        'otp': otp,
	    },
	    beforeSend: function () {
              $('.let-loader-layer').addClass("let-visible");
            },
	    success: function (data) {
	    	var obj = $.parseJSON(data);
              if(obj.status==true){
		    	$('#otp_confirm_section,.bmw_phone_message').html('');
		    	$('.bmw-phone-section').append('<input type="hidden" name="bmw_phone" value="'+phone+'">');
	    			$('#otp_confirm_section').addClass('let-text-success let-text-center').html(obj.message);
	    			$('#bmw_phone,#bmw-country-code').attr('disabled','disabled');
	    		}else{
	    			$('.bmw_phone_message').addClass('let-text-danger').css('margin-top','-10px').html(obj.message);
	    		}
	    	 $('.let-loader-layer').removeClass("let-visible");
	    }
	});

	return false;
});

$('#insert_epin').click(function(e){
	e.preventDefault();    
   if($('#epin_form').is(':hidden'))
    {
      $('#epin_form').show('slow');
       
    }else{
     $('#epin_form').hide('slow');
    }
 
});


$('#update_epin').click(function(e){
	e.preventDefault();    
  new_epin=$('#epin_value').val();
  old_epin=$('#old_epin').val();
  $.ajax({
	    type: 'POST',
	    url: bmwajaxurl,
	    data: {
	        'action': 'bmw_update_epin',
	        'new_epin': new_epin,
	        'old_epin': old_epin,
	    },
	    success: function (data) {
	    	$('#epin_form').reload();
	    		
	    	}
	  
	});
	        return false;

});


$('#account_details_form').submit(function(e) {
	e.preventDefault(); 
	var form = $(this);
		$.ajax({
	    type: 'POST',
	    url: bmwajaxurl,
	    dataType : 'json',
	    data:form.serialize(),
	    success: function (data) {
	    	if(data.status==true){
	    		 $('#form-message').html('<div class="let-alert let-p-1 let-text-white let-rounded-0 let-alert-success" role="alert">'
                    +'<strong>'+data.message+'</strong></div>');
	    	} else{
	    		$.each(data.error,function(key,value){
	    			$('#'+key).html(value);
	    		});
	    		 $('#form-message').html('<div class="let-alert let-p-1 let-text-white let-rounded-0 let-alert-danger" role="alert">'
                    +'<strong>'+data.message+'</strong></div>');
	    		}

	        return false; 
	    }
	});
	});

function bmw_withdrwal_request(){
    var amount=$('#withdrwal_amount').val();
    $.ajax({
        type: 'POST',
        url: bmwajaxurl,
        data: {
            'action': 'bmw_withdrwal_amount_request',
            'amount': amount,   
        },
        beforeSend: function () {
              $('.let-loader-layer').addClass("let-visible");
            },
        success: function (data) {
            $('#withdrwal_amount_message').html('').removeClass('let-text-success let-text-danger');
            var obj = $.parseJSON(data);
            setTimeout(function () { 
            if(obj.status==true){
                $('#withdrwal_amount_message').html(obj.message).addClass('let-text-success');
            } else{
                $('#withdrwal_amount_message').html(obj.message).addClass('let-text-danger');
            } 
            $('.let-loader-layer').removeClass("let-visible");   }, 2000);  
        }
    });
};

$("#bmw_invitation_form").submit(function(e) {
	e.preventDefault();
	var invite=$('#bmw_email').val();
    $.ajax({
           type: "POST",
           url: bmwajaxurl,
           data: {
           	'action': 'bmw_send_invitation_hook',
	        'invite_mail': invite,
	    	},
           success: function(data)
           {
           	var obj = $.parseJSON(data);
	    	$('.bmw_email_message').html('').removeClass('let-text-success let-text-danger');
	    	if(obj.status==true){
	    		$('.bmw_email_message').html(obj.message).addClass('let-text-success'); 
	    	} else{
	    		$('.bmw_email_message').html(obj.message).addClass('let-text-danger'); 
	    		
	    		}
	    	
           }
         });
     return false;
});

$('#invite_email').blur(function(e){
	e.preventDefault();
	var email=$('#invite_email').val();
	$.ajax({
	    type: 'POST',
	    url: bmwajaxurl,
	    data: {
	        'action': 'bmw_email_check',
	        'email': email,
	    },
	    success: function (data) {
	    	var obj = $.parseJSON(data);
	    	$('.bmw_email_check').html('');
	    	if(obj.status==true){
	    		$('.bmw_email_check').css('color','green'); 
	    		$('.bmw_email_check').html(obj.message); 
	    	} else{
	    		$.each(obj.error,function(key,value){
	    			if($('.bmw_email_check').attr('id')==key){	
	    			$('.bmw_email_check').html(value);
	    			}
	    		});
	    		}
	        return false; 
	    }
	});
	});

function run(sel) {
var year=$('#year').val();
    $.ajax({
        type: "POST",
        url: bmwajaxurl,
        data: { 
        	'action':'bmw_user_graph',
        	'year':year,
        	},

    success: function (data) {
    	location.reload();
    }
});

}

$(document).ready(function(){  
  $("#download").on('click', function () {
            var element = $("#chart_div"); // global variable
             html2canvas(element, {
         onrendered: function (canvas) {
                var imgageData = canvas.toDataURL("image/png");
                var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                $("#download").attr("download", "geneology.png").attr("href", newData);
                $("#download").text('Download');
             }
         });
  $( ".let-number-only" ).keypress(function() {
  return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57));
  });
});

});
