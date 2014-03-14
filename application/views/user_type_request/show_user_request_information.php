<?php //print_array($user_request) ?>
<?php //print_array($service_type) ?>
<?php //print_array($company_profile) ?>
<div class="container ccs-user-type-details">
    <div class="media">
        <div class="row media-body">  
            <div class="col-sm-6 col-md-5 col-xs-6" style="padding-top:12px;">	
		        <a class="" href="#">
		          <img class="media-object" src="<?php echo base_url() . $user_request->profile_pic ?>" title="<?php echo ucwords($user_request->requestor_name) ?>">
		        </a>
		        <div class="ccs-request-action-mask">
			        <div class="ccs-request-action button-group">
			        	<button class="ccs-request-approve" data-decide="2">Approve</button>
			        	<button class="ccs-request-decline" data-decide="1">Decline</button>
			        	<button class="ccs-request-recall" data-decide="0"><i class="icon-long-arrow-left"></i> Recall</button>
			        </div>
			    </div>
            </div>
        	<div class="col-md-7 col-sm-6 col-xs-6">
        		<table valign="top" class="ccs-table-user-information" >
	                <tbody>
		                <tr>
		                    <td>Name</td>
		                    <td><?php echo ucwords($user_request->requestor_name) ?></td>
		                </tr>
		                <tr>
		                    <td>Date Requested</td>
		                    <td><?php echo date('M. d, Y',strtotime($user_request->daterequested)) ?></td>
		                </tr>
		                <tr>
		                    <td>Date Affirmed</td>
		                    <td><?php echo (!empty($user_request->dateaffirmed))?($user_request->status == 'Pending')?date('M. d, Y',strtotime($user_request->dateaffirmed)).' <small><i>(recalled)</i></small>':date('M. d, Y',strtotime($user_request->dateaffirmed)):'---------------' ?></td>
		                </tr>
		                <tr>
		                    <td>Status</td>
		                    <td> <?php echo ucwords($user_request->status) ?></td>
		                </tr>
