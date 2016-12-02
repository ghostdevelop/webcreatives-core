<?php
if(!class_exists('WCSlider')) {
	
class WCSlider{
		
		public function __construct($sliderID, $query_args = array()){
			$this->ID = $sliderID;
			$this->query =  $this->get_query($sliderID, $query_args);
		}

		static function get_object_ids($sliderID){
			global $wpdb;
			
			$table_name = $wpdb->prefix . "gallery_relations";
			
			$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE sliderID = $sliderID ORDER BY list_order ASC", ARRAY_A );
			foreach( $results as $result )
			$ids[] = $result['objectID'];
			
			if (is_array($ids))
				return $ids;
			
			return false;
		}	
		
		function get_objects($sliderID){
			global $wpdb;
			
			$results = $wpdb->get_results( "SELECT * FROM $this->table_name WHERE sliderID = $sliderID ORDER BY list_order ASC", ARRAY_A );
			
			return $results;
		}	
		
		function get_query($sliderID, $query_args){
			global $wpdb;
			
			$object_ids = $this->get_object_ids($sliderID);

			$defaults = array(
				'post__in' => $object_ids,
				'post_type' => 'any',
				'post_status' => 'any',
				'posts_per_page' => -1,
			);
			
			$args = array_merge($defaults, $query_args);
			
			$slider = new WP_Query($args);	
			
			return $slider;

			
		}	
	}
}
?>
