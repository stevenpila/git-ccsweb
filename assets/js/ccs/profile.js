$(document).ready(function(){
    var base_url = 'http://localhost/ccsweb/';
    /*-------------------------------
    
                 events
    
    --------------------------------*/
    // toggle change prof pic button
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
    $(document).on('click','#ccs-user-profile-edit',function(){
        var form = $('form[name="ccs-profile-update-form"]');
        var hint = $(this).attr('data-hint');
        
        if(hint == 1){
            form.submit();
        }
        else{
            //show_profile_edit_input();
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
        
        //hide_profile_edit_input();
    });
    $(document).on('click','#ccs-profile-picture-dropdown .dropdown-menu > li a.delete',function(){
        var data = $(this).parent().parent().parent().attr('data-value');
//        alert(data);
        is_user_still_logged_in(function(){
            delete_profile_picture(data);
        });
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
                if(result.status){
                    Dialog('Profile picture was removed.', 'alert', true, false, function(){});
                    location.reload();
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }
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
        $('.ccs-avatars').css({
            'animation-name': 'flipInX',
            'animation-duration': '0.4s',
            'animation-fill-mode': 'both'
        });
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

    // personal information update
        var personal_validator = $('form[name="ccs-profile-personal-form"]').validate({
            debug: true,
            rules: {
                firstname: "required",
                lastname: "required",
                password: "required"
            },
            messages: {
                firstname: "",
                lastname: "",
                password: ""
            },
            onkeyup: false,
            onclick: false,
            // onfocusout: false,
            errorClass: 'ccs-error',
            highlight: function(element, errorClass, validClass){
                $(element).addClass(errorClass);
            },
            unhighlight: function(element, errorClass, validClass){
                $(element).removeClass(errorClass);
            },
            // errorPlacement: function(error, element){
            //     error.insertBefore(element);
            // },
            submitHandler: function(form){
                var data = $(form).serialize();

                is_user_still_logged_in(function(){
                    check_if_password_is_correct(data, form);
                });
            }
        });
        // var save_profile_peersonal_information_changes = function(form){
        //     var data = form.serialize();

        //     $.ajax({
        //         type: 'POST',
        //         url: base_url + 'profile/update',
        //         data: data,
        //         dataType: 'json',
        //         success: function(output){
        //             if(output.status){
        //                 alert("Profile successfully updated.");
        //                 $.ajaxSetup({ cache: false });
        //                 $('.css-profile-count-actions > ul > li:eq(2) > div.ccs-user-information').load(base_url + 'profile #ccs-profile-personal-information > form', function(){
        //                     var el = document.getElementById('ccs-profile-personal-information');

        //                     el.style.display = 'block';
        //                     $('input', el).removeAttr('disabled');
        //                     $('.ccs-date > span').addClass('hide');
        //                     $('.ccs-date > input').removeClass('hide');

        //                     validate_personal($('form[name="ccs-profile-personal-form"]'));
        //                 });
        //             }
        //             else alert('Something went wrong. Try again.');
        //         },
        //         error: function(xhr){
        //             alert(xhr.responseText);
        //         }
        //     });
        // }
//        function check_if_email_is_valid(email){
//            var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
//
//            return pattern.test(email);
//        }


        var account_validator = $('form[name="ccs-profile-account-form"]').validate({
            debug: true,
            rules: {
                password: "required",
                newpassword: {
                    required: true,
                    minlength: 6
                },
                confirmpassword: {
                    required: true,
                    minlength: 6,
                    equalTo: '#newpassword'
                }
            },
            messages: {
                password: '',
                newpassword: {
                    required: '',
                    minlength: '<b style="color: #D9534F; font-size: 10px">Mininum length is 6</b>'
                },
                confirmpassword: {
                    required: '',
                    minlength: '<b style="color: #D9534F; font-size: 10px">Mininum length is 6</b>',
                    equalTo: '<b style="color: #D9534F; font-size: 10px">Password do not match</b>'
                }
            },
            onkeyup: false,
            onclick: false,
            // onfocusout: false,
            errorClass: 'ccs-error',
            highlight: function(element, errorClass, validClass){
                $(element).addClass(errorClass);
            },
            unhighlight: function(element, errorClass, validClass){
                $(element).removeClass(errorClass);
            },
            // errorPlacement: function(error, element){
            //     error.insertBefore(element);
            // },
            submitHandler: function(form){
                var data = $(form).serialize();

                is_user_still_logged_in(function(){
                    check_if_password_is_correct(data, form);
                });
            }
        });
        
        var email_validator = $('form[name="ccs-profile-email-form"]').validate({
            debug: true,
            rules: {
                newemail: {
                    required: true,
                    email: true
                },
                password: 'required',
            },
            messages: {
                newemail: {
                    required: '',
                    email: '<b style="color: #D9534F; font-size: 10px">Invalid email</b>'
                },
                password: '',
            },
            onkeyup: false,
            onclick: false,
            // onfocusout: false,
            errorClass: 'ccs-error',
            highlight: function(element, errorClass, validClass){
                $(element).addClass(errorClass);
            },
            unhighlight: function(element, errorClass, validClass){
                $(element).removeClass(errorClass);
            },
            // errorPlacement: function(error, element){
            //     error.insertBefore(element);
            // },
            submitHandler: function(form){
                var data = $(form).serialize();

                is_user_still_logged_in(function(){
                    check_if_password_is_correct(data, form);
                });
            }
        });
    
        var check_if_password_is_correct = function(data, form){
            $.ajax({
                type: 'POST',
                url: base_url + 'profile/check_if_password_is_correct',
                data: data,
                dataType: 'json',
                success: function(output){
                    if(output.status){
                        form.submit();
                        // save_profile_peersonal_information_changes(form);
                    }
                    else{
                        Dialog('Password is incorrect.', 'alert', true, false, function(){});
                        // alert('Password is incorrect.');
                    }
                },
                error: function(xhr){
                    alert(xhr.responseText);
                }
            });
        }
    
    $('.css-profile-count-actions > ul > li > a').click(function(e){
        var content = $(this).siblings('.ccs-user-information'),
            el = $(this);

        // reset_accordion();

        if(el.hasClass('active')){
            content.slideUp();
            el.removeClass('active');
        }else{
            reset_accordion();

            $('input', el.parent()).removeAttr('disabled');
            $('.ccs-date > span').addClass('hide');
            $('.ccs-date > input').removeClass('hide');

            content.slideDown();
            el.addClass('active');
        }

        $('.ccs-user-information', el.parent()).promise().done(function(){
            var t = el.parent().offset().top - 50;

            $('html, body').animate({
                scrollTop: t + 'px'
            },'slow');
            if(el.hasClass('active')) $('.ccs-user-information input:eq(0)', el.parent()).focus();
            else{
                $('.ccs-user-information label.ccs-error').remove();
                $('.ccs-user-information input', el.parent()).prop('disabled',true).removeClass('ccs-error');
                $('.ccs-user-information button[type="reset"]', el.parent()).click();

                // personal_validator.resetForm();
                // account_validator.resetForm();
                // email_validator.resetForm();

                $('.ccs-date > span').removeClass('hide');
                $('.ccs-date > input').addClass('hide');
            } 
        });
        

        e.preventDefault();
    });

    function reset_accordion(){
        var el = $('.css-profile-count-actions > ul > li > a.active'),
            par = el.parent();

        el.removeClass('active');
        $('> div.ccs-user-information', par).slideUp();

        $('> div.ccs-user-information', par).promise().done(function(){
            $('label.ccs-error').remove();
            $('input', this).prop('disabled',true).removeClass('ccs-error');
            $('button[type="reset"]', this).click();

            // personal_validator.resetForm();
            // account_validator.resetForm();
            // email_validator.resetForm();

            $('.ccs-date > span', this).removeClass('hide');
            $('.ccs-date > input', this).addClass('hide');
        });
    }

    $('form[name="ccs-profile-company-form"]').validate({
            debug: true,
            rules: {
                cname: "required",
                caddress: "required",
                cemail: {
                    required: true,
                    email: true
                },
                cwebsite: "required",
                cnumber: "required",
                cposition: "required",
                password: 'required',
            },
            messages: {
                cname: "",
                caddress: "",
                cemail: {
                    required: '',
                    email: '<b style="color: #D9534F; font-size: 10px">Invalid email</b>'
                },
                cwebsite: "",
                cnumber: "",
                cposition: "",
                password: '',
            },
            onkeyup: false,
            onclick: false,
            // onfocusout: false,
            errorClass: 'ccs-error',
            highlight: function(element, errorClass, validClass){
                $(element).addClass(errorClass);
            },
            unhighlight: function(element, errorClass, validClass){
                $(element).removeClass(errorClass);
            },
            // errorPlacement: function(error, element){
            //     error.insertBefore(element);
            // },
            submitHandler: function(form){
                var data = $(form).serialize();

                is_user_still_logged_in(function(){
                    check_if_password_is_correct(data, form);
                });
            }
        });

    $('.edit-profile-company-btn').click(function(){
        var form = $('form[name="ccs-profile-company-form"]');
        if($(this).siblings('button.cancel-edit-profile-company-btn').hasClass('hide')){
            $('input', form).removeAttr('disabled');
            $('.ccs-password', form).removeClass('hide');
            $('input:eq(0)', form).focus();
            $(this).attr('type','submit').html('<i class="icon-ok"></i> Submit');

            $(this).siblings('button.cancel-edit-profile-company-btn').removeClass('hide');
        }
    });
    $('.cancel-edit-profile-company-btn').click(function(e){
        $(this).siblings('button.edit-profile-company-btn').attr('type','button').html('<i class="ic-pencil2"></i> Edit');
        $(this).addClass('hide');
        $('form[name="ccs-profile-company-form"] input').prop('disabled',true);
        $('form[name="ccs-profile-company-form"] .ccs-password').addClass('hide');
        document.getElementById('ccs-profile-company-form-id').reset();

        e.preventDefault();
    });

    
    /*-------------------------------
    
                functions
    
    --------------------------------*/
    var update_profile_picture = function(data){
        url = 'http://localhost/ccsweb/profile/';
        $.ajax({
            type: 'POST',
            url: base_url + 'profile/update_current_profile_picture',
            data: {
                key: data
            },
            dataType: 'json',
            success: function(result){
                if(result.status){
                    Dialog('Profile picture has been successfully updated.', 'alert', true, false, function(){});
                    location.reload();
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }
});
