<?php
if(!class_exists('WCSliderAdmin')) {
	
class WCSliderAdmin{
		
		public function __construct(){
					
		}
		
		function slider_create_object_html($object){
			$value = ($object['value'] != "" ? $object['value'] : get_the_title($object['objectID']));
			echo '<li id="element-'.$object['id'].'" class="element">
				    	<div class="left">
				    		<div class="element_image">'.get_the_post_thumbnail($object['objectID'], array(50,50)).'</div>
				    		<div class="element_title">'.$value.'</div>
				    	</div>
				    	<div class="right">
				    		<div class="element_actions">
				    			<a class="remove_element" data-id="'.$object['id'].'">
				    				<span class="dashicons dashicons-trash"></span>
				    			</a>
				    		</div>	
				    		<div class="element_info">Típus: <span>'.get_post_type($object['objectID']).'</span></div>
				    	</div>	
				    	<br clear="all">	    
				 </li>';	
		}	
		
		public function get_slider_objects($sliderID){
			global $wpdb;
			
			$table_name = $wpdb->prefix . "gallery_relations";
			
			$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE sliderID = $sliderID ORDER BY list_order ASC", ARRAY_A );
			
			return $results;
		}		
	}
}
?>
