//Genre Ajax Filtering
jQuery(function($)
{
	//Load posts on page load
	campaign_get_posts();

	//If list item is clicked, trigger input change and add css class
	$('#campaign-filter li').on('click', function(e){
		// e.preventDefault();
		var input = $(this).find('input');
		// console.log(input);
		if ( $(this).attr('class') == 'clear-all' )
		{
			$('#campaign-filter li').removeClass('selected').find('input').prop('checked',false);
			campaign_get_posts();
		}
		else if (input.is(':checked'))
		{
			// input.prop('checked', false);
			$(this).removeClass('selected');
		} 
		else {
			// input.prop('checked', true);
			$(this).addClass('selected');	
		}
		input.trigger("change");
	});
	
	//If input is changed, load posts
	$('#campaign-filter input').on('change', function(){
		campaign_get_posts(); //Load Posts
	});
	
	//Find Selected Categories
	function getSelectedCampaigns()
	{
		var campaigns = [];
	
		$("#campaign-filter li input:checked").each(function() {
			var val = $(this).val();
			campaigns.push(val);
		});		
		console.log(campaigns);
		return campaigns;
	}
	
	// //Fire ajax request when typing in search
	// $('#campaign-search input.text-search').on('keyup', function(e){
	// 	if( e.keyCode == 27 )
	// 	{
	// 		$(this).val('');
	// 	}
		
	// 	campaign_get_posts(); //Load Posts
	// });
	
	// $('#submit-search').on('click', function(e){
	// 	e.preventDefault();
	// 	campaign_get_posts(); //Load Posts
	// });
	
	//Get Search Form Values
	// function getSearchValue()
	// {
	// 	var searchValue = $('#campaign-search input.text-search').val();	
	// 	return searchValue;
	// }
	
	// If pagination is clicked, load correct posts
	$('.campaign-filter-navigation a').on('click', function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		var paged = url.split('/page/'); //this only works if permalinks are off!
		// debugger;
		console.log(paged);
		campaign_get_posts(paged[1]); //Load Posts (feed in paged value) //get the second value in the resulting array created by url.split
	});
	
	//Main ajax function
	function campaign_get_posts(paged)
	{
		var paged_value = paged;
		var ajax_url = ajax_campaign_params.ajax_url;
		// console.log(ajax_url);

		$.ajax({
			type: 'GET',
			url: ajax_url,
			data: {
				action: 'campaign_filter',
				campaigns: getSelectedCampaigns,
				// search: getSearchValue(),
				paged: paged_value
			},
			beforeSend: function ()
			{
				//Show loader here
			},
			success: function(data)
			{
				//Hide loader here
				$('#campaign-results').html(data);
			},
			error: function()
			{
				$("#campaign-results").html('<p>There has been an error</p>');
			}
		});				
	}
	
})
