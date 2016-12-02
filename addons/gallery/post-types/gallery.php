<?php
class GalleryPostType {

    /**
    * hooks
    */
    public function __construct() {
        add_action('init', array($this, 'register'));
        //add_action('save_post', array(&$this, 'save_metabox'), 1, 2); // save the custom fields

    }

    /**
    * admin_init action
    */
    public function init() {

    }

    /**
    * register Custom Post Type
    */
    public function register() {
    
		$labels = array(
			'name'                => _x( 'Galériák', 'webcreatives-core' ),
			'singular_name'       => _x( 'Galéria', 'webcreatives-core' ),
			'menu_name'           => __( 'Galériák', 'webcreatives-core' ),
			'name_admin_bar'      => __( 'Galéria', 'webcreatives-core' ),
			'parent_item_colon'   => __( 'Szülő galéria:', 'webcreatives-core' ),
			'all_items'           => __( 'Összes galéria', 'webcreatives-core' ),
			'add_new_item'        => __( 'Új galéria hozzáadása', 'webcreatives-core' ),
			'add_new'             => __( 'Új galéria hozzáadása', 'webcreatives-core' ),
			'new_item'            => __( 'Új galéria', 'webcreatives-core' ),
			'edit_item'           => __( 'Galéria szerkesztése', 'webcreatives-core' ),
			'update_item'         => __( 'Galéria frissítése', 'webcreatives-core' ),
			'view_item'           => __( 'Galéria megtekintése', 'webcreatives-core' ),
			'search_items'        => __( 'Galéria keresése', 'webcreatives-core' ),
			'not_found'           => __( 'Nem található egy galéria sem', 'webcreatives-core' ),
			'not_found_in_trash'  => __( 'Nem található egy galéria sem a kukában', 'webcreatives-core' ),
		);    
        // register the post type
        register_post_type('gallery', array(
		
			'labels'=> $labels,
            'description' => __('Galériák', 'webcreatives-core'),
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'public' => true,
            'show_ui' => true,
            'auto-draft' => false,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'menu_position' => 4,
            'menu_icon'	=> 'dashicons-images-alt',
            'revisions' => false,
            'hierarchical' => true,
            'has_archive' => true,
			'supports' => array('title', 'thumbnail'),
            'rewrite' => false,
            'can_export' => false,
            'capability_type' => 'page',
            'register_meta_box_cb' => array(&$this, 'add_metabox')               
        ));
    }
    
    public function add_metabox(){
	    add_meta_box('elements', __('Elements', 'webcreatives-core'), array(&$this, 'metabox'), 'gallery','normal');
    }
    
    public function metabox($post){
	   include(sprintf("%s/admin-templates/element-editor.php", dirname(dirname(__FILE__))));
    }
    
    public function save_metabox($post_id){
	    
    }
    
    
 }
$GalleryPostType = new GalleryPostType();




?>
