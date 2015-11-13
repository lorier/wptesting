(function($) {

	function find_page_number( element ) {
		element.find('span').remove();
		return parseInt( element.html() );
	}

	$(document).on( 'click', '.nav-links a', function( event ) {
		event.preventDefault();

		page = find_page_number( $(this).clone() );
		console.log(page);
		$.ajax({
			url: ajaxpagination.ajaxurl,
			type: 'post',
			data: {
				action: 'ajax_pagination',
				query_vars: ajaxpagination.query_vars,
				page: page
			},
			beforeSend: function() {
				$('#main').find( 'article' ).remove();
				$('#main nav').remove();
				$(document).scrollTop();
				$('#main').append( '<div class="page-content" id="loader">Loading New Posts...</div>' );
			},
			success: function( html ) {

				$('#main #loader').remove();
				$('#main').append( html );
			}
		})
	})
})(jQuery);