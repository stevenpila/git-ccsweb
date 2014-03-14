<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>CCS | College of Computer Studies | <?php echo $class ?></title>
        
    <!-- bootstrap -->
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/bootstrap_v3/css/bootstrap.css">
    <!-- font awesome -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-awesome/css/font-awesome.min.css">
    <!-- scrollbar -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/scrollbar/jquery.fs.scroller.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/scrollbar/jquery.mCustomScrollbar.css">
    <!-- datatables -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/datatables/css/dataTables.bootstrap.css">
    <!-- summernote -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/summernote/summernote.css">
    <!-- gallery -->
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/gallery/blueimp-gallery.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/gallery/bootstrap-image-gallery.min.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/gallery/gallery.css" />
    <!-- datepicker -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/datepicker/datepicker.bootstrap.css">
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/js/plugin/timepicker/css/bootstrap-formhelpers.min.css">
    <!-- autoscroll -->
        <!-- <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/autoscroll/autoscroll.css"> -->
    <!-- toastr css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/ccs/toastr.css">
    
    <!-- customize css -->
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/ccs/main.css">
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/ccs/layout.css">
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/ccs/announcement.css">
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/ccs/forum.css">
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/ccs/poll.css">
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/ccs/user-type-request.css">
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/ccs/profile.css">
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/ccs/home.css">
        
    <!-- jquery -->
        <script src="<?php echo base_url() ?>assets/js/plugin/jquery/jquery.js"></script>
    </head>
    <body style="padding-top: 53px; background: #222; position: absolute; top: 0; bottom: 0; left: 0; right: 0">
        <!-- header -->
        <nav class="navbar navbar-inverse navbar-fixed-top ccs-navbar-header" style="border-bottom: 0px" role="navigation"> 
           
            <div class="ccs-search-profile pull-left">
                <input id="ccs-profile-search-textbox" data-provide="typeahead" autocomplete="off" type="text" placeholder="Search Profile.." /> 
               <i class="ic-search2" id="ccs-search-button"></i>
            </div>
             <div class="container-fluid pull-left" style="background: #222; margin-left: 30px">
                <div class="ccs-navbar-header">CCS <span style="font-weight:700;font-style:italic;">Web</span></div>

            </div>
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse" id="bs-example-navbar-collapse-1" style="border: none;">
                    <div class="navbar-inverse">
                        <!--<div class="ccs-navbar-inverse-fields">-->
                            <ul class="nav navbar-nav navbar-right ccs-navbar-inverse-fields" id="css-tabs">
                             
                                <li class="<?php echo ($class == 'Home')?'active':'' ?>" style="display: list-item;"><a href="<?php echo base_url() ?>home">Home</a></li>
                                <?php echo $this->authentication->is_authorized_link_by_name('announcement','Announcement',($class == 'Announcement')?'active':'') ?>
                                <?php echo $this->authentication->is_authorized_link_by_name('forum','Forum',($class == 'Forum')?'active':'') ?>
                                <?php echo $this->authentication->is_authorized_link_by_name('poll','Poll',($class == 'Poll')?'active':'') ?>
                                <?php echo $this->authentication->is_authorized_link_by_name('user_type_request','Request',($class == 'User_type_request')?'active':'') ?>
                                <?php echo $this->authentication->is_authorized_link_by_name('privileges','Privileges',($class == 'Privileges')?'active':'') ?>
                            </ul>
                        <!--</div>-->
                    </div>
                </div>
            </div>
        </nav>
    <!-- end of header -->
    <!-- content -->
        <div class="row ccs-layout-content">
            <div class="ccs-profile-services-vertical-menu">
                 <div class="ccs-profile-image-container ccs-user-name-current-owner">
                    <div class="ccs-profile-image ccs-user-name-profile-picture" style="padding: 8px 8px;">
                        <img src="<?php echo $this->authentication->user_profile_picture() ?>" title="Avatar">
                    </div>
                    <div class="ccs-vertical-menu-span">
                        <div style="vertical-align:middle;color:#ddd;margin-top: -10px" id="ccs-users-name">
                             <div style="font-size:20px;word-break:break-all;">
                                <!--?php echo strtoupper(($this->authentication->user_data()->lastname)) ?-->
                                <?php echo strtoupper($this->authentication->user_name()) ?>
                             </div>
                              <div class="ccs-user-type" style="margin-top: -7px"><?php echo $this->authentication->user_type() ?>
                             </div>
                        </div>
                    </div>
                </div>
                <ul class="css-vertical-menu-ul">
                   <!--  <li><a href="#"><i class="ic-search2"></i>
                        <span class="ccs-vertical-menu-span"><input id="ccs-profile-search-textbox" data-provide="typeahead" autocomplete="off" type="text" placeholder="Search Profile..." onblur="this.parentNode.parentNode.parentNode.className = this.parentNode.parentNode.parentNode.className.replace(/\bactive\b/,'')" onfocus="this.parentNode.parentNode.parentNode.setAttribute('class','active');"></span>
                    </a></li> -->
                    <li class="<?php echo ($class == 'Profile')?'active':'' ?>"><a href="<?php echo base_url() ?>profile"><i class="ic-user2"></i>
                        <span class="ccs-vertical-menu-span">Profile</span>
                    </a></li>
                    <li class="<?php echo ($class == 'Gallery')?'active':'' ?>"><a href="<?php echo base_url() ?>gallery"><i class="ic-pictures"></i>
                        <span class="ccs-vertical-menu-span">Gallery</span>
                    </a></li>
                    <li id="accordion">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">
                            <i class="ic-cog"></i>
                            <span class="ccs-vertical-menu-span">Services</span>
                        </a>
                        <div class="ccs-profile-submenu in" id="collapseOne">
                                <ul>
                                    <?php
                                        foreach ($urls as $key => $value) { 
                                            $flag = FALSE;

                                            foreach ($approved_services as $service_key => $service_value) {
                                                if($value->id == $service_value) {
                                                    $flag = TRUE;
                                                    break;
                                                }
                                            }

                                            $href = (!empty($value->url)) ? $value->url : null;
                                            $service_name = trim($value->name);

                                            if ($is_super == 1) {
                                                echo '<li id="'. $service_name .'"><i class="ic-arrow-down"></i><ul class="ccs-services-submenu-controls"><li class="my-edit" rel="' . $service_name . '"><i class="glyphicon glyphicon-globe"></i> Edit Url</li><li class="my-rename" rel="' . $service_name . '"><i class="glyphicon glyphicon-pencil"></i> Rename Service</li><li class="my-delete" rel="' . $service_name . '"><i class="glyphicon glyphicon-trash"></i> Delete Service</li></ul><a title="'. $service_name .'" href="' . $href . '" target="_blank" rel="' . $service_name . '"><div class="transition" rel="' . $service_name . '">' . $service_name .'</div></a></li>';
                                            }
                                            elseif ($flag) {
                                                echo '<li id="'. $service_name .'"><i class="ic-arrow-down"></i><ul class="ccs-services-submenu-controls"><li class="my-edit" rel="' . $service_name . '"><i class="glyphicon glyphicon-globe"></i> Edit Url</li><li class="my-rename" rel="' . $service_name . '"><i class="glyphicon glyphicon-pencil"></i> Rename Service</li></ul><a title="'. $service_name .'" href="' . $href . '" target="_blank" rel="' . $service_name . '"><div class="transition" rel="' . $service_name . '">' . $service_name .'</div></a></li>';
                                            }
                                            else {
                                                echo '<li><a title="'. $service_name .'" href="' . $href . '" target="_blank" rel="' . $service_name . '"><div class="transition" rel="' . $service_name . '">' . $service_name .'</div></a></li>';
                                            }
                                        }

                                        if($is_super == 1) {
                                            echo '<li id="ccs-add-service-button"><a href="#"><span class="ccs-add-new-service"><i class="glyphicon glyphicon-plus-sign"></i> Add Service</span></a></li>';
                                        }
                                    ?>
                                </ul>
                        </div>
                    </li>
                    <li><a href="<?php echo base_url() ?>account/logout"><i class="ic-switch"></i>
                        <span class="ccs-vertical-menu-span">Sign out</span>
                    </a></li>
                </ul>

            <div class="ccs-hide-or-show-vertical-menu"><span class="ic-arrow-left"></span></div>
            </div>
            <div class="col-md-12 ccs-content-container">
                <?php if($links[0]['link_name'] != 'Home'){ ?>
                <div class="ccs-breadcrumbs">
                    <ul>
                        <li><a href="<?php echo base_url() ?>home">Home</a></li>
                    <?php for($i=0;$i<count($links);$i++){ ?>
                        <li style="color: #fff; font-weight: bold"><i class="icon-caret-right"></i></li>
                        <li class="<?php echo ($i==count($links)-1)?'active':'' ?>"><a href="<?php echo $links[$i]['link'] ?>"><?php echo $links[$i]['link_name'] ?></a></li>
                    <?php } ?>
                    </ul>
                </div>
                <?php } ?>
                <?php echo $content ?>
            </div>
        </div>

                                    
                                    
    
    <!-- modal -->
        <div class="modal fade" id="ccs-global-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body" style="height: auto !important">
                </div>
                <div class="modal-footer">
                </div>
              </div>
            </div>
        </div>

        <div class="ccs-submit-delete-privileges-container">
            <a class="btn btn-warning" style="border-radius: 50% 50%" href="#" title="Delete selected rows."><i class="ic-trash"></i></a>
        </div>

        <div class="dialog-layout" style="text-align:center;" tabindex="-1">
            <!-- DO YOU WANT TO TAKE A SHIT?
            <button id="btn-del-layout" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></button>
            <button id="btn-cancel-layout" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button> -->
        </div>
        <div class="overlay-bg-layout">
        </div>
        <!-- <div class="navbar navbar-static-bottom navbar-inverse" style="color: #fff; text-align: center; padding-top: 12px; margin-bottom: 0; border-radius: 0">
            &COPY; 2013 All Rights Reserved. Software Engineering Project. CCS Website.
        </div> -->
    <!-- end of content -->
        
    <!-- gallery -->
        <script src="<?php echo base_url() ?>assets/js/plugin/gallery/jquery.blueimp-gallery.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/plugin/gallery/bootstrap-image-gallery.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/plugin/gallery/image-gallery.js"></script>
        <script src="<?php echo base_url() ?>assets/js/plugin/gallery/jquery.fullscreen-min.js"></script>
    <!-- form validation -->
        <script src="<?php echo base_url() ?>assets/js/plugin/formvalidator/dist/jquery.validate.min.js"></script>
    <!-- timeago -->
        <script src="<?php echo base_url() ?>assets/js/plugin/timeago/jquery.timeago.js"></script>
    <!-- bootstrap -->
        <script src="<?php echo base_url() ?>assets/css/bootstrap_v3/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/plugin/timepicker/js/bootstrap-formhelpers-number.js"></script>
        <script src="<?php echo base_url() ?>assets/js/plugin/timepicker/js/bootstrap-formhelpers-selectbox.js"></script>
        <script src="<?php echo base_url() ?>assets/js/plugin/timepicker/js/bootstrap-formhelpers-datepicker.js"></script>
        <script src="<?php echo base_url() ?>assets/js/plugin/timepicker/js/bootstrap-formhelpers-timepicker.js"></script>
    <!-- datatables -->
        <script src="<?php echo base_url() ?>assets/js/plugin/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/plugin/datatables/dataTables.bootstrap.js"></script>
    <!-- scrollbar -->
        <script src="<?php echo base_url() ?>assets/js/plugin/scrollbar/jquery.scroller.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/plugin/scrollbar/jquery.mousewhweel.js"></script>
        <script src="<?php echo base_url() ?>assets/js/plugin/scrollbar/jquery.mCustomScrollbar.js"></script>
    <!-- summernote -->
        <script src="<?php echo base_url() ?>assets/js/plugin/summernote/summernote.min.js"></script>
    <!-- autosize -->
        <script src="<?php echo base_url() ?>assets/js/plugin/autosize/jquery.autosize.min.js"></script>
    <!-- datepicker -->
        <script src="<?php echo base_url() ?>assets/js/plugin/datepicker/datepicker.bootstrap.js"></script>
    <!-- slider -->
        <script src="<?php echo base_url() ?>assets/js/plugin/slider/flowslider.jquery.js"></script>
    <!-- toastr js -->
        <script src="<?php echo base_url() ?>assets/js/ccs/toastr.js"></script>
    <!-- typeahead -->
        <script src="<?php echo base_url() ?>assets/js/plugin/typeahead/bootstrap3-typeahead.js"></script>
    <!-- modernizr -->
        <script src="<?php echo base_url() ?>assets/js/plugin/modernizr/modernizr.js"></script>
    <!-- autoscroll -->
        <!--script src="<?php echo base_url() ?>assets/js/plugin/autoscroll/autoscroll.js"></script-->
    <!-- customize js -->
        <script src="<?php echo base_url() ?>assets/js/ccs/main.js"></script>
        <script src="<?php echo base_url() ?>assets/js/ccs/layout.js"></script>
        <script src="<?php echo base_url() ?>assets/js/ccs/user-type-request.js"></script>
