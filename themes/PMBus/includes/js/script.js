jQuery(function($){
	$('.target').click(function () {
		$.post(ajax_object.ajaxurl, {
			action: 'ajax_action',
			post_id: $(this).find('input.post_id').attr('value')
		}, function(data) {
			alert(data); // alerts 'ajax submitted'
		});
	});
});
