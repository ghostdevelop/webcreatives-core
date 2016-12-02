jQuery(function($) {	
	$(".autocomplete").each(function( ) {
		$(this).autocomplete({
			source: function(request, response) {
				$.getJSON(rootpath + "lib/livesearch.php", { term: request.term, action: $(this.element).attr('data-action')}, 
			          response);
			},			
			minLength: 2,//search after two characters,,
		    create: function() {
		        $(this).data('ui-autocomplete')._renderItem = function(ul, item) {
				    return $('<li></li>')
			        .data( "item.autocomplete", item )
			        .append( "<a>" + item.value + "</a> - <span>"+ item.type +"</span>" )
			        .appendTo( ul );
				}
		    },
			select: function(event,ui){
				var sliderID = $(this).attr('data-id');
			    $.ajax({
			        url: rootpath + "lib/ajax.php",
			        data: {
			            'action':'slider_add_page_callback',
			            'sliderID' : sliderID,
			            'objectID' : ui.item.id,
			            'value' : ui.item.value,
			        },
			        method: 'POST',
			        success:function(data) {
			            // This outputs the result of the ajax request
			            $('#slider_elements').append(data);
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });  
			    this.value = "";	
			    return false;	
		    }	    
		});   
	}); 	
});