<!-- Pending -->        <?php if($user_request->status == 'Pending'){ ?>
		                <tr valign="center">
		                    <td>Services</td>
		                    <td class="ccs-user-information-services">
<!-- for admin -->				<?php if($user_request->usertypeid == 2){ ?>
		                        	<span class="ccs-service-type-request-id" data-value="<?php echo $service_type->service_id ?>"><?php echo ucwords($service_type->service_type) ?></span>
		                            <!-- ?<ul class="ccs-service-type-select"> -->
		                            <select name="new_service_type" class="form-control hide" style="width: auto">
		                                <?php foreach($services as $service){ ?>
		                                    <option style="padding: 5px 15px" value="<?php echo $service->id ?>" <?php echo ($service_type->service_type == $service->name)?'selected':'' ?>><?php echo $service->name ?></option>
		                                <?php } ?>
		                                <!-- <span class="ccs-user-services-type-hide"><i class="ic-switch"></i>Close</span> -->
		                            </select>
		                            <button class="ccs-service-type-change" data-hint="<?php echo $service_type->service_id ?>" data-select="2" title="Change"><b>Edit</b> <i class="ic-pencil2"></i></button>
<!-- for employee -->		        <?php }elseif($user_request->usertypeid == 3){ ?>
		                        	<?php $service_id = explode(',', $service_type->service_id) ?>
		                            <span class="ccs-service-type-request-id" data-value="<?php echo $service_type->service_id ?>"><?php foreach($service_id as $key => $cur_service_id){ echo $this->authentication->service_type($cur_service_id); echo ($key != count($service_id) - 1) ? '</br>' : ''; } ?></span>
		                            <!-- ?<ul class="ccs-service-type-select"> -->
		                            <select name="new_service_type" class="form-control hide" style="width: auto" multiple>
		                                <?php foreach($services as $service){ 
		                                	if(array_search($service->id, array(3,4,5,6)) !== FALSE){ ?>
		                                    	<option style="padding: 5px 15px" value="<?php echo $service->id ?>" <?php echo (array_search($service->id, $service_id) !== FALSE) ? 'selected' : '' ?>><?php echo $service->name ?></option>
		                                <?php }else{ ?>
		                                		<option class="hide" style="padding: 5px 15px" value="<?php echo $service->id ?>"><?php echo $service->name ?></option>
		                                <?php }} ?>
		                                <!-- <span class="ccs-user-services-type-hide"><i class="ic-switch"></i>Close</span> -->
		                            </select>
		                            <button class="ccs-service-type-change" data-hint="<?php echo $service_type->service_id ?>" data-select="3" title="Change"><b>Edit</b> <i class="ic-pencil2"></i></button>
		                    	<?php } ?>
		                    </td>
		                </tr>
<!-- Approved -->		<?php }else{ ?>
		                <tr valign="center">
		                    <td>Services</td>
		                    <td class="ccs-user-information-services">
		                        <?php if($user_request->affirmedusertypeid == 2){ ?>
		                        	<select name="new_service_type" class="form-control hide" style="width: auto">
		                        		<option value="<?php echo $service_type->affirmed_service_id ?>" selected><?php echo $service_type->affirmed_service_type ?></option>
		                        	</select>
		                        	<span class="ccs-service-type-request-id" data-value="<?php echo $service_type->affirmed_service_id ?>"><?php echo $service_type->affirmed_service_type ?></span>
		                        <?php }elseif($user_request->affirmedusertypeid == 3){ ?>
		                        	<?php $service_id = explode(',', $service_type->affirmed_service_id) ?>
		                        	<select name="new_service_type" class="form-control hide" style="width: auto">
		                        		<?php foreach($service_id as $key => $cur_service_id){ ?>
		                        		<option value="<?php echo $cur_service_id ?>" selected><?php echo $this->authentication->service_type($cur_service_id) ?></option>
		                        		<?php } ?>
		                        	</select>
		                            <span class="ccs-service-type-request-id" data-value="<?php echo $service_type->service_id ?>"><?php foreach($service_id as $key => $cur_service_id){ echo $this->authentication->service_type($cur_service_id); echo ($key != count($service_id) - 1) ? '</br>' : ''; } ?></span>
		                        <?php } ?>
		                    </td>
		                </tr>
		                <?php } ?>
		                <tr valign="center">
		                    <td>User Type</td>
		                    <td class="ccs-user-information-user-type-request">
		                    <?php if($user_request->status == 'Pending'){ ?>
		                        <span class="ccs-user-type-request-id" data-value="<?php echo $user_request->usertypeid ?>"><?php echo $user_request->user_type ?></span>
		                        <!-- <ul class="ccs-user-type-select"> -->
		                        <select name="new_user_type" class="form-control hide" style="width: auto">
		                            <?php foreach($user_types as $user_type){ 
		                                if(array_search($user_type->id, array(2,3,5)) !== FALSE){ ?>
		                                <option style="padding: 5px 15px" value="<?php echo $user_type->id ?>" <?php echo($user_request->usertypeid == $user_type->id)?'selected':'' ?>><?php echo $user_type->name ?></option>
		                            <?php }} ?>
		                        </select>
		                        <button class="ccs-user-type-change" data-hint="<?php echo $user_request->usertypeid ?>" data-select="<?php echo $user_request->usertypeid ?>" title="Change"><b>Edit</b> <i class="ic-pencil2"></i></button>
		                    <?php }else{ ?>
		                    	<select name="new_user_type" class="form-control hide" style="width: auto">
		                    		<option style="padding: 5px 15px" value="<?php echo $user_request->affirmedusertypeid ?>" selected><?php echo $user_request->affirmed_user_type ?></option>
		                    	</select>
		                        <span class="ccs-user-type-request-id" data-value="<?php echo $user_request->affirmedusertypeid ?>"><?php echo $user_request->affirmed_user_type ?></span>
		                    <?php } ?>
		                    </td>
		                </tr>
	                </tbody>
	            </table>
    		</div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var base_url = 'http://localhost/ccsweb/',
			user_id = <?php echo $user_request->userid ?>,
			service_detail_id = <?php echo ($service_type)?$service_type->id:'' ?>,
			request_id = <?php echo $user_request->id ?>,
			user_type_id = <?php echo $user_request->usertypeid ?>;

		<?php if($user_request->status == 'Pending'){ ?>
			$('.ccs-request-action').css({
         	   marginRight : '0px',
         	   marginLeft : '-162px'
        	});
			$('.ccs-request-action').animate({
           		marginRight : '-150px',
           		marginLeft : '0px'
        	},function(){
        		$('.ccs-request-action > button:eq(2)').remove();
        		$('.ccs-request-action').css({
        			marginRight: '0px',
        			width: 'auto'
        		});
        	});
		<?php }else{ ?>
			$('.ccs-request-action').animate({
         	   marginRight : '0px',
         	   marginLeft : '-162px'
        	},function(){
        		$('.ccs-request-action > button:eq(0), .ccs-request-action > button:eq(1)').remove();
        		$('.ccs-request-action').css({
        			marginLeft: '0px',
        			width: 'auto'
        		});
        	});
		<?php } ?>

		$('.ccs-request-decline, .ccs-request-approve, .ccs-request-recall').click(function(){
			var type = $(this).attr('data-decide'),
				user_type = $('select[name="new_user_type"]').val(),
				service_type = $('select[name="new_service_type"]').val();

			var data = 'req_id=' + request_id + '&service_detail_id=' + service_detail_id + '&user_id=' + user_id + '&confirm=' + type + '&user_type_id=' + user_type + '&cur_user_type_id=' + user_type_id + '&service_type_id=' + service_type;

			is_user_still_logged_in(function(){
				approve_decline_recall_request(data, type);
			});
		});

		function approve_decline_recall_request(data, ans){
			$.ajax({
				url: base_url + 'user_type_request/approve_decline_recall_request',
				type: 'POST',
				data: data,
				dataType: 'json',
				beforeSend: function(){
					$('.ccs-user-type-details').parent().parent().css({visibility: 'hidden'});
				},
				success: function(output){
					if(output.status){
						$('.ccs-user-type-details').parent().load(base_url + 'user_type_request/show_user_request_information', {req_id: request_id}, function(){
							var index = $('.ccs-user-type-details').parent().parent().parent().index();
							var tbody = $('.ccs-user-type-details').parents('tbody');
							var cla = $('tr:eq(' + (index-1) + ') > td:eq(3)', tbody).attr('class');
							var affirm = (ans == 2) ? 'Approved' : (ans == 1) ? 'Denied' : 'Pending';

							$('tr:eq(' + (index-1) + ') > td:eq(3)', tbody).children('span').html(affirm).parent().removeClass(cla).addClass(affirm);
							$('tr:eq(' + (index-1) + ') > td:eq(5)', tbody).html(output.date_affirmed);
							$('tr:eq(' + (index-1) + ') > td:eq(2)', tbody).html(output.user_type);
							$('.ccs-user-type-details').parent().parent().css({visibility: 'visible'});
						});
					}
					else Dialog('Something went wrong. Try again.', 'alert', true, false, function(){}); //alert('Something went wrong. Try again.');
				},
				error: function(xhr){
					alert(xhr.responseText);
				}
			});
		}

		$('.ccs-service-type-change').click(function(){
			var id = $(this).attr('data-hint'),
				type = $(this).attr('data-select');

			if($('select[name="new_user_type"]').hasClass('hide')) reset_select_tag(type);

			if(!$('select[name="new_service_type"]').hasClass('hide')) $(this).attr('title','Change').html('<b>Edit</b> <i class="ic-pencil2"></i>');
			else $(this).attr('title','Cancel').html('<b>Cancel</b> <i class="icon-remove"></i>');

			$('select[name="new_service_type"], .ccs-service-type-request-id').toggleClass('hide');
			if(type == 2) $('select[name="new_service_type"]').val(id);
			else if(type == 3) $('select[name="new_service_type"]').val(id.split(','));
		});

		function reset_select_tag(type){
			if(type == 2){
				set_select_tag(false);
				$('select[name="new_service_type"]').removeAttr('multiple');
			}
			else if(type == 3){
				set_select_tag(true);
				$('select[name="new_service_type"]').attr('multiple','');
			}

			$('select[name="new_service_type"] > option').removeAttr('selected');
		}

		$('.ccs-user-type-change').click(function(){
			var id = $(this).attr('data-hint'),
				ser_id = $('.ccs-service-type-change').attr('data-hint');
				type = $(this).attr('data-select');

			reset_select_tag(type);

			if(!$('select[name="new_user_type"]').hasClass('hide')){
				if($('.ccs-table-user-information > tbody > tr:eq(4)').hasClass('hide')){
					$('select[name="new_service_type"], .ccs-service-type-request-id').toggleClass('hide');

					if(!$('select[name="new_service_type"]').hasClass('hide')) $('.ccs-service-type-change').attr('title','Cancel').html('<b>Cancel</b> <i class="icon-remove"></i>').removeClass('hide');
					else $('.ccs-service-type-change').attr('title','Change').html('<b>Edit</b> <i class="ic-pencil2"></i>').removeClass('hide');

					$('.ccs-table-user-information > tbody > tr:eq(4)').removeClass('hide');
				}
				else{
					if(!$('select[name="new_service_type"]').hasClass('hide')) $('.ccs-service-type-change').attr('title','Cancel').html('<b>Cancel</b> <i class="icon-remove"></i>').removeClass('hide');
					else $('.ccs-service-type-change').attr('title','Change').html('<b>Edit</b> <i class="ic-pencil2"></i>').removeClass('hide');
				}

				$(this).attr('title','Change').html('<b>Edit</b> <i class="ic-pencil2"></i>');
			} 
			else $(this).attr('title','Cancel').html('<b>Cancel</b> <i class="icon-remove"></i>');

			$('select[name="new_user_type"], .ccs-user-type-request-id').toggleClass('hide');
			$('select[name="new_user_type"]').val(id);

			if(type == 2) $('select[name="new_service_type"]').val(ser_id);
			else if(type == 3) $('select[name="new_service_type"]').val(ser_id.split(','));
		});

		$('select[name="new_user_type"]').change(function(){
			var val = $(this).val(),
				type = $('.ccs-user-type-change').attr('data-select');

			if(val == 3){
				set_select_tag(true);
				$('select[name="new_service_type"]').attr('multiple','');
				$('.ccs-table-user-information > tbody > tr:eq(4)').removeClass('hide');
			}else if(val == 2){
				set_select_tag(false);
				$('select[name="new_service_type"]').removeAttr('multiple');
				$('.ccs-table-user-information > tbody > tr:eq(4)').removeClass('hide');
			}else{
				$('.ccs-table-user-information > tbody > tr:eq(4)').addClass('hide');
			}

			if(val != type) $('.ccs-service-type-change').addClass('hide');
			else $('.ccs-service-type-change').removeClass('hide');

			$('select[name="new_service_type"]').removeClass('hide');
			$('.ccs-service-type-request-id').addClass('hide');
			$('.ccs-service-type-change').attr('title','Cancel').html('<b>Cancel</b> <i class="icon-remove"></i>');
		});

		function set_select_tag(filter){
			if(filter){
				$('select[name="new_service_type"] > option').each(function(){
					var val = $(this).val();

					if(val != 3 && val != 4 && val != 5 && val != 6) $(this).addClass('hide');
				});
				$('select[name="new_service_type"]').val(3);
			}else{
				$('select[name="new_service_type"] > option').removeClass('hide');
				$('select[name="new_service_type"]').val(1);
			}
		}
	});

</script>