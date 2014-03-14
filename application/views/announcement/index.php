<div class="row ccs-announcement-row">
    <?php if($this->authentication->is_authorized_function_by_name('Announcement/create_announcement')){ ?>
      <div class="ccs-add-new-forum-announcement-form">
        <?php echo form_open_multipart('announcement/create_announcement',array('name'=>'ccs-announcement-add-form','method'=>'POST')) ?>
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
                            <input type="file" style="color: #222; text-align: center" name="userfile[]"  />
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
    <div class="col-md-12 ccs-announcement">
<?php if($announcements){ ?>
<?php foreach($announcements as $announcement){ ?>
        <a class="ccs-announcement-locator" name="<?php echo $announcement->id ?>"></a>
          <div class="media ccs-announcement-media" data-value="<?php echo $announcement->id ?>">
              
              <div class="media-body col-sm-12">
                <?php echo form_open_multipart('announcement/edit_announcement',array('name'=>'ccs-announcement-edit-form','method'=>'POST')) ?>
                <input type="hidden" name="ann_id" value="<?php echo $announcement->id ?>"/>
                <div class="ccs-announcement-thread-container">
                    <a class="ccs-announcement-thread" href="#" style="word-wrap: break-word"><?php echo htmlspecialchars($announcement->topic)?></a>
                
                
                <div class="media-header">
                  <a class="ccs-profile-image-container <?php echo($announcement->user_id == $this->authentication->user_id())?'ccs-current-owner':'' ?>" href="#" onclick="return false;">
                    <div class="ccs-profile-image">
                        <img class="media-object" src="<?php echo base_url() . $announcement->author_pic ?>" title="<?php echo ucwords($announcement->author_name) ?>">

                  <div class="ccs-announcement-author">
                    <span><?php echo ucwords(htmlspecialchars($announcement->author_name)) ?> <?php echo date('M d, Y',strtotime(htmlspecialchars($announcement->date_posted))) ?></span>
                    <span>Date joined: <?php echo date('m/d/y', strtotime($announcement->author_date_joined)) ?></span>
                    <span><?php echo ucwords($this->authentication->user_type($announcement->author_user_type)) ?></span>
                    <span>Posts : <?php echo $announcement->posts ?></span>
                 </div>  
                    </div>

                  </a>
                  <br/>
                <?php if($this->authentication->is_authorized_function_by_name('Announcement/pin_announcement') || $this->authentication->is_authorized_function_by_name('Announcement/unpin_announcement')){ ?>
                    <div class="<?php echo ($announcement->pinned == 1) ? 'ccs-announcement-unpin' : 'ccs-announcement-pin' ?>" title="<?php echo ($announcement->pinned == 1) ? 'Unpin this announcement.' : 'Pin this announcement' ?>"><i class="<?php echo ($announcement->pinned == 1) ? 'ic-locked' : 'ic-unlocked' ?>"></i></div><br/>
                <?php } ?>
              </div>
                </div>
                <input type="hidden" name="topic" class="form-control input-lg" value="<?php echo $announcement->topic ?>"/>
                <textarea class="ccs-summernote-announcement-edit-container form-control hide" name="detail"></textarea>
                
                     <div class="row ccs-announcement-thread-controls">
                        <a class="col-md-1 fb-share-button" style="padding-bottom:1px;color:#fff;position:relative;" title="Share on Facebook" href="<?php echo base_url() . 'announcement#' . $announcement->id ?>" target="_blank">
                            <i style="font-size:22px;position:absolute;left:12px;top:5px;background: #3b5998;padding:3px 8px;" class="icon-facebook"></i></a>
                        <ul data-value="<?php echo $announcement->id ?>">
                           <li class="ccs-announcement-see-more" data-collapse="0"><a href="#<?php echo $announcement->id ?>"><span class="ic-arrow-down"></span></a></li>
                        <?php if($announcement->user_id == $this->authentication->user_id() || $this->authentication->user_type_id() == 1){ ?>
                            <?php if($this->authentication->is_authorized_function_by_name('Announcement/edit_announcement')){ ?>
                           <li class="ccs-announcement-edit"><a href="#<?php echo $announcement->id ?>"><span class="ic-pencil2"></span></a></li>
                            <?php }
                            if($this->authentication->is_authorized_function_by_name('Announcement/delete_announcement')){ ?>
                           <li class="ccs-announcement-delete"><a href="#"><span class="ic-trash x16"></span></a></li>
                        <?php }} ?>
                        </ul>
                    </div>

                <div class="ccs-announcement-edit-summernote"></div>
                 <a href="#<?php echo $announcement->id ?>" class="btn btn-default ccs-announcement-cancel-btn pull-right hide" type="button" style="border-radius: 0; margin-right: 10px"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
                <button class="btn btn-default ccs-announcement-edit-btn pull-right hide" type="submit" style="border-radius: 0; margin-right: 10px"><i class="glyphicon glyphicon-ok"></i> Save</button>       

                <p class="ccs-announcement-detail" data-height="" style="margin: 0 0px 0 0; text-align: justify;overflow-x: auto">
                    <?php echo $announcement->detail ?>
              
                </p>
                <!-- <a href="https://www.facebook.com/sharer/sharer.php?u=http://127.0.0.1/ccsweb/announcement?id=<?php echo $announcement->id?>" target="_blank">FB</a> -->
                
                <?php if($announcement->file_attachments){ 
                        $files = explode(' ', $announcement->file_attachments); ?>
                
                    <div class="ccs-media-attachments">
                        Attachments: <br/>
                            
                        <?php foreach($files as $file){  ?>
                        <span class="ccs-media-attachments-inner">
                            <input type="hidden" name="attachments[]" value="<?php echo $file ?>"/>
                            <a style="margin-top: 5px; margin-right: 5px" class="ccs-uploaded-attachments" href="<?php echo base_url() . 'announcement/download_file_attachment?file=' . $file ?>"><i style="color: #fff; margin: 2px 3px 0 0" class="ic-paperclip pull-left"></i> <span class="ccs-undo-attachment hide">undo</span><span class="ccs-file-attachment"><?php echo basename($file) ?></span></a>
                            <i class="ic-error hide" style="font-size: 1.5em"></i>
                        </span>
                        <?php } ?> 
                        <br/>
                        <div class="col-sm-6 ccs-attach-files-edit hide" style="padding: 0">
                            <span class="ccs-hide-upload" style="margin-left: 0">
                            <!--     <div class="ccs-replace-upload">
                                    <i class="ic-paperclip"></i>
                                    <input />
                                </div> -->
                                <i class="icon-minus-sign-alt pull-right"></i>
                                <input type="file" name="userfile[]" />
                            </span>
                            <a class="ccs-add-another-attachment" href="#" onclick="return false;">
                                Add
                                <i class="icon-plus-sign-alt"></i>
                            </a>
                        </div>
                        <input type="hidden" name="add_attachment" value="0"/>
                    </div>
                <?php }else{ ?>

                    <div class="ccs-media-attachments" style="padding:0 10px;border:0;height:0;">
                        <span class="ccs-attachment-title hide"> Attachments:</span> <br/>
                        <div class="col-sm-6 ccs-attach-files-edit hide" style="padding: 0">
                            <span class="ccs-hide-upload" style="margin-left: 0">
                            <!--     <div class="ccs-replace-upload">
                                    <i class="ic-paperclip"></i>
                                    <input />
                                </div> -->
                                <i class="icon-minus-sign-alt pull-right"></i>
                                <input type="file" name="userfile[]" />
                            </span>
                            <a class="ccs-add-another-attachment" href="#" onclick="return false;">
                                Add
                                <i class="icon-plus-sign-alt"></i>
                            </a>
                        </div>
                        <input type="hidden" name="add_attachment" value="0"/>
                    </div>
                <?php } ?>
                  
                </form>
                <form method="POST" action="<?php echo base_url() ?>announcement/<?php echo ($announcement->pinned == 1) ? 'unpin_announcement' : 'pin_announcement' ?>">
                    <input type="hidden" name="ann_id" value="<?php echo $announcement->id ?>" />
                </form>
              </div><br/>
          </div>
<?php }}else{ ?>
    <div class="media ccs-announcement-media ccs-forum-media-no-post">
        No Announcements Available... <a href="#" style="text-decoration:none;" class="ccs-no-available-create-post">Create one</a>
    </div>
<?php } ?>
    </div>
</div>
<script>
    $(document).ready(function(){
        var flag = false;

        <?php if($this->session->flashdata('ccs-announcement-edit-status')){ ?>
            find_edited_announcement();
        <?php } ?>

        function find_edited_announcement(){
            var link = location.href,
            slink = link.split('/'),
            ilink = slink[slink.length-1].match(/#[0-9][0-9]*$/gi);
            nlink = (ilink) ? ilink.toString().replace(/^#/,'') : null;

            if(nlink){
                open_edited_announcement(nlink);
            }
        }

        function open_edited_announcement(id){
            var container = $('.ccs-announcement-media[data-value="' + id + '"]');

            $('.media-body > form:eq(0) > .ccs-announcement-detail, .media-body > form:eq(0) > .ccs-media-attachments', container).show();
        }
        
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
                }).attr('title','Enter details here.');
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
               validate_captcha_and_topic(form);
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

    function validate_captcha_and_topic(form){
        var base_url = 'http://localhost/ccsweb/',
            data = form.serialize();

        $.ajax({
            url: base_url + 'announcement/verify_captcha_and_topic',
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
