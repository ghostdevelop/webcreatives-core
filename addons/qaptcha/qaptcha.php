<?php 
	if(!class_exists('QAPTCHA')) {

	    class QAPTCHA {
	    
		    public function __construct(){	
				add_action('wp_login', array(&$this, 'EndSession'));
				add_action('wp_logout', array(&$this, 'EndSession'));
				add_action( 'wp_enqueue_scripts', array(&$this, 'front_scripts'), 99);
				add_action( 'login_enqueue_scripts', array(&$this, 'front_scripts'));
				add_action ('wp_authenticate' , array(&$this, 'check_custom_authentication'));	
				add_action( 'login_form', array(&$this, 'login_fields') );	
				add_filter( 'woocommerce_process_registration_errors', array(&$this, 'validate_woocommerce_registration'), 10, 4 );
				add_filter( 'wpcf7_validate_quaptcha', array(&$this, 'validate_contact_form'), 10, 2 ); 
  				add_filter( 'wpcf7_validate_quaptcha*', array(&$this, 'validate_contact_form'), 10, 2 ); 
  				add_action( 'wpcf7_init', array(&$this, 'add_quaptcha_field' )); 		
  				add_action( 'wpcf7_enqueue_scripts', array(&$this, 'action_wpcf7_enqueue_scripts'), 99, 0 ); 		
		    }	
		    				
			public function startSession() {
			    if(!session_id()) {
			        session_start();
			    }
			}
		
			public function EndSession() {
				if(session_id()) {
			    	session_destroy ();
				}
			}	
			
			public function front_scripts(){
				wp_enqueue_script( 'jquery');
				wp_enqueue_script( 'jquery-ui-draggable');
				wp_enqueue_script( 'jquery-ui-touch', plugins_url( 'js/jquery.ui.touch.js', __FILE__ ),  array('jquery'));
				wp_enqueue_script( 'QapTcha.jquery-jquery', plugins_url( 'js/QapTcha.jquery.js', __FILE__ ),  array('jquery'), '1.0', true);
				wp_localize_script( 'QapTcha.jquery-jquery', 'ajax_urls',	array( 'admin_url' => plugins_url( '', __FILE__ ), 'resubmit' => __('Újrapróbálkozás', 'webcreatives-core') ) );			
				
				wp_enqueue_style( 'quaptcha', plugins_url( 'css/QapTcha.jquery.css', __FILE__ ));					
			}	
			
			function login_fields() {
				echo $this->get_the_login_field("admin-captcha");
				wp_enqueue_script( 'QapTcha-jquery', plugins_url( 'js/QapTcha-admin.js', __FILE__ ),  array('jquery'), '1.0', true);
			}
			
			function get_the_login_field($param = "") {
			
				$field = '<div class="QapTcha '.$param.'"></div>';
				$field .= '';
				
				return $field;
	
			}									
			
			function check_custom_authentication ($username) {
		        global $wpdb;
				session_start();
		
		        if (!username_exists($username)) {
			         return;
		        }
		        
				if ($_POST == array()) {
					return true;
				}
				
				// check if $_SESSION['qaptcha_key'] created with AJAX exists
				if(isset($_SESSION['qaptcha_key']) && !empty($_SESSION['qaptcha_key'])){
					$myVar = $_SESSION['qaptcha_key'];
					// check if the random input created exists and is empty
					if(isset($_POST[''.$myVar.'']) && empty($_POST[''.$myVar.''])){
						unset($_SESSION['qaptcha_key']);
					} else{
						header('Location: /wp-login.php?login_qatcha_err=1');
						exit();
					}
				} else {
					header('Location: /wp-login.php?login_qatcha_err=1');
					exit();
				}				
	
	
			}	
			
			function validate_woocommerce_registration( $validation_error, $username, $password, $email ){
				global $wpdb;
				session_start();

			    if( isset($_SESSION['qaptcha_key']) && !empty($_SESSION['qaptcha_key']) ){
			    	$myVar = $_SESSION['qaptcha_key'];
					// check if the random input created exists and is empty
					if(isset($_POST[''.$myVar.'']) && empty($_POST[''.$myVar.''])){
						unset($_SESSION['qaptcha_key']);
					} else{
			        	$validation_error->add('error', '<strong>ERROR</strong>: CAPTCHA response was incorrect');
			        }
			    } else {
			        $validation_error->add('error', '<strong>ERROR</strong>: CAPTCHA response was incorrect');
				    
			    }
	
			    return $validation_error;
			}	
			
			function add_quaptcha_field() {
			    wpcf7_add_shortcode( 'quaptcha', array(&$this, 'custom_quaptcha_shortcode_handler' ));
			}
			 
			function custom_quaptcha_shortcode_handler( $tag ) {
			    return $this->get_the_login_field("wpcf7-captcha");
			}						
						
			function validate_contact_form($result,$tag){
				global $wpdb;
				session_start();
				
			    if( isset($_SESSION['qaptcha_key']) && !empty($_SESSION['qaptcha_key']) ){
			    	$myVar = $_SESSION['qaptcha_key'];
					// check if the random input created exists and is empty
					if(isset($_POST[''.$myVar.'']) && empty($_POST[''.$myVar.''])){
						unset($_SESSION['qaptcha_key']);
					} else{
						$result['valid'] = false;
						$result['reason'][$name] = __('CAPTCHA response was incorrect', 'webcreatives-core');
			        }
			    } else {
						$result['valid'] = false;
						$result['reason'][$name] = __('CAPTCHA response was incorrect', 'webcreatives-core');
				    
			    }
			
				return $result;			
			

			    if( isset($_SESSION['qaptcha_key']) && !empty($_SESSION['qaptcha_key']) ){
			    	$myVar = $_SESSION['qaptcha_key'];
					// check if the random input created exists and is empty
					if(isset($_POST[''.$myVar.'']) && empty($_POST[''.$myVar.''])){
						unset($_SESSION['qaptcha_key']);
						return true;
					} else{
			        	return false;
			        }
			    } else {
			        return false;
				    
			    }
	
			    return $result;
			}
			
			// define the wpcf7_enqueue_scripts callback 
			function action_wpcf7_enqueue_scripts(  ) { 
			    // make action magic happen here... 
				wp_enqueue_script( 'QapTcha-jquery', plugins_url( 'js/QapTcha.js', __FILE__ ),  array('jquery'), '1.0', true);
			}			    								
		}
	}
	
	if (class_exists('QAPTCHA')){
		$QAPTCHA = new QAPTCHA();
	}
