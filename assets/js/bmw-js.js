var $=jQuery.noConflict();
var bmpbaseurl=jQuery('meta[name="bmw_base_url"]').attr('content');
var bmpajaxurl=$('meta[name="bmw_adminajax"]').attr('content');
 var CURRENT_URL = window.location.href.split('#')[0],
    $BODY = $('.let-bmp-body'),
    $MENU_TOGGLE = $('#let_menu_toggle'),
    $SIDEBAR_MENU = $('#let-sidebar-menu'),
    $LEFT_COL = $('.let-left_col'),
    $RIGHT_COL = $('.let-right_col'),
    $NAV_MENU = $('.let-nav_menu');
// Sidebar

function init_sidebar() {



    var openUpMenu = function () {
        $SIDEBAR_MENU.find('li').removeClass('let-active let-active-sm');
        $SIDEBAR_MENU.find('li ul').slideUp();
    }

    $SIDEBAR_MENU.find('a').on('click', function (ev) {
        var $li = $(this).parent();
        if ($li.is('.let-active')) {
            $li.removeClass('let-active let-active-sm');
            $('ul:first', $li).slideUp(function () {
             
            });
        } else {
            // prevent closing menu if we are on child menu
            if (!$li.parent().is('.let-child_menu')) {
                openUpMenu();
            } else {
                if ($BODY.is('let-nav-sm')) {
                    if (!$li.parent().is('let-child_menu')) {
                        openUpMenu();
                    }
                }
            }

            $li.addClass('let-active');

            $('ul:first', $li).slideDown(function () {
                
            });
        }
    });

    // toggle small or large menu
    $MENU_TOGGLE.on('click', function () {alert();
        if ($BODY.find('let-left_col')) {
            $SIDEBAR_MENU.find('li.let-active ul').hide();
            $SIDEBAR_MENU.find('li.let-active').addClass('let-active-sm').removeClass('let-active');
        } else {
            $SIDEBAR_MENU.find('li.let-active-sm ul').show();
            $SIDEBAR_MENU.find('li.let-active-sm').addClass('let-active').removeClass('let-active-sm');
        }

        $BODY.children().toggleClass('let-nav-md let-nav-sm');

        

        $('.dataTable').each(function () { $(this).dataTable().fnDraw(); });
    });
    // check active menu
    $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('let-current-page');

    $SIDEBAR_MENU.find('a').filter(function () {
        return this.href == CURRENT_URL;
    }).parent('li').addClass('let-current-page').parents('ul').slideDown(function () {
      
    }).parent().addClass('let-active');

    // recompute content when resizing
   

    // fixed sidebar
    if ($.fn.mCustomScrollbar) {
        $('.let-menu_fixed').mCustomScrollbar({
            autoHideScrollbar: true,
            theme: 'minimal',
            mouseWheel: { preventDefault: true }
        });
    }
}

$(document).ready(function () {
    $('.let-collapse-link').on('click', function () {
        var $BOX_PANEL = $(this).closest('.let-x_panel'),
            $ICON = $(this).find('i'),
            $BOX_CONTENT = $BOX_PANEL.find('.let-x_content');

        // fix for some div with hardcoded fix class
        if ($BOX_PANEL.attr('style')) {
            $BOX_CONTENT.slideToggle(200, function () {
                $BOX_PANEL.removeAttr('style');
            });
        } else {
            $BOX_CONTENT.slideToggle(200);
            $BOX_PANEL.css('height', 'auto');
        }

        $ICON.toggleClass('fa-chevron-up fa-chevron-down');
    });

    $('.let-close-link').click(function () {
        var $BOX_PANEL = $(this).closest('.let-x_panel');

        $BOX_PANEL.remove();
    });

    $("#bmw_login_form").submit(function(e) {
    e.preventDefault(); 
    var form = $(this);
    var postdata=form.serialize();
    $.ajax({
           type: "POST",
           url: bmpajaxurl,
           data: postdata,
           success: function(data)
           {
            var obj = $.parseJSON(data);
            if(obj.status==false){
                $.each(obj.error , function (key, value) {
                    $('#'+key).html(value);
                });

            } else{
                location.reload();
            }

           }
         });
     return false;
});



});

$(document).ready(function () {


    init_sidebar();
    $('#changePicture').on('change',function(){
        $('#profilePictureForm').submit();
    });
    $('#profilePictureForm').submit(function(e)
           {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
              $.ajax({
            url:bmpajaxurl,
            type: "POST",
            data:formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
              $('.let-pic-layer').addClass("let-pic-visible");
            },
            success: function (data) {
                setTimeout(function () {
                var obj = $.parseJSON(data);
                    if(obj.status==true){
                        $('#profilePictureImg').attr('src',obj.profile);
                        $('.let-pic-layer').removeClass("let-pic-visible");
                     }  
                }, 2000);
        }

           });
}); 


 if ($("input.let-flat")[0]) {
  $('input.let-flat').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
}

$('.wp-list-table').addClass('let-table-hover');
}); 
