<?php
	if(!class_exists('CookiePopUp')) {
	
		class CookiePopUp{
			
			public function __construct(){	
				add_action( 'wp_enqueue_scripts', array(&$this, 'enqueue' ));	
				add_action('admin_init', array(&$this, 'register_settings') );	
			}
			
			function enqueue(){
				wp_enqueue_script(
				    'jquery.cookie',
				    plugins_url( '/js/jquery.cookie.js', __FILE__ ),
				    array( 'jquery' ),
				    '1.0.0',
				    true
				);
			
			
				wp_enqueue_script(
				    'cookie-popup',
				    plugins_url( '/js/cookie-popup.js', __FILE__ ),
				    array( 'jquery' ),
				    '1.0.0',
				    true
				);
				
				$message = (get_option('cookie-message') != '' ? get_option('cookie-message') : __( 'Ez a weboldal a legjobb felhasználói élmény elérése érdekében sütiket (cookie) használ. Weboldalunk használatával jóváhagyja a sütik használatát.', 'webcreatives-core' ));
				$acceptLabel = (get_option('cookie-accept-button-label') != '' ? get_option('cookie-accept-button-label') : __( 'Elfogadom', 'webcreatives-core' ));
				$acceptUrl = (get_option('cookie-accept-button-url') != '' ? get_option('cookie-accept-button-url') : home_url());
				$moreLabel = (get_option('cookie-more-button-label') != '' ? get_option('cookie-more-button-label') : __( 'További információk...', 'webcreatives-core' ));
				$moreUrl = (get_option('cookie-more-button-url') != '' ? get_option('cookie-more-button-url') : home_url());
				
				wp_localize_script(
				    'cookie-popup',
				    'cookie_pop_text', array(
				        'message' => $message,
				        'acceptLabel'  => $acceptLabel,
				        'acceptUrl'  => $acceptUrl,
				        'moreLabel'    => $moreLabel,
				        'moreUrl'    => $moreUrl,
				    )
				);				
				
				wp_enqueue_style(
				    'cookie-popup',
				    plugins_url( '/css/cookie-popup.css', __FILE__ ),
				    array(),
				    '1.0.0'
				);
			}
			
			function register_settings(){
				register_setting('webcreatives-group', 'cookie-message'); 
				register_setting('webcreatives-group', 'cookie-accept-button-label'); 
				register_setting('webcreatives-group', 'cookie-accept-button-url'); 
				register_setting('webcreatives-group', 'cookie-more-button-label'); 
				register_setting('webcreatives-group', 'cookie-more-button-url'); 
			}	
			
		}
	}
	
	if(class_exists('CookiePopUp')) {
	
		$CookiePopUp = new CookiePopUp();
	}