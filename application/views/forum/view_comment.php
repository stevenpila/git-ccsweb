<div class="ccs-forum-suggested-answer">
    <p data-comment="<?php echo $comment->message ?>"><?php echo nl2br(str_replace(' ','&nbsp;',$comment->message)) ?></p>
    <span class="ccs-date-forum-posted" id="forum"><b><?php echo ucwords($comment->author_name) ?></b> 
        <abbr class="timeago" style="border: 0" title="<?php echo date('c',strtotime($comment->date_posted)) ?>"><?php echo date('F d, Y &#8226; h:i A',  strtotime($comment->date_posted)) ?></abbr>
    </span>
    <?php if($this->authentication->is_authorized_function_by_name('Forum/edit_comment') || $this->authentication->is_authorized_function_by_name('Forum/delete_comment') || ($this->authentication->user_id() == $comment->thread_user_id && $this->authentication->is_authorized_function_by_name('Forum/suggest_comment'))){ ?>
    <div class="ccs-forum-comments-controls">
        <ul data-value="<?php echo $comment->id ?>">
            <li>{</li>
              <?php if($this->authentication->is_authorized_function_by_name('Forum/edit_comment')){ ?>
               <li class="ccs-forum-comment-edit"><a href="#"><span class="ic-pencil"></span></a></li>
              <?php }
              if($this->authentication->is_authorized_function_by_name('Forum/delete_comment')){ ?>
               <li class="ccs-forum-comment-delete"><a href="#"><span class="ic-trash"></span></a></li>
              <?php } ?>
              <?php if($this->authentication->user_id() == $comment->thread_user_id && $this->authentication->is_authorized_function_by_name('Forum/suggest_comment')){ ?>
               <li class="ccs-forum-comment-check"><a href="#"><span class="ic-checkmark"></span></a></li>
              <?php } ?>
            <li>}</li>
            <form method="POST" action="<?php echo base_url() ?>forum/suggest_comment">
                  <input type="hidden" name="perma_link" value="<?php echo $comment->thread_perma_link ?>"/>
                  <input type="hidden" name="topic_id" value="<?php echo $comment->topic_id ?>"/>
                  <input type="hidden" name="comment_id" value="<?php echo $comment->id ?>"/>
            </form>
        </ul>
    </div>
    <?php } ?>
</div>
<script>
    $(document).ready(function(){
        $('abbr.timeago').timeago();
    });
</script>