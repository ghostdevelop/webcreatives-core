<?php
if(!class_exists('WebcreativesGallery')) {
	
class WebcreativesGallery{
		
		public function __construct(){
			$this->init();								
			/* Filter the single_template with our custom function*/
			add_action( 'admin_enqueue_scripts', array(&$this, 'admin_scripts' ));	
		}
		
		public function init(){
			wCore::get_dir('class', false, dirname(__FILE__));
			wCore::get_dir('post-types', false, dirname(__FILE__));
		}
		
		public function admin_scripts() {
			if ($this->get_current_post_type() == 'gallery'){	
				wp_enqueue_media();			
				wp_enqueue_style('gallery-admin', plugins_url( './css/gallery-admin.css', __FILE__ ));
				wp_enqueue_script('autocomplete');
				wp_localize_script( 'autocomplete', 'rootpath', plugin_dir_url(__FILE__) );
				wp_enqueue_script('gallery-admin', plugins_url( './js/gallery-admin.js', __FILE__ ), array('jquery') );
			}
		}
		
		public function front_scripts(){
		
		}	
		
		function get_current_post_type() {
		  global $post, $typenow, $current_screen;
			
		  //we have a post so we can just get the post type from that
		  if ( $post && $post->post_type )
		    return $post->post_type;
		    
		  //check the global $typenow - set in admin.php
		  elseif( $typenow )
		    return $typenow;
		    
		  //check the global $current_screen object - set in sceen.php
		  elseif( $current_screen && $current_screen->post_type )
		    return $current_screen->post_type;
		  
		  //lastly check the post_type querystring
		  elseif( isset( $_REQUEST['post_type'] ) )
		    return sanitize_key( $_REQUEST['post_type'] );
			
		  //we do not know the post type!
		  return null;
		}			
		
	}
}

if(class_exists('WebcreativesGallery')){
    // instantiate the plugin class
    $WebcreativesGallery = new WebcreativesGallery();
}
?>
