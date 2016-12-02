<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-includes/wp-db.php' );
//connect to your database
$wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST); 
$postdata['action'] = sanitize_text_field($_POST['action']);
$postdata['id'] = (int) $_POST['id'];
$postdata['sliderID'] = (int) $_POST['sliderID'];
$postdata['objectID'] = (int) $_POST['objectID'];
$postdata['value'] = sanitize_text_field($_POST['value']);
$postdata['data'] = (array) $_POST['data'];

call_user_func($postdata['action'], $postdata);

function slider_add_page_callback($postdata){
	global $wpdb;
	$prefix = "wp_";
	
	$table_name = $prefix . "gallery_relations";
	$wpdb->insert($table_name, array(
	   "sliderID" => $postdata['sliderID'],
	   "objectID" => $postdata['objectID'],
	));	

	WCSliderAdmin::slider_create_object_html($postdata);
	
	die();
}

function slider_remove_element($postdata){
	global $wpdb;
	$prefix = "wp_";
	
	$table_name = $prefix . "gallery_relations";
	echo $wpdb->delete( $table_name, array( 'id' => $postdata['id']) );
}

function slider_order_objects($postdata){
	global $wpdb;
	$prefix = "wp_";
	
	$table_name = $prefix . "gallery_relations";
	foreach ($postdata['data'] as $data){		
		$number = get_numerics($data);
		$ids[] = $number[0];
	}
	
	foreach ($ids as $key => $id){
		$wpdb->update( 
			$table_name, 
			array( 
				'list_order' => $key,	// string
			), 
			array( 'id' => $id ), 
			array( 
				'%d',	// value1
			), 
			array( '%d' ) 
		);		
	}
}

function get_numerics ($str) {
    preg_match_all('/\d+/', $str, $matches);
    return $matches[0];
}