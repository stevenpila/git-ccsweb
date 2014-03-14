$(document).ready(function(){
    var base_url = 'http://localhost/ccsweb/';

    initFileUploads();
         
    $('.ccs-add-another-attachment').click(function(){
        $('<span class="ccs-hide-upload">\n\
            <i class="icon-minus-sign-alt"></i>\n\
            <input type="file" name="userfile[]" style="color: #222; text-align: center">\n\
            </span>').insertBefore(this);
        initFileUploads();
    });

    $('.ccs-button-post > button[type="button"]').click(function(){
        $('.ccs-content-container .ccs-add-new-forum-announcement-form').slideUp();
    });

    $(document).on('click','.ccs-no-available-create-post',function(e){
        $('.ccs-content-container .ccs-add-new-forum-announcement-form').slideDown(function(){
            $('input', this).first().focus();
        });

        e.preventDefault();
    });
    $('.ccs-announcement-add-new > a').click(function(){

        $('.ccs-add-new-forum-announcement-form').slideToggle(function(){
            $('input', this).first().focus();
        });
    });
    
    //collapse or uncollapse thread content
    $('.ccs-announcement-see-more').click(function(){
        see_more_announcement_details($(this));

    });

    function see_more_announcement_details(el){
        var par = el.parents('.ccs-announcement-media');

        $('.media-body p.ccs-announcement-detail', par).slideToggle();
        $('.media-body .ccs-media-attachments', par).slideToggle();

        if(par.index() == $('.ccs-announcement-media').last().index()){
            $('html, body').animate({
                scrollTop: $(document).height() + 'px'
            });
        }
    }
    
    // trigger delete announcement
    $('.ccs-announcement-delete').click(function(e){
        var value = $(this).parent('ul').attr('data-value');
        
        Dialog('Are you sure to delete this thread?', 'confirm', false, false, function(){
            is_user_still_logged_in(function(){
                delete_announcement(value);
            });
        });
        
        e.preventDefault();
    });
    
    // delete announcement function
    var delete_announcement = function(value){
        $.ajax({
            type: 'POST',
            url: base_url + 'announcement/delete_announcement',
            data: { 
                ann_id : value
            },
            dataType: 'json',
            success: function(output){
                if(output.status){
                    var group = $('.ccs-announcement');
                    var list = $('.ccs-announcement-media', group).last().index();

                    if(list > 2){
                        $('.ccs-announcement > .media.ccs-announcement-media[data-value="' + value + '"]').slideUp(function(){
                            $(this).remove();
                        });
                    }
                    else{
                        $('.ccs-announcement > .media.ccs-announcement-media[data-value="' + value + '"]')
                        .slideUp(function(){
                            $(this).html('No Announcements Available... <a href="#" style="text-decoration:none;" class="ccs-no-available-create-post">Create one</a>')
                            .addClass('ccs-forum-media-no-post')
                            .slideDown();
                        })
                    }
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }
    
    //index.php

    $(document).on('click','.note-editor > .note-toolbar > .note-insert > button', function(e){
        e.preventDefault();

        var note_parent = $(this).parents('.note-editor');  
        var parent = $(this).parents('form');
        var parent_name = parent.attr('name');

        if(parent_name == 'ccs-announcement-add-form')
            var summernote = $('.ccs-add-new-forum-announcement-form-content');
        else if(parent_name == 'ccs-announcement-edit-form')
            var summernote = $('.ccs-announcement-edit-summernote', parent);

        var code = summernote.code();
        var regex = /<img\b[^>]*>/gi;

        $('body').removeClass('modal-open');
        $('.modal-backdrop.in').remove();

        if(regex.test(code.toString())){
            Dialog('Warning: You can only insert one image per topic.', 'alert', true, false, function(){});
        }
        else{
            $('.note-image-input', note_parent).click();
        }

        return false;
    });

    $(document).on('change','.ccs-attach-files > span > input',function(){
        $('.ccs-btn-post > input[type="hidden"]').val('1');
    });
    $(document).on('click','.ccs-attach-files > span > i',function(){
        if($('.ccs-attach-files > span').last().index() > 1)
            $(this).parent().remove();
        else{
            $(this).parent().children('input').val('');
        }

        if(is_all_input_file_empty()) $('.ccs-btn-post > input[type="hidden"]').val('0');
    });


    $(document).on('change','.ccs-media-attachments .ccs-attach-files-edit > span > input', function(){
        $(this).parents('.ccs-media-attachments').children('input[name="add_attachment"]').val('1');
    });
    $(document).on('click','.ccs-media-attachments .ccs-attach-files-edit > span > i',function(){
        var par = $(this).parents('.ccs-attach-files-edit');
        if($('> span', par).last().index() > 0){
            $(this).parent().remove();
        }
        else{
            $(this).parent().children('input').val('');
        }

        if(is_all_input_file_empty_edit(par)) par.parent('.ccs-media-attachments').children('input[name="add_attachment"]').val('0');
    });

    //for create
    function is_all_input_file_empty(){
        var flag = true;

        $('.ccs-add-new-forum-announcement-form-inner .ccs-attach-files > span').each(function(i, item){
            if($(this).has('input').length && $(this).children('input').val() != "") flag = false;
        });

        return flag;
    }
    //for edit
    function is_all_input_file_empty_edit(el){
        var flag = true;

        el.children('span').each(function(i, item){
            if($('input', this).val() != "") flag = false;
        });

        return flag;
    }

    $('.ccs-announcement-edit').click(function(e){
        var par = $(this).parents('.media-body').children('form[name="ccs-announcement-edit-form"]');
        var parentier = par.parent();
        
        reset_all_edit_summernote();
        
        $('.ccs-media-attachments', parentier).show();

        $('a', this).addClass('ccs-cursor-help').parent().unbind('click');
        $('.ccs-announcement-thread-controls > ul > .ccs-announcement-see-more > a', par).addClass('ccs-cursor-help').parent().unbind('click');
        par.children('.ccs-announcement-edit-summernote').summernote({
            height: 'auto',
            focus: true,
            toolbar: [
    //                ['style', ['style']], // no style button
                ['style', ['bold', 'italic', 'underline', 'clear']],
                // ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
    //                ['height', ['height']],
                ['insert', ['picture']], // no insert buttons
                ['table', ['table']] // no table button
          //     ['help', ['help']] //no help button
            ],
            oninit: function(){
                $('<label class="ccs-error hide pull-right" for="detail" style="position: absolute; right: 0; margin: 5px 5px 0 0; color: #B94A48"><i class="glyphicon glyphicon-asterisk pull-right"></i></label>').insertBefore($('.note-editable', par));
                // $('.ccs-announcement .note-editable').css({
                //     'min-height': '150px'
                // });
                par.children('p').hide();
                var sHTML = par.children('p').html();

                par.children('.ccs-announcement-edit-summernote').code(sHTML);
                par.children('.note-editor').css({
                    margin: '0 0px',
                   border: '1px solid #f0f0f0',
                   background : '#fff'
                });
                par.children('.note-toolbar').css({
                   background : 'none'
                });
                par.children('.ccs-media-attachments').css({
                    'margin-top': '30px',
                    'height': 'auto'
                });
                if($('.ccs-media-attachments > .ccs-attachment-title', par).length){
                    $('.ccs-media-attachments > .ccs-attachment-title', par).removeClass('hide');
                }
                par.children('.ccs-media-attachments').children('.ccs-attach-files-edit').removeClass('hide');
                $('.ccs-media-attachments > .ccs-media-attachments-inner').addClass('ccs-list-item');
                $('.ccs-media-attachments > .ccs-media-attachments-inner > i.ic-error', par).removeClass('hide');
                $('button.ccs-announcement-edit-btn, a.ccs-announcement-cancel-btn', par).removeClass('hide');

                if(parentier.parent().index() == $('.ccs-announcement-media').last().index()){
                    $('html, body').animate({
                        scrollTop: $(document).height() + 'px'
                    });
                }
            },
            onblur: function(e) {
                var code = $(this).code();
                var regex = /\S/g;
                var result = strip_tags(code, "<img>"), result = result.replace(/&nbsp;/gi, "");

                if(regex.test(result)){
                    //hide required error
                    $('.note-editor > label', par).addClass('hide');
                    $('.note-editable', par).removeClass('ccs-error-input');
                }
                else {
                    $('.note-editor > label', par).removeClass('hide');
                    $('.note-editable', par).addClass('ccs-error-input');
                }
            }
        });
    });
    $('.ccs-announcement-pin > i').click(function(e){
        e.preventDefault();

        var el = $(this);

        // var ans = confirm('You are about to pin this post. Are you sure to continue?');
        Dialog('You are about to pin this post. Are you sure to continue?', 'confirm', false, false, function(){
            $('form:eq(1)', el.parents('.media-body')).submit();
        });
    });
    $('.ccs-announcement-unpin > i').click(function(e){
        e.preventDefault();

        var el = $(this);

        // var ans = confirm('You are about to unpin this post. Are you sure to continue?');
        Dialog('You are about to unpin this post. Are you sure to continue?', 'confirm', false, false, function(){
            $('form:eq(1)', el.parents('.media-body')).submit();
        });
    });

    $('.ccs-media-attachments > .ccs-media-attachments-inner > i.ic-error').click(function(){
        var par = $(this).parent();

        $('input', par).attr('disabled','true');
        $('a > span.ccs-file-attachment', par).addClass('hide');
        $('a > span.ccs-undo-attachment', par).removeClass('hide');
        $(this).addClass('hide');
        $('a', par).attr('onclick','return false;');
    });
    $('.ccs-media-attachments > .ccs-media-attachments-inner > a > span.ccs-undo-attachment').click(function(e){
        e.preventDefault();

        var par = $(this).parents('.ccs-media-attachments-inner');
        
        $('input', par).removeAttr('disabled');
        $(this).parent().children('span.ccs-file-attachment').removeClass('hide');
        $(this).addClass('hide');
        $('i.ic-error', par).removeClass('hide');
        $(this).parent().removeAttr('onclick');
    });
    $('form[name="ccs-announcement-edit-form"] button[type="submit"]').click(function(e){
        var par = $(this).parent('form');
        var code = $('.ccs-announcement-edit-summernote', par).code();
        var regex = /\S/g;
        var result = strip_tags(code, "<img>"), result = result.replace(/&nbsp;/gi, "");
        var add_attachment = $('.ccs-media-attachments > input[name="add_attachment"]', par).val();
        var is_all_attachment = ($('.ccs-media-attachments > .ccs-media-attachments-inner', par).length) ? is_all_attachment_available(par) : true;
        $('.ccs-summernote-announcement-edit-container', par).val(code);
        remove_blank_file_input();

        if(code == $('> p', par).html() && add_attachment == 0 && is_all_attachment){
            Dialog('Warning: Cannot save with the same content.', 'alert', true, false, function(){});
        }
        else if((code != $('> p', par).html() && ($('.note-editor > label', par).hasClass('hide') || regex.test(result))) || add_attachment == 1 || !is_all_attachment){
            var len = $('.ccs-media-attachments > .ccs-attach-files-edit > .ccs-hide-upload', par).length - 1,
                err = 0;

            console.log('length: ' + len + ' regex: ' + regex.test(result) + ' add: ' + add_attachment + ' is all attach: ' + is_all_attachment);
            $('.ccs-media-attachments > .ccs-attach-files-edit > .ccs-hide-upload > input', par).each(function(i, item){
                var F = this.files;
                var el = $(this).parent();

                if(F && F[0]){ 
                    validate_file_attachments(F[0], function(){
                        if($('.ccs-media-attachments > .ccs-attach-files-edit > .ccs-hide-upload', par).last().index() == 0){
                            $('input', el).val('');
                            $('.ccs-media-attachments > input[name="add_attachment"]', par).val('0');
                        }
                        else{
                            el.remove();
                        }

                        err++;
                    });
                }
            });

            if(err > 0){
                var t = (err > 1) ? ' invalid files were removed. Continue?' : ' invalid file was removed. Continue?';

                Dialog(err + t, 'confirm', false, false, function(){
                    add_attachment = $('.ccs-media-attachments > input[name="add_attachment"]', par).val();

                    if((code != $('> p', par).html() && ($('.note-editor > label', par).hasClass('hide') || regex.test(result))) || add_attachment == 1 || !is_all_attachment) setTimeout(function(){ par.submit(); }, 100);
                });
            }
            else setTimeout(function(){ par.submit(); }, 100);
        }

        e.preventDefault();
    });
    $('form[name="ccs-announcement-edit-form"] a.ccs-announcement-cancel-btn').click(function(){
        var par = $(this).parent('form'); 
        var parentier = par.parent('.media-body');
        
        par.children('.ccs-announcement-edit-summernote').destroy();
        
        if($('.ccs-media-attachments > .ccs-attachment-title', par).length){
            $('.ccs-media-attachments > .ccs-attachment-title', par).addClass('hide');
        }
        $('.ccs-media-attachments > .ccs-attach-files-edit', par).addClass('hide');
        par.children('p').show();
        par.children('.ccs-announcement-edit-summernote').html("");
        $('.ccs-media-attachments > .ccs-media-attachments-inner', par).removeClass('ccs-list-item');
        $('.ccs-media-attachments > .ccs-media-attachments-inner > i.ic-error', par).addClass('hide');
        $('button.ccs-announcement-edit-btn, a.ccs-announcement-cancel-btn', par).addClass('hide');

        $('.ccs-announcement-thread-controls .ccs-announcement-see-more > a', parentier).removeClass('ccs-cursor-help').parent().bind('click', function(e){
            see_more_announcement_details($(this));
        });
        $('.ccs-announcement-thread-controls .ccs-announcement-edit > a', parentier).removeClass('ccs-cursor-help').parent().bind('click', function(e){
            bind_ccs_announcement_edit(this);
        });
    });

    function is_all_attachment_available(form){
        var flag = true;

        if($('.ccs-media-attachments', form).length){
            var par = $('.ccs-media-attachments', form);

            $('.ccs-media-attachments-inner', par).each(function(){
                if($('input', this).attr('disabled')) flag = false;
            });
        }

        return flag;
    }

    function is_all_file_input_blank(){
        var flag = true;

        $('.ccs-attach-files-edit > span > input').each(function(){
            if($(this).val() != "") flag = false;
        });

        return flag;
    }

    function remove_blank_file_input(){
        if(is_all_file_input_blank()){
            $('.ccs-attach-files-edit > span > input').each(function(){
                if($(this).val() == "" && $(this).parent().last().index() > 0){
                    $(this).parent().remove();
                } 
            });
        }
        else{
            $('.ccs-attach-files-edit > span > input').each(function(){
                if($(this).val() == ""){
                    $(this).parent().remove();
                } 
            });
        }
    }

    $('.ccs-add-new-forum-announcement-form form').validate({
        debug: true,
        rules: {
            topic: "required",
            captcha: "required"
        },
        messages: {
            topic: "<i class='glyphicon glyphicon-asterisk pull-right'></i>",
            captcha: "<i class='glyphicon glyphicon-asterisk pull-right'></i>"
        },
        onkeyup: false,
        onclick: false,
        focusInvalid: false,
        errorClass: 'ccs-error-input',
        highlight: function(element, errorClass, validClass){
            var par = $(element).parent();

            if(!$('label.ccs-error', par).hasClass('ccs-invalid-input'))
                $('label.ccs-error', par).removeClass('hide').html("<i class='glyphicon glyphicon-asterisk pull-right'></i>");
            if(!$(element).hasClass('ccs-invalid-input'))
                $(element).addClass(errorClass);
        },
        unhighlight: function(element, errorClass, validClass){
            var par = $(element).parent();

            if(!$('label.ccs-error', par).hasClass('ccs-invalid-input'))
                $('label.ccs-error', par).addClass('hide').html("<i class='glyphicon glyphicon-asterisk pull-right'></i>");
            if(!$(element).hasClass('ccs-invalid-input'))
                $(element).removeClass(errorClass);
        },
        errorPlacement: function(error, element){
            var par = $(element).parent();

            $('label.ccs-error', par).removeClass('hide').html("<i class='glyphicon glyphicon-asterisk pull-right'></i>");
        },
        submitHandler: function(form){
            form.submit();
        }
    });

    $('.ccs-captcha-refresh').click(function(){
        var base_url = 'http://localhost/ccsweb/';
        var btn = $(this);
        
        btn.attr('onclick','return false').addClass('disabled');
        $('.ccs-btn-post > .ccs-post-capcha > div > span > span').load(base_url + 'announcement #ccs-captcha-container > img, #ccs-captcha-container > input',function(){
            btn.removeAttr('onclick').removeClass('disabled');
        });
    });
    
    function bind_ccs_announcement_edit(el){
        var par = $(el).parents('.media-body').children('form[name="ccs-announcement-edit-form"]');
        var parentier = par.parent();
        
        reset_all_edit_summernote();
        
        $('.ccs-media-attachments', parentier).show();

        $('a', el).addClass('ccs-cursor-help').parent().unbind('click');
        $('.ccs-announcement-thread-controls > ul > .ccs-announcement-see-more > a', par).addClass('ccs-cursor-help').parent().unbind('click');
        par.children('.ccs-announcement-edit-summernote').summernote({
            height: 'auto',
            focus: true,
            toolbar: [
    //                ['style', ['style']], // no style button
                ['style', ['bold', 'italic', 'underline', 'clear']],
                // ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
    //                ['height', ['height']],
                ['insert', ['picture']], // no insert buttons
                ['table', ['table']] // no table button
          //     ['help', ['help']] //no help button
            ],
            oninit: function(){
                $('<label class="ccs-error hide pull-right" for="detail" style="position: absolute; right: 0; margin: 5px 5px 0 0; color: #B94A48"><i class="glyphicon glyphicon-asterisk pull-right"></i></label>').insertBefore($('.note-editable', par));

                par.children('p').hide();
                var sHTML = par.children('p').html();

                par.children('.ccs-announcement-edit-summernote').code(sHTML);
                par.children('.note-editor').css({
                    margin: '0 0px',
                   border: '1px solid #f0f0f0',
                   background : '#fff'
                });
                par.children('.note-toolbar').css({
                   background : 'none'
                });
                par.children('.ccs-media-attachments').css({
                    'margin-top': '30px',
                    'height': 'auto'
                });
                if($('.ccs-media-attachments > .ccs-attachment-title', par).length){
                    $('.ccs-media-attachments > .ccs-attachment-title', par).removeClass('hide');
                }
                par.children('.ccs-media-attachments').children('.ccs-attach-files-edit').removeClass('hide');
                $('.ccs-media-attachments > .ccs-media-attachments-inner > i.ic-error', par).removeClass('hide');
                $('.ccs-media-attachments > .ccs-media-attachments-inner', par).addClass('ccs-list-item');
                $('button.ccs-announcement-edit-btn, a.ccs-announcement-cancel-btn', par).removeClass('hide');

                if(parentier.parent().index() == $('.ccs-announcement-media').last().index()){
                    $('html, body').animate({
                        scrollTop: $(document).height() + 'px'
                    });
                }
            },
            onblur: function(e) {
                var code = $(this).code();
                var regex = /\S/g;
                var result = strip_tags(code, "<img>"), result = result.replace(/&nbsp;/gi, "");

                if(regex.test(result)){
                    //hide required error
                    $('.note-editor > label', par).addClass('hide');
                }
                else $('.note-editor > label', par).removeClass('hide');
            }
        });
    }
    
    function reset_all_edit_summernote(){
        $('.ccs-announcement .note-editor').each(function(){
            var par = $(this).parent('form'); 
            var parentier = par.parent('.media-body');
            
            par.children('.ccs-announcement-edit-summernote').destroy();
            
            if($('.ccs-media-attachments > .ccs-attachment-title', par).length){
                $('.ccs-media-attachments > .ccs-attachment-title', par).addClass('hide');
            }
            $('.ccs-media-attachments > .ccs-attach-files-edit', par).addClass('hide');
            par.children('p').show();
            par.children('.ccs-announcement-edit-summernote').html("");
            $('.ccs-media-attachments > .ccs-media-attachments-inner', par).removeClass('ccs-list-item');
            $('.ccs-media-attachments > .ccs-media-attachments-inner > i.ic-error', par).addClass('hide');
            $('button.ccs-announcement-edit-btn, a.ccs-announcement-cancel-btn', par).addClass('hide');

            $('.ccs-announcement-thread-controls .ccs-announcement-see-more > a', parentier).removeClass('ccs-cursor-help').parent().bind('click', function(e){
                see_more_announcement_details($(this));
            });
            $('.ccs-announcement-thread-controls .ccs-announcement-edit > a', parentier).removeClass('ccs-cursor-help').parent().bind('click', function(e){
                bind_ccs_announcement_edit(this);
            });
        });
    }
    
    function strip_tags(input, allowed){
        allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
        var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
            commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
        return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
            return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
        });
    }
});