<!-- <?php print_array($forums) ?> -->
<div class="row ccs-forum-row">
    <?php if($this->authentication->is_authorized_function_by_name('Forum/create_forum')){ ?>
    <div class="ccs-add-new-forum-announcement-form">
        <?php echo form_open_multipart('forum/create_forum',array('name'=>'ccs-announcement-add-form','method'=>'POST')) ?>
        <div class="ccs-add-new-forum-announcement-form-inner"> 
            <div class="input-group ccs-input-topic-label">
                <div class="input-group-addon">Title :</div>
                <label class="ccs-error hide pull-right" for="topic" style="position: absolute; right: 0; margin: 5px 5px 0 0; color: #B94A48">
                    <i class="glyphicon glyphicon-asterisk pull-right"></i>
                </label>
                <input type="text" name="topic" class="input-lg" placeholder="Title Here" title="Enter title here." onkeypress="if(event.keyCode == 13){ this.form.post.click(); return false; }"/>
            </div>
            <textarea id="ccs-summernote-announcement-create-container" class="form-control hide" name="detail" placeholder="Detail"></textarea>
            <div class="ccs-add-new-forum-announcement-form-content"></div>
            <div class="row ccs-btn-post">
                <input type="hidden" name="add_attachment" value="0"/>
                <div class="col-md-4 ccs-attach-files" style="padding: 0 5px 30px 0">
                        <div style="font-size:15px;"><i class="icon-attach"></i></div>
                        <span class="ccs-hide-upload">
                        <!--     <div class="ccs-replace-upload">
                                <i class="ic-paperclip"></i>
                                <input />
                            </div> -->
                            <i class="icon-minus-sign-alt pull-right"></i>
                            <input type="file" style="color:#222;" name="userfile[]" />
                        </span>
                        <a class="ccs-add-another-attachment" href="#" onclick="return false;" title="Attach another file.">Add <i class="icon-plus-sign-alt"></i></a>
                    
                </div> 

                 <div class="col-md-4 ccs-post-capcha">
                        <span style="font-size:15px;"></span>
                        <div class="col-md-12" style="padding: 0 26px">
                            <span class="input-group-addon" style="background: transparent; border-radius: 0; border: 0; padding: 0 0 10px; text-align: left"><span id="ccs-captcha-container"><?php echo $captcha['captcha'] ?><input type="hidden" name="captcha_id" value="<?php echo $captcha['captcha_id'] ?>"/></span> 
                            <label class="btn btn-warning ccs-captcha-refresh" title="Generate another captcha word.">Refresh <i class="icon-refresh"></i></label></span>
                            <label class="ccs-error pull-right hide" for="topic" style="position: absolute; right: 0; margin: 3px 30px 0 0; color: #B94A48">
                                <i class="glyphicon glyphicon-asterisk pull-right"></i>
                            </label>
                            <input type="text" name="captcha" class="input-sm" placeholder="Word Here" style="border-radius: 0" title="Enter captcha word here." onkeypress="if(event.keyCode == 13){ this.form.post.click(); return false; }">
                        </div>
                    </div>   

                <div class="col-md-4 ccs-button-post">
                    <button type="button" title="Cancel"><i class="icon-chevron-sign-left"></i> Cancel</button>
                    <button name="post" type="submit" title="Post announcement">Post <i class="icon-chevron-sign-right"></i></button>
                </div>
            </div>
        </div>
        </form>
    </div>
    <div class="col-md-12 ccs-announcement-header" style="padding: 0">
        <?php // $this->authentication->is_authorized_anchor('announcement/create_announcement','<i class="ic-add"></i>','class="btn-add-announcement ccs-announcement-add-new"') ?>
        <div class="btn-add-announcement ccs-announcement-add-new" title="Click to toggle create new announcement."><a href="#"><b>Create </b><i class="icon-plus-sign-alt"></i></a></div>
    </div>
    <?php } ?>
    <div class="col-md-12 ccs-forum">
        <!-- <span style="margin-left:50px;display:inline-block;font-size:20px;padding:10px;  ">Forum</span> -->
    <?php if($forums){ ?>
    <?php foreach($forums as $forum){ ?>
        <div class="ccs-forum-media-container">
            <a name="<?php echo $forum->id ?>" style="position: absolute; margin-top: -60px"></a>
            <div class="ccs-forum-media">
                <div class="ccs-pin-forum">
                <?php if($this->authentication->is_authorized_function_by_name(($forum->pinned == 1) ? 'Forum/unpin_forum' : 'Forum/pin_forum')){ ?>
                    <div class="ccs-pin-box <?php echo ($forum->pinned == 1) ? 'ccs-pinned' : '' ?>"><?php echo ($forum->pinned == 1) ? ' <i class="glyphicon glyphicon-ok" style="margin-left: 2px"></i>' : '' ?></div>
                    <form method="POST" action="<?php echo base_url() ?>forum/<?php echo ($forum->pinned == 1) ? 'unpin_forum' : 'pin_forum' ?>">
                        <input type="hidden" name="thread_id" value="<?php echo $forum->id ?>"/>
                    </form>
                <?php } ?>
                </div>
                &nbsp;
                
                    <div class="ccs-forum-medium">
                        <span class="ccs-forum-user-type"><?php echo ucwords($this->authentication->user_type($forum->author_user_type))?></span>
                        <span class="ccs-date-forum-posted"><?php echo date('M d, Y', strtotime($forum->date_posted)) ?></span>
                    </div>
                &nbsp;
                <div class="ccs-forum-topic-and-reviews">
                    <span><a href="<?php echo base_url() . 'forum/' . htmlspecialchars($forum->perma_link) ?>"><?php echo htmlspecialchars($forum->topic) ?></a></span>
                    <span class="ccs-forum-replies">
                        <a href="<?php echo base_url() . 'forum/' . htmlspecialchars($forum->perma_link) ?>">[<?php echo ($forum->comments > 0)?$forum->comments:'no' ?> repl<?php echo ($forum->comments == 1)?'y':'ies' ?> <i class="ic-chat"></i>]</a>
                    <?php if($this->authentication->user_id() == $forum->user_id && ($this->authentication->is_authorized_function_by_name('Forum/edit_forum') || $this->authentication->is_authorized_function_by_name('Forum/delete_forum'))){ ?>
                        <span class="ccs-forum-options" id="ccs-forum-options-index" data-value="<?php echo $forum->id ?>"><i class="ic-cog"></i>
                             <div class="ccs-forum-thread-controls">
                                <ul data-value="<?php echo $forum->id ?> ">
                                    <?php if($this->authentication->user_id() == $forum->user_id){ ?>
                                       <?php if($this->authentication->is_authorized_function_by_name('Forum/edit_forum')){ ?>
                                       <li class="ccs-forum-edit"><a href="<?php echo base_url() . 'forum/' . htmlspecialchars($forum->perma_link) . '?id=' . md5($forum->id) ?>"><span class="ic-pencil2"> </span>Edit</a></li>
                                       
                                    <?php }
                                        if($this->authentication->is_authorized_function_by_name('Forum/delete_forum')){ ?>
                                       <li class="ccs-forum-delete"><a href="#"><span class="ic-trash"> </span>Delete</a></li>
                                    <?php }} ?>
                                </ul>
                             </div>
                        </span>
                    <?php } ?>
                    </span>
                    <?php $detail = strip_tags($forum->detail); ?>
                    <span class="ccs-forum-topic-and-reviews-desc">
                        
                        <?php echo (strlen($detail) > 50) ? trim(substr($detail, 0, 50)) . '....' : $detail ?>
                    </span>
                </div>

             
            </div>
        </div>
    <?php }}else{ ?>
        <div class="ccs-forum-media-container ccs-forum-media-no-post">
            No Threads Available... <a href="#" style="text-decoration:none;" class="ccs-no-available-create-post">Create one</a>
        </div>
    <?php } ?>
    </div>
