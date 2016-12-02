jQuery(function($) {   
	$('.remove_element').click(function (){
		var element = $(this).closest('.element');
		var id = $(this).attr('data-id');
		
	    $.ajax({
	        url: rootpath + "lib/ajax.php",
	        data: {
	            'action':'slider_remove_element',
	            'id' : id,
	        },
	        method: 'POST',
	        success:function(data) {
	            // This outputs the result of the ajax request
	            if (data == 1){
		            element.remove();
	            }
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    }); 		
	});

	$( "#slider_elements" ).sortable({
	    update: function( event, ui ) {
		    var data = $(this).sortable('toArray');
		    $.ajax({
		        url: rootpath + "lib/ajax.php",
		        data: {
		            'action':'slider_order_objects',
		            'data' : data
		        },
		        method: 'POST',
		        success:function(data) {
		            // This outputs the result of the ajax request
		            console.log(data);
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });  
	    }
	});
	
	$( "#slider_elements" ).disableSelection();
	
                 
	var _custom_media = true,
	_orig_send_attachment = wp.media.editor.send.attachment;
 
	$('.upload_button').click(function(e) {
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = $(this);
		_custom_media = true;
		var sliderID = $(this).attr('data-id');
		wp.media.editor.send.attachment = function(props, attachment){
			if ( _custom_media ) {
			    $.ajax({
			        url: rootpath + "lib/ajax.php",
			        data: {
			            'action':'slider_add_page_callback',
			            'sliderID' : sliderID,
			            'objectID' : attachment.id,
			            'value' : attachment.title,
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
			} else {
				return _orig_send_attachment.apply( this, [props, attachment] );
			};
		}
 
		wp.media.editor.open(button);
		return false;
	});	
});