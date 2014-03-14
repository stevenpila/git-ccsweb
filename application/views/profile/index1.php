<div class="ccs-user-profile">
	<div>
		<div class="ccs-user-activities row">
			<div class="col-md-2 ccs-user-profile-user-type pull-left"><span id="css-profile-employee"><?php echo $profile_details->user_type ?> <i class="ic-arrow-down2"></i></span>
				<i class="ic-pencil2"></i>
				<div class="ccs-user-type-employee" id="css-profile-employee-dropdown">
					<ul>
						<li><input type="text" value="<?php echo $profile_details->firstname; echo (isset($profile_details->middlename))?' '.substr($profile_details->middlename,0,1).'.':''; echo $profile_details->lastname ?>"/></li>
						<li><input type="text" value="Human Resource"/></li>
						<li><input type="text" value="Jefferson Developent Inc."/></li>
						<li><input type="text" value="IT park, Sky Rise 2, Lahug"/></li>
					</ul>
					<div class="ccs-divider"></div>
					<ul>
						<li><input type="text" value="jefferson.com.ph"/></li>
						<li><input type="text" value="jeffesion@gmail.com"/></li>
						<li><input type="text" value="09231323159"/></li>
					</ul>
				</div>
			</div>
			<ul class="col-md-9">
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
                    <div class="ccs-user-profile-picture" style="width: 250px; float: left; margin-top: 14px">
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
                        <form class="ccs-change-profile-picture" method="post" action="<?php echo base_url() ?>profile/upload" enctype="multipart/form-data">
                            <input class="hide" id="ccs-profile-upload-profile-picture" type="file" name="userfile" />
                        </form>
                        <div class="dropdown" id="ccs-profile-picture-dropdown" data-value="<?php echo $picture[count($picture)-1] ?>">
                            <a href="#" data-toggle="dropdown" class="btn btn-default options"><?php echo ($picture[count($picture) - 1] != 'default_profile_picture.jpg')?'<i class="icon-pencil"></i> Edit Profile Picture':'<i class="icon-plus"></i> Add Profile Picture' ?></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                <li><a href="#" class="choose"><i class="icon-picture"></i> Choose from photos...</a></li>
                                <li><a href="#" class="upload"><i class="icon-upload-alt"></i> &nbsp;Upload a photo</a></li>
                                <?php echo ($picture[count($picture) - 1] != 'default_profile_picture.jpg')?'<li><a href="#" class="delete"><i class="icon-remove"></i> &nbsp;Remove this picture</a></li>':''?>
                            </ul>
                        </div>
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
                    <div class="ccs-user-information" id="account-info">
                        <form name="ccs-profile-update-form" method="POST" action="<?php echo base_url() ?>profile/update">
                            <ul>
                                <li>
                                    <span>First Name: </span><input disabled type="text" value="<?php echo ucwords($profile_details->firstname) ?>" name="firstname" placeholder="Your first name" />
                                <li>
                                    <span>Middle Name: </span><input disabled type="text" value="<?php echo ucwords($profile_details->middlename) ?>" name="middlename" placeholder="Your middle name" />
                                </li>   
                                <li>
                                    <span>Last Name: </span><input disabled type="text" value="<?php echo ucwords($profile_details->lastname) ?>" name="lastname" placeholder="Your last name" />
                                </li>
                                <li>
                                    <span>Birth Date: </span>
                                    <div class="input-group ccs-date">
                                        <input type="text" name="birthdate" value="<?php echo (!empty($profile_details->birthdate))?$profile_details->birthdate:'' ?>" disabled/>
                                        <span class="input-group-addon" style="padding: 3px 10px 1px 10px; cursor: pointer"><i class="icon-th"></i></span>
                                    </div>
                                </li>
                                <li>
                                    <span>New Password</span><input disabled type="password" name="newpassword" placeholder="New password" />
                                </li>
                                <li>
                                    <span>Date joined: </span>
                                    <input type="text" disabled value="<?php echo date('M d, Y',  strtotime($profile_details->datecreated)) ?>" title="<?php echo date('F d, Y \a\t h:i A',  strtotime($profile_details->datecreated)) ?>" />
                                </li>
                                <li>
                                    <span>Last login: </span>
                                    <input type="text" disabled value="<?php echo date('M d, Y h:i A',strtotime($profile_details->lastlogin)) ?>" title="<?php echo date('F d, Y \a\t h:i A',  strtotime($profile_details->lastlogin)) ?>" />
                                </li>
                                <li>
                                    <span>Last logout: </span>
                                    <input type="text" disabled value="<?php echo date('M d, Y h:i A',strtotime($profile_details->lastlogout)) ?>" title="<?php echo date('F d, Y \a\t h:i A',  strtotime($profile_details->lastlogout)) ?>" />
                                </li>
                                <li>
                                    <span>Email Address: </span>
                                    <div class="input-group input-group-xm">
                                        <span class="input-group-addon ccs-update-profile-email-checker"><i class="ic-mail"></i></span>
                                        <input type="email" disabled value="<?php echo $profile_details->email ?>" placeholder="Your email" name="email">
                                    </div>
                                </li>
                                <li class="profile-password hide">
                                    <span>Your Password:</span>
                                    <input disabled type="password" name="password" placeholder="Current password" />
                                </li>
                                <li>
                                    <button type="button" id="ccs-user-profile-edit" class="btn" data-hint="0"><i class='icon-pencil'></i> Edit</button>
                                    <button type="button" id="ccs-user-profile-edit-cancel" class="btn hide" data-hint="0" title='Cancel'><i class='icon-remove'></i> Cancel</button>
                                </li>
                            </ul>
                        </form>
                        <div class="ccs-user-recent-activities">
                            <ul>
                                <li class="active">Posts</li>
                                <li>Comments</li>
                                <li>History</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
		</div>	
		<div class="ccs-user-profile-body-posts">
			<div class="ccs-user-profile-posts"><b>Forum</b></div>
            <?php if($forums){
                foreach($forums as $forum){ ?>
			<div class="ccs-user-profile-forum-posts">
                <span><a href="<?php echo base_url() ?>forum/<?php echo $forum->perma_link ?>"><?php echo $forum->topic ?></a></span>
                <?php $detail = strip_tags($forum->detail) ?>
                <span class="ccs-forum-topic-and-reviews-desc"><?php echo (strlen($detail) > 50) ? trim(substr($detail, 0, 50)) . '....' : $detail ?>
                </span>
            </div>
            <?php }} ?>
		</div>
	</div>	
