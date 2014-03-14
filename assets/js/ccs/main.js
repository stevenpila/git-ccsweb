var base_url = 'http://localhost/ccsweb/';

function is_user_still_logged_in(callback){
    $.ajax({
        url: base_url + 'account/is_logged_in',
        dataType: 'json',
        success: function(output){
            if(output.status == 1){
                callback();
            }
            else{
                alert("You're not logged in anymore. You will be redirected to the login page.");
                document.location = base_url;
            }
        },
        error: function(xhr){
            alert(xhr.responseText);
        }
    });
}

var W3CDOM = (document.createElement && document.getElementsByTagName);

function initFileUploads() {
    if (!W3CDOM) return;
    var fakeFileUpload = document.createElement('div');
    fakeFileUpload.className = 'ccs-replace-upload';
    var icon = document.createElement('i');
    icon.className = 'ic-paperclip';
    fakeFileUpload.appendChild(icon);
    var input = document.createElement('input');
    input.setAttribute('disabled','true');
    input.setAttribute('style','text-align: center');
    fakeFileUpload.appendChild(input);
    var x = document.getElementsByTagName('input');
    for(var i=0;i<x.length;i++) {
        if(x[i].type == 'file' && x[i].parentNode.className == 'ccs-hide-upload'){
            var clone = fakeFileUpload.cloneNode(true);
            x[i].parentNode.appendChild(clone);
            x[i].relatedElement = clone.getElementsByTagName('input')[0];
            x[i].relatedElement.value = x[i].value;
            x[i].setAttribute('title', x[i].value);
            x[i].onchange = x[i].onmouseout = function () {
                this.relatedElement.value = this.value;
                this.relatedElement.setAttribute('title', this.value);
            }
        }
    }
}

function validate_file_attachments(file, callback){
    var reader = new FileReader();
    var allowed_types = ['JPEG','JPG','PNG','BMP','GIF','XLS','XLSX','PDF','DOCX','DOC','ZIP','RAR','7ZIP','ODT','TXT','CSV','PPT','PPTX','GZ'];
    var flag = false;

    // reader.readAsDataURL(file);
    //reader.onload = function(_file){
        var name = file.name,
            type = name.split('.')[name.split('.').length - 1].toUpperCase();
            size = ~~(file.size/1024);

        if(allowed_types.indexOf(type) > -1) flag = true;

        if(!flag || size > 10000){
            callback();
        }
    //}
}

