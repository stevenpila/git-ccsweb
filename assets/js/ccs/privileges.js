$(document).ready(function(){
	var base_url = 'http://localhost/ccsweb/';

	$('.ccs-set-privilege').click(function(e){
		$('.ccs-set-privilege-container').slideToggle();

		e.preventDefault();
	});
	$('.ccs-module-name').click(function(){
		var val = $(this).val();

		if($(this).is(':checked')){
			$(this).parent().find($('input[data-value="' + val + '"]')).prop('checked', true);
		}
		else{
			$(this).parent().find($('input[data-value="' + val + '"]')).prop('checked', false);
		}
	});
	$('.ccs-method-name').click(function(){
		var val = $(this).attr('data-value');

		if(is_all_checkbox_not_checked(val)) $('.ccs-module-name[value="' + val + '"]').prop('checked', false);
		else $('.ccs-module-name[value="' + val + '"]').prop('checked', true);

	});

	function is_all_checkbox_not_checked(id){
		var flag = true;

		$('.ccs-method-name[data-value="' + id + '"]').each(function(){
			if($(this).is(':checked')) flag = false;
		});

		return flag;
	}

	$('.ccs-toggle-check-all').click(function(){
		if($(this).is(':checked')){
			$(this).parent().find($('input')).prop('checked', true);
		}
		else{
			$(this).parent().find($('input')).prop('checked', false);
		}
	});

	$('form[name="ccs-set-privilege-form"]').validate({
		debug: true,
		rules: {
			'user_types[]': 'required',
			'privileges[]': 'required'
		},
		messages: {
			'user_types[]': 'required',
			'privileges[]': 'required'
		},
		onkeyup: false,
        onclick: false,
       	onfocusout: false,
//        focusInvalid: false,
        // errorClass: 'ccs-error',
//        validClass: 'ccs-valid',
        highlight: function(element, errorClass, validClass){
            $(element).parent().find($('span > i')).removeClass('hide');
        },
        unhighlight: function(element, errorClass, validClass){
        	$(element).parent().find($('span > i')).addClass('hide');
        },
        errorPlacement: function(error, element){
            $(element).parent().find($('span > i')).removeClass('hide');

            $('html, body').animate({
            	scrollTop: '0px'
            },0);
        },
        submitHandler: function(form){
            form.submit();
        }
	});

	$('.ccs-show-delete-privilege').click(function(){
		if($('.ccs-privileges-delete').hasClass('hide')) $(this).html('<i class="ic-arrow-left"></i> Back');
		else $(this).html('<i class="ic-trash"></i> Delete');

		$('.ccs-privileges-show, .ccs-privileges-delete').toggleClass('hide');
	});

	var floating;
	$('.ccs-privileges-delete-checkbox').click(function(){
		var el = $(this);
		var t = el.offset().top + 3;
        var l = el.offset().left - 35;

		$('input', this).click();

		if($('input', this).is(':checked')) $('i', this).removeClass('icon-check-empty').addClass('icon-ok');
		else $('i', this).removeClass('icon-ok').addClass('icon-check-empty');

		if(is_all_delete_checkbox_not_checked()){
			$('.ccs-delete-privileges-btn').addClass('disabled').attr('disabled','');
			$('.ccs-submit-delete-privileges-container').hide();
		}
		else{
			clearTimeout(floating);
			$('.ccs-submit-delete-privileges-container').css({
				top: t + 'px',
				left: l + 'px'
			}).hide().show();
			floating = setTimeout(function(){ $('.ccs-submit-delete-privileges-container').hide(); }, 3000);
			$('.ccs-delete-privileges-btn').removeClass('disabled').removeAttr('disabled');
		}

	});

	$('.ccs-privileges-delete-checkbox-all').click(function(){
		var el = $(this);
		var t = el.offset().top + 3;
        var l = el.offset().left - 35;

        $('input', this).click();

		if($('input', this).is(':checked')){
			$('.ccs-privileges-delete-checkbox').each(function(){
				$('input', this).prop('checked',true);
				$('i', this).removeClass('icon-check-empty').addClass('icon-ok');
			});

			$('i', this).removeClass('icon-check-empty').addClass('icon-ok');

			clearTimeout(floating);
			$('.ccs-submit-delete-privileges-container').css({
				top: t + 'px',
				left: l + 'px'
			}).hide().show();

			floating = setTimeout(function(){ $('.ccs-submit-delete-privileges-container').hide(); }, 3000);
			$('.ccs-delete-privileges-btn').removeClass('disabled').removeAttr('disabled');
		} 
		else{
			$('.ccs-privileges-delete-checkbox').each(function(){
				$('input', this).prop('checked',false);
				$('i', this).removeClass('icon-ok').addClass('icon-check-empty');
			});

			$('.ccs-delete-privileges-btn').addClass('disabled').attr('disabled','');
			$('.ccs-submit-delete-privileges-container').hide();

			$('i', this).removeClass('icon-ok').addClass('icon-check-empty');
		}


	});

	$(document).on({
		mouseenter: function(){
			clearTimeout(floating);
		},
		mouseleave: function(){
			floating = setTimeout(function(){ $('.ccs-submit-delete-privileges-container').hide(); }, 3000);
		},
	}, '.ccs-submit-delete-privileges-container');

	$(window).resize(function(){
		$('.ccs-submit-delete-privileges-container').hide();
	});

	function is_all_delete_checkbox_not_checked(){
		var flag = true;

		$('.ccs-privileges-delete-checkbox > input').each(function(){
			if($(this).is(':checked')) flag = false;
		});

		return flag;
	}

	$(document).on('click','.ccs-submit-delete-privileges-container > a, .ccs-delete-privileges-btn',function(e){
		var ans = 'Are you sure to delete selected rows?';

		Dialog(ans, 'confirm', false, false, function(){
			$('form[name="ccs-delete-privileges-form"]').submit();
		});
		// if(ans){
		// 	$('form[name="ccs-delete-privileges-form"]').submit();
		// }

		e.preventDefault();
	});
});