<!--        <script src="<?php echo base_url() ?>assets/js/ccs/modules.js"></script>
        <script src="<?php echo base_url() ?>assets/js/ccs/methods.js"></script>
        <script src="<?php echo base_url() ?>assets/js/ccs/module-details.js"></script>
        <script src="<?php echo base_url() ?>assets/js/ccs/user-type-details.js"></script>-->
        <script src="<?php echo base_url() ?>assets/js/ccs/forum.js"></script>
        <script src="<?php echo base_url() ?>assets/js/ccs/announcement.js"></script>
        <script src="<?php echo base_url() ?>assets/js/ccs/poll.js"></script>
        <script src="<?php echo base_url() ?>assets/js/ccs/privileges.js"></script>
        <script src="<?php echo base_url() ?>assets/js/ccs/profile.js"></script>
        <script src="<?php echo base_url() ?>assets/js/ccs/gallery.js"></script>        

        <script>
            $(document).ready(function(){
                var enteredMaxWidth = 0;
                var exitMaxWidth = 0;
                media_query();
                $('#ccs-search-button').click(function(){
                    $('#ccs-profile-search-textbox').toggleClass('dropItXSearch');
                });

                $(window).resize(function(){
                    $('.ccs-profile-services-vertical-menu').mCustomScrollbar('update');
                    media_query();
                });

                function media_query(){


                    if(Modernizr.mq('(max-width: 763px)')){
                        enteredMaxWidth += 1;
                        if(enteredMaxWidth == 1){
                            $('#ccs-users-name').hide();
                            $('.ccs-layout-content').css('padding-left','50px');
                            $('.ccs-hide-or-show-vertical-menu span').addClass('ic-uniE611').removeClass('ic-arrow-left');
                            $('.ccs-hide-or-show-vertical-menu').css('left','0');
                            $('#collapseOne').removeClass('in').addClass('collapse');
                            exitMaxWidth = 0;
                        }
                    }
                    else{
                        exitMaxWidth += 1;
                        if(exitMaxWidth == 1){
                            $('.ccs-layout-content').css('padding-left','250px');
                             $('.ccs-profile-services-vertical-menu').css({
                                width: '250px'
                            }).promise().done(function(){
                                $('#ccs-users-name').show();
                            });
                            $('.ccs-hide-or-show-vertical-menu').css('left','200px');
                            $('.ccs-profile-services-vertical-menu span.ccs-vertical-menu-span').show();
                            $('.ccs-hide-or-show-vertical-menu span').addClass('ic-arrow-left').removeClass('ic-uniE611');
                            enteredMaxWidth = 0;
                        }
                    }
                }

                $('.ccs-profile-services-vertical-menu').mCustomScrollbar({
                    autoHideScrollbar: true,
                    scrollInertia: 150,
                    advanced: {
                        updateOnBrowserResize: true,
                        updateOnContentResize: true
                    }
                });

                var base_url = 'http://localhost/ccsweb/';
                
                $.ajax({
                    type: 'POST',
                    url: base_url + 'account/is_valid_email',
                    dataType: 'json',
                    success: function(result) {
                        if(result.email_notification && result.invalid) {
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "positionClass": "toast-bottom-right",
                                "onclick": true,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": false,
                                "extendedTimeOut": false,
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            toastr.info("Your email is Not yet validated. Please go to profile and validate your email.")

                            $('button.toast-close-button').click(function(e){
                                $.ajax({
                                    type: 'POST',
                                    url: base_url + 'account/toggle_notif',
                                    dataType: 'json',
                                    success: function(result) {},
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
                                        toastr.error(error, "Oops!")
                                    }
                                });
                            });
                        }
                    }
                    /*error: function(xhr,status,error) {
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
                        toastr.error(error, "Oops!")
                    }*/
                });

            });
        </script>
    </body>
</html>