function Dialog(text, type, backevent, value, callback){
    var el = $('.dialog-layout'),
        overlay = $('.overlay-bg-layout'),
        alert = '<button id="btn-del-layout" class="btn btn-success" tabindex="1"><i class="icon-ok"></i></button>',
        confirm = '<button id="btn-del-layout" class="btn btn-success" tabindex="1"><i class="icon-ok"></i></button>\n\
            <button id="btn-cancel-layout" class="btn btn-danger" tabindex=1><i class="glyphicon glyphicon-remove"></i></button>',
        prompt = '<br/><input type="text" name="dialog_input" class="input" tabindex="1" style="border:none;border-bottom:1px solid #ddd;margin: 8px 0 10px 0; padding: 5px 0" value="' + value + '"/>\n\
            <button id="btn-del-layout" class="btn btn-success" tabindex="2" style="margin-top: -7px"><i class="glyphicon glyphicon-ok"></i></button>\n\
            <button id="btn-cancel-layout" class="btn btn-danger" tabindex="3" style="margin-top: -7px"><i class="glyphicon glyphicon-remove"></i></button>';

    el.html(text + ' ');
    overlay.attr('data-close', backevent);
    $('input, a, button, textarea, select', document).attr('tabindex','-1');
    
    if(type === 'alert'){
        $(alert).appendTo(el);

        $('button', el).focus();
        $('button', el).click(function(){
            overlay.hide();
            el.html('');
            el.hide();

            // callback();
            $('input, a, button, textarea, select', document).removeAttr('tabindex');
        });
    }
    else if(type === 'confirm'){
        $(confirm).appendTo(el);

        $('button:eq(0)', el).click(function(){
            overlay.hide();
            el.html('');
            el.hide();

            $('input, a, button, textarea, select', document).removeAttr('tabindex');
            callback();
        });
        $('button:eq(1)', el).click(function(){
            overlay.hide();
            el.html('');
            el.hide();

            $('input, a, button, textarea, select', document).removeAttr('tabindex');
        });
    }
    else if(type === 'prompt'){
        $(prompt).appendTo(el);

        $('button:eq(0)', el).click(function(){
            var value = $('input:eq(0)', el).val();
                value = strip_tags(value);
                value = $.trim(value);

            overlay.hide(); 
            el.html('');
            el.hide();

            $('input, a, button, textarea, select', document).removeAttr('tabindex');
            callback(value);
        });
        $('button:eq(1)', el).click(function(){
            overlay.hide(); 
            el.html('');
            el.hide();

            $('input, a, button, textarea, select', document).removeAttr('tabindex');
        });
    }

    overlay.show();
    overlay.promise().done(function(){
        el.css({
            left: '50%',
            marginLeft: '-' + (el.width() / 2) + 'px'
        }).slideDown('fast');

        el.promise().done(function(){
            if($('input:eq(0)', el).length) $('input:eq(0)', el).focus().select();
            else $('button:eq(0)', el).focus();
        });
    });

    if(backevent === true){
        overlay.click(function(){
            $(this).hide();
            el.hide();
        });
    }
}

$(document).on('keypress','.dialog-layout > input:eq(0)', function(e){
    var el = $('.dialog-layout');
    
    if(e.keyCode == 13) $('button:eq(0)', el).click();
});

// $(document).on('blur','.dialog-layout > button:eq(0)', function(e){
// 	var el = $('.dialog-layout');
	
// 	if($('button:eq(1)', el).length) $('button:eq(1)', el).focus();
// 	else setTimeout(function(){ $('button:eq(0)', el).focus(); }, 10);
// });

// $(document).on('blur','.dialog-layout > button:eq(1)', function(e){
// 	var el = $('.dialog-layout');
	
// 	if($('input:eq(0)', el).length) $('input:eq(0)', el).focus();
// 	else if($('button:eq(0)', el).length) $('button:eq(0)', el).focus(); 
// 	else setTimeout(function(){ $('button:eq(1)', el).focus(); }, 10);
// });

// $(document).on('blur','.dialog-layout > input:eq(0)', function(e){
// 	var el = $('.dialog-layout');
	
// 	$('button:eq(0)', el).focus();
// });

// $(document).on('click','.dialog-layout > input:eq(0)', function(e){
//     $(this).focus();
// });

