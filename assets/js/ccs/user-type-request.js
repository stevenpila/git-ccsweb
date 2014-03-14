$(document).ready(function(){
	var base_url = 'http://localhost/ccsweb/';

	$('.accordion-collapse').click(function(e){
		var ref = $(this).attr('href');
		var id = $(this).parent().attr('data-value');
		var el = $(this);

		if($('tr.showed-collapse' + ref).length){
			$(ref).remove();
		}
		else{
			reset_all_show_collapse();

			is_user_still_logged_in(function(){
				show_user_request_information(el, ref, id);
			});
		}

		e.preventDefault();
	});

	function reset_all_show_collapse(){
		$('.datatable > tbody > tr.showed-collapse').each(function(){
			$(this).remove();
		});
	}

	function show_user_request_information(el, ref, id){
		$.post(base_url + 'user_type_request/show_user_request_information', {req_id: id}, function(data){
			$('<tr class="showed-collapse" id="' + ref.replace(/^#/gi,'') + '"><td colspan="6">\n\
			<div>' + data + '</div>\n\
			</td><td class="hide">\n\
			</td><td class="hide"></td><td class="hide"></td><td class="hide"></td><td class="hide"></td></tr>').insertAfter(el.parent().parent());
		});
	}	
});