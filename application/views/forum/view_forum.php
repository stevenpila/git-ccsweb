<!-- <?php print_array($forum) ?> -->
<!-- <?php print_array($comments) ?> -->
<style>
    .ccs-forum-topic-and-reviews-viewer-topic img{
        max-width: 100% !important;
    }
</style>
<div class="row ccs-forum-comment-row">
    <div class="ccs-forum-topic-and-reviews-viewer">
        <a class="col-md-1 fb-share-button" style="padding-bottom:1px;color:#fff;position:relative;" href="<?php echo base_url() . 'forum/' . $forum->perma_link ?>" target="_blank" title="Share on Facebook">
                            <i style="font-size:22px;position:absolute;left:12px;top:5px;background: #3b5998;padding:3px 8px;" class="icon-facebook"></i></a>
        <div class="row ccs-forum-topic-and-reviews-viewer-content">
            <div class="col-md-2 ccs-forum-image-container" style="text-align:center">
                <img src="<?php echo base_url() . $forum->author_pic ?>" />
                <span class="ccs-forum-divider"><?php echo ucwords($forum->author_name) ?></span>
            </div>
            <div class="col-md-10 ccs-forum-topic-and-reviews-viewer-topic"> <span class="ccs-forum-topic-title">" <?php echo htmlspecialchars($forum->topic)?> "</span>
                <br>
                <div class="ccs-forum-topic-and-reviews-viewer-desc">
                <?php echo form_open_multipart('forum/edit_forum',array('name'=>'ccs-announcement-edit-form','method'=>'POST')) ?>
                    <input type="hidden" name="thread_id" value="<?php echo $forum->id ?>"/>
                    <input type="hidden" name="topic" class="form-control input-lg" value="<?php echo $forum->topic ?>"/>
                    <p><?php echo $forum->detail ?></p>
                    <textarea class="ccs-summernote-announcement-edit-container form-control hide" name="detail"></textarea>
                    <div class="ccs-announcement-edit-summernote"></div>
                    <a href="#" class="btn btn-default ccs-view-forum-cancel-btn pull-right hide" type="button" style="border-radius: 0"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
                    <button class="btn btn-default ccs-announcement-edit-btn pull-right hide" type="submit" style="border-radius: 0; margin-right: 10px"><i class="glyphicon glyphicon-ok"></i> Save</button>
                
                <?php if($forum->file_attachments){ 
                        $files = explode(' ', $forum->file_attachments); ?>
                
                    <div class="ccs-media-attachments" style="margin: 10px 0; display: block">
                        <span style="border-bottom:1px dashed rgba(0,0,0,0.2); margin-left: 2px; color: #222"> Attachments:</span> <br/>
                        
                        <?php foreach($files as $file){  ?>
                        <span class="ccs-media-attachments-inner">
                            <input type="hidden" name="attachments[]" value="<?php echo $file ?>"/>
                            <a style="margin-top:5px;margin-right:5px;" class="ccs-uploaded-attachments" href="<?php echo base_url() . 'announcement/download_file_attachment?file=' . $file ?>"><i style="color: #888; margin: 2px 3px 0 0" class="ic-paperclip pull-left"></i> <span class="ccs-undo-attachment hide" title="Undo <?php echo basename($file) ?>">undo</span><span class="ccs-file-attachment"><?php echo basename($file) ?></span></a>
                            <i class="ic-error hide" style="color: #222; font-size: 1.5em" title="Remove <?php echo basename($file) ?>"></i>
                        </span>
                        <?php } ?> 
                        <br/>
                        <div class="col-sm-8 ccs-attach-files-edit hide" style="padding: 0; color: #222; margin-left: -11px; margin-top: 20px">
                            <span class="ccs-hide-upload" style="margin-left: 0">
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
                    <div class="ccs-media-attachments" style="padding: 0; border: 0; height: 0">
                        <span class="ccs-attachment-title hide" style="border-bottom:1px dashed rgba(0,0,0,0.2); margin-left: 2px; color: #222"> Attachments:</span> <br/>
                        <div class="col-sm-6 ccs-attach-files-edit hide" style="padding: 0; color: #222">
                            <span class="ccs-hide-upload" style="margin-left: 0">
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
                    <br/>
                    <span style="font-size: 12px; color: #333"><i>{ <?php echo date('M d, Y', strtotime($forum->date_posted)) ?> }</i></span>
                <?php if($this->authentication->user_id() == $forum->user_id && ($this->authentication->is_authorized_function_by_name('Forum/edit_forum') || $this->authentication->is_authorized_function_by_name('Forum/delete_forum'))){ ?>
                    <span class="ccs-forum-options" data-value="<?php echo $forum->id ?>"><i class="ic-cog"></i>
                         <div class="ccs-forum-thread-controls" id="view-forum-controls">
                            <ul data-value="<?php echo $forum->id ?> ">
                               <?php if($this->authentication->is_authorized_function_by_name('Forum/edit_forum')){ ?>
                               <li class="ccs-view-forum-edit"><a><span class="ic-pencil2"> </span>Edit</a></li>
                               <?php } 
                                    if($this->authentication->is_authorized_function_by_name('Forum/delete_forum')){ ?>
                               <li class="ccs-view-forum-delete"><a><span class="ic-trash"> </span>Delete</a></li>
                               <?php } ?>
                            </ul>
                         </div>
                    </span>
                <?php } ?>
                    </form>
                    <form name="ccs-view-forum-delete-form" method="POST" action="<?php echo base_url() ?>forum/delete_forum/<?php echo $forum->id ?>">
                        <input type="hidden" name="is_delete" value="0"/>
                    </form>
                </div>
            </div>

        </div>
        <div class="ccs-forum-comments">
            <div class="">Comments&nbsp;&nbsp;<i class="ic-chat"></i>
                <div class="ccs-forum-individual-comment">

                <?php if($comments){ ?>
                <?php foreach($comments as $comment){ ?>
                    <?php if($comment->suggested == 1){ ?>
                    <div class="ccs-forum-suggested-answer ccs-is-suggested">
                        <a name="<?php echo $comment->id ?>" style="position:relative; top: -50px"></a>
                        <i class="ic-checkmark"></i>
                        <p style="font-size:15px;" data-comment="<?php echo $comment->message ?>"><?php echo nl2br($comment->message) ?></p>
                        <span class="ccs-date-forum-posted" id="forum"><b><?php echo ucwords($comment->author_name) ?></b> 
                            <abbr class="timeago hide" style="border: 0" title="<?php echo date('c',strtotime($comment->date_posted)) ?>"><?php echo date('F d, Y &#8226; h:i A',  strtotime($comment->date_posted)) ?></abbr>
                        </span>
                    <?php if($this->authentication->user_id() == $comment->user_id || $this->authentication->user_id() == $forum->user_id || $this->authentication->user_type_id() == 1 || $this->authentication->user_type_id() == 4){ ?>
                        <div class="ccs-forum-comments-controls">
                            <ul data-value="<?php echo $comment->id ?>">
                                <li>{</li>
                                <?php if($this->authentication->user_id() == $comment->user_id){  ?>
                                   <li class="ccs-forum-comment-edit"><a href="#"><span class="ic-pencil"></span></a></li>
                                <?php } ?>
                                   <li class="ccs-forum-comment-delete"><a href="#"><span class="ic-trash"></span></a></li>
                                <?php if($this->authentication->user_id() == $forum->user_id){ ?>
                                   <li class="ccs-forum-comment-uncheck"><a href="#"><span style="font-size:10px;" class="ic-close"></span></a></li>
                                <?php } ?>
                                <li>}</li>
                                <form method="POST" action="<?php echo base_url() ?>forum/unsuggest_comment">
                                    <input type="hidden" name="perma_link" value="<?php echo $forum->perma_link ?>"/>
                                    <input type="hidden" name="comment_id" value="<?php echo $comment->id ?>"/>
                                </form>
                            </ul>
                        </div>
                    <?php } ?>
                    </div>
                    <?php }else{ ?>
                    <div class="ccs-forum-suggested-answer">
                        <a name="<?php echo $comment->id ?>" style="position:relative; top: -50px"></a>
                        <p data-comment="<?php echo $comment->message ?>"><?php echo nl2br(str_replace(' ','&nbsp;',$comment->message)) ?></p>
                        <span class="ccs-date-forum-posted" id="forum"><b><?php echo ucwords($comment->author_name) ?></b> 
                            <abbr class="timeago hide" style="border: 0" title="<?php echo date('c',strtotime($comment->date_posted)) ?>"><?php echo date('F d, Y &#8226; h:i A',  strtotime($comment->date_posted)) ?></abbr>
                        </span>
                    <?php if(($this->authentication->user_id() == $comment->user_id || $this->authentication->user_id() == $forum->user_id) && ($this->authentication->is_authorized_function_by_name(($comment->suggested == 1)?'Forum/unsuggest_comment':'Forum/suggest_comment') || $this->authentication->is_authorized_function_by_name('Forum/edit_comment') || $this->authentication->is_authorized_function_by_name('Forum/delete_comment'))){ ?>
                        <div class="ccs-forum-comments-controls">
                            <ul data-value="<?php echo $comment->id ?>">
                                <li>{</li>
                                <?php if($this->authentication->user_id() == $comment->user_id && $this->authentication->is_authorized_function_by_name('Forum/edit_comment')){ ?>
                                   <li class="ccs-forum-comment-edit"><a href="#"><span class="ic-pencil"></span></a></li>
                                <?php } 
                                    if($this->authentication->is_authorized_function_by_name('Forum/delete_comment')){ ?>
                                   <li class="ccs-forum-comment-delete"><a href="#"><span class="ic-trash"></span></a></li>
                                <?php }
                                    if($this->authentication->user_id() == $forum->user_id && $this->authentication->is_authorized_function_by_name(($comment->suggested == 1)?'Forum/unsuggest_comment':'Forum/suggest_comment')){ ?>
                                   <li class="ccs-forum-comment-check"><a href="#"><span class="ic-checkmark"></span></a></li>
                                <?php } ?>
                                <li>}</li>
                                <form method="POST" action="<?php echo base_url() ?>forum/suggest_comment">
                                    <input type="hidden" name="perma_link" value="<?php echo $forum->perma_link ?>"/>
                                    <input type="hidden" name="topic_id" value="<?php echo $forum->id ?>"/>
                                    <input type="hidden" name="comment_id" value="<?php echo $comment->id ?>"/>
                                </form>
                            </ul>
                        </div>
                    <?php } ?>
                    </div>
                <?php }}}
                    if($this->authentication->is_authorized_function_by_name('Forum/create_comment')){ ?>
                    <div class="ccs-forum-add-comment">
                        <br/>
                        <form method="POST" name="ccs-forum-create-comment">
                            <input type="hidden" name="topic_id" value="<?php echo $forum->id ?>" />
                            <label class="ccs-error hide pull-right" for="comment" style="position: absolute; right: 0; margin: 2px 20px 0 0; color: #B94A48">
                                <i class="glyphicon glyphicon-asterisk pull-right"></i>
                            </label>
                            <textarea name="comment" placeholder="Leave a comment..." style="min-width: 100%; max-width: 100%; min-height: 80px"></textarea>
                            <br/><br/>
                            <button class="btn" type="submit">Post</button>
                        </form>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('abbr.timeago').removeClass('hide').timeago();
        $(".ccs-forum-add-comment > form > textarea").autosize();

        find_comment();

        function find_comment(){
            var link = location.href,
            slink = link.split('/'),
            ilink = slink[slink.length-1].match(/#[0-9][0-9]*$/gi);
            nlink = (ilink) ? ilink.toString().replace(/^#/,'') : null;

            if(nlink){
                highlight_comment(nlink);
            }
        }

        function highlight_comment(id){
            var el = $('.ccs-forum-suggested-answer > a[name="' + id + '"]').parent();

            el.css({ backgroundColor: 'rgba(0,0,0,0.2)' });

            setTimeout(function(){ el.css({ backgroundColor: 'rgba(0,255,0,0)' }); }, 5000);
        }

        <?php if($is_edit){ ?>
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

            // $('.ccs-view-forum-cancel-btn').unbind('click');
            // $('.ccs-view-forum-edit').unbind('click');
        <?php } ?>

        $(document).on('paste', '.note-editable', function(){
            var el = $(this).parent().siblings('.ccs-announcement-edit-summernote');

            setTimeout(function(){
                var value = el.code(),
                    sanitize = value.replace(/'/g, "\'").replace(/"/g, '\"').replace(/(<[p|a][\s\S]+?>|<\/[p|a]>)/g, "");

                //alert(sanitize);
                el.code(sanitize);
            }, 0);
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

    function strip_tags(input, allowed){
        allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
        var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
            commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
        return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
            return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
        });
    }
</script>