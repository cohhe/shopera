// Admin Javascript
jQuery( document ).ready( function( $ ) {

	// Choose layout
	$("#vh_layouts img").click(function() {
		$(this).parent().parent().find(".selected").removeClass("selected");
		$(this).addClass("selected");
	});

	jQuery(document).on('click', '.shopera-rating-dismiss', function() {
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'shopera_dismiss_notice'
			},
			success: function(data) {
				jQuery('.shopera-rating-notice').remove();
			}
		});
	});
});