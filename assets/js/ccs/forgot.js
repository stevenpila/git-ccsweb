
$(document).ready(function(){
	var base_url = 'http://localhost/ccsweb/', email_or_username, confirmation_code;
/* <<<< ============================= Error Validation Blink ============================= */
    var blink = function(id) {
    	setTimeout(function(){
    		$('#'+id).removeClass('my-error');
    		setTimeout(function(){
    			$('#'+id).addClass('my-error');
				setTimeout(function(){
					$('#'+id).removeClass('my-error');
					setTimeout(function(){
						$('#'+id).addClass('my-error');
					},100);
				},100);
    		},100);
    	},100);
	}
/* ============================= Error Validation Blink ============================= >>>> */

/* <<<< ============================= ON FOCUS ============================= */
	$(document).on('blur','#forgot-password-email-username',function(e){
		$('#forgot-password-email-username').removeClass('my-error');
	});

	$(document).on('blur','#forgot-password-secret-answer',function(e){
	    $('#forgot-password-secret-answer').removeClass('my-error');
	});

	$(document).on('blur','#forgot-password-secret-question',function(e){
		$('#forgot-password-secret-question').removeClass('my-error');
	});


	$(document).on('blur','#forgot-secret-answer-email-username',function(e){
		$('#forgot-secret-answer-email-username').removeClass('my-error');
	});

	$(document).on('blur','#forgot-secret-answer-confirmation-code',function(e){
	    $('#forgot-secret-answer-confirmation-code').removeClass('my-error');
	});

	$(document).on('blur','#forgot-secret-answer-new-pwd-id',function(e){
		$('#forgot-secret-answer-new-pwd-id').removeClass('my-error');
	});

	$(document).on('blur','#forgot-secret-answer-re-new-pwd-id',function(e){
		$('#forgot-secret-answer-re-new-pwd-id').removeClass('my-error');
	});
/* ============================= ON FOCUS ============================= >>>> */

/* <<<< ============================= Forgot Secret Answer 1st Back ============================= */
	$(document).on('click','a.back[data-index="2"]',function(e) {
		e.preventDefault();

	    $('.modal-title.forgot').html('Forgot Secret Answer? &nbsp;&nbsp; <small>Step 1 of 3</small>');
	    $('#forgot-secret-answer-email-username').show();
	    $('#forgot-secret-answer-confirmation-code').hide();
		$('#forgot-secret-answer-new-pwd-id').hide();
		$('#mybr').hide();
		$('#forgot-secret-answer-re-new-pwd-id').hide();
		$('.modal-footer.forgot').html('\n\
	    	<div class="pull-right">\n\
	        	<button class="btn btn-primary next" tabindex="2" data-index="1">Next</button>\n\
	        	<a class="btn btn-danger" tabindex="3" data-dismiss="modal">Cancel</a>\n\
	    	</div>\n\
	    ');
	   	$('#forgot-secret-answer-email-username').val(email_or_username);
	});
/* ============================= Forgot Secret Answer 1st Back ============================= >>>> */

/* <<<< ============================= Forgot Secret Answer 2nd Back ============================= */
	$(document).on('click','a.back[data-index="3"]',function(e) {
		e.preventDefault();

		$('.modal-title.forgot').html('Forgot Secret Answer? &nbsp;&nbsp; <small>Step 2 of 3</small>');
		$('#forgot-secret-answer-email-username').hide();
		$('#forgot-secret-answer-confirmation-code').show();
		$('#forgot-secret-answer-new-pwd-id').hide();
		$('#mybr').hide();
		$('#forgot-secret-answer-re-new-pwd-id').hide();
	    $('.modal-footer.forgot').html('\n\
	    	<div class="pull-right">\n\
	        	<a class="btn btn-primary back" tabindex="3" data-index="2">Back</a>\n\
	        	<button class="btn btn-primary next" tabindex="2" data-index="2">Next</button>\n\
	        	<a class="btn btn-danger" tabindex="4" data-dismiss="modal">Cancel</a>\n\
	   		</div>\n\
	    ');
	    $('#forgot-secret-answer-confirmation-code').val(confirmation_code);
	});	
/* ============================= Forgot Secret Answer 2nd Back ============================= >>>> */

/* <<<< ============================= Forgot Password Link ============================= */
	$(document).on('click','#forgot_password_link',function(e) {
	    $('.modal-title.forgot').html('Forgot Password?');
	    $('.modal-body.forgot').html('\n\
	        <div><input type="text" id="forgot-password-email-username" name="forgot_password_email_username" placeholder="Email or Username" class="form-control" tabindex="1" /></div>\n\
            <br/>\n\
			<div>\n\
	            <select id="forgot-password-secret-question" style="width:438px" name="forgot_password_secret_question" class="form-control" tabindex="2">\n\
	              <option value="0">Secret Question</option>\n\
	              <option value="1">What is your pet\'s name?</option>\n\
	              <option value="2">What is your favorite subject?</option>\n\
	              <option value="3">What is your father\'s name?</option>\n\
	              <option value="4">Where did you met your first love?</option>\n\
	            </select>\n\
			</div>\n\
			<br/>\n\
			<div><input type="password" id="forgot-password-secret-answer" name="forgot_password_secret_answer" placeholder="Secret Answer" class="form-control" tabindex="3" /></div>\n\
			<div><a href="#" id="forgot-secret-answer-link" tabindex="6">Forgot secret answer?</a></div>\n\
	      ');
	    $('.modal-footer.forgot').html('\n\
	        <div class="pull-right">\n\
				<button id="submit-forgot-password-request" class="btn btn-primary" tabindex="4">Submit</button>\n\
				<a class="btn btn-danger" data-dismiss="modal" tabindex="5">Cancel</a>\n\
			</div>\n\
	    ');
	});

	/*$(document).on('click','#forgot_password_link',function(e) {
	    $('.modal-title.forgot').html('Forgot Password?');
	    $('.modal-body.forgot').html('\n\
	        <input type="text" id="forgot-password-email-username" name="forgot_password_email_username" placeholder="Email or Username" class="form-control" tabindex="1" />\n\
	        <br/>\n\
	        <div class="btn-group">\n\
	        <select id="forgot-password-secret-question" style="width:438px" name="forgot_password_secret_question" class="form-control" tabindex="2">\n\
	        	<option value="0">Secret Question</option>\n\
	            <option value="1">What is your pet\'s name?</option>\n\
	            <option value="2">What is your favorite subject?</option>\n\
	            <option value="3">What is your father\'s name?</option>\n\
	            <option value="4">Where did you met your first love?</option>\n\
	        </select>\n\
	        </div>\n\
	        <br/><br/>\n\
	        <input  type="password" id="forgot-password-secret-answer" name="forgot_password_secret_answer" placeholder="Secret Answer" class="form-control" tabindex="3" />\n\
	        <div>\n\
	            <a href="#" id="forgot-secret-answer-link" tabindex="6">Forgot secret answer?</a>\n\
	        </div>\n\
	      ');
	    $('.modal-footer.forgot').html('\n\
	        <div class="pull-right">\n\
	        	<button id="submit-forgot-password-request" class="btn btn-primary" tabindex="4">Submit</button>\n\
	        	<a class="btn btn-danger" data-dismiss="modal" tabindex="5">Cancel</a>\n\
	        </div>\n\
	    ');
	});*/
/* ============================= Forgot Password Link ============================= >>>> */

/* <<<< ============================= Submit Forgot Password Request ============================= */
	$(document).on('click','#submit-forgot-password-request',function(e){
		e.preventDefault();
	    	
		$('#forgot-password-email-username').removeClass('my-error');
		$('#forgot-password-secret-answer').removeClass('my-error');
		$('#forgot-password-secret-question').removeClass('my-error');

		var mythis = this, mydata, forgot_username, forgot_sec_question, forgot_sec_answer;

	    $(mythis).attr('disabled',true);
	    forgot_username = $('#forgot-password-email-username').val().trim();
	    forgot_sec_question = $('#forgot-password-secret-question').val().trim();
	    forgot_sec_answer = $('#forgot-password-secret-answer').val().trim();


	    if(forgot_username == "") {
			$('#forgot-password-email-username').addClass('my-error');
			blink('forgot-password-email-username');
			$(mythis).removeAttr('disabled');
	    }
	    else if(forgot_sec_question == 0) {
			$('#forgot-password-secret-question').addClass('my-error');
			blink('forgot-password-secret-question');
			$(mythis).removeAttr('disabled');
	    }
	    else if(forgot_sec_answer == "") {
			$('#forgot-password-secret-answer').addClass('my-error');
			blink('forgot-password-secret-answer');
			$(mythis).removeAttr('disabled');
	    }
	    else {
			mydata = $('#forgot-form').serialize();
	    	$.ajax({
	            type: 'POST',
	            url: base_url + 'account/forgot_password',
	            data: mydata,
	            dataType: 'json',
	            success: function(result) {
			    	$('#forgot_password_modal').modal('hide');					
					if(result.status) {
			            toastr.options = {
			            	"closeButton": true,
			                "debug": false,
			                "positionClass": "toast-bottom-right",
			                "onclick": true,
			                "showDuration": "300",
			                "hideDuration": "1000",
			                "timeOut": "10000",
			                "extendedTimeOut": "1000",
			                "showEasing": "swing",
			                "hideEasing": "linear",
			                "showMethod": "fadeIn",
			                "hideMethod": "fadeOut"
			            }
						toastr.success("Your new password: <strong>" +result.password +"</strong>", "Success!")
					}
					else if(result.usertype == 2 || result.usertype == 3) {
						toastr.options = {
			            	"closeButton": true,
			                "debug": false,
			                "positionClass": "toast-bottom-right",
			                "onclick": true,
			                "showDuration": "300",
			                "hideDuration": "1000",
			                "timeOut": "10000",
			                "extendedTimeOut": "1000",
			                "showEasing": "swing",
			                "hideEasing": "linear",
			                "showMethod": "fadeIn",
			                "hideMethod": "fadeOut"
			            }
						toastr.error("Password reset denied. Please click this <u><strong><a href='http://localhost/moodle/login/forgot_password.php'>link</a></strong></u> and request a new password.", "Oops!")
					}
					else if(!result.status){
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
						toastr.error("Password reset failed. Please try again.", "Oops!")
					}
					$(mythis).removeAttr('disabled');
	            },
	            error: function(xhr,status,error) {
					$('#forgot_password_modal').modal('hide');		           
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
	                $(mythis).removeAttr('disabled');
	            }
	        });

			/*$('#forgot-password-email-username').val(null);
	    	$('#forgot-password-secret-question').val(0);
	    	$('#forgot-password-secret-answer').val(null);*/
	    }
	});
/* ============================= Submit Forgot Password Request ============================= >>>> */

/* <<<< ============================= Forgot Secret Answer Link ============================= */
	$(document).on('click','#forgot-secret-answer-link',function(e) {
	    $('.modal-title.forgot').html('Forgot Secret Answer? &nbsp;&nbsp; <small>Step 1 of 3</small>');
	    $('.modal-body.forgot').html('\n\
      		<input type="text" tabindex="1" id="forgot-secret-answer-email-username" name="forgot_secret_answer_email_username" placeholder="Email or Username" class="form-control" />\n\
      		<input type="text" tabindex="1" id="forgot-secret-answer-confirmation-code" name="forgot_secret_answer_confirmation_code" placeholder="Confirmation Code" class="form-control" />\n\
      		<input type="password" tabindex="1" placeholder="New Password" id="forgot-secret-answer-new-pwd-id" name="forgot_secret_answer_new_password" class="form-control" />\n\
      		<br id="mybr"/>\n\
      		<input type="password" tabindex="2" placeholder="Re-enter New Password" id="forgot-secret-answer-re-new-pwd-id" name="forgot_secret_answer_re_new_password" class="form-control" />\n\
	    ');

	    $('#forgot-secret-answer-confirmation-code').hide();
		$('#forgot-secret-answer-new-pwd-id').hide();
		$('#mybr').hide();
		$('#forgot-secret-answer-re-new-pwd-id').hide();
	
		$('.modal-footer.forgot').html('\n\
	      <div class="pull-right">\n\
	        <button class="btn btn-primary next" tabindex="2" data-index="1">Next</button>\n\
	        <a class="btn btn-danger" tabindex="3" data-dismiss="modal">Cancel</a>\n\
	      </div>\n\
	    ');
	});
/* ============================= Forgot Secret Answer Link ============================= >>>> */

/* <<<< ============================= Forgot Secret Answer 1st Next ============================= */
	$(document).on('click','button.next[data-index="1"]',function(e) {
		e.preventDefault();

		$('#forgot-secret-answer-email-username').removeClass('my-error');
	    var mythis = this, mydata;	   
	    $(mythis).attr('disabled',true);

	    email_or_username = $('#forgot-secret-answer-email-username').val().trim();

	    if(email_or_username == "") {
	    	$('#forgot-secret-answer-email-username').addClass('my-error');
	    	blink('forgot-secret-answer-email-username');
	        $(mythis).removeAttr('disabled');
	    }
	    else {
			mydata = $('#forgot-form').serialize();
	        $.ajax({
	            type: 'POST',
	            url: base_url + 'account/send_the_confirmation_code',
	            data: mydata,
	            dataType: 'json',
	            success: function(result) {
		            if(result.status == 1) {
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
						toastr.success("Confirmation code sent. Please check your email and proceed.", "Success!")

		                $('.modal-title.forgot').html('Forgot Secret Answer? &nbsp;&nbsp; <small>Step 2 of 3</small>');
					    $('#forgot-secret-answer-email-username').hide();
					    $('#forgot-secret-answer-confirmation-code').show();
		                $('.modal-footer.forgot').html('\n\
		                	<div class="pull-right">\n\
					        	<a class="btn btn-primary back" tabindex="3" data-index="2">Back</a>\n\
					        	<button class="btn btn-primary next" tabindex="2" data-index="2">Next</button>\n\
					        	<a class="btn btn-danger" tabindex="4" data-dismiss="modal">Cancel</a>\n\
		                	</div>\n\
		                ');
		            }
		            else if(result.status == 3) {
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
						toastr.error("You have invalid email address. Please contact your administrator.", "Oops!")
		                $(mythis).removeAttr('disabled');
		            }
		            else if(result.status == 2) {
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
						toastr.error("Sending confirmation code failed. Please check your internet connection and try again.", "Oops!")
		                $(mythis).removeAttr('disabled');		            	
		            }
		            else if(result.status < 0) {
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
						toastr.error("Database error occured. Please try again.", "Oops!")
		                $(mythis).removeAttr('disabled');		            	
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
						toastr.error("Incorrect email or username. Please try again.", "Oops!")
		              	$(mythis).removeAttr('disabled');
		            }
	            },
	            error: function(xhr,status,error) {
			        $('#forgot_password_modal').modal('hide');		            
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
	                $(mythis).removeAttr('disabled');
	            }
	        });

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
			toastr.info('Sending confirmation code to your email. Please wait.', "Sending...")  
	    }
	});
/* ============================= Forgot Secret Answer 1st Next ============================= >>>> */

/* <<<< ============================= Forgot Secret Answer 2nd Next ============================= */
	$(document).on('click','button.next[data-index="2"]',function(e) {
		e.preventDefault();

	    $('#forgot-secret-answer-confirmation-code').removeClass('my-error');
	    var mythis = this, mydata;
	    $(mythis).attr('disabled',true);

	    confirmation_code = $('#forgot-secret-answer-confirmation-code').val().trim();

	    if(confirmation_code == "") {
	    	$('#forgot-secret-answer-confirmation-code').addClass('my-error');
	    	blink('forgot-secret-answer-confirmation-code');
	        $(mythis).removeAttr('disabled');
	    }
	    else {
			mydata = $('#forgot-form').serialize();
	        $.ajax({
	            type: 'POST',
	            url: base_url + 'account/validate_confirmation_code',
	            data: mydata,
	            dataType: 'json',
	            success: function(result) {
	                if(result.status) {
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
						toastr.success("Comfirmation code verified. Please proceed.", "Success!")

	                	$('.modal-title.forgot').html('Forgot Secret Answer? &nbsp;&nbsp; <small>Step 3 of 3</small>');
					    $('#forgot-secret-answer-email-username').hide();
					    $('#forgot-secret-answer-confirmation-code').hide();
						$('#forgot-secret-answer-new-pwd-id').show();
						$('#mybr').show();
						$('#forgot-secret-answer-re-new-pwd-id').show();
		                $('.modal-footer.forgot').html('\n\
		                    <div class="pull-right">\n\
		                    	<a class="btn btn-primary back" tabindex="4" data-index="3">Back</a>\n\
		                    	<button class="btn btn-primary finish" tabindex="3" data-index="3">Finish</button>\n\
		                    	<a class="btn btn-danger" tabindex="5" data-dismiss="modal">Cancel</a>\n\
		                    </div>\n\
		                ');
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
						toastr.error("Invalid confirmation code. Please check your email and try again.", "Oops!")
	                	$(mythis).removeAttr('disabled');
	                }
	            },
	            error: function(xhr,status,error) {
			        $('#forgot_password_modal').modal('hide');
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
	                $(mythis).removeAttr('disabled');
	            }
	        });
	    }
	});
/* ============================= Forgot Secret Answer 2nd Next ============================= >>>> */

/* <<<< ============================= Forgot Secret Answer Finish ============================= */
	$(document).on('click','button.finish[data-index="3"]',function(e){
		e.preventDefault();
		
		$('#forgot-secret-answer-new-pwd-id').removeClass('my-error');
		$('#forgot-secret-answer-re-new-pwd-id').removeClass('my-error');
	    
	    var new_pwd, re_new_pwd, mydata;

		new_pwd = $('#forgot-secret-answer-new-pwd-id').val();
		re_new_pwd = $('#forgot-secret-answer-re-new-pwd-id').val();

		if(new_pwd == "") {
			$('#forgot-secret-answer-new-pwd-id').addClass('my-error');
			blink('forgot-secret-answer-new-pwd-id');
		}
		else if(re_new_pwd == "") {
			$('#forgot-secret-answer-re-new-pwd-id').addClass('my-error');
			blink('forgot-secret-answer-re-new-pwd-id');
		}
		else if(new_pwd !== re_new_pwd) {
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
			toastr.error("Password did not match! Please check your password.", "Oops!")
		}
		else {
	    	mydata = $('#forgot-form').serialize();
	    	$.ajax({
	            type: 'POST',
	            url: base_url + 'account/forgot_secret_answer',
	            data: mydata,
	            dataType: 'json',
	            success: function(result) {
	            	$('#forgot_password_modal').modal('hide');
	            	if(result.status) {
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
						toastr.success("Your password was successfully changed.", "Success!")
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
						toastr.error("Your password was not changed. Please try again.", "Oops!")
					}
	            },
	            error: function(xhr,status,error) {
	            	$('#forgot_password_modal').modal('hide');
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
	            }
        	});
		}
	});
/* ============================= Forgot Secret Answer Finish ============================= >>>> */
});
