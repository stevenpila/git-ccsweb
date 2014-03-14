$(document).end(function(){
   $('.options').hide(); 
});
$(document).ready(function(){
    var base_url = 'http://localhost/ccsweb/';
    /*-------------------------------
    
                 events
    
    --------------------------------*/
    $(document).on('click','#ccs-profile-picture-dropdown .dropdown-menu > li a.delete',function(){
        var data = $(this).parent().parent().parent().attr('data-value');
//        alert(data);
        delete_profile_picture(data);
    });

    var delete_profile_picture = function(data){
        $.ajax({
            type: 'POST',
            url: base_url + 'profile/remove_current_profile_picture',
            data: {
                key: data
            },
            dataType: 'json',
            success: function(result){
                if(result.status)
                    location.reload();
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }

    $('.ccs-date .input-group-addon').css({"background-color":"tranparent"});
    $('input[name="firstname"]').prop('disabled', true).css({"border-color":"transparent"});
    $('input[name="middlename"]').prop('disabled', true).css({"border-color":"transparent"});
    $('input[name="lastname"]').prop('disabled', true).css({"border-color":"transparent"});
    $('input[name="newpassword"]').prop('disabled', true).css({"border-color":"transparent"});
    $('input[name="password"]').prop('disabled', true).css({"border-color":"transparent"});
    $('.profile-password').addClass('hide');
    $('input[name="birthdate"]').prop('disabled', true).prop('readonly',false).css({"border-color":"transparent"});
    $('input[name="email"]').prop('disabled', true).css({"border-color":"transparent"});
    $('#ccs-user-profile-edit').prop('disabled',false);
    $('#ccs-user-profile-edit').attr('title','Edit').attr('data-hint','0').html('<i class="icon-pencil"></i> Edit');
    $('#ccs-user-profile-edit').prop('disabled',false);
    $('#ccs-user-profile-edit-cancel').addClass('hide');
    
    // toggle change prof pic button
    $('.options',this).hide();
    $(document).on('mouseenter','.ccs-user-profile-picture',function(){
        if(!$('#ccs-profile-picture-dropdown').hasClass('open'))
            $('.options',this).show();
        else
            $('.options',this).show();
    });
    $(document).on('mouseleave','.ccs-user-profile-picture',function(){
        if($('#ccs-profile-picture-dropdown').hasClass('open'))
            $('.options',this).show();
        else
            $('.options',this).hide();
    });
    $(document).click(function(){
        $('.options',this).hide();
    });
    // edit user profile
    var firstname = $('input[name="firstname"]').val();
    var middlename = $('input[name="middlename"]').val();
    var lastname = $('input[name="lastname"]').val();
    var newpassword = $('input[name="newpassword"]').val();
    var password = $('input[name="password"]').val();
    var birthdate = $('input[name="birthdate"]').val();
    var email = $('input[name="email"]').val();
    $(document).on('click','#ccs-user-profile-edit',function(){
        var form = $('form[name="ccs-profile-update-form"]');
        var hint = $(this).attr('data-hint');
        
        if(hint == 1){
            form.submit();
        }
        else{
            show_profile_edit_input();
//            $('html,body').scrollTop(60);
        }
    });
    $(document).on('keyup','input[name="password"]',function(){
//        if($('input[type="password"]').)
        var data = $('input[name="password"]').val();
//        alert(data.length);
        if(data.length)
            $('#ccs-user-profile-edit').prop('disabled',false);
        else
            $('#ccs-user-profile-edit').prop('disabled',true);
    });
    // cancel edit user profile
    $(document).on('click','#ccs-user-profile-edit-cancel',function(){
        var form = $('form[name="ccs-profile-update-form"]');
        
        hide_profile_edit_input();
    });
    // trigger for activating file type input
    
    $(document).on('click','#ccs-profile-picture-dropdown > .dropdown-menu > li a.upload, .gallery-caption button',function(){
        $('.ccs-change-profile-picture input[type="file"]').click();
    });
    // change profile picture
    $(document).on('change','#ccs-profile-upload-profile-picture, #ccs-gallery-upload-profile-picture',function(){
         $(this).parent('form').submit();
//         location
    });
       
    $('form[name="ccs-profile-update-form"] input[name="email"]').focus(function(){
        $('.ccs-update-profile-email-checker').html('<i class="ic-mail"></i>');
    });
     
    $('form[name="ccs-profile-update-form"] .input-group.ccs-date .input-group-addon').click(function(){
        $('input[name="birthdate"]').focus();
    });
    
    $('#ccs-profile-picture-dropdown .dropdown-menu > li a.choose').click(function(){
        $('.ccs-avatars').removeClass('hide');
    });
    $('.ccs-avatars button.set').click(function(){
        var container = $('#slider > div > span > div.selected');
        var bg = container.attr('data-value');
//        alert(bg);
        if(container.hasClass('selected')){
            update_profile_picture(bg);
        }
        else{
            alert('You have not yet chosen.');
        }
    });
    
    $('.ccs-avatars button.cancel').click(function(){
        location.reload();
    });
    
    $('#slider > div > span > div').click(function(){
        var container = $(this).children('div');
        var bg = container.css('background-image');
        bg = bg.replace('url("','').replace('")','');
        if($('#slider > div > span > div').hasClass('selected')){
            $('#slider > div > span > div').removeClass('selected')
            $('.ccs-profile-image-container img').attr('src',bg);
            $(this).addClass('selected');
        }
        else{
            $(this).addClass('selected');
            $('.ccs-profile-image-container img').attr('src',bg);
        }
    });
    
    /*-------------------------------
    
                functions
    
    --------------------------------*/
    
    // save profile changes
//    var ajaxFileUpload = function(id){
//        if(id == "ccs-profile-upload-profile-picture"){
//            $(".ccs-user-profile-picture i.icon-spin").removeClass('hide');
//            $(".ccs-user-profile-picture img").css({ visibility: 'hidden'});
//            alert(1);
//        }
//        $.ajaxFileUpload({
//            url:'http://localhost/ccs/index.php/profile/upload',
//            secureuri:false,
//            fileElementId:id,
//            dataType: 'json',
//            success: function(data){
//                if(data.status){
//                    location.reload();
//                }
//            }
//        });
//        
//        return false;
//    }
    

    // show input fields for edit
    var show_profile_edit_input = function(){
        $('input[name="firstname"]').prop('disabled', false).css({"border-color":"rgba(0,0,0,.5)"});
        $('input[name="middlename"]').prop('disabled', false).css({"border-color":"rgba(0,0,0,.5)"});
        $('input[name="lastname"]').prop('disabled', false).css({"border-color":"rgba(0,0,0,.5)"});
        $('input[name="newpassword"]').prop('disabled', false).css({"border-color":"rgba(0,0,0,.5)"});
        $('.profile-password').removeClass('hide');
        $('input[name="password"]').prop('disabled', false).css({"border-color":"rgba(0,0,0,.5)"});
        $('input[name="birthdate"]').prop('disabled', false).prop('readonly',true).css({"border-color":"rgba(0,0,0,.5)"});
        $('input[name="email"]').prop('disabled', false).css({"border-color":"rgba(0,0,0,.5)"});
        
        $('#ccs-user-profile-edit').attr('data-hint','1').html('<i class="icon-save"></i> Save');
        $('#ccs-user-profile-edit').prop('disabled',true);
        $('#ccs-user-profile-edit-cancel').removeClass('hide');
//        $('html,body').scrollTop(0);
    }
    // hide input fields for edit
    var hide_profile_edit_input = function(){
        $('.ccs-date .input-group-addon').css({"background-color":"tranparent"});
        $('input[name="firstname"]').prop('disabled', true).css({"border-color":"transparent"}).val(firstname);
        $('input[name="middlename"]').prop('disabled', true).css({"border-color":"transparent"}).val(middlename);
        $('input[name="lastname"]').prop('disabled', true).css({"border-color":"transparent"}).val(lastname);
        $('input[name="newpassword"]').prop('disabled', true).css({"border-color":"transparent"}).val(newpassword);
        $('input[name="password"]').prop('disabled', true).css({"border-color":"transparent"}).val(password);
        $('.profile-password').addClass('hide');
        $('input[name="birthdate"]').prop('disabled', true).prop('readonly',false).css({"border-color":"transparent"}).val(birthdate);
        $('input[name="email"]').prop('disabled', true).css({"border-color":"transparent"}).val(email);
        
        $('#ccs-user-profile-edit').attr('title','Edit').attr('data-hint','0').html('<i class="icon-pencil"></i> Edit');
        $('#ccs-user-profile-edit').prop('disabled',false);
        $('#ccs-user-profile-edit-cancel').addClass('hide');
    }
    var update_profile_picture = function(data){
        $.ajax({
            type: 'POST',
            url: base_url + 'profile/update_current_profile_picture',
            data: {
                key: data
            },
            dataType: 'json',
            success: function(result){
                if(result.status)
                    location.reload();
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }
});
