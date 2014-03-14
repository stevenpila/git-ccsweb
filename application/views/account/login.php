<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CCS | College of Computer Studies</title>
        <link rel="icon" type='image/png' href='<?php echo base_url() ?>assets/img/ccs_logo.png'/>
        
    <!-- bootstrap -->
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/bootstrap_v3/css/bootstrap.css">
    <!-- font awesome -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-awesome/css/font-awesome.min.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/ccs/orange.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/ccs/noJS.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/ccs/dropdownstyle.css">
        
    <!-- scrollbar -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/scrollbar/jquery.fs.scroller.css">
        
    <!-- customize css -->
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/ccs/main.css">

    <!-- toastr css -->
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/ccs/toastr.css">
        <link rel="stylesheet" media="screen" href="<?php echo base_url() ?>assets/css/ccs/account.css">
    </head>
    <body style="position: absolute; top: 0; bottom: 0; left: 0; right: 0">
        
          <div class="row ccs-account-container" style="height: 100%">
          <div class="col-md-8 col-sm-8 col-lg-9 ccs-home-page" style="overflow-y: hidden; height: 100%; padding: 0; background: #ff5200">
                 <?php
                $images = glob('uploads/albums/slides/*');
                $new_images = array();

                 foreach($images as $image){
                  $path_parts = pathinfo($image);
                  $image_name = $path_parts['filename'];
                  $extension = $path_parts['extension'];

                  if($extension != 'txt') array_push($new_images, $image);
                }

                $i = count($new_images);
                $loop = ceil($i / 5);
              ?>
        <div id="ccs-toggle-carousel" class="col-md-12 col-xs-12" style="padding:0;">
            <div id="carousel-example-generic" class="carousel slide" style="background:#fff; padding: 50px auto;">

              <!-- Wrapper for slides -->
                <div class="carousel-inner ccs-gallery-thumbnail-carousel">
                  <!--?php for(;;){ ?-->
                  <?php for($j = 1; $j <= $loop ; $j++){ 
                        $count = 1; ?>
                  <div class="item <?php echo ($j == 1) ? 'active' : '' ?>">
                    <div class="row" style="width: 100%; text-align:center; white-space: nowrap">
                    <?php for($l = (($j - 1) * 5), $m = (($j - 1) * 5) ; $l < $i ; $l++){
                      $path_parts = pathinfo($new_images[$l]);
                      $image_name = $path_parts['filename'];
                      $extension = $path_parts['extension'];

                      if($l < ($m + 5)){ ?>

                        <div class="ccs-gallery-thumbnail" style="display: inline-block">
                          <a href="#" class="thumbnail">
                            <img src="<?php echo base_url() . $new_images[$l] ?>" id="<?php echo $m ?>" alt="<?php echo $image_name ?>" style="width:9vw; height:9vw;">
                           </a>
                        </div>
                    <?php }} ?>
                    </div>
                  </div>
                  <?php } ?>
                </div>
             
              <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
          </div>

              
                      <div class="ccs-toggle-images">
                        <button class="btn btn-default">Toggle <i class="ic-arrow-up"></i></button>
                      </div>
                       <div class="col-md-8 col-xs-12" class="ccs-image-div-viewer" style="text-align:center;">
                          <div id="front_div">             
                            <video  id="movie1" width="100%" height="50%">
                              <source src="../assets/video/ccs.mp4" type="video/mp4">
                            </video>
                          </div>
                        <img id="imageBox" src="" style="margin-left: 20px"/>
                      </div>
                     <div class="col-lg-4 col-md-4 col-xs-12 ccs-web-text" style="text-align:center;">CCS <span style="font-weight:700;font-style:italic;">Web</span>
                         <p id="join-us">Join Us!</p>
                     </div>

                     <!-- <div class="col-md-12 pull-right row-footer">
                          <img src="<?php echo base_url() ?>assets/img/ccslogo.png">
                    </div> -->
        </div> <!-- additional content here -->
            <div class="col-md-4 col-sm-4 col-lg-3 ccs-login-page">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#sign-in" data-toggle="tab" class="sign-in-tab"><span class="ic-user black x48"></span></a></li>
                    <li class="pull-right" style="margin-right: -2px"><a href="#sign-up" data-toggle="tab" class="sign-up-tab"><span class="ic-users black x48"></span></a></li>
                </ul>
                <div class="tab-content" style="overflow-y: hidden">

                <div class="tab-pane active" id="sign-in">
                    <div id="sign-in-text">Sign in</div>
                    <div class="ccs-sign-in-form">
                        <form name="sign_in" action="<?php echo base_url() ?>account/login" method="POST" class="form-horizontal" role="form">
                          <div name="validation_errors" class="hide"><?php echo (isset($signin_status))?(!$signin_status)?validation_errors():'<div class="alert alert-danger"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;<b>Username</b>/<b>Password</b> is invalid.</div>':''; ?></div>
                          <div class="row" id="">
                              <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-10" style="padding: 0">
                                 <div id="ccs-sign-in-form-inputs"> 
                                    <div class="form-group" style="margin: 0">
                                      <input type="text" name="username" class="input form-control" placeholder="Username" autofocus>
                                    </div>
                                    <div class="form-group" style="margin: 0">
                                      <input type="password" name="password" class="input form-control " placeholder="Password">
                                    </div>
                                    <a id="forgot_password_link" href="#forgot_password_modal" data-toggle="modal">Forgot Password?</a>
                                 </div>
                                <br>
                              </div>
                          </div>
                            <div style="display: inline-block; margin: 0 auto; width: 100%" align="center">
                              <div class="moodle-text-checkbox" autocomplete="off">
                                  <button type="submit" class="log-in-btn">Log in</button>
                                  <input type="checkbox" id="ccs-moodle-login-checkbox" style="cursor: pointer; visibility: hidden"/> 
                                  <label for="ccs-moodle-login-checkbox" style="cursor: pointer; font-weight: normal; visibility: hidden">to Moodle </label>
                              </div>
                            </div>
  <!--<script type="text/javascript" src="<?php echo base_url() ?>js/ccs/moodle.js"></script>-->
                        </form>
                    </div>
                </div>
              <div class="tab-pane" id="sign-up">
                <div class="ccs-sign-up-form">
                <form name="sign_up" action="<?php echo base_url() ?>account/signup" method="POST" class="form-horizontal" role="form">
                <div class="form-group" style="margin-top: 15px">
                    <label class="ccs-error-left hide" for="user_type">
                        <i class="glyphicon glyphicon-asterisk pull-right"></i>
                    </label>
                    <div id="dd" name="user_type" class="wrapper-dropdown-1 sign-up-dropdown" tabindex="1" style="padding-top: 10px; padding-bottom: 12px">
                        <span>Sign up as</span>
                        <ul class="dropdown" tabindex="1">
                            <li data-value="7"><a href="#">Guest</a></li>
                            <li data-value="5"><a href="#">Alumni</a></li>
                            <li data-value="4"><a href="#">Faculty</a></li>
                            <li data-value="3"><a href="#">Employee</a></li>
                            <li data-value="2"><a href="#">Administrator</a></li>
                        </ul>
                        <input type="hidden" name="user_type" />
                    </div>
                </div>
                <div class="form-group ccs-sign-up-fields" style="margin-top: 14px">
                  <div class="row">
                    <div class="col-md-12" style="padding: 0 ">
                      <div class="form-group ccs-sign-up-name">
                        <div class="input-group">
                          <span class="input-group-addon"><input type="text" name="first_name" class="text-field-style form-control input-lg" placeholder="First Name" title="This field is required."></span>
                          <span class="input-group-addon"><input type="text" name="last_name" class="form-control input-lg" placeholder="Last Name" title="This field is required."></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="ccs-sign-up-email-checker ccs-hidden"><i class="icon-spinner icon-spin"></i></label>
                        <input type="text" name="email" class="form-control input-lg" id="ccs-sign-up-email" placeholder="Email" title="This field is required.">
                      </div>
                      <div class="form-group">
                        <label class="ccs-error-left hide" for="secret_question">
                            <i class="glyphicon glyphicon-asterisk pull-right"></i>
                        </label>
                      <div id="sq" name="secret_question" class="wrapper-dropdown-1 secret-question-dropdown" tabindex="1" title="This field is required." style="padding-top: 10px; padding-bottom: 12px">
                            <span>Secret Question</span>
                            <ul class="dropdown" tabindex="1">
                                <?php foreach($secret_questions as $secret_question){ ?>
                                <li data-value="<?php echo $secret_question->id ?>"><a href="#"><?php echo $secret_question->name ?></a></li>
                                <?php } ?>
                            </ul>
                            <input type="hidden" name="secret_question" />
                      </div>
                      </div>
                      <div class="form-group">
                        <input type="text" name="secret_answer" class="form-control input-lg" placeholder="Secret Answer" title="This field is required.">
                      </div>
                      <div class="form-group">
                        <label class="ccs-sign-up-username-checker ccs-hidden"><i class="icon-spinner icon-spin"></i></label>
                        <input type="text" name="username" class="form-control input-lg" id="ccs-sign-up-username" placeholder="Username" title="This field is required.">
                      </div>
                      <div class="form-group">
                        <input type="password" name="password" class="form-control input-lg" id="ccs-sign-up-password" placeholder="Password" title="This field is required.">
                      </div>
                      <div class="form-group">
                        <input type="password" name="confirm_password" class="form-control input-lg" placeholder="Confirm Password" title="This field is required.">
                      </div>
                      <div class="form-group ccs-sign-up-service-form hide">
                        <label class="ccs-error-left hide" for="service_type">
                            <i class="glyphicon glyphicon-asterisk pull-right"></i>
                        </label>
                        <div id="st" name="service_type" class="wrapper-dropdown-1 service-type-dropdown" tabindex="1" title="This field is required." style="padding-top: 10px; padding-bottom: 12px">
                            <span>Service Type</span>
                            <ul class="dropdown" tabindex="1">
                                <?php foreach($service_types as $service_type){ ?>
                                <li data-value="<?php echo $service_type->id ?>"><a href="#"><?php echo $service_type->name ?></a></li>
                                <?php } ?>
                            </ul>
                            <input type="hidden" name="service_type" disabled/>
                        </div>  
                      </div>
                    </div>
                  </div>
                  <div class="row ccs-sign-up-company-form hide">
                      <div class="col-md-12" style="padding: 0">
                          <div class="form-group">
                            <label class="ccs-error-left hide" for="company_service_type">
                                <i class="glyphicon glyphicon-asterisk pull-right"></i>
                            </label>
                            <div id="cst" name="company_service_type" class="wrapper-dropdown-1 company-sign-up-dropdown" tabindex="1" title="This field is required." style="padding-top: 10px; padding-bottom: 12px">
                                <span>Service Type</span>
                                <ul class="dropdown" tabindex="1">
                                    <?php foreach($service_types as $service_type){ ?>
                                    <?php if(array_search($service_type->id, array(3,4,5,6)) !== FALSE){ ?>
                                        <li data-value="<?php echo $service_type->id ?>"><a href="#"><?php echo $service_type->name ?></a></li>
                                    <?php }} ?>
                                </ul>
                                <input type="hidden" name="company_service_type" disabled/>
                            </div>
                          </div>
                          <div class="form-group" style="text-align: left !important;font-size:15px;">
                              Company Profile 
                          </div>
                          <div class="form-group">
                            <input type="text" name="company_name" class="form-control input-lg" placeholder="Name" title="This field is required." disabled>
                          </div>
                          <div class="form-group">
                            <input type="text" name="company_address" class="form-control input-lg" placeholder="Address" title="This field is required." disabled>
                          </div>
                          <div class="form-group">
                            <input type="email" name="company_email" class="form-control input-lg" placeholder="Email" title="This field is required." disabled>
                          </div>
                          <div class="form-group">
                            <input type="text" name="company_website" class="form-control input-lg" placeholder="Website" title="This field is required." disabled>
                          </div>
                          <div class="form-group">
                            <input type="text" name="company_contact_number" class="form-control input-lg" placeholder="Contact Number" title="This field is required." disabled>
                          </div>
                          <div class="form-group" style="margin-bottom: 5px">
                            <input type="text" name="company_position" class="form-control input-lg" placeholder="Position e.g. Manager, Employee, etc." title="This field is required." disabled>
                          </div>
                      </div>
                  </div>
                  <input type="hidden" name="service_form" value="1" disabled/>
                  <input type="hidden" name="company_form" value="1" disabled/>
                </div>
                
                <div class="form-group" style="padding: 0 0 8px 0; font-size: 12px; color: #999">
                    By clicking Sign up, you agree to our <b>Terms</b> and <b>Conditions</b>.
                </div>
                <div class="form-group">
                  <button type="submit" class="log-in-btn">Sign up</button>
                </div>
                <input type="hidden" id="ccs-captcha-checker" value="0"/>
                </form>
                    </div>
                 </div>
               </div>
             </div>
            </div><!-- ROW -->
        
    <!-- modal for sign in form -->
        <div class="modal fade ccs-sign-in-checker-container" id="ccs-sign-in-moodle-checker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content" style="height: 285px !important">
                <div class="modal-body">
                    <h1>Processing . . .</h1><br/>
                    <div class="ccs-sign-in-checker first">Checking if Account is valid (Moodle)<i class="glyphicon pull-right hide"></i><div class="ccs-sign-in-loader pull-right"></div></div>
                    <div class="ccs-sign-in-checker second ccs-hidden"><span>Signing in to Moodle</span><i class="glyphicon pull-right hide"></i><div class="ccs-sign-in-loader pull-right"></div></div>
                    <div class="ccs-sign-in-checker third ccs-hidden">Submitting form for CCS Website<div class="ccs-sign-in-loader pull-right"></div></div>
                </div>
              </div>
            </div>
        </div>

    <!-- modal for captcha -->
        <div class="modal fade" id="ccs-captcha-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width: 400px">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><font size=5 face="Verdana"><b>Captcha</b></font></h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                          <span class="input-group-addon" style="background: transparent; border-radius: 0; border: 0; padding: 0 0 10px; text-align: left"><span id="ccs-captcha-container"><?php echo $captcha['captcha'] ?><input type="hidden" name="captcha_id" value="<?php echo $captcha['captcha_id'] ?>"/></span> 
                          <label class="btn btn-warning btn-sm" id="ccs-captcha-word-refresh" title="Generate another captcha word." style="border-radius: 0">Refresh <i class="icon-refresh"></i></label></span>
                          <label class="ccs-error pull-right hide" for="topic" style="position: absolute; right: 0; margin: 3px 20px 0 0; color: #B94A48">
                              <i class="glyphicon glyphicon-asterisk pull-right"></i>
                          </label>
                          <input type="text" name="captcha" class="input form-control" placeholder="Word Here" style="border-radius: 0; box-shadow: none" title="Enter captcha word here." onkeypress="if(event.keyCode == 13){ document.getElementById('ccs-captcha-word-submit').click(); return false; }">
                      </div>
                </div>
                <div class="modal-footer">
                    <button type='button' class='btn btn-warning btn-sm' id="ccs-captcha-word-submit" title='Submit' style="border-radius: 0">Submit</button>
                    <button type='button' class='btn btn-sm' data-dismiss='modal' title='Cancel' style="border-radius: 0">Cancel</button>
                </div>
              </div>
            </div>
        </div>

<!-- <<<< ======================================== FORGOT PASSWORD MODAL ======================================== -->
        <div class="modal fade" id="forgot_password_modal" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="width:500px">
            <div class="modal-content">
              <div class="modal-header">
                <a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                <h4 class="modal-title forgot" id="myModalLabel"></h4>
              </div>
              <form method="POST" id="forgot-form">
                <div class="modal-body forgot"></div>
                <div class="modal-footer forgot"></div>
              </form>
            </div>
          </div>
        </div>
        
<!-- ======================================== FORGOT PASSWORD MODAL ======================================== >>>> -->

    <!-- moodle logout container -->
        <div class="ccs-moodle-logout-container"></div>
        
    <!-- sign up error -->
        <div class="ccs-sign-up-error hide">
            <div class="alert alert-danger" style="margin: 20px 0 0 0"><i class="glyphicon glyphicon-remove"></i> Email not available.</div>
            <div class="alert alert-danger" style="margin: 10px 0 10px 0"><i class="glyphicon glyphicon-remove"></i> Username not available.</div>
        </div>
    <!-- customized dialog -->
        <div class="dialog-layout" style="text-align:center;">
            <!-- DO YOU WANT TO TAKE A SHIT?
            <button id="btn-del-layout" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></button>
            <button id="btn-cancel-layout" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button> -->
        </div>
        <div class="overlay-bg-layout">
        </div>

    <!-- jquery -->
        <script src="<?php echo base_url() ?>assets/js/plugin/jquery/jquery.js"></script>
    <!-- bootstrap -->
        <script src="<?php echo base_url() ?>assets/css/bootstrap_v3/js/bootstrap.js"></script>
    <!-- checkbox style -->
        <script src="<?php echo base_url() ?>assets/js/plugin/checkbox/icheck.min.js"></script>
    <!-- form validation -->
        <script src="<?php echo base_url() ?>assets/js/plugin/formvalidator/dist/jquery.validate.min.js"></script>
    <!-- scrollbar -->
        <script src="<?php echo base_url() ?>assets/js/plugin/scrollbar/jquery.scroller.min.js"></script>
    <!-- placeholder for IE -->
        <script src="<?php echo base_url() ?>assets/js/plugin/placeholder/placeholder.js"></script>
    <!-- customize js -->
        <script src="<?php echo base_url() ?>assets/js/ccs/main.js"></script>
    <!-- forgot password js -->
        <script src="<?php echo base_url() ?>assets/js/ccs/forgot.js"></script>
    <!-- toastr js -->
        <script src="<?php echo base_url() ?>assets/js/ccs/toastr.js"></script>

    <!-- internal scripts [ necessary ] -->
        <script>
            $(document).ready(function(){
              $('input').each(function(){
                var self = $(this),
                    label = self.next(),
                    label_text = label.text();

                label.remove();
                self.iCheck({
                  checkboxClass: 'icheckbox_line-orange',
                  radioClass: 'iradio_line-orange',
                  insert: '<div class="icheck_line-icon"></div>' + label_text
                });
              });
            });
        </script>
        <script>
            $(document).ready(function(){
                var base_url = 'http://localhost/ccsweb/';

                $('#carousel-example-captions').carousel({
                  interval: false
                });
                $('#carousel-example-captions2').carousel();
                $('.left.carousel-control[href="#carousel-example-captions"]').click(function(){
                  $('.left.carousel-control[href="#carousel-example-captions2"]').click();
                });
                $('.right.carousel-control[href="#carousel-example-captions"]').click(function(){
                  $('.right.carousel-control[href="#carousel-example-captions2"]').click();
                });
                $('.ccs-sign-up-fields').scroller();
                $('a[data-toggle="tab"].sign-in-tab').on('shown.bs.tab', function (e) {
                    //e.target; // activated tab
                    $('input[name="username"]').focus();
                });
                $('a[data-toggle="tab"].sign-up-tab').on('shown.bs.tab', function (e) {
                    //e.target; // activated tab
                    $('.ccs-sign-up-fields').scroller('reset');
                });
            <?php if(isset($signin_status) && !$signin_status){ ?>
                Dialog('Invalid username/password.', 'alert', true, false, function(){});
            <?php } ?>
            });
        </script>
        <script>
           var ed = "";
            $(document).ready(function(){
              $('.ccs-gallery-thumbnail').click(function(){
                  var src = $('img', this).attr('src');

                  $('#imageBox').attr('src', src).show();
                  $('#front_div').hide();
              });


              $('#front_div').click(function(){
                  // $('#front_div').attr("class","front_div2");
                  // alert("played");
                  $('#movie1')[0].play();
              });

              $('#imageBox').click(function(){
                    $('#imageBox').css('display', 'none');
                    $('#front_div').show();

              });
            }); 
        </script>
        <script type="text/javascript">
          $(document).ready(function() {
            $('.carousel').carousel({
              interval: 10000
            });

            $('.ccs-toggle-images button').click(function(){
              if($('#ccs-toggle-carousel').css('display') != 'none') $('i', this).removeClass('ic-arrow-up').addClass('ic-arrow-down');
              else $('i', this).removeClass('ic-arrow-down').addClass('ic-arrow-up');

              $('#ccs-toggle-carousel').slideToggle();
            });

          });
        </script>
    </body>
</html>