$(document).ready(function(){
    var base_url = 'http://localhost/ccsweb/';

    $('.fb-share-button').click(function(e){
        var current_url = $(this).attr('href'), 
            sharer_url = 'https://www.facebook.com/sharer/sharer.php?u=';

        current_url = current_url.replace('localhost','127.0.0.1');                
        window.open(sharer_url + current_url, "Share on Facebook", "width=675, height=300, scrollbars=yes");
        e.preventDefault();
      });

    $(document).keypress(function(e){
        var el = $('.dialog-layout'),
            overlay = $('.overlay-bg-layout');

        if(e.keyCode == 27 && overlay.attr('data-close') == 'true'){
        //if(e.keyCode == 27){
            if($('.overlay-bg-layout').css('display') == 'block'){
                el.html('');
                el.hide();
                overlay.hide();
            }
        }
    });

    //Dialog('YEAH?','prompt',false,'hehe',function(e){ alert(e); });
    /*-------------------------------
    
                  events
    
    --------------------------------*/
    
    // logout to moodle
    $('.ccs-logout').click(function(e){
        var user_type = $(this).attr('data-user-type');
        
        if(user_type == 4 || user_type == 6)
            show_modal_logout_to_moodle();
        else
            document.location = base_url + 'account/logout';
        
        e.preventDefault();
    });
    
    // submit sign in form and check if user wants to sign in to moodle also or not
    $('.ccs-sign-in-form button[type="submit"]').click(function(e){
        var data = $('form[name="sign_in"]').serialize();
            
        if($('#ccs-moodle-login-checkbox').parent('div').attr('aria-checked') == "true"){
            $('#ccs-sign-in-moodle-checker').modal({
                keyboard: false,
                backdrop: 'static'
            });
            
            check_if_account_is_valid_in_moodle(data);

            e.preventDefault();
        }
    });
    
    // submit sign up form if valid
    $('.ccs-sign-up-form button[type="submit"]').click(function(e){
        e.preventDefault();
        
        var group = $('.ccs-sign-up-form');
        
        if($('form', group).valid()){ 
            $('.ccs-sign-up-fields .scroller-content', group).animate({ scrollTop: 0 }, function(){
                $('form', group).submit();
            });
        }
    });
    $('.ccs-sign-in-form form').validate({
        debug: true,
        rules: {
            username: "required",
            password: "required"
        },
        messages: {
            username: "",
            password: ""
        },
        onkeyup: false,
        onclick: false,
//        onfocusout: false,
        focusInvalid: false,
        errorClass: 'ccs-error',
//        validClass: 'ccs-valid',
        highlight: function(element, errorClass, validClass){
            $(element).addClass(errorClass);
        },
        unhighlight: function(element, errorClass, validClass){
            $(element).removeClass(errorClass);
            
            //$(element).parent('div').parent('div').children('label').addClass('hide');
        },
        errorPlacement: function(error, element){
            //error.insertBefore(element);
        },
//        success: function(label){
//            label.css({
//                'padding': '2px 4px 2px 3px',
//                'border-color': '#22bd00',
//                'border-top-color': '#66AFE9',
//                'background': '#dff0d8',
//                'color': '#468847'
//            });
//            label.html("<i class='icon-ok'></i>");
//        },
        submitHandler: function(form){
            form.submit();
        }
    });
    
    //validate sign up form
    $('.ccs-sign-up-form form').validate({
        debug: true,
        ignore: "",
        rules: {
            first_name: "required",
            last_name: "required",
            email: {
                required: true,
                email: true
            },
            secret_question: "required",
            secret_answer: "required",
            username: "required",
            password: {
                required: true,
                minlength: 6
            },
            confirm_password: {
                required: true,
                equalTo: "#ccs-sign-up-password"
            },
            company_name: "required",
            company_address: "required",
            company_email: {
                required: true,
                email: true
            },
            company_website: "required",
            company_contact_number: "required",
            company_position: "required",
            service_type: "required",
            company_service_type: "required",
            user_type: "required"
        },
        messages: {
            first_name: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
            last_name: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
            email: {
                required: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
                email: "<b style='margin-left: 4px'>Invalid email<b><i class='glyphicon glyphicon-asterisk pull-right'></i>"
            },
            secret_question: "",
            secret_answer: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
            username: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
            password: {
                required: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
                minlength: "<b style='margin-left: 4px'>Min length is 6 characters<b><i class='glyphicon glyphicon-asterisk pull-right'></i>"
            },
            confirm_password: {
                required: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
                equalTo: "<b style='margin-left: 4px'>Passwords do not matched<b><i class='glyphicon glyphicon-asterisk pull-right'></i>"
            },
            company_name: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
            company_address: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
            company_email: {
                required: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
                email: "<b style='margin-left: 4px'>Invalid email<b><i class='glyphicon glyphicon-asterisk pull-right'></i>"
            },
            company_website: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
            company_contact_number: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
            company_position: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
            service_type: "",
            company_service_type: "",
            user_type: ""
        },
        onkeyup: false,
        onclick: false,
//        onfocusout: false,
        focusInvalid: false,
        errorClass: 'ccs-error',
//        validClass: 'ccs-valid',
        highlight: function(element, errorClass, validClass){
            var name = $(element).attr('name');
            
            if(name == 'user_type' || name == 'secret_question' || name == 'service_type' || name == 'company_service_type') $(element).parent('div').addClass('ccs-error');
            else $(element).addClass(errorClass);
        },
        unhighlight: function(element, errorClass, validClass){
            $(element).removeClass(errorClass);
            
            //$(element).parent('div').parent('div').children('label').addClass('hide');
        },
        errorPlacement: function(error, element){
            var name = $(element).attr('name');
                
            if(name == 'user_type' || name == 'secret_question' || name == 'service_type' || name == 'company_service_type') $(element).parent('div').parent('div').children('label').removeClass('hide');
            else error.insertBefore(element);
        },
//        success: function(label){
//            label.css({
//                'padding': '2px 4px 2px 3px',
//                'border-color': '#22bd00',
//                'border-top-color': '#66AFE9',
//                'background': '#dff0d8',
//                'color': '#468847'
//            });
//            label.html("<i class='icon-ok'></i>");
//        },
        submitHandler: function(form){
            var data = $('.ccs-sign-up-form form').serialize();
            
            is_username_available(data, form);
        }
    });
    
    // reset username and email textbox preloader to original state
    $('#ccs-sign-up-username').focus(function(){
        $(this).removeClass('ccs-not-available');
        $('.ccs-sign-up-username-checker').addClass('ccs-hidden').removeClass('username-not-ok').removeClass('username-ok');
        $('.ccs-sign-up-username-checker').html("<i class='icon-spinner icon-spin'></i>");
    });
    $('#ccs-sign-up-email').focus(function(){
        $(this).removeClass('ccs-not-available');
        $('.ccs-sign-up-email-checker').addClass('ccs-hidden').removeClass('email-not-ok').removeClass('email-ok');
        $('.ccs-sign-up-email-checker').html("<i class='icon-spinner icon-spin'></i>");
    });
    
    // submit captcha word
    $(document).on('click','#ccs-captcha-word-submit',function(){
        var modal = $('#ccs-captcha-modal'),
            word = $('input[name="captcha"]', modal).val();

        if(!(/\S/g).test(word)){
            modal.find('label.ccs-error').removeClass('hide');
            modal.find('input[name="captcha"]').addClass('ccs-error');
        }
        else{
            modal.find('label.ccs-error').addClass('hide');
            modal.find('input[name="captcha"]').removeClass('ccs-error');

            check_if_captcha_is_valid(modal);
        }
    });
    
    $('#ccs-captcha-word-refresh').click(function(){
        var btn = $(this);

        btn.attr('onclick','return false').addClass('disabled');
        $('#ccs-captcha-modal .modal-body > .col-md-12 > span > span').load(base_url + 'account #ccs-captcha-container > img, #ccs-captcha-container > input', function(){
            btn.removeAttr('onclick').removeClass('disabled');
        });
    });
    
    /*-------------------------------
    
                functions
    
    --------------------------------*/
    
    // check if username and email are available
    var is_username_available = function(data, form){
        $.ajax({
            type: 'POST',
            url: base_url + 'account/is_username_available',
            data: data,
            dataType: 'json',
            beforeSend: function(){
                // ajax loader
                $('.ccs-sign-up-username-checker').removeClass('ccs-hidden');
            },
            success: function(output){
                if(output.status){
                    // show not available
                    var group = $('.ccs-sign-up-username-checker').parent('div');
                    
                    $('.ccs-sign-up-username-checker').addClass('username-not-ok');
                    $('.ccs-sign-up-username-checker').html("<b style='margin-left: 5px'>Username not available</b><i class='glyphicon glyphicon-remove'></i>");
                    $('input', group).addClass('ccs-not-available');
                }
                else{
                    // show available
                    $('.ccs-sign-up-username-checker').addClass('username-ok');
                    $('.ccs-sign-up-username-checker').html("<b style='margin-left: 5px'>Username available</b><i class='glyphicon glyphicon-ok'></i>");
                    
                    //show captcha
                    $('#ccs-captcha-modal .modal-body > .col-md-12 > span > span').load(base_url + 'account #ccs-captcha-container > img, #ccs-captcha-container > input', function(){  
                        $('#ccs-captcha-modal').modal({
                            backdrop: 'static'
                        });
                        $('#ccs-captcha-modal').on('shown.bs.modal', function(){
                            $(this).find('input').focus();
                        });
                    });
                    // form.submit();
                }
            }
        });
    }

    // check if captcha is valid
    var check_if_captcha_is_valid = function(form){
        var word = $('input[name="captcha"]', form).val(),
            word_id = $('input[name="captcha_id"]', form).val();

        $.ajax({
            type: 'POST',
            url: base_url  + 'account/verify_captcha_and_topic',
            data: {
                captcha: word,
                captcha_id: word_id
            },
            dataType: 'json',
            beforeSend: function(){
                form.find('label.ccs-error').removeClass('hide').addClass('captcha-loader');
                form.find('label.ccs-error').html('<i class="icon-spinner icon-spin pull-right"></i>');
            },
            success: function(output){
                if(output.status){
                    form.find('input').removeClass('ccs-error');
                    $('#ccs-captcha-checker').val('1');
                    
                    setTimeout(function(){ document.sign_up.submit(); }, 100);
                }
                else{
                    form.find('input').addClass('ccs-error');
                    form.find('label.ccs-error').removeClass('captcha-loader');
                    form.find('label.ccs-error').addClass('ccs-error');
                    form.find('label.ccs-error').html('<b style="margin-left: 4px">Invalid captcha<b> <i class="icon-asterisk pull-right"></i>');
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }
    
    // show sign up form for company user type
    var show_sign_up_company_form = function(){
        var group = $('.ccs-sign-up-form');
        
        $('input[name="company_form"]', group).val(2);
        $('.ccs-sign-up-company-form input', group).removeAttr('disabled');
        $('.ccs-sign-up-company-form', group).removeClass('hide');
        
        $('.ccs-sign-up-fields .scroller-content', group).animate({scrollTop: $(this).scrollTop() + $('.ccs-sign-up-company-form', group).height()},500);

        $('.ccs-sign-up-fields', group).scroller('reset');
    }
    
    // hide sign up form for company user type
    var hide_sign_up_company_form = function(){
        var group = $('.ccs-sign-up-form');
        
        $('input[name="company_form"]', group).val(1);
        $('.ccs-sign-up-fields .scroller-content', group).css({ scrollTop: 0 });
        $('.ccs-sign-up-company-form', group).addClass('hide');
        $('.ccs-sign-up-company-form input', group).attr('disabled',true);
        
        $('label.ccs-error', group).hide();
        $('label.ccs-error-left', group).addClass('hide');
        $('input, div', group).removeClass('ccs-error');
        
        $('.ccs-sign-up-fields', group).scroller('reset');
    }
    
    // show sevrice type for administrator user type
    var show_select_tag_for_services = function(active, height){
        var group = $('.ccs-sign-up-form');
        
        $('input[name="service_form"]', group).val(2);
        
        $('.ccs-sign-up-service-form', group).removeClass('hide');
        $('.ccs-sign-up-service-form input', group).removeAttr('disabled');
        
        if(!active) $('.ccs-sign-up-fields .scroller-content', group).animate({scrollTop: $(this).scrollTop() + $('.ccs-sign-up-service-form', group).height() + height},500);
        else $('.ccs-sign-up-fields .scroller-content', group).animate({scrollTop: $(this).scrollTop() +  height},500);
        
        $('.ccs-sign-up-fields', group).scroller('reset');
    }
    
    // hide sevrice type for administrator user type
    var hide_select_tag_for_services = function(){
        var group = $('.ccs-sign-up-form');
        
        $('input[name="service_form"]', group).val(1);
        $('.ccs-sign-up-fields .scroller-content', group).css({ scrollTop: 0 });
        $('.ccs-sign-up-service-form', group).addClass('hide');
        $('.ccs-sign-up-service-form input', group).attr('disabled',true);
        
        $('label.ccs-error', group).hide();
        $('label.ccs-error-left', group).addClass('hide');
        $('input, div', group).removeClass('ccs-error');
        
        $('.ccs-sign-up-fields', group).scroller('reset');
    }
    
    // check if username and password is valid in moodle table
    var check_if_account_is_valid_in_moodle = function(data){
        $.ajax({
            type: 'POST',
            url: base_url + 'account/ajax_moodle_login',
            data: data,
            dataType: 'json',
//            beforeSend: function(){
//                $('.ccs-sign-in-loader').css('visibility','visible'); // optional
//            },
            success: function(output){
                var group1 = $('#ccs-sign-in-moodle-checker .first');
                var group2 = $('#ccs-sign-in-moodle-checker .second');
                
                if(output.status == 1){
                    group1.css({
                        background: '#5cb85c',
                        color: '#fff'
                    });
                    $('div', group1).hide();
                    $('i', group1).removeClass('hide').addClass('glyphicon-ok');
                    
                    group2.removeClass('ccs-hidden');
                    
                    check_moodle_if_logged_in(data, group2);
                }
                else{
                    group1.css({
                        background: '#d9534f',
                        color: '#fff'
                    });
                    $('div', group1).hide();
                    $('i', group1).removeClass('hide').addClass('glyphicon-remove');
                    
                    group2.html('Submitting form for CCS Website<div class="ccs-sign-in-loader pull-right"></div>');
                    group2.removeClass('ccs-hidden');
                    
                    setTimeout(function(){
                        $('form[name="sign_in"]').submit();
                    }, 500);
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }
    
    // sign in to moodle
    var sign_in_to_moodle = function(data){
        $.ajax({
            type: 'POST',
            url: 'http://localhost/moodle/login/index.php',
            data: data,
//            beforeSend: function(){
//                var group3 = $('#ccs-sign-in-moodle-checker .third'); // optional
//                group3.removeClass('ccs-hidden');
//            },
            success: function(){
                var group2 = $('#ccs-sign-in-moodle-checker .second');
                group2.css({
                    background: '#5cb85c',
                    color: '#fff'
                });
                $('div', group2).hide();
                $('i', group2).removeClass('hide').addClass('glyphicon-ok');
                
                var group3 = $('#ccs-sign-in-moodle-checker .third');
                group3.removeClass('ccs-hidden');
                
                setTimeout(function(){
                    $('form[name="sign_in"]').submit();
                }, 1000);
            },
            error: function(xhr){
                 alert(xhr.responseText);
            }
        });
    }
    
    /*-------------------------------
    
            captcha functions
    
    --------------------------------*/
    
    // show captcha modal
    var show_captcha_modal = function(){
        $('#ccs-captcha-modal .modal-body').load(base_url + 'account/get_captcha', function(){
           $('#ccs-captcha-modal').modal({
               backdrop: 'static'
           });
           $('#ccs-captcha-modal').on('shown.bs.modal', function () {
                $('form[name="ccs-captcha-form"] input').focus();
           });
        });
    }
    
    /*-------------------------------
    
            logout to moodle
    
    --------------------------------*/
    
    // show modal logout to moodle
    var show_modal_logout_to_moodle = function(){
        $('.ccs-sign-out-checker-container').modal({
            keyboard: false,
            backdrop: 'static'
        });
        $('.ccs-sign-out-checker-container').on('shown.bs.modal', function () {
            var ans = confirm("Do you want to logout also to Moodle?");


            if(ans){
                logout_to_moodle(function(){ document.location = base_url + 'account/logout'; });
            }
            else{
                var group = $('.ccs-sign-out-checker-container .first');
                var group2 = $('.ccs-sign-out-checker-container .second');
                $('div', group).addClass('hide');
                $('i', group).removeClass('hide').addClass('glyphicon-remove');
                group.css({
                    background: '#d9534f',
                    color: '#fff'
                });
                group2.removeClass('ccs-hidden');
                
                document.location = base_url + 'account/logout';
            }
        });
    }
    
    // logout to moodle
    var logout_to_moodle = function(callback){
        $('.ccs-moodle-logout-container').load('http://localhost/moodle/login/index.php #ccs-moodle-logout-sesskey',function(){
            var value = $('.ccs-moodle-logout-container input').val();
            $.get('http://localhost/moodle/login/logout.php',{ sesskey: value },function(){
                setTimeout(function(){
                    callback();
                },100);
            });
        });
    }
    
    // check if moodle is still logged in, if login, will logout then sign in else sign in immediately
    var check_moodle_if_logged_in = function(data, group2){
        $('.ccs-moodle-logout-container').load('http://localhost/moodle/login/index.php #ccs-moodle-logout-session',function(){
            var value = $('.ccs-moodle-logout-container input').val();
            $.post(base_url + 'account/check_moodle',{ moodlesession: value },function(output){
                if(output != 0){
                    $('span',group2).html('Signing out <b style="color:#aaa"><i class="glyphicon glyphicon-play" style="margin: 0 0 0 2px"></i> Signing in to Moodle</b>'); 
                    logout_to_moodle(function(){
                        $('span',group2).html('Signing out <i class="glyphicon glyphicon-play" style="margin: 0 0 0 2px"></i> Signing in to Moodle');
                        sign_in_to_moodle(data);
                    });
                }
                else{
                    sign_in_to_moodle(data);
                }
            });
        });
    }
    
    /*-------------------------------
    
           customized dropdown
    
    --------------------------------*/
    
    function DropDown(el) {
        this.dd = el;
        this.placeholder = this.dd.children('span');
        this.opts = this.dd.find('ul.dropdown > li');
        this.val = '';
        this.index = -1;
        this.initEvents();
    }
    DropDown.prototype = {
        initEvents : function() {
            var obj = this;

            obj.dd.on('click', function(e){
                var dd = $(this);
                
                if(dd.hasClass('company-sign-up-dropdown')){
                    if(!e.shiftKey){
                        $(this).toggleClass('active');
                        $(this.opts).toggleClass('active');
                    }
                }
                else{
                  $(this).toggleClass('active');
                  $(this.opts).toggleClass('active');
                }
                return false;
            });
            
            obj.opts.on('click', function(e){
                  var opt = $(this);
                  var value = opt.attr('data-value');
                  obj.val = opt.text();
                  obj.index = opt.index();
                  
                  if(obj.dd.hasClass('sign-up-dropdown')){
                    $('input', obj.dd).val(value);
                    
                    $('ul > li', obj.dd).each(function(){
                        $(this).removeClass('selected-item');
                    });
                    
                    opt.addClass('selected-item');
                    obj.placeholder.text("Sign up as:  " + obj.val);
                    
                    if(value == 2){
                        hide_sign_up_company_form();
                        show_select_tag_for_services(false,0);
                    }
                    else if(value == 3){
                        hide_select_tag_for_services();
                        show_sign_up_company_form();
                    }
                    else{
                        hide_sign_up_company_form();
                        hide_select_tag_for_services();
                    }
                    
                    $('#dd').parent('div').children('label').addClass('hide');
                    $('#dd').removeClass('ccs-error');
                  }
                  else if(obj.dd.hasClass('company-sign-up-dropdown')){
                      if(e.shiftKey){
                          if(!opt.hasClass('selected-item')){
                            opt.addClass('selected-item');
                            
                            if(obj.placeholder.text() == "Service Type"){
                                $('input', obj.dd).val(value);
                                obj.placeholder.text(obj.val);
                            }
                            else{
                                $('input', obj.dd).val($('input', obj.dd).val() + ',' + value);
                                obj.placeholder.text(obj.placeholder.text() + ',' + obj.val);
                            }
                            
                            $('#cst').parent('div').children('label').addClass('hide');
                            $('#cst').removeClass('ccs-error');
                          }else{
                            var text = obj.placeholder.text(), val = $('input', obj.dd).val();
                            var text_split = text.split(','), val_split = val.split(',');
                            var text_new = new Array(), val_new = new Array();
                            
                            for(var i = 0; i < text_split.length ; i++){
                                if(text_split[i] != obj.val){
                                    text_new.push(text_split[i]);
                                }
                            }
                            for(var i = 0; i < val_split.length ; i++){
                                if(val_split[i] != value){
                                    val_new.push(val_split[i]);
                                }
                            }
                            
                            if(text_new.length < 1){
                                $('#cst').parent('div').children('label').removeClass('hide');
                                $('#cst').addClass('ccs-error');
                                
                                obj.placeholder.text("Service Type");
                                $('input', obj.dd).val("");
                            }
                            else{
                                obj.placeholder.text(text_new.join(','));
                                $('input', obj.dd).val(val_new.join(','));
                            }
                            
                            opt.removeClass('selected-item');
                          }
                      }
                      else{
                          $('#cst').parent('div').children('label').addClass('hide');
                          $('#cst').removeClass('ccs-error');
                          
                          $('input', obj.dd).val(value);
                          
                          $('ul > li', obj.dd).each(function(){
                              $(this).removeClass('selected-item');
                          });
                          
                          opt.addClass('selected-item');
                          
                          obj.placeholder.text(obj.val);
                      }
                  }
                  else{
                    if(obj.dd.hasClass('secret-question-dropdown')){
                        $('#sq').parent('div').children('label').addClass('hide');
                        $('#sq').removeClass('ccs-error');
                    }
                    else if(obj.dd.hasClass('service-type-dropdown')){
                        $('#st').parent('div').children('label').addClass('hide');
                        $('#st').removeClass('ccs-error');
                    }
                    
                    $('input', obj.dd).val(value);
                    
                    $('ul > li', obj.dd).each(function(){
                        $(this).removeClass('selected-item');
                    });
                    
                    opt.addClass('selected-item');
                      
                    obj.placeholder.text(obj.val);
                  }
                  //if(e.shiftKey) alert(1);
            });
        },
        getValue : function() {
            return this.val;
        },
        getIndex : function() {
            return this.index;
        }
    }
    // initialize dropdown
    $(function() {
        var dd = new DropDown( $('#dd') );
        var sq = new DropDown( $('#sq') );
        var st = new DropDown( $('#st') );
        var cst = new DropDown( $('#cst') );

        $(document).click(function() {
            // all dropdowns
            $('.wrapper-dropdown-1').removeClass('active');
        });
    });
    // for user type dropdown
    $('#dd').click(function(){
        $('#sq').removeClass('active');
        $('#st').removeClass('active');
        $('#cst').removeClass('active');
    });
    // for select secret question dropdown
    $('#sq').click(function(){
        $('#dd').removeClass('active');
        $('#st').removeClass('active');
        $('#cst').removeClass('active');
    });
    // for service type dropdown (administrator)
    $('#st').click(function(){
        var group = $('.ccs-sign-up-form');

        $('#sq').removeClass('active');
        $('#dd').removeClass('active');
        $('#cst').removeClass('active');
        if(!$(this).hasClass('active')) show_select_tag_for_services(true,$(this).position().top);
        else $('.ccs-sign-up-fields .scroller-content', group).scrollTop(50);
    });
    // for service type dropdown (employee)
    $('#cst').click(function(){
        $('#dd').removeClass('active');
        $('#st').removeClass('active');
        $('#sq').removeClass('active');
    });
    
}); //end of ready function

function strip_tags(input, allowed){
    allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
        commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
    return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
        return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
    });
}