</div>
<script>
    $(document).ready(function(){
        var flag = false;
        
        $('.ccs-add-new-forum-announcement-form-content').summernote({
            height: 'auto',
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
            },
            onblur: function(e) {
                var code = $(this).code();
                var regex = /\S/g;
                var result = strip_tags(code, "<img>"), result = result.replace(/&nbsp;/gi, "");
                var form = $('form[name="ccs-announcement-add-form"]');
                
                if(regex.test(result)){
                    //hide required error
                    $('.note-editor > label', form).addClass('hide');
                    $('.note-editable', form).removeClass('ccs-error-input');
                }
                else if(flag && !regex.test(result)){
                    $('.note-editable', form).addClass('ccs-error-input');
                    $('.note-editor > label', form).removeClass('hide');
                } 
            }
        });

        $('form[name="ccs-announcement-add-form"] button[type="submit"]').click(function(e){
            e.preventDefault();

            var summernote = $('.ccs-add-new-forum-announcement-form-content');
            var code = summernote.code();
            var regex = /\S/g;
            $('#ccs-summernote-announcement-create-container').val(code);
            var result = strip_tags(code, "<img>"), result = result.replace(/&nbsp;/gi, "");
            var form = $('form[name="ccs-announcement-add-form"]');
            var valid = form.valid();
            flag = true;
            remove_blank_file_input();

            if(valid && regex.test(result)){
               validate_captcha_and_topic(form, code);
            }
            else if(!regex.test(result)){
                $('.note-editor > label', form).removeClass('hide');
                $('.note-editable', form).addClass('ccs-error-input');
            }
        });

        $(document).on('paste', '.note-editable', function(){
            var el = ($(this).parent().siblings('.ccs-announcement-edit-summernote').length) ? $(this).parent().siblings('.ccs-announcement-edit-summernote') : $(this).parent().siblings('.ccs-add-new-forum-announcement-form-content');

            setTimeout(function(){
                var value = el.code(),
                    sanitize = value.replace(/'/g, "\'").replace(/"/g, '\"').replace(/(<[p|a][\s\S]+?>|<\/[p|a]>)/g, "");

                //alert(sanitize);
                el.code(sanitize);
            }, 0);
        });
    });

    function is_all_file_input_blank(){
        var flag = true;

        $('.ccs-attach-files > span > input').each(function(){
            if($(this).val() != "") flag = false;
        });

        return flag;
    }

    function remove_blank_file_input(){
        if(is_all_file_input_blank()){
            $('.ccs-attach-files > span > input').each(function(){
                if($(this).val() == "" && $(this).parent().last().index() > 1){
                    $(this).parent().remove();
                } 
            });
        }
        else{
            $('.ccs-attach-files > span > input').each(function(){
                if($(this).val() == ""){
                    $(this).parent().remove();
                } 
            });
        }
    }

    function validate_captcha_and_topic(form, code){
        var base_url = 'http://localhost/ccsweb/',
            data = form.serialize();

        $.ajax({
            url: base_url + 'forum/verify_captcha_and_topic',
            type: 'POST',
            data: data,
            dataType: 'json',
            beforeSend: function(){
                $('.ccs-post-capcha > div > label').removeClass('hide').addClass('ccs-orange').html("<i class='icon-spinner icon-spin'></i>");
                $('.ccs-input-topic-label > label').removeClass('hide').addClass('ccs-orange').html("<i class='icon-spinner icon-spin'></i>");
            },
            success: function(data){
                if(data.captcha == 1 && data.topic == 0){
                    var len = $('.ccs-add-new-forum-announcement-form-inner .ccs-attach-files > .ccs-hide-upload').length - 1,
                        err = 0;

                    $('.ccs-add-new-forum-announcement-form-inner .ccs-attach-files > .ccs-hide-upload > input').each(function(i, item){
                        var F = this.files;
                        var el = $(this).parent();

                        if(F && F[0]){ 
                            validate_file_attachments(F[0], function(){
                                if($('.ccs-add-new-forum-announcement-form-inner .ccs-attach-files > .ccs-hide-upload').last().index() == 1){
                                    $('input', el).val('');
                                    $('.ccs-add-new-forum-announcement-form-inner .ccs-btn-post > input[name="add_attachment"]').val('0');
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
                            setTimeout(function(){ form.submit(); }, 100);
                        });
                    }
                    else setTimeout(function(){ form.submit(); }, 100);
                }else{
                    if(data.captcha == 0){
                        $('.ccs-post-capcha > div > label').removeClass('hide').removeClass('ccs-orange').addClass('ccs-invalid-input').html("Invalid Captcha <i class='glyphicon glyphicon-asterisk pull-right' style='margin: 1px 0 0 5px'></i>");
                        $('.ccs-post-capcha > div > input').addClass('ccs-error-input').addClass('ccs-invalid-input').focus();
                    }
                    else{
                        $('.ccs-post-capcha > div > label').addClass('hide').removeClass('ccs-post-capcha');
                        $('.ccs-post-capcha > div > input').removeClass('ccs-error-input').removeClass('ccs-invalid-input');
                    }

                    if(data.topic == 1){
                        $('.ccs-input-topic-label > label').removeClass('hide').removeClass('ccs-orange').addClass('ccs-invalid-input').html("Topic Already Exists <i class='glyphicon glyphicon-asterisk pull-right' style='margin: 1px 0 0 5px'></i>");
                        $('.ccs-input-topic-label > input').addClass('ccs-error-input').addClass('ccs-invalid-input').focus();
                    }
                    else{
                        $('.ccs-input-topic-label > label').addClass('hide').removeClass('ccs-post-capcha');
                        $('.ccs-input-topic-label > input').removeClass('ccs-error-input').removeClass('ccs-invalid-input');
                    }
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
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
</script>