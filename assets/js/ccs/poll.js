$(document).ready(function(){
	var flagPost = false;
	var base_url = 'http://localhost/ccsweb/';

	$('form[name="ccs-create-poll-form"]').submit(function(e){
		flagPost = true;

		if(validate_poll_option_textfields()){
			if(is_options_unique()){
				validate_topic(this);
			}
			else Dialog('All options must be unique.', 'alert', true, false, function(){});
		}
		
		e.preventDefault();
	});

	$('form[name="ccs-create-poll-form"] input[type="reset"]').click(function(){
		$('.ccs-create-poll').removeClass('dropIt');
		$('form[name="ccs-create-poll-form"] label.ccs-error').addClass('hide');
	});

	function validate_poll_option_textfields(){
		var flag = true,
			focus = false,
			regex = /\S/g,
			topic = $('.ccs-create-poll-topic > input').val();
		topic = strip_tags(topic, "");

		if(!regex.test(topic)){
			flag = false;
			focus = true;
			$('.ccs-create-poll-topic > label.ccs-error').removeClass('hide');
			$('.ccs-create-poll-topic > input').addClass('ccs-error-input').focus();
		}
		else{
			$('.ccs-create-poll-topic > label.ccs-error').addClass('hide');
			$('.ccs-create-poll-topic > input').removeClass('ccs-error-input');
		}

		$('.ccs-create-poll-options > ul > li > input').each(function(){
			var option = $(this).val(),
				regex = /\S/g;
			option = strip_tags(option, "");

			if(!regex.test(option)){
				flag = false;
				$(this).parent().children('label.ccs-error').removeClass('hide');
				$(this).addClass('ccs-error-input');
				if(!focus){
					$(this).focus();
					focus = true;
				}
			}
			else{ 
				$(this).parent().children('label.ccs-error').addClass('hide');
				$(this).removeClass('ccs-error-input');
			}
		});

		if($('.ccs-polls-closing-time').css('display') == 'block'){
			var date_input = $('.bfh-datepicker-toggle > input'),
				time_input = $('.bfh-timepicker-toggle > input'),
				regex = /\S/g;

			if(!regex.test(date_input.val())){
				flag = false;
				date_input.addClass('ccs-error-input');
			}
			else{
				date_input.removeClass('ccs-error-input');
			}
			if(!regex.test(time_input.val())){
				flag = false;
				time_input.addClass('ccs-error-input');
			}
			else{
				date_input.removeClass('ccs-error-input');
			}
		}

		return flag;
	}

	function is_options_unique(){
		var flag = true,
			options = [];

		$('.ccs-create-poll-options > ul > li > input').each(function(){
			var option = $(this).val(),
				regex = /\S/g;
			option = strip_tags(option, "");

			if($.inArray(option, options) >= 0 ) {
		        flag = false;
		        return false; // <-- stops the loop

		    }else{
		        options.push(option);
		    }
		});

		return flag;
	}

	function validate_topic(form){
		$.ajax({
            url: base_url + 'poll/verify_topic',
            type: 'POST',
            data: {
            	topic: $.trim($('.ccs-create-poll-topic > input').val())
            },
            dataType: 'json',
            beforeSend: function(){
                $('.ccs-create-poll-topic > label.ccs-error').removeClass('hide').addClass('ccs-orange').html('<i class="icon-spin icon-spinner"></i>');
            },
            success: function(data){
                if(data.status){
                	$('.ccs-create-poll-topic > label.ccs-error').removeClass('ccs-orange').html("Topic Already Exists <i class='glyphicon glyphicon-asterisk pull-right' style='margin: 1px 0 0 5px'></i>");
                }else{
                	form.submit();
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
	}

	$(document).on('blur','.ccs-create-poll-options > ul > li > input, .ccs-create-poll-topic > input', function(){
		var regex = /\S/g,
			value = $(this).val();
		value = strip_tags(value, "");

		if(flagPost){
			if(regex.test(value)){
				$(this).parent().children('label.ccs-error').addClass('hide');
				$(this).removeClass('ccs-error-input');
			} 
			else{
				$(this).parent().children('label.ccs-error').removeClass('hide');
				$(this).addClass('ccs-error-input');
			}
		}
	});

	$('.ccs-btn-create-poll').click(function(){
		$('.ccs-create-poll').toggleClass('dropIt');
		$('.ccs-create-poll').promise().done(function(){
			$('input:eq(0)', this).focus();
		});
	});

	$('.ccs-poll-controls-trigger').click(function(){
		$('.ccs-polls-controls', this).toggleClass('dropItX');
		$(this).toggleClass('clicked');
		if($(this).hasClass('clicked')) $(this).attr('title','Hide options.');
		else $(this).attr('title','Show options.');
	});

	$('.ccs-add-new-poll-option-plus').click(function(){
		add_poll_option($(this));
	});

	function add_poll_option(el){
		var val = $('.ccs-create-poll-options > ul > li').last().index() + 1;

		if(is_valid_to_add_option(val))
			$('<li>\n\
				<label class="ccs-error pull-right hide" for="option" style="position: absolute; right: 0; margin: 5px 25px 0 0; color: #B94A48; font-size: 10px">\n\
	                <i class="glyphicon glyphicon-asterisk pull-right"></i>\n\
	            </label>\n\
	            <input type="text" name="option[]" placeholder="Option ' + val + '"  style="padding-right: 8px"/><span class="remove" title="Remove this option."><i class="ic-close"></i></span>\n\
	           </li>').insertBefore(el.parent());
	}

	// limits the adding of poll option
	function is_valid_to_add_option(val){
		//return (val < 6) ? true : false;
		return true;
	}

	$(document).on('click','.ccs-create-poll-options li > span > i.ic-close',function(){
		$(this).parent().parent().remove();

		$('.ccs-create-poll-options > ul > li > input').each(function(i, item){
			$(this).attr('placeholder', 'Option ' + (i + 1));
		});
	});

	$(document).on('click','.ccs-poll-vote-btn',function(){
		var poll_id = $(this).parent().parent().attr('data-value'),
			opt_id = $(this).parent().attr('data-value'),
			el = $(this);

		
		is_user_still_logged_in(function(){
			is_poll_closed(el, poll_id, opt_id);
		});
	});

	function is_poll_closed(el, p_id, o_id){
		$.ajax({
			url: base_url + 'poll/is_poll_closed',
			type: 'POST',
			data: {
				poll_id: p_id
			},
			dataType: 'json',
			beforeSend: function(){},
			success: function(output){
				if(output.status == 0){
					has_user_voted_already(el, p_id, o_id);
				}
				else{
					var new_status = 'Open';

					el.parents('.ccs-polls-media').find('.ccs-poll-close-open').attr('data-status', new_status).attr('title','Click to ' + new_status.replace(/d$/,'').toLowerCase() + ' this topic.').html(new_status.replace(/d$/,''));
					el.parents('.ccs-polls-media').find('.ccs-polls-status').children('div').html('Closed');
					
					el.parents('.ccs-polls-media').removeClass(new_status).addClass('Closed');
					Dialog('Sorry, this topic has been closed.', 'alert', true, false, function(){});
				}
			},
			error: function(xhr){
				alert(xhr.responseText);
			}
		});
	}

	function has_user_voted_already(el, p_id, o_id){
		$.ajax({
			url: base_url + 'poll/is_user_voted',
			type: 'POST',
			data: {
				poll_id: p_id
			},
			dataType: 'json',
			beforeSend: function(){},
			success: function(output){
				if(output.status == 0){
					vote_topic_option(el, p_id, o_id);
				}
				else Dialog('Sorry, you already voted this topic.', 'alert', true, false, function(){}); 
			},
			error: function(xhr){
				alert(xhr.responseText);
			}
		});
	}

	function vote_topic_option(el, p_id, o_id){
		$.ajax({
			url: base_url + 'poll/vote_poll_option',
			type: 'POST',
			data: {
				poll_id: p_id,
				option_id: o_id
			},
			dataType: 'json',
			beforeSend: function(){},
			success: function(output){
				if(output.status == 1){
					var par = el.parents('li');
					var value = parseInt(par.attr('data-votes')) + 1;
					var votes = parseInt(par.parent('ul').attr('data-total-votes')) + 1;
					var percentage = parseFloat(value/votes) * 100;

					el.remove();
					par.prepend('<i class="icon-ok x40 ccs-poll-vote-btn" style="color: #ff6000"></i>');
					par.children('span.x40').last().html(value);
					par.parent('ul').attr('data-total-votes', votes);
					par.attr('data-votes', value);

					set_options_progress_bar(par.parent('ul'));
				}
				else Dialog('Sorry, something went wrong. Try again.', 'alert', true, false, function(){}); //alert('Sorry, something went wrong. Try again.');
			},
			error: function(xhr){
				alert(xhr.responseText);
			}
		});
	}

	function set_options_progress_bar(par){
		var votes = parseInt(par.attr('data-total-votes'));

		$('> li', par).each(function(i, item){
			var el = $(this);

			if(i > 0){
				var value = parseInt(el.attr('data-votes')),
					percentage = parseFloat(value/votes) * 100;

				if(percentage.toString().indexOf('.') > -1){
					percentage = parseFloat(percentage.toString().substr(0, percentage.toString().indexOf('.') + 3));
				}

				//el.children('span.x40').last().html(percentage + '%');
				el.find('.ccs-votes-progress-bar-container').attr('title', percentage + '%');
				el.find('.ccs-votes-progress-bar').animate({
					width: percentage + '%'
				});
			}
		});
	}

	$('.ccs-poll-delete').click(function(){
		var ans = 'Are you sure to delete this topic?',
			poll_id = $(this).parent().attr('data-value'),
			el = $(this);

		Dialog(ans, 'confirm', false, false, function(){
            is_user_still_logged_in(function(){ 
				delete_poll(el, poll_id); 
			});
        });
		// if(ans){
		// 	is_user_still_logged_in(function(){ 
		// 		delete_poll(el, poll_id); 
		// 	});
		// }
	});

	function delete_poll(el, id){
		$.ajax({
			url: base_url + 'poll/delete_poll',
			type: 'POST',
			data: {
				poll_id: id
			},
			dataType: 'json',
			beforeSend: function(){},
			success: function(output){
				if(output.status == 1){
					var list = $('.ccs-polls-body > .ccs-polls-media').last().index();

					if(list > 0){
						el.parents('.ccs-polls-media').slideUp(function(){
							$(this).remove();
						});
					}else{
						el.parents('.ccs-polls-media').slideUp(function(){
							$(this).html('No Polls Available... <a href="#" style="text-decoration:none;" class="ccs-no-available-create-post">Create one</a>')
							.addClass('ccs-polls-media-no-post').slideDown();
						});
					}
				}
				else Dialog('Sorry, something went wrong. Try again.', 'alert', true, false, function(){}); //alert('Sorry, something went wrong. Try again.');
			},
			error: function(xhr){
				alert(xhr.responseText);
			}
		});
	}

	$(document).on('click','.ccs-polls-media-no-post',function(){
		$('.ccs-create-poll').addClass('dropIt');
		$('.ccs-create-poll').promise().done(function(){
			$('input:eq(0)', this).focus();
		});
	});

	$('.ccs-poll-close-open').click(function(){
		var poll_id = $(this).parent().attr('data-value'),
			status = $(this).attr('data-status'),
			el = $(this);
		var ans = 'Are you sure to ' + status.replace(/d$/,'').toLowerCase() + ' this topic?';

		Dialog(ans, 'confirm', false, false, function(){
            is_user_still_logged_in(function(){
				open_close_poll(el, status, poll_id);
			});
        });
		// if(ans){
		// 	is_user_still_logged_in(function(){
		// 		open_close_poll(el, status, poll_id);
		// 	});
		// }
	});

	function open_close_poll(el, status, id){
		$.ajax({
			url: base_url + 'poll/open_close_poll',
			type: 'POST',
			data: {
				poll_id: id,
				status: status
			},
			dataType: 'json',
			beforeSend: function(){},
			success: function(output){
				if(output.status == 1){
					var new_status = (status == 'Closed') ? 'Open' : 'Closed';

					el.attr('data-status', new_status).attr('title','Click to ' + new_status.replace(/d$/,'').toLowerCase() + ' this topic.').html(new_status.replace(/d$/,''));
					$('.ccs-polls-author-container > .ccs-polls-author > .ccs-polls-status > div', el.parents('.ccs-polls-media')).html(status);

					el.parents('.ccs-polls-media').removeClass(new_status).addClass(status);
				}
				else Dialog('Sorry, something went wrong. Try again.', 'alert', true, false, function(){}); //alert('Sorry, something went wrong. Try again.');
			},
			error: function(xhr){
				alert(xhr.responseText);
			}
		});
	}
});

function strip_tags(input, allowed){
    allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
        commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
    return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
        return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
    });
}

