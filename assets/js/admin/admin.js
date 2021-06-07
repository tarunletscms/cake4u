var $=jQuery.noConflict();
var bmwajaxurl=$('meta[name="bmw_adminajax"]').attr('content');

function bmpinserthtml(html, field) { 
var obj = document.getElementById(field);
    try { 
        if (obj.selectionStart || obj.selectionStart === 0) {
            obj.focus();
            var os = obj.selectionStart;
            var oe = obj.selectionEnd;
            var np = os + html.length;
            obj.value = obj.value.substring(0, os) + html + obj.value.substring(oe, obj.value.length);
            o.setSelectionRange(np, np);
        } else if (document.selection) {
            obj.focus();
            sel = document.selection.createRange();
            sel.text = html;
        } else {
            obj.value += html;
        }
        
    } catch (e) {
    }
}
function select_payment_status_fun(id){
  alert("do you really want to change");
  $('#select_payment_status').blur(function(){
   
  var select_payment_status=$('#select_payment_status').val();

  $.ajax({
      type: 'POST',
      url: bmwajaxurl,
      data: {
          'action': 'select_payment_status_exist',
          'select_status': select_payment_status,
          'id': id,
      },
      success: function (data) {

      var obj = $.parseJSON(data);
 
       //  if(obj.status==true){
       // alert(obj.message);
          
       //  } 
          // return false;
      }
  });

});
}


$(document).ready(function(){
    $('.wrap_style').css('height',$('.content_style').height());
    $( ".let-number-only" ).keypress(function() {
  return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57) || event.charCode==46);
  });
});
function reset_data(link)
{
  $.ajax({
      type: 'POST',
      url: link,
      data: {
          'action': 'bmw_admin_reset_data',
      },
      success: function (data) {
        
       alert("Binary MLM Data Successfully Reset");
          
        }
    
  });

}
function bmw_distribute_commission(link)
{
  $.ajax({
      type: 'POST',
      url: link,
      data: {
          'action': 'bmw_distribute_commission',
      },
      beforeSend: function () {
              $('.let-loader-layer').addClass("let-visible");
            },
      success: function (data) {
        $('.let-loader-layer').removeClass("let-visible");   
        alert("Binary MLM Commissions Successfully Distributed");
        location.reload();
          
        }
    
  });

}
function bmw_run_payout(link)
{
  $.ajax({
      type: 'POST',
      url: link,
      data: {
          'action': 'bmw_run_payout',
      },

      beforeSend: function () {
              $('.let-loader-layer').addClass("let-visible");
            },
      success: function (data) {
        $('.let-loader-layer').removeClass("let-visible"); 
        alert("Binary MLM Payout Successfully Run");
        location.reload();
        }
    
  });

}
function message_center_post(link){
  var to =$('#message_center_to').val();
  var subject =$('#message_center_subject').val();
  var message =$('#message_center_message').val();
  $.ajax({
      type: 'POST',
      url: link,
      data: {
          'action': 'bmw_message_center',
          'to': to,
          'subject': subject,
          'message': message, 
      },
      success: function (data) {
        var obj = $.parseJSON(data);
        if(obj.status==true){
          $('.mail-message-success').html(obj.message);
          // location.reload(true); 
        } else{
          $.each(obj.error,function(key,value){
            if($('.m_c_to').attr('id')==key){  
            $('.m_c_to').html(value);
            }else if($('.m_c_subject').attr('id')==key){ 
            $('.m_c_subject').html(value);
            }else if($('.m_c_message').attr('id')==key){  
            $('.m_c_message').html(value);
            }
          });
        }     
      }
  });
}

$("#submit_mail_setting").submit(function(e) {
    e.preventDefault(); 
    var form = $(this);
    var postdata=form.serialize();
    $.ajax({
           type: "POST",
           url: ajaxurl,
           data: postdata,
           success: function(data)
           {
            var obj = $.parseJSON(data);
            if(obj.status==false){
                $.each(obj.error , function (key, value) {
            $('#'+key).html(value);
                });

            }

           }
         });
     return false;
});
$("#submit_sms_setting").submit(function(e) {
    e.preventDefault(); 
    var form = $(this);
    var postdata=form.serialize();
    $.ajax({
           type: "POST",
           url: ajaxurl,
           data: postdata,
           success: function(data)
           {
            var obj = $.parseJSON(data);
            if(obj.status==false){
                $.each(obj.error , function (key, value) {
            $('#'+key).html(value);
                });

            }

           }
         });
     return false;
});
$(".install_bmw_addon").click(function(e) {
    e.preventDefault(); 
    var plugin = $(this).attr('data-plugin-slug');
    $.ajax({
           type: "POST",
           url: ajaxurl,
           data: {
            'action':'bmw_install_addon',
            'plugin':plugin
           },
           beforeSend: function () {
              $('.bmw_'+plugin).addClass("let-visible");
            },
           success: function(data)
           {
            if(data){
            $('.bmw_'+plugin).removeClass("let-visible");
            location.reload();
            }
           }
         });
     return false;
});

    // $('#from_data').val($('#from').val());
    // $('#to_data').val($('#to').val());   
function bmw_withdraw_function(id,row_id)
{
  var transaction_id= $('#transaction_id'+row_id).val();
  var method  =  $('.method_selection'+row_id).val();
  $.ajax({
           type: "POST",
           url: ajaxurl,
           data: {
            'action':'bmw_withdraw_data_update',
            'user_id':id,
            'transaction_id':transaction_id,
            'method':method,
            'row_id':row_id,
           },
           success: function(data)
           {
            var obj = $.parseJSON(data); 
          if (obj.status==false) {
          $('#err_message'+row_id).html('');
          $('#err_message'+row_id).html(obj.transaction_id_err);
        }else{
         location.reload();
      }
         return false;
  
}
});
}
function ChangeMailForm(){
 document.getElementById('ChangeMailForm').submit();
}
function ChangesmsForm(){
 document.getElementById('ChangesmsForm').submit();
}
