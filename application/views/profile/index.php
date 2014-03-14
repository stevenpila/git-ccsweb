<?php //print_array($profile_details) ?>
<div class="ccs-user-profile">
	<div>
		<div class="ccs-user-activities">
			<ul>
				<li>Posts
					<div class="ccs-user-activities-posts"><?php echo $profile_details->forum_posts ?></div>
				</li>
				<li>Comments
					<div class="ccs-user-activities-comments"><?php echo $profile_details->comment_posts ?></div>
				</li>
				<li>Polls
					<div class="ccs-user-activities-polls"><?php echo $profile_details->poll_posts ?></div>
				</li>
			</ul>
		</div>
            
		<div class="ccs-user-profile-header-container">
                    <div class="ccs-user-profile-header-container-2">
                        <div class="ccs-user-profile-header">
                            <div class="ccs-user-profile-information">
                                <div class="ccs-user-profile-picture">

                                    <i class="icon-spinner icon-spin icon-5x hide"></i>
                                    <?php
                                        $picture = explode('/',$profile_details->profilepicture);
                                        $uploads = glob('uploads/users/'.md5($profile_details->username).'/*');
                                        echo '<div data-value='.$picture[count($picture)-1].'>
                                                <a class="ccs-profile-image-container ccs-current-owner">
                                                    <img class="media-object" style="width:168px;height:168px" src="'.base_url().$profile_details->profilepicture.'" />
                                                </a>
                                              </div>';
                                    ?>
                                    <?php if(!isset($is_search)){ ?>
                                    <form class="ccs-change-profile-picture" method="post" action="<?php echo base_url() ?>profile/upload" enctype="multipart/form-data">
                                        <input class="hide" id="ccs-profile-upload-profile-picture" type="file" name="userfile" />
                                    </form>
                                    <div class="dropdown" id="ccs-profile-picture-dropdown" data-value="<?php echo $picture[count($picture)-1] ?>">
                                        <a href="#" data-toggle="dropdown" class="btn btn-default options"><?php echo ($picture[count($picture) - 1] != 'default_profile_picture.jpg')?'<i class="icon-pencil"></i>':'<i class="icon-plus"></i>' ?></a>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                            <li><a href="#" class="choose"><i class="icon-picture"></i> Choose from photos...</a></li>
                                            <li><a href="#" class="upload"><i class="icon-upload-alt"></i> &nbsp;Upload a photo</a></li>
                                            <?php echo ($picture[count($picture) - 1] != 'default_profile_picture.jpg')?'<li><a href="#" class="delete"><i class="icon-remove"></i> &nbsp;Remove this picture</a></li>':''?>
                                        </ul>
                                    </div>
                                    <?php } ?>
                                     
                                </div>
                                <div class="ccs-user-personal-information">
                                    <ul>
                                        <li class="ccs-user-profile-name"><?php echo strtoupper($profile_details->full_name) ?></li>
                                        <li class="ccs-user-profile-usertype"><?php echo $this->authentication->user_type($profile_details->usertype) ?></li>
                                        <br>
                                        <li><i class="ic-mail"></i>&nbsp;&nbsp;<span id="my-email"><?php echo $profile_details->email ?></span>

                                            <?php if($profile_details->validemail == 0 && $profile_details->profile_user_id == $this->authentication->user_id()){ ?>
                                                <a id="validate-email" class="label label-danger">Click <strong><u>me</u></strong> to validate this email!</a>
                                                <br>
                                            <?php } ?>
                                        
                                        </li>
                                        <br>
                                        <!-- <?php //echo ($profile_details->validemail == 1)?'validated':'not validated' ?> -->
                                         <?php if($profile_details->validemail == 0 && $profile_details->profile_user_id == $this->authentication->user_id()){ ?>
                                        <li style="padding-top:10px;">Date joined: &nbsp;<?php echo date('M. d, Y',  strtotime($profile_details->datecreated)) ?></li>
                                         <?php } else{ ?>
                                        <li style="padding-top:0px;">Date joined: &nbsp;<?php echo date('M. d, Y',  strtotime($profile_details->datecreated)) ?></li>
                                        <?php } ?>
                                        <li>Last login: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('M. d, Y',strtotime($profile_details->lastlogin)) ?></li>
                                        <li>Last logout: &nbsp;&nbsp;<?php echo date('M. d, Y',strtotime($profile_details->lastlogout)) ?></li>
                                    </ul>
                                </div>
                                <?php if($profile_details->usertype == 3){ ?>
                                <div class="ccs-user-company-information">
                                    <form name="ccs-profile-company-form" id="ccs-profile-company-form-id" method="POST" action="<?php echo base_url() ?>profile/update_company">
                                    <ul>
                                        <li>Company name: <input type="text" name="cname" value="<?php echo $profile_details->companyname ?>" disabled/></li>
                                        <li>Company address: <input type="text" name="caddress" value="<?php echo $profile_details->companyaddress ?>" disabled/></li>
                                        <li>Company email: <input type="text" name="cemail" value="<?php echo $profile_details->companyemail ?>" disabled/></li>
                                        <li>Company website: <input type="text" name="cwebsite" value="<?php echo $profile_details->companywebsite ?>" disabled/></li>
                                        <li>Company contact number: <input type="text" name="cnumber" value="<?php echo $profile_details->companycontactnumber ?>" disabled/></li>
                                        <li>Position: <input type="text" name="cposition" value="<?php echo $profile_details->companyposition ?>" disabled/></li>
                                        <br>
                                        <li class="ccs-password hide">Password: <input type="password" name="password" placeholder="Your password" disabled/></li>
                                        <li class="ccs-profile-update-form-controls">
                                            <button class="edit-profile-company-btn" type="button"><i class="ic-pencil2"></i> Edit</button>
                                            <button class="cancel-edit-profile-company-btn hide" type="button"><i class="icon-remove"></i> Cancel</button>
                                        </li>
                                    </ul>
                                    </form>
                                </div>
                                <?php } ?>
                               <!--  <div>
                                    <ul>
                                        <li value="<?php echo ucwords($profile_details->firstname) ?>"><?php echo ucwords($profile_details->firstname) ?></li>
                                    </ul>
                                </div> -->
                            </div>     
                             <div class="ccs-avatars hide">
                                <div id="slider" class="slider-horizontal ccs-avatar">
                                    <?php
                                        $avatars = glob('assets/img/avatars/*');
                                        $i = 0;
                                        foreach($avatars as $avatar){
                                            $path_parts = pathinfo($avatar); 
                                            $filename = $path_parts['filename'];
                                            $extension = $path_parts['extension'];
                                            echo '<div class="ccs-avatar-container" data-value="'.$filename.".".$extension.'">
                                                    <div style="background-image:url('.$avatar.');background-position: center center;background-repeat: no-repeat;background-size: contain"></div>
                                                 </div>';
                                        }
                                    ?>
                                </div>
                                <div class="center_text">
                                    <button class="btn set"><i class="icon-ok"></i> Set as avatar</button>
                                    <button class="btn cancel"><i class="icon-remove"></i> Cancel</button>
                                </div>
                            </div>
                            <div class="css-profile-count-actions">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <div>
                                                <div><i class="icon-bullhorn"></i></div>
                                                <div>Posts</div>
                                            </div>
                                            <div class="ccs-profile-action-caption">View recent and old posts in forum and announcement</div>
                                        </a>
                                        <div class="ccs-user-information" id="ccs-profile-posts">
                                            <?php if($forums){
                                                foreach($forums as $forum){ ?>
                                            <div class="ccs-user-profile-forum-posts">
                                                <span><a href="<?php echo base_url() ?>forum/<?php echo $forum->perma_link ?>"><?php echo $forum->topic ?></a> <small style="color: #555; font-size: 10px">- <?php echo date('M. d, Y', strtotime($forum->date_posted)) ?></small></span>
                                                <?php $detail = strip_tags($forum->detail) ?>
                                                <span class="ccs-forum-topic-and-reviews-desc"><?php echo (strlen($detail) > 50) ? trim(substr($detail, 0, 50)) . '....' : $detail ?>
                                                </span>
                                            </div>
                                            <?php }}else{ ?>
                                            <div class="ccs-user-profile-forum-posts" align="center">
                                                No Threads/Announcements Posted
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div>
                                                <div><i class="ic-chat"></i></div>
                                                <div>Comments</div>
                                            </div>
                                            <div class="ccs-profile-action-caption">View recent and old comments in forum</div>
                                        </a>
                                        <div class="ccs-user-information" id="ccs-profile-comments">
                                            <?php if($comments){
                                                foreach($comments as $comment){ ?>
                                            <div class="ccs-user-profile-forum-posts">
                                                <span style="color: #999">re: <a href="<?php echo base_url() ?>forum/<?php echo $comment->permalink . '#' . $comment->id ?>"><?php echo $comment->thread ?></a> <small style="color: #555; font-size: 10px">- <abbr class="timeago hide" style="border: 0" title="<?php echo date('c',strtotime($comment->date_posted)) ?>"><?php echo date('F d, Y &#8226; h:i A',  strtotime($comment->date_posted)) ?></abbr></small></span>
                                                <?php $message = strip_tags($comment->message) ?>
                                                <span class="ccs-forum-topic-and-reviews-desc"><?php echo (strlen($message) > 50) ? trim(substr($message, 0, 50)) . '....' : $message ?>
                                                </span>
                                            </div>
                                            <?php }}else{ ?>
                                            <div class="ccs-user-profile-forum-posts" align="center">
                                                No Comments Posted
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </li>
                                    <?php if(!isset($is_search)){ ?>
                                    <li>
                                        <a href="#">
                                            <div>
                                                <div><i class="ic-pencil2"></i></div>
                                                <div>Update Profile</div>
                                            </div>
                                            <div class="ccs-profile-action-caption">Change personal and <!--company-->information</div>
                                        </a>
                                        <div class="ccs-user-information" id="ccs-profile-personal-information">
                                            <form name="ccs-profile-personal-form" method="POST" action="<?php echo base_url() ?>profile/update_information">
                                                <div class="ccs-profile-update-form-header">Personal Information</div>
                                                <ul>
                                                    <li>
                                                        <span>First Name: </span><input type="text" value="<?php echo ucwords($profile_details->firstname) ?>" name="firstname" placeholder="Your first name" disabled/>
                                                    <li>
                                                        <span>Middle Name: </span><input type="text" value="<?php echo ucwords($profile_details->middlename) ?>" name="middlename" placeholder="Your middle name (optional)" disabled/>
                                                    </li>   
                                                    <li>
                                                        <span>Last Name: </span><input type="text" value="<?php echo ucwords($profile_details->lastname) ?>" name="lastname" placeholder="Your last name" disabled/>
                                                    </li>
                                                    <li>
                                                        <span>Birth Date: </span>
                                                        <div class="ccs-date">
                                                            <span><?php echo (!empty($profile_details->birthdate))?date('F d, Y', strtotime($profile_details->birthdate)):'' ?></span>
                                                            <input class="hide bfh-datepicker" type="text" name="birthdate" value="<?php echo (!empty($profile_details->birthdate))?$profile_details->birthdate:'' ?>" disabled readonly onfocus="this.blur()"/>
                                                        </div>
                                                        <!-- <div class="bfh-datepicker"></div> -->
                                                    </li><br/>
                                                    <li>
                                                        <span>Password: </span><input type="password" name="password" placeholder="Your Password" disabled/>
                                                    </li>
                                                    <li class="ccs-profile-update-form-controls">
                                                        <button type="submit"><i class="icon-ok"></i> Submit</button>
                                                        <button type="reset"><i class="icon-refresh"></i> Clear</button>
                                                    </li>
                                                </ul>
                                            </form>
                                         </div>
                                    </li>
                                    <li>
                                        <a href="#"> 
                                            <div>
                                                <div><i class="ic-key"></i></div>
                                                <div>Settings</div>
                                            </div>
                                            <div class="ccs-profile-action-caption">Change current email or password</div>
                                        </a>
                                        <div class="ccs-user-information">
                                            <div class="row">
                                                <form name="ccs-profile-account-form" method="POST" action="<?php echo base_url() ?>profile/update_account">
                                                    <ul class="col-md-6">
                                                        <div class="ccs-profile-update-form-header">Change Password</div>
                                                        <li>
                                                            <span>Current Password: </span>
                                                            <input type="password" name="password" placeholder="Old password" disabled/>
                                                        </li>
                                                        <li>
                                                            <span>New Password: </span>
                                                            <input type="password" name="newpassword" id="newpassword" placeholder="New password" disabled/>
                                                        </li>
                                                         <li>
                                                            <span>Re-type New Password: </span>
                                                            <input type="password" name="confirmpassword" placeholder="Re-type new password" disabled/>
                                                        </li>
                                                        <li class="ccs-profile-update-form-controls">
                                                            <button type="submit"><i class="icon-ok"></i> Change</button>
                                                            <button type="reset"><i class="icon-refresh"></i> Clear</button>
                                                        </li>
                                                    </ul>
                                                </form>
                                                <form name="ccs-profile-email-form" method="POST" action="<?php echo base_url() ?>profile/update_email">
                                                     <ul class="col-md-6">
                                                        <div class="ccs-profile-update-form-header">Change Email</div>
                                                        <li>
                                                            <span>New Email Address: </span>
                                                             <input type="email" placeholder="New email" name="newemail" disabled/>
                                                        </li>
                                                        <li>
                                                            <span>Password: </span>
                                                            <input type="password" name="password" placeholder="Your password" disabled/>
                                                        </li>
                                                        <li class="ccs-profile-update-form-controls">
                                                            <button type="submit"><i class="icon-ok"></i> Change</button>
                                                            <button type="reset"><i class="icon-refresh"></i> Clear</button>
                                                        </li>
                                                    </ul>
                                                </form>
                                            </div>
                                         </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                           
                            </div>
                    </div>
		</div>	


	</div>


</div>			
<script type="text/javascript">
    $(document).ready(function(){
        var check = false,
            base_url = 'http://localhost/ccsweb/';

        $('abbr.timeago').removeClass('hide').timeago();

        <?php if($status === 1){ ?>
            update_profile_status(true);
        <?php }elseif($status === 0){ ?>
            update_profile_status(false);
        <?php } ?>

        $("#slider").FlowSlider({
            infinite: true,
            controllers: ["Drag"],
            controllerOptions: [{
                el: document
            }]
        }); 

        $('input[name="birthdate"]').datepicker({
            format: 'yyyy/mm/dd'
        });
        // $('.bfh-datepicker').bfhdatepicker({
        //     format: 'y-m-d',
        //     name: 'date',
        //     align: 'right'
        // });
        
        
        function update_profile_status(status){
            if(status) Dialog('Profile successfully updated.', 'alert', true, false, function(){}); //alert('Profile successfully updated.');
            else Dialog('There were no changes made.', 'alert', true, false, function(){}); //alert('There were no changes made.');
        }

        $(document).on('click','#validate-email',function(e){
            e.preventDefault();

            var my_email = $('#my-email').html().trim(),
                el = $(this);

            el.prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: base_url + 'account/validate_email',
                data: {
                    email: my_email
                },
                dataType: 'json',
                success: function(result) {
                    $('#toast-container > .toast-info:eq(0)').fadeOut(1000, function(){
                        $(this).remove();
                    });

                    if(result.status === 1) {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-bottom-right",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr.success("Validation code was sent.", "Success")

                        var text = 'Validation code sent. Please enter the code here.';
                        Dialog(text, 'prompt', false, '', function(e){
                            var code = e.trim();

                            if(code !== ''){
                                $.ajax({
                                    type: 'POST',
                                    url: base_url + 'account/verify_validation_code',
                                    data: {
                                        email: my_email, 
                                        validation_code: code
                                    },
                                    dataType: 'json',
                                    success: function(result) {
                                        if(result.status) {
                                            Dialog('Congratulations! You have now a validated email.', 'alert', true, false, function(){});
                                            el.hide();
                                        }
                                        else {
                                            Dialog('Incorrect validation code. Please check your email and try again.', 'alert', true, false, function(){});
                                            el.removeAttr('disabled');
                                        }
                                    },
                                    error: function(xhr,status,error) {
                                        toastr.options = {
                                            "closeButton": true,
                                            "debug": false,
                                            "positionClass": "toast-bottom-right",
                                            "onclick": null,
                                            "showDuration": "300",
                                            "hideDuration": "1000",
                                            "timeOut": "5000",
                                            "extendedTimeOut": "1000",
                                            "showEasing": "swing",
                                            "hideEasing": "linear",
                                            "showMethod": "fadeIn",
                                            "hideMethod": "fadeOut"
                                        }
                                        toastr.error("An error occured. Please try again.", "Oops!")

                                        el.removeAttr('disabled');
                                    }
                                });
                            }
                            else {
                                Dialog('Please enter your validation code and try again.', 'alert', true, false, function(){});
                                el.removeAttr('disabled');
                            }
                        });
                    }
                    else if(result.status === -1) {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-bottom-right",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr.error('Database error occured. Please try again.', "Oops!")

                        el.removeAttr('disabled');                        
                    }
                    else {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-bottom-right",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr.error('Sending validation code failed. Please check your internet connection and try again.', "Oops!")

                        el.removeAttr('disabled');
                    }
                },
                error: function(xhr,status,error) {
                    $('#toast-container > .toast-info:eq(0)').fadeOut(1000, function(){
                        $(this).remove();
                    });

                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "positionClass": "toast-bottom-right",
                        "onclick": null,
                        "showDuration": "3000",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                    toastr.error("An error occured. Please try again.", "Oops!")

                    el.removeAttr('disabled');
                }
            });

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "showDuration": "0",
                "hideDuration": "0",
                "timeOut": "0",
                "extendedTimeOut": "0",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.info('Sending validation code to your email. Please wait.', "Sending...")

        });
    });
</script>



