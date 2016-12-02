<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-includes/wp-db.php' );

//connect to your database
$wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST); 


$term = trim(strip_tags($_GET['term'])); //retrieve the search term that autocomplete sends
$action = trim(strip_tags($_GET['action'])); //retrieve the search term that autocomplete sends
$cat = (int) $_GET['cat']; //retrieve the search term that autocomplete sends
$posts_table = "wp_posts";

if ($action == 'custom_post_loop_autocomplete'){
	$matches = $wpdb->get_results("SELECT 
		ID AS id, post_title AS value 
		FROM wp_posts p
		JOIN wp_term_relationships tr ON (p.ID = tr.object_id)
		JOIN wp_term_taxonomy tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
		JOIN wp_terms t ON (tt.term_id = t.term_id)		
		WHERE p.post_title LIKE '%$term%' 
		AND (p.post_type != 'revision' 
		AND p.post_type != 'nav_menu_item')
		AND tt.taxonomy = 'category'
		AND t.term_id = $cat" );	

}

if ($action == 'add_slider_object'){
	$matches = $wpdb->get_results( "SELECT ID AS id, post_title AS value, post_type AS type FROM wp_posts WHERE post_title LIKE '%$term%' AND (post_type != 'revision' AND post_type != 'nav_menu_item')" );	
}

echo json_encode($matches);//format the array into json data		

?>