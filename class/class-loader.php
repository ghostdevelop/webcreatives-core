<?php 
	if(!class_exists('WebcreativesCoreLoader')) {
	
	    class WebcreativesCoreLoader {
	    
		    public function __construct(){
		    	add_action( 'wp_enqueue_scripts', array(&$this, 'load_core_scripts' ));
		    	add_action( 'wp_enqueue_scripts', array(&$this, 'register_styles' ));
		    	add_action( 'wp_enqueue_scripts', array(&$this, 'register_scripts' ));		
		    }
		    
		    function register_scripts(){
				//wp_register_script( $handle, $src, $deps, $ver, $in_footer ); 	
			    wp_register_script( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', array('jquery') ); 		    
			    wp_register_script( 'magic-scroll', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js' ); 		    
			    wp_register_script( 'magic-scroll-debug', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js' ); 		    
			    wp_register_script( 'iconpicker', plugin_dir_url( __FILE__ ) . '../js/iconpicker.js', array('jquery.ui.pos') ); 		    
			    wp_register_script( 'autocomplete', plugin_dir_url( __FILE__ ) . '../js/autocomplete.js', array('jquery-ui-autocomplete') ); 		    
			    wp_register_script( 'jssocials', plugin_dir_url( __FILE__ ) . '../js/jssocials.min.js', array('jquery') ); 		    
			    wp_register_script( 'jquery.ui.pos', plugin_dir_url( __FILE__ ) . '../js/jquery.ui.pos.js', array('jquery') ); 		    
		    }
		    
		    function register_styles(){
		    	//wp_register_style( $handle, $src, $deps, $ver, $media ); 	
				wp_register_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css' ); 		    
				wp_register_style( 'wyswyg', plugin_dir_url( __FILE__ ) . '../css/wyswig-styles.css' ); 		    	    
				wp_register_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' ); 		    
				wp_register_style( 'iconpicker', plugin_dir_url( __FILE__ ) . '../css/fontawesome-iconpicker.min.css' ); 		    
				wp_register_style( 'jssocials', plugin_dir_url( __FILE__ ) . '../css/jssocials/jssocials.css' ); 		    	    
				wp_register_style( 'jssocials-theme-classic', plugin_dir_url( __FILE__ ) . '../css/jssocials/jssocials-theme-classic.css' ); 		    
				wp_register_style( 'jssocials-theme-minima', plugin_dir_url( __FILE__ ) . '../css/jssocials/jssocials-theme-minima.css' ); 		   	    
				wp_register_style( 'jssocials-theme-flat', plugin_dir_url( __FILE__ ) . '../css/jssocials/jssocials-theme-flat.css' ); 		    	    
				wp_register_style( 'jssocials-theme-plain', plugin_dir_url( __FILE__ ) . '../css/jssocials/jssocials-theme-plain.css' ); 		    	    
	    	    
		    }
		    
		    function load_core_scripts(){
			    //wp_enqueue_script( 'core-scripts', plugin_dir_url( __FILE__ ) . '../js/core-scripts.js', array('jquery', 'jquery-ui-accordion') );
		    }
		    	
		    function admin_scripts(){
			    
		    }
		    
		    function front_scripts(){
			    
		    }
	    }
	}
	
	if (class_exists('WebcreativesCoreLoader')){
		$WebcreativesCoreLoader = new WebcreativesCoreLoader();
	}
?>