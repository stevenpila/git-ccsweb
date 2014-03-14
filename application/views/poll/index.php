<div class="ccs-polls">
	<?php if($this->authentication->is_authorized_function_by_name('Poll/create_poll')){ ?>
	<div class="row ccs-polls-title">
		<span class="" style="position:relative;">
			<button class="ccs-btn-create-poll" title="Show create poll."><b>Create </b><i style="color:#ff6000;" class="icon-plus-sign-alt"></i></button>
			<label id="poll-timer"><?php echo date('F d, Y h:i:s A', strtotime($datetime)) ?></label>
			<form name="ccs-create-poll-form" method="POST" action="<?php echo base_url() ?>poll/create_poll">
				<div class="ccs-create-poll">
					<ul>
						<li class="ccs-create-poll-topic">
							<label class="ccs-error pull-right hide" for="topic" style="position: absolute; right: 0; margin: 4px 17px 0 0; color: #B94A48; font-size: 10px">
			                    <i class="glyphicon glyphicon-asterisk pull-right"></i>
			                </label>
							<input name="topic" style="border: 1px solid #ccc; box-shadow: 0 -2px 0 rgba(0, 0, 0, 0.05) inset;" type="text" placeholder="Question/Topic"/>
							<!-- <div class="input-group ccs-date">
                                <input type="text" name="expire" placeholder="Closing Time" readonly/>
                                <span class="input-group-addon" style="padding: 3px 10px 1px 10px; cursor: pointer"><i class="icon-th"></i></span>
                            </div> -->
							<!-- <input name="expire" type="text" placeholder="Closing Date (optional)" style="border: 1px solid #ccc; border-top: none"/> -->	
						<a class="ccs-polls-add-closing-time" href="#" style="color: rgb(34, 34, 34); font-size: 12px; text-decoration: none; padding: 0px 10px; margin-top: 5px;"><i class="icon-time"></i> Set Closing Time <i class="icon-caret-down pull-right" style="font-size: 16px; margin: 7px 10px 0px 0px;"></i></a>
						<div class="col-md-12 ccs-polls-closing-time" style="display: none; padding: 0 10px">
						<div class="bfh-datepicker"></div><div class="bfh-timepicker"></div>
						</div>
						</li>
						<li class="ccs-create-poll-options">
							<ul>
								<li>
									<label class="ccs-error pull-right hide" for="option" style="position: absolute; right: 0; margin: 5px 25px 0 0; color: #B94A48; font-size: 10px">
					                    <i class="glyphicon glyphicon-asterisk pull-right"></i>
					                </label>
									<input name="option[]" type="text" placeholder="Option 1"/></li>
								<li>
									<label class="ccs-error pull-right hide" for="option" style="position: absolute; right: 0; margin: 5px 25px 0 0; color: #B94A48; font-size: 10px">
					                    <i class="glyphicon glyphicon-asterisk pull-right"></i>
					                </label>
									<input name="option[]" type="text" placeholder="Option 2"/></li>
								<li>
									<label class="ccs-error pull-right hide" for="option" style="position: absolute; right: 0; margin: 5px 25px 0 0; color: #B94A48; font-size: 10px">
					                    <i class="glyphicon glyphicon-asterisk pull-right"></i>
					                </label>
									<input name="option[]" type="text" placeholder="Option 3" style="padding-right: 8px"/><span class="remove" title="Remove this option."><i class="ic-close"></i></span></li>
								<li><span class="ccs-add-new-poll-option-plus" title="Click to add more options.">+</span></li>
							</ul>	
						</li>
						<li>
							<div align="center"><input type="submit" value="Post" title="Post"/></div>
							<div align="center"><input id="ccs-create-poll-cancel" type="reset" value="Cancel" title="Cancel"/></div>
						</li>
					</ul>
				</div>
			</form>
		</span>
	</div>
	<?php } ?>
	<div class="row ccs-polls-body">
		<?php if($polls){ ?>
		<?php foreach($polls as $poll){ ?>
		<div class="col-md-6 col-lg-6 ccs-polls-media <?php echo ($poll->status)?>">
			<div class="ccs-polls-author-container">
				<div class="ccs-polls-author">
					<div class="ccs-polls-author-name"><?php echo strtoupper($poll->author_name) ?></div>
					<div class="ccs-polls-author-user-type"><b><?php echo $this->authentication->user_type($poll->author_user_type) ?></b></div>
					<div class="ccs-polls-status"><div style="color: rgb(255,171,23); font-size: 30px; width: 100px"><?php echo $poll->status ?></div></div>
				</div>
				<div class="ccs-polls-user-profile-picture" style="margin: -8px 0 8px 0">
					<span style="font-size: 100px; line-height: 20px;">...</span>
					<img src="<?php echo base_url() . $poll->author_pic ?>" />
					
				</div>
			</div>	
			<div class="ccs-polls-medium">
				<div class="ccs-polls-question"><?php echo $poll->topic ?>
					<?php if($this->authentication->user_id() == $poll->user_id && ($this->authentication->is_authorized_function_by_name('Poll/delete_poll') || $this->authentication->is_authorized_function_by_name('Poll/open_close_poll'))){ ?>
					<i id="ccs-poll-controls-trigger" class="ic-cog ccs-poll-controls-trigger" style="position: absolute; right: 13px; top: 5px; cursor: pointer" title="Show options.">
						<div class="ccs-polls-controls">
							<ul data-value="<?php echo $poll->id ?>">
								<?php if($this->authentication->is_authorized_function_by_name('Poll/delete_poll')){ ?>
								<li class="ccs-poll-delete" title="Click to delete this topic.">Delete</li>
								<div class="ccs-divider"></div>
								<?php } 
									if($this->authentication->is_authorized_function_by_name('Poll/open_close_poll') && !$poll->expiration){ ?>
								<li class="ccs-poll-close-open" data-status="<?php echo ($poll->status == 'Open') ? 'Closed' : 'Open' ?>" title="Click to <?php echo ($poll->status == 'Open') ? 'close' : 'open' ?> this topic."><?php echo ($poll->status == 'Open') ? 'Close' : 'Open' ?></li>
								<?php } ?>
							</ul>
						</div>
					</i>
					<?php } ?>
				</div>
				<div class="ccs-polls-time-posted"><b><?php echo date('M. d, Y', strtotime($poll->date_posted)) ?></b>
					<i><?php echo ($poll->expiration) ? 'Closing Time: ' . date('M. d, Y h:i A', strtotime($poll->expiration)) : '' ?></i>
				</div>
				<div class="ccs-polls-options">
					<div class="ccs-polls-options-answers">
					<?php 
						$options = $this->poll->get_all_poll_options_by_id($poll->id);
						$total_votes = 0;
						foreach ($options as $option) {
							$total_votes += $option->votes;
						}
					?>
					<ul data-value="<?php echo $poll->id ?>" data-total-votes="<?php echo $total_votes ?>">
						<li><span>ANSWERS</span><span class="pull-right">VOTES</span></li>
						<?php foreach($options as $option){ 
							$percentage = ($total_votes) ? (strstr((string)($option->votes/$total_votes)*100,'.')) ? number_format(($option->votes/$total_votes)*100,2,'.','') : number_format(($option->votes/$total_votes)*100,0,'.','') : '0'; ?>
						<li data-value="<?php echo $option->id ?>" data-votes="<?php echo $option->votes ?>">
							<?php if(!$this->poll->is_user_voted_poll_option_by_id($this->authentication->user_id(),$poll->id,$option->id)){ ?>
								<i class="icon-circle ccs-poll-vote-btn<?php echo ($this->authentication->is_authorized_function_by_name('Poll/vote_poll_option'))?'':'-prevent' ?>" title="Click to vote for this option." style="margin-right: 2px"></i>
								<span><?php echo $option->option ?></span>
							<?php }else{ ?>
							  <i class="icon-ok x40 ccs-poll-vote-btn" style="color: #ff6000"></i>
							<span style=""><?php echo $option->option ?></span>
							<?php } ?>
							<span class="pull-right x40" style="min-width:35px; text-align: center"><?php echo $option->votes ?></span>
							<div class="ccs-votes-progress-bar-container" title="<?php echo $percentage ?>%">
								<div class="ccs-votes-progress-bar" style="width:<?php echo $percentage ?>%"></div>	
							</div>
						</li>
						<?php } ?>
					</ul>
					</div>
				</div>
			</div>
		</div>
		<?php }}else{ ?>
		<div class="row ccs-polls-media ccs-polls-media-no-post">
			No Polls Available... <a href="#" style="text-decoration:none;" class="ccs-no-available-create-post">Create one</a>
		</div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">

	var date = new Date("<?php echo date('M d, Y H:i:s', strtotime($datetime)) ?>");
	var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	var month = date.getMonth(),
		day = date.getDate(),
		year = date.getFullYear(),
		hour = date.getHours(),
		min = date.getMinutes(),
		sec = date.getSeconds();

	$(document).ready(function(){
		$('.bfh-timepicker').bfhtimepicker({
			name: 'time',
			align: 'right'
		});
		$('.bfh-datepicker').bfhdatepicker({
			format: 'y-m-d',
			name: 'date',
			align: 'right'
		});

		setInterval(poll_timer, 1000);

		$('.ccs-poll-vote-btn-prevent').click(function(e){
			Dialog('Sorry. You are not authorized to vote.', 'alert', true, false, function(){});
			// alert('Sorry. You are not authorized to vote.');

			e.preventDefault();
		});

		$('.ccs-polls-add-closing-time').click(function(e){
			if($('.ccs-polls-closing-time').css('display') == 'none'){
				$('.ccs-polls-closing-time input').removeAttr('disabled');
			}

			$('.ccs-polls-closing-time').slideToggle(function(){
				if($('.ccs-polls-closing-time').css('display') == 'none'){
					$('.ccs-polls-closing-time input').prop('disabled', true);
					$('.ccs-polls-closing-time .bfh-datepicker-toggle > input, .ccs-polls-closing-time .bfh-timepicker-toggle > input').val('');
					$('.ccs-polls-closing-time input').removeClass('ccs-error-input');
				}
			});

			e.preventDefault();
		});
	});
	
	function poll_timer(){
		if(sec == 59){
			min++;
			sec = 0;
			if(min == 60){
				hour++;
				min = 0;
				if(hour == 24){
					day++;
					hour = 0;
					if(day == getNumDaysInMonth(month + 1, year) + 1){
						month++;
						day = 1;
						if(month == 12){
							year++;
							month = 0;
						}
					}
				}
			}
		}
		else{
			sec++;
		}
		
		var today = months[month] + ' ' + ((day < 10) ? '0' + day : day) + ', ' + year,
			hours = (hour < 10) ? '0' + hour : (hour > 12) ? ((hour - 12) < 10) ? '0' + (hour - 12) : (hour - 12) : hour,
			mins = (min < 10) ? '0' + min : min,
			secs = (sec < 10) ? '0' + sec : sec,
			status = (hour >= 12) ? 'PM' : 'AM';

		if((hour - 12) == -12) hours = 12;

		//$('#poll-timer').html(hour + ":" + min + ":" + sec + " " + status;);
		$('#poll-timer').html(today + " " + hours + ":" + mins + ":" + secs + " " + status);

	}

	function getNumDaysInMonth(month, year) {
	    return new Date(year, month, 0).getDate();
	}
</script>