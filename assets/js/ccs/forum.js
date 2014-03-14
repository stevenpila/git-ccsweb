$(document).ready(function(){
    var base_url = 'http://localhost/ccsweb/';
    /*-------------------------------
    
                 events
    
    --------------------------------*/
    
 
    /* OPTIONS EVENT*/
    $('.ccs-forum-options').click(function(){
        var val = $(this).attr('data-value');
        reset(val);
        $('.ccs-forum-thread-controls', this).toggleClass('view-options');
    });

    function reset(id){
        $('.ccs-forum-options[data-value!="' + id + '"]').each(function(){
            $('.ccs-forum-thread-controls', this).removeClass('view-options');
        });
    }

    /*******************************

                 Thread

    ********************************/

    //pin or unpin forum
    $('.ccs-pin-box').click(function(){
        var el = $(this);
        if($(this).hasClass('ccs-pinned'))
            var ans = 'You are about to unpin this post. Are you sure to continue?';
        else
            var ans = 'You are about to pin this post. Are you sure to continue?';

        Dialog(ans, 'confirm', false, false, function(){
            $('form', el.parent()).submit();
        });
    });

    // delete forum
    $('.ccs-forum-delete').click(function(e){
        var value = $(this).parent('ul').attr('data-value');
        var ans = 'Are you sure to delete this thread?';
        var el = $(this);
        
        Dialog(ans, 'confirm', false, false, function(){
            is_user_still_logged_in(function(){
                delete_forum(value, el);
            });
        });

        e.preventDefault();
    });
    // delete forum function
    function delete_forum(value, el){
        $.ajax({
            type: 'POST',
            url: base_url + 'forum/delete_forum',
            data: { 
                thread_id : value,
                xsrf_token: $('meta[name="xsrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(output){
                if(output.status == 1){ 
                    var group = $('.ccs-forum');
                    var list = $('div.ccs-forum-media-container', group).last().index();

                    if(list > 0){
                        el.parents('.ccs-forum-media-container').slideUp(function(){
                            $(this).remove();
                        });
                    }
                    else{
                        el.parents('.ccs-forum-media-container')
                        .slideUp(function(){
                            $(this).html('No Threads Available... <a href="#" style="text-decoration:none;" class="ccs-no-available-create-post">Create one</a>')
                            .addClass('ccs-forum-media-no-post')
                            .slideDown();
                        });
                    }
                }
            }
        });
    }

    $('.ccs-view-forum-edit').click(function(e){
        $('.ccs-announcement-edit-summernote').summernote({
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
                $('<label class="ccs-error hide pull-right" for="detail" style="position: absolute; right: 0; margin: 5px 5px 0 0; color: #B94A48"><i class="glyphicon glyphicon-asterisk pull-right"></i></label>').insertBefore('.note-editable');
                $('.note-editable').css({
                    'min-height': '100px'
                });
                $('.note-editor').css({
                    color: '#000'
                });
                $('.ccs-forum-topic-and-reviews-viewer-desc > form > p').hide();
                $('.ccs-forum-topic-and-reviews-viewer-desc > form > .ccs-media-attachments > span').removeClass('hide');
                $('.ccs-forum-topic-and-reviews-viewer-desc > form > .ccs-media-attachments').show();
                var sHTML = $('.ccs-forum-topic-and-reviews-viewer-desc > form > p').html();

                $('.ccs-announcement-edit-summernote').code(sHTML);

                show_edit_forum();
            },
            onblur: function(e) {
                var code = $(this).code();
                var regex = /\S/g;
                var result = strip_tags(code, "<img>"), result = result.replace(/&nbsp;/gi, "");
                
                if(regex.test(result)){
                        //hide required error
                    $('.note-editor > label').addClass('hide');
                    $('.note-editable').removeClass('ccs-error-input');
                }
                else{
                    $('.note-editor > label').removeClass('hide');
                    $('.note-editable').addClass('ccs-error-input');
                } 
            }
        });

        $(this).unbind('click');

        e.preventDefault();
    });

    $('.ccs-view-forum-delete').click(function(e){
        var ans = 'Are you sure to delete this thread?';
        var par = $(this).parents('.ccs-forum-thread-controls');

        Dialog(ans, 'confirm', false, false, function(){
            $('form[name="ccs-view-forum-delete-form"] input').first().val('1');
            $('form[name="ccs-view-forum-delete-form"]').submit();
        });

        e.preventDefault();
    });

    $('.ccs-view-forum-cancel-btn').click(function(){
        $('.ccs-announcement-edit-summernote').destroy();
        $('.ccs-announcement-edit-summernote').html("");
        $('.ccs-forum-topic-and-reviews-viewer-desc > form > p').show();

        hide_edit_forum();

        $('.ccs-view-forum-edit').bind('click', function(e){
            $('.ccs-announcement-edit-summernote').summernote({
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
                    $('<label class="ccs-error hide pull-right" for="detail" style="position: absolute; right: 0; margin: 5px 5px 0 0; color: #B94A48"><i class="glyphicon glyphicon-asterisk pull-right"></i></label>').insertBefore('.note-editable');
                    $('.note-editable').css({
                        'min-height': '100px'
                    });
                    $('.note-editor').css({
                        color: '#000'
                    });
                    $('.ccs-forum-topic-and-reviews-viewer-desc > form > p').hide();
                    var sHTML = $('.ccs-forum-topic-and-reviews-viewer-desc > form > p').html();

                    $('.ccs-announcement-edit-summernote').code(sHTML);

                    show_edit_forum();
                },
                onblur: function(e) {
                    var code = $(this).code();
                    var regex = /\S/g;
                    var result = strip_tags(code, "<img>"), result = result.replace(/&nbsp;/gi, "");
                    
                    if(regex.test(result)){
                        //hide required error
                        $('.note-editor > label').addClass('hide');
                        $('.note-editable').removeClass('ccs-error-input');
                    }
                    else{
                        $('.note-editor > label').removeClass('hide');
                        $('.note-editable').addClass('ccs-error-input');
                    } 
                }
            });

            $(this).unbind('click');

            e.preventDefault();
        });
    });

    function show_edit_forum(){
        $('.ccs-forum-topic-and-reviews-viewer-desc .ccs-view-forum-cancel-btn, .ccs-forum-topic-and-reviews-viewer-desc .ccs-announcement-edit-btn').removeClass('hide');

        $('.ccs-forum-topic-and-reviews-viewer-desc .ccs-media-attachments > .ccs-media-attachments-inner').addClass('ccs-list-item');
        $('.ccs-forum-topic-and-reviews-viewer-desc .ccs-media-attachments > .ccs-media-attachments-inner > i.ic-error').removeClass('hide');
        $('.ccs-forum-topic-and-reviews-viewer-desc .ccs-media-attachments > .ccs-attach-files-edit').removeClass('hide');
        $('.ccs-forum-topic-and-reviews-viewer-desc .ccs-media-attachments').css({
            'margin-top': '35px'
        });
        $('.ccs-forum-topic-and-reviews-viewer-desc > form > .ccs-media-attachments > span.ccs-attachment-title').removeClass('hide');
        $('.ccs-forum-topic-and-reviews-viewer-desc > form > .ccs-media-attachments').show();

        $('.ccs-forum-options .ccs-view-forum-edit > a').addClass('ccs-cursor-help');
        $('.ccs-forum-options .ccs-view-forum-edit').addClass('ccs-cursor-help');
    }

    function hide_edit_forum(){
        $('.ccs-forum-topic-and-reviews-viewer-desc .ccs-view-forum-cancel-btn, .ccs-forum-topic-and-reviews-viewer-desc .ccs-announcement-edit-btn').addClass('hide');

        $('.ccs-forum-topic-and-reviews-viewer-desc .ccs-media-attachments > .ccs-media-attachments-inner').removeClass('ccs-list-item');
        $('.ccs-forum-topic-and-reviews-viewer-desc .ccs-media-attachments > .ccs-media-attachments-inner > i.ic-error').addClass('hide');
        $('.ccs-forum-topic-and-reviews-viewer-desc .ccs-media-attachments > .ccs-attach-files-edit').addClass('hide');
        $('.ccs-forum-topic-and-reviews-viewer-desc .ccs-media-attachments').css({
            'margin-top': '0'
        });
        $('.ccs-forum-topic-and-reviews-viewer-desc > form > .ccs-media-attachments > span.ccs-attachment-title').addClass('hide');

        $('.ccs-forum-options .ccs-view-forum-edit > a').removeClass('ccs-cursor-help');
        $('.ccs-forum-options .ccs-view-forum-edit').removeClass('ccs-cursor-help');
    }
    // $('ccs-no-available-create-post').click(function(){

    // });
    /*******************************

                 Comment

    ********************************/

    //validate create comment, then post
    $('form[name="ccs-forum-create-comment"]').validate({
        debug: true,
        rules: {
            comment: "required"
        },
        messages: {
            comment: "<i class='glyphicon glyphicon-asterisk pull-right'></i>"
        },
        onkeyup: false,
        onclick: false,
        unhighlight: function(element, errorClass, validClass){
            var par = $(element).parent();

            $('label.ccs-error', par).addClass('hide');
        },
        errorPlacement: function(error, element){
            var par = $(element).parent();

            $('label.ccs-error', par).removeClass('hide');
        },
        submitHandler: function(form){
            var data = $('form[name="ccs-forum-create-comment"]').serialize();

            is_user_still_logged_in(function(){
                create_comment(data);
            });
        }
    });
    //create comment function
    function create_comment(data){
        $.ajax({
            url: base_url + 'forum/create_comment',
            type: 'POST',
            data: data,
            dataType: 'json',
            beforeSend: function(){},
            success: function(output){
                if(output.status){
                    $.post(base_url + 'forum/view_comment',{comment_id: output.status, xsrf_token: $('meta[name="xsrf-token"]').attr('content')},function(data){
                        if($('.ccs-forum-individual-comment > .ccs-forum-suggested-answer.ccs-is-suggested').length){
                            $(data).insertAfter('.ccs-forum-suggested-answer.ccs-is-suggested').hide().slideDown('fast');
                        }
                        else{
                            $(data).prependTo('.ccs-forum-individual-comment').hide().slideDown('fast');
                        }

                        $('html,body').animate({ scrollTop: 0 }, 500);

                        $('.ccs-forum-individual-comment > .ccs-forum-add-comment textarea').val('').focus();
                    });
                }
                else{
                    Dialog('An error has occured. Please try again.', 'alert', true, false, function(){});
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }
    // delete comment
    $(document).on('click','.ccs-forum-comment-delete',function(e){
        var value = $(this).parent('ul').attr('data-value');
        var ans = 'Are you sure to delete this comment?';
        var el = $(this);

        Dialog(ans, 'confirm', false, false, function(){
            is_user_still_logged_in(function(){
                delete_comment(value, el);
            });
        });

        e.preventDefault();
    });
    // delete comment function
    var delete_comment = function(value, el){
        $.ajax({
            type: 'POST',
            url: base_url + 'forum/delete_comment',
            data: { 
                comment_id : value,
                xsrf_token: $('meta[name="xsrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(output){
                if(output.status == 1){
                    el.parents('.ccs-forum-suggested-answer').slideUp(function(){
                        $(this).remove();
                        
                        // var group = $('.ccs-forum-individual-comment');
                        
                        // if(!group.has('div.ccs-forum-suggested-answer').length){
                        //     group.prepend('<div class="ccs-forum-discussion-comment-no-post" style="padding: 1px 0 8px 0; text-align: center">\n\
                        //     <h3><i>No Comments Available</i></h3>\n\
                        //     </div>').hide().fadeIn(function(){
                        //         $('html,body').scrollTop($(document).height());
                        //     });
                        // }
                    });
                }
            }
        });
    }

    //suggest comment
    $(document).on('click','.ccs-forum-comment-check',function(e){
        var par = $(this).parent();
        var ans = 'You are about to suggest this comment. Are you sure to continue?';

        Dialog(ans, 'confirm', false, false, function(){
            $('form', par).submit();
        });

        e.preventDefault();
    });
    //unsuggest comment
    $(document).on('click','.ccs-forum-comment-uncheck',function(e){
        var par = $(this).parent();
        var ans = 'You are about to unsuggest this comment. Are you sure to continue?';

        Dialog(ans, 'confirm', false, false, function(){
            $('form', par).submit();
        });

        e.preventDefault();
    });

    //show edit comment
    $(document).on('click','.ccs-forum-comment-edit',function(e){
        var par = $(this).parents('.ccs-forum-suggested-answer');
        var comment = par.children('p').attr('data-comment');

        reset_all_edited_container();

        $('a', this).addClass('ccs-cursor-help');
        $(this).removeClass('ccs-forum-comment-edit').addClass('ccs-forum-comment-edit-unbind');
        $('<div class="ccs-forum-comment-edit-container">\n\
            <label class="label label-danger" style="border-radius: 0"><i class="glyphicon glyphicon-exclamation-sign"></i> HTML TAGS are not allowed and cannot be counted as text.</label>\n\
            <label class="ccs-error hide pull-right" for="edit_comment" style="position: absolute; right: 0; margin: 22px 5px 0 0; color: #B94A48">\n\
            <i class="glyphicon glyphicon-asterisk pull-right"></i></label>\n\
            <textarea class="ccs-forum-comment-edit-textarea" name="edit_comment" style="min-width: 100%; max-width: 100%; min-height: 80px; border: 0">' + comment + '</textarea>\n\
            <button class="btn btn-default pull-right ccs-forum-comment-edit-cancel" style="border-radius: 0"><i class="glyphicon glyphicon-remove"></i> Cancel</button>\n\
            <button class="btn btn-default pull-right ccs-forum-comment-edit-save" style="border-radius: 0; margin-right: 10px"><i class="glyphicon glyphicon-ok"></i> Save</button></div>').insertAfter(par.children('p'));
        $('textarea', par).autosize().show().focus().trigger('autosize.resize');
        par.children('p').hide();
        par.children('.ccs-date-forum-posted').css({
            marginTop: '35px'
        });
        e.preventDefault();
    });
    //reset all edited container
    function reset_all_edited_container(){
        $('.ccs-forum-individual-comment .ccs-forum-comment-edit-container').each(function(i, item){
            var par = $(this).parent();

            $(this).remove();
            par.children('p').show();
            par.children('.ccs-date-forum-posted').css({
                marginTop: '0'
            });

            $('.ccs-forum-comment-edit-container > label.ccs-error', par).addClass('hide');

            $('.ccs-forum-comments-controls .ccs-forum-comment-edit-unbind > a', par).removeClass('ccs-cursor-help');
            $('.ccs-forum-comments-controls .ccs-forum-comment-edit-unbind', par).removeClass('ccs-forum-comment-edit-unbind').addClass('ccs-forum-comment-edit');
        });
    }
    //edit comment
    $(document).on('click','.ccs-forum-comment-edit-save',function(e){
        var par = $(this).parents('.ccs-forum-suggested-answer');
        var comment = $('p', par).attr('data-comment');
        var edited = $('textarea', par).val();
        var regex = /\S/g;
        var clear_edited = strip_tags(edited,"");
        
        if(edited == comment) Dialog('Warning: Cannot save with the same content.', 'alert', true, false, function(){});
        else if(!regex.test(clear_edited)){
            $('.ccs-forum-comment-edit-container > label.ccs-error', par).removeClass('hide');
        }
        else{
            var comment_id = $('.ccs-forum-comments-controls form > input[name="comment_id"]', par).val();

            is_user_still_logged_in(function(){
                edit_comment(comment_id, edited, par);
            });
        }

        e.preventDefault();
    });
    //edit comment function
    function edit_comment(id, comment, par){
        $.ajax({
            url: base_url + 'forum/edit_comment',
            type: 'POST',
            dataType: 'json',
            data: {
                comment: comment,
                comment_id: id,
                xsrf_token: $('meta[name="xsrf-token"]').attr('content')
            },
            beforeSend: function(){},
            success: function(output){
                if(output.status == 1){
                    $('p', par).html(nl2br($.trim(strip_tags(comment,"")))).show();
                    par.children('.ccs-date-forum-posted').css({
                        marginTop: '0'
                    });
                    $('p', par).attr('data-comment',$.trim(strip_tags(comment,"")));
                    $('.ccs-forum-comment-edit-container', par).remove();
                    $('.ccs-forum-comment-edit-container > label.ccs-error', par).addClass('hide');

                    $('.ccs-forum-comments-controls .ccs-forum-comment-edit-unbind > a', par).removeClass('ccs-cursor-help');
                    $('.ccs-forum-comments-controls .ccs-forum-comment-edit-unbind', par).removeClass('ccs-forum-comment-edit-unbind').addClass('ccs-forum-comment-edit');
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }

    //cancel edit comment
    $(document).on('click','.ccs-forum-comment-edit-cancel',function(e){
        var par = $(this).parents('.ccs-forum-suggested-answer');

        $('.ccs-forum-comment-edit-container', par).remove();
        par.children('p').show();
        par.children('.ccs-date-forum-posted').css({
            marginTop: '0'
        });
        $('.ccs-forum-comment-edit-container > label.ccs-error', par).addClass('hide');

        $('.ccs-forum-comments-controls .ccs-forum-comment-edit-unbind > a', par).removeClass('ccs-cursor-help');
        $('.ccs-forum-comments-controls .ccs-forum-comment-edit-unbind', par).removeClass('ccs-forum-comment-edit-unbind').addClass('ccs-forum-comment-edit');

        e.preventDefault();
    });
});

function strip_tags(input, allowed){
    allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
        commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
    return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
        return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
    });
}

function nl2br(str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
