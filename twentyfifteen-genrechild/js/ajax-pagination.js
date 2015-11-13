(function($) {
	genre_get_posts();
	var current_page = 1;
	console.log(current_page);

	//If list item is clicked, trigger input change and add css class
	$('select').change(function(){
		// var input = $(this).find('input');
		
		// if ( $(this).attr('class') == 'clear-all' )
		// {
		// 	$('#genre-filter li').removeClass('selected').find('input').prop('checked',false);
		// 	genre_get_posts();
		// }
		// else if (input.is(':checked'))
		// {
		// 	// input.prop('checked', false);
		// 	$(this).removeClass('selected');
		// } else {
		// 	// input.prop('checked', true);
		// 	$(this).addClass('selected');	
		// }
		// input.trigger("change");
		genre_get_posts(); //Load Posts
		
	});

	//If input is changed, load posts
	// $('#genre-filter input').on('change', function(){
	// 	genre_get_posts(); //Load Posts
	// });


	//Find Selected Genres
	function getSelectedGenres()
	{
		var genres = [];
	
		$('select option:selected').each(function() {
			var val = $(this).val();
			genres.push(val);
		});		
		// console.log(genres);
		return genres;
	}

	function find_page_number( element ) {
		element.find('span').remove();
		return parseInt( element.html() );
	}
	//If pagination is clicked, load correct posts

	$(document).on( 'click', '.nav-links a.page-numbers', function( event ) {
		event.preventDefault();
		var page = find_page_number( $(this).clone() );
		// current_page = parseInt(page);
		// console.log(current_page);
		genre_get_posts(page);

	})
	$(document).on( 'click', '.nav-links .next', function ( event ) {
		event.preventDefault;
		current_page = current_page + 1;
		genre_get_posts(current_page);
		console.log(current_page);
	})
	$(document).on( 'click', '.nav-links .prev', function ( event ) {
		event.preventDefault;
		current_page = current_page + 1;
		genre_get_posts(current_page);
		console.log(current_page);
	})
	function genre_get_posts(page) {

		$.ajax({
			url: ajaxpagination.ajaxurl,
			type: 'GET',
			data: {
				action: 'ajax_pagination',
				genres: getSelectedGenres,
				query_vars: ajaxpagination.query_vars,
				page: page,
			},
			// beforeSend: function() {
			// 	$('#genre-results').find( 'article' ).remove();
			// 	// $('#genre-results nav').remove();
			// 	$(document).scrollTop();
			// 	$('#genre-results').append( '<div class="page-content" id="loader">Loading New Posts...</div>' );
			// },
			success: function( data ) {
				// alert('success');
				$('#genre-results').find( 'article' ).remove();
				$('#genre-results .nav-links').remove();
				$('#genre-results').html( data );
			},
			error: function()
			{
				$("#genre-results").html('<p>There has been an error</p>');
			}
		})
	}
})(jQuery);