<?php 

function is_buildered(){
	global $wpdb;
	
	$panels = get_post_meta(get_the_ID(), 'panels_data', true);
	if ($panels) return true;
	
	return false;
}

function dropdown_post_types($name, $selected, $array = array('public' => true, '_builtin' => false), $output = 'objects'){
	$array['_builtin'] = true;
	$post_types = get_post_types($array, $output); 	
	$array['_builtin'] = false;
	$post_types2 = get_post_types($array, $output); 	
	
	$post_types = array_merge($post_types, $post_types2);
	unset($post_types['attachment']);
	
	
	
	echo '<select name="'.$name.'">';
	
	foreach ($post_types as $post_type){
		echo '<option value="'.$post_type->name.'" '.selected($selected, $post_type->name).'>'.$post_type->labels->name.'</option>';
	}
	
	echo '</select>';
}

function get_the_slug($echo=true){
	global $post;
	$slug = basename($post->post_name);
	$slug = apply_filters('slug_filter', $slug);
	
	return $slug;
}

function the_slug(){
	do_action('before_slug', $slug);
	echo get_the_slug();
	do_action('after_slug', $slug);
}

function theme_textdomain($context = ""){
	$template = wp_get_theme();		
	$textdomain = $template->template;
	
	if ($context != ""){
		$textdomain .= $context;
	}
	
	return $textdomain;
}



/**
 * Load a template part into a template
 *
 * Makes it easy for a theme to reuse sections of code in a easy to overload way
 * for child themes.
 *
 * Includes the named template part for a theme or if a name is specified then a
 * specialised part will be included. If the theme contains no {slug}.php file
 * then no template will be included.
 *
 * The template is included using require, not require_once, so you may include the
 * same template part multiple times.
 *
 * For the $name parameter, if the file is called "{slug}-special.php" then specify
 * "special".
 * 
 * For the var parameter, simple create an array of variables you want to access in the template
 * and then access them e.g. 
 * 
 * array("var1=>"Something","var2"=>"Another One","var3"=>"heres a third";
 * 
 * becomes
 * 
 * $var1, $var2, $var3 within the template file.
 *
 * @since 3.0.0
 *
 * @param string $slug The slug name for the generic template.
 * @param string $name The name of the specialised template.
 * @param array $vars The list of variables to carry over to the template
 * @author Eugene Agyeman zmastaa.com
 */
function get_template_part_with_params( $slug, $name = null,$vars=null ) {
	/**
	 * Fires before the specified template part file is loaded.
	 *
	 * The dynamic portion of the hook name, `$slug`, refers to the slug name
	 * for the generic template part.
	 *
	 * @since 3.0.0
	 *
	 * @param string $slug The slug name for the generic template.
	 * @param string $name The name of the specialized template.
	 * @param array $vars The list of variables to carry over to the template
	 */
	do_action( "get_template_part_{$slug}", $slug, $name );
 
	$templates = array();
	$name = (string) $name;
	if ( '' !== $name )
		$templates[] = "{$slug}-{$name}.php";
 
	$templates[] = "{$slug}.php";
 
	extract($vars);
	foreach ($templates as $template){
		include(locate_template($template));
	}
}	