</div>			
<script type="text/javascript">
    $(document).ready(function(){
        var check = false;

        $("#slider").FlowSlider({
            infinite: true,
            controllers: ["Drag"],
            controllerOptions: [{
                el: document
            }]
        }); 
        $('#css-profile-employee').click(function(){
                if(check == false){
                        $('#css-profile-employee-dropdown').addClass('dropIt');
                        check = true;
                }
                else{
                        $('#css-profile-employee-dropdown').removeClass('dropIt');	
                        check = false;
                }
        });
        $('input[name="birthdate"]').datepicker({
            format: 'yyyy/mm/dd'
        });
    });
</script>
<script>
    $(document).ready(function(){
        
        $('form[name="ccs-profile-update-form"]').validate({
            debug: true,
            rules: {
                firstname: "required",
                lastname: "required",
                email: {
                    required: true,
                    email: true
                },
                password: "required"
            },
            messages: {
                firstname: "<i class='icon-asterisk pull-right'></i>",
                lastname: "<i class='icon-asterisk pull-right'></i>",
                email: {
                    required: "<i class='icon-asterisk pull-right'></i>",
                    email: "<span style='font-size:11px;padding: 0px 2px'>Invalid email</span>"
                },
                password: "<i class='icon-asterisk pull-right'></i>"
            },
            onfocusout: false,
            errorClass: 'ccs-error',
            highlight: function(element, errorClass, validClass){
                $(element).addClass(errorClass);
            },
            unhighlight: function(element, errorClass, validClass){
                $(element).removeClass(errorClass);
            },
            errorPlacement: function(error, element){
                error.insertBefore(element);
            },
            submitHandler: function(form){
                var data = $('form[name="ccs-profile-update-form"]').serialize();
                var ccs_form = $('form[name="ccs-profile-update-form"]');

                check_if_password_is_correct(data, ccs_form);
            }
        });
        
        var check_if_password_is_correct = function(data, form){
            $.ajax({
                type: 'POST',
                url: 'http://localhost/ccsweb/profile/check_if_password_is_correct',
                data: data,
                dataType: 'json',
                success: function(output){
                    if(output.status){
                        save_user_profile_changes(form);
                    }
                    else{
                        alert('Incorrect password');
                    }
                },
                error: function(xhr){
                    alert(xhr.responseText);
                }
            });
        }
        var save_user_profile_changes = function(form){
            var value = form.serialize();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>profile/update',
                data: value,
                dataType: 'json',
                success: function(output){
                    if(output.status){
                        alert("Profile successfully updated.");
                        location.reload();
                    }
                    else
                        alert('There was an error on the data you submitted.');
                },
                error: function(xhr){
                    alert(xhr.responseText);
                }
            });
        }
//        function check_if_email_is_valid(email){
//            var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
//
//            return pattern.test(email);
//        }
        
    });
</script>