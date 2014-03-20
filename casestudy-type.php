  <?php

// Register the custom post type
add_action('init', 'casestudy_register');  

// meta box added for custom fields box.
add_action("admin_init", "casestudy_meta_box");  

// handle the saving of the custom fields.
add_action( 'save_post', 'casestudy_meta_box_save' );
+
// This hides the parent dropdown from page attributes.  We're setting the parent on case studies automatically upon saving, by looking up the page id that has "is_casestudy_parent" set on it.
 add_action('admin_menu', function() { remove_meta_box('pageparentdiv', 'CaseStudy', 'normal');});
  
function casestudy_register() {  
	$labels = array(
		'name'               => _x( 'Case Studies', 'post type general name' ),
		'singular_name'      => _x( 'Case Study', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'casestudy' ),
		'add_new_item'       => __( 'Add New Case Study' ),
		'edit_item'          => __( 'Edit Case Study' ),
		'new_item'           => __( 'New Case Study' ),
		'all_items'          => __( 'All Case Studies' ),
		'view_item'          => __( 'View Case Study' ),
		'search_items'       => __( 'Search Case Studies' ),
		'not_found'          => __( 'No Case Studies found' ),
		'not_found_in_trash' => __( 'No Case Studies found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Case Studies'
	);

    $args = array(  
        'labels' => __($labels),  
		'description', 'Case studies',
        'public' => true,
        'show_ui' => true,  
        'capability_type' => 'page',
		'query_var' => true,		
        'hierarchical' => true,
        'rewrite' => array('with_front' => false, 'slug'=>'/services/case-studies'),
		'has_archive' => false,
		'show_in_nav_menus' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'supports' => array('title', 'page-attributes', 'editor', 'thumbnail'),
		'taxonomies' => array('post_tag')
       );  
  
    register_post_type( 'casestudy' , $args ); 
//	echo " register_post_type <br><pre>"; print_r($args); echo "</pre>";
} 

function casestudy_meta_box(){
	add_action( 'add_meta_boxes', 'action_add_meta_boxes', 0 );
    add_meta_box("lshift_admin", "Case Study", "casestudy_intro", "casestudy", "normal", "high");    
}     
  
  
function action_add_meta_boxes() {
	global $_wp_post_type_features;
	if (isset($_wp_post_type_features['casestudy']['editor']) && $_wp_post_type_features['casestudy']['editor']) {
		unset($_wp_post_type_features['casestudy']['editor']);
		add_meta_box(
			'description_section',
			__('Middle Column'),
			'editor_custom_box',
			'casestudy', 'normal', 'high'
		);
	}

	if (isset($_wp_post_type_features['casestudy']['excerpt']) && $_wp_post_type_features['casestudy']['excerpt']) {
		unset($_wp_post_type_features['casestudy']['excerpt']);
	}
}
    
function editor_custom_box( $post ) {

	the_editor($post->post_content);
}
    
function casestudy_meta_box_save( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( !wp_verify_nonce( $_POST['casestudy_meta_box_nonce'], plugin_basename( __FILE__ ) ) ) {
		return;
	}
	
	if ( 'casestudy' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ) { 
			return;
		}
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	
	$intro = $_POST['intro'];
	update_post_meta( $post_id, '_intro', $intro );

	$headline = $_POST['headline'];
	update_post_meta( $post_id, '_headline', $headline );

}
  
function casestudy_intro(){    
        global $post;    
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return $post_id;
		}
		
        $custom = get_post_custom($post->ID);    
        $intro = $custom["_intro"][0];
        $headline = $custom["_headline"][0];	
		wp_nonce_field( plugin_basename( __FILE__ ), 'casestudy_meta_box_nonce' );
?>    
    <p><label>Headline:</label><input type="text" id="headline" style="width:87%" name="headline" value="<?php echo $headline ?>" /></p>
	<p><label>Top banner:</label>
	<textarea id="excerpt" name="excerpt" style="width:87%" rows="4"><?php echo $post->post_excerpt ?></textarea></p>
	<p>Left column text:</p>
	<?php 
	wp_editor( $intro, 'intro'); 
}    
?>