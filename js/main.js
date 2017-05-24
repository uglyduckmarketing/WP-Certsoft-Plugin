	jQuery(document).ready(function($){
		$('#exotic_save_list').click(function(){
			alert('save disabled');
		});
				
		$('#exotic_add_dancer').click(function(){
			$.post(
			    ajaxurl, 
			    {
			        'action': 'exotic_roll_call_ajax',
			        'name':   $('#exotic_dancer_name').val()
			    }, 
			    function(response){
			        //alert('The server responded: ' + response);
					$('#exotic_dancer_name').val('');
					$('#exotic_add_dancer_results').html(response);
			    }
			);			
		});		
		//	
		$(function(){
			$( '#exotic_schedule_container, #dancer_list' ).sortable({
				connectWith: '.connectedSortable'
			}).disableSelection();
		});		
	});