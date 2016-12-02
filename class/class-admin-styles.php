<?php 
	if(!class_exists('ADMIN_STYLES')) {
	
	    class ADMIN_STYLES {
	    
		    function __construct(){
			    add_action('admin_init', array(&$this, 'admin_color_schemes'));
			    add_action('wp_head', array(&$this, 'admin_bar_style'));
			    add_filter('get_user_option_admin_color', array(&$this, 'change_admin_color'));
			    add_action('admin_head', array(&$this, 'admin_color_scheme'));
			    add_action( 'login_enqueue_scripts', array(&$this, 'custom_login' ));	
				add_filter( 'login_headerurl', array(&$this, 'custom_login_url' ));
				add_filter( 'login_headertitle', array(&$this, 'custom_login_title' ));
				add_filter('admin_footer_text', array(&$this, 'remove_footer_admin'));			
				add_action( 'admin_bar_menu', array(&$this, 'remove_wp_logo'), 999 );		
				add_action( 'admin_bar_menu', array(&$this, 'custom_admin_bar'), 999);		
				add_action( 'wp_before_admin_bar_render', array(&$this, 'admin_bar_new_menu' ));						
		    }
		    
			function admin_color_schemes() {  
			    
			    $theme_dir = plugins_url( '../css/admin-styles.css', __FILE__ );   
			    
			    wp_admin_css_color( 
			    	'webcreatives-admin-style', __( 'Webcreatives Admin Style' ),  
			        $theme_dir,  
			        array( '#253944', '#9ebaa0', '#738e96', '#f2fcff' )  
			    );

			}  	
		
			function admin_bar_style(){
				wp_enqueue_style( 'custom-admin-bar',plugins_url( '../css/admin-bar.css', __FILE__ ));	
			}	    
			
			function change_admin_color($result) {
				return 'webcreatives-admin-style';
			}	
			
			function admin_color_scheme() {
			   global $_wp_admin_css_colors;
			   $_wp_admin_css_colors = 0;
			}		
			
			function custom_login_url() {
			    return home_url();
			}
			
			function custom_login_title(){
				return get_bloginfo('description');
			}
			
			function remove_footer_admin () {
			    echo '';
			}	
			
			function remove_wp_logo( $wp_admin_bar ) {
				$wp_admin_bar->remove_node( 'wp-logo' );
			}												
			
			function custom_login() {
				wp_enqueue_style('custom_login', plugins_url( '../css/custom-login.css', __FILE__ ));
			}
			
			function custom_admin_bar($wp_admin_bar){
				if ( current_user_can( 'manage_options' ) ) {
				    /* A user with admin privileges */
					$wp_admin_bar->remove_node( 'comments' );
				} else {
				    /* A user without admin privileges */
					$wp_admin_bar->remove_node( 'updates' );
					$wp_admin_bar->remove_node( 'comments' );
					$wp_admin_bar->remove_node( 'new-media' );
					//$wp_admin_bar->remove_node( 'new-content' );		
				}			
			}
			
			function admin_bar_new_menu() {
			    global $wp_admin_bar;
			    $wp_admin_bar->remove_menu('new-post');
			    $wp_admin_bar->remove_menu('new-media');
	            $wp_admin_bar->add_menu( array(
		             'parent' => 'new-content',
		             'id' => 'new-post',
		             'title' => __('Hír', 'webcreatives-core'),
		             'href' => admin_url( 'post-new.php' ),
		             )
		        );
			
			}						
	    }
	}
	
	if (class_exists('ADMIN_STYLES')){
		$ADMIN_STYLES = new ADMIN_STYLES();
	}
?>