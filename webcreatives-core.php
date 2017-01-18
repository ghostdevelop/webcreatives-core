<?php
/*
Plugin Name: Webcreatives Core
Plugin URI: http://webcreatives.hu
Description: webcreatives core plugin, to easily build high quality website
Version: 1.2
Author: Peter Bartfai
Author URI: 
License: GPL2
*/
/*
Copyright 2015
*/
	if(!class_exists('wCore')) {
	
	class wCore{
		
		public function __construct(){
			add_action('admin_menu', array(&$this, 'create_pages'));										
			add_filter( 'post_thumbnail_html', array(&$this, 'attachment_thumbnail'), 10, 5);
			add_action('admin_init', array(&$this, 'register_settings') );	
			$this->init();					
		}
		
		public function init(){
			$this->generate_constans();			
			$this->get_dir('class');
			$this->get_addon('addons');
			add_action( 'plugins_loaded', array(&$this, 'setup_languages' ));			
				
		}
		
		public function setup_languages(){

			load_plugin_textdomain( 'webcreatives-core', false, wCorePath.'/languages/' );
		}
		
		function generate_constans(){
			$file = __FILE__;
			$plugin_url = plugin_dir_url($file);
			$plugin_path = plugin_dir_path($file);

			define("wCorePath", $plugin_path);
			define("wCoreUrl", $plugin_url);

		}
		
        public static function activate(){
			global $wpdb;
			
			$charset_collate = $wpdb->get_charset_collate();
			$table_name = $wpdb->prefix . "gallery_relations";
			
			$sql = "CREATE TABLE  IF NOT EXISTS $table_name (
			  id mediumint(9) NOT NULL AUTO_INCREMENT,
			  sliderID int(5) NOT NULL,
			  objectID int(5) NOT NULL,
			  list_order int(3) NOT NULL,
			  PRIMARY KEY (id),
			  UNIQUE KEY id (sliderID, objectID)
			) $charset_collate;";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
        } // END public static function activate
    
        /**
         * Deactivate the plugin
         */     
        public static function deactivate(){
            // Do nothing
        } // END public static function deactivate		
		
		static function get_dir($dirname, $all = true,  $location = false){
			$location = ($location == false ? $location = dirname(__FILE__) : $location);
			$dirnames = glob($location . '/'. $dirname .'/*.php');

			foreach ($dirnames as $filename) {
				    $adds = explode("/", $filename);
					include $filename;	  
			}						
		}	
		
		static function get_addon($dirname, $folders = true, $location = false){
			$location = ($location == false ? $location = dirname(__FILE__) : $location);
			$dirnames = glob($location . '/'. $dirname .'/*.php');
			
			if (is_array($dirnames)){
				foreach ($dirnames as $filename) {
					    $adds = explode("/", $filename);
						include $filename;	  
				}				
			}
			
											
			if ($folders == true){
				$dirnames = glob(dirname(__FILE__) . '/'. $dirname . '/*', GLOB_ONLYDIR);
				foreach ($dirnames as $filename) {
					    $adds = explode("/", $filename);
						include $filename . '/' . end($adds) . '.php';	 
				}	
			}
		}		
				
		
		function create_pages(){
			add_menu_page('Webcreatives beállítások', 'Webcreatives beállítások', 'administrator', __FILE__, array(&$this, 'theme_settings_page'),'dashicons-admin-generic', 999);			
		}
	
		function logout_url(){
		  wp_redirect( home_url() );
		  exit();
		}		
		
		function theme_settings_page(){
			include(sprintf("%s/admin-templates/theme-options.php", dirname(__FILE__)));	
		}
		
		function register_settings(){
			register_setting('webcreatives-group', 'twitter'); 
			register_setting('webcreatives-group', 'facebook'); 
			register_setting('webcreatives-group', 'gplus'); 	
			register_setting('webcreatives-group', 'logo'); 		
		}	
				

		function attachment_thumbnail($html, $post_id, $post_thumbnail_id, $size, $attr ){
			if (get_post_type($post_id) == 'attachment' && get_post_mime_type($post_id) != 'video/x-flv'){	
				$html = wp_get_attachment_image( $post_id, $size, false, $attr );
			}
			
			if (get_post_type($post_id) == 'attachment' && get_post_mime_type($post_id) == 'video/x-flv'){
				$html = '<iframe src="'.wp_get_attachment_url($post_id).'" width="560" height="315" frameborder="0" allowfullscreen></iframe>';		
			}
			
			return $html;
		}			
		
	} //End wCore Class
}

if(class_exists('wCore')){
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('wCore', 'activate'));
    register_deactivation_hook(__FILE__, array('wCore', 'deactivate'));

    // instantiate the plugin class
    $wCore = new wCore();
}

