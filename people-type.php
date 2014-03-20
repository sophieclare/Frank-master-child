<?php

// Register the custom post type
add_action('init', 'people_register');  

// meta box added for people box.
add_action("admin_init", "people_meta_box");

// handle the saving of the intro/brief field.
add_action( 'save_post', 'people_meta_box_save' );

// This hides the parent dropdown from page attributes.  We're setting the parent on case studies automatically upon saving, by looking up the page id that has "is_casestudy_parent" set on it.
// add_action('admin_menu', function() { remove_meta_box('pageparentdiv', 'CaseStudy', 'normal');});
  
function people_register() {
	$labels = array(
		'name'               => _x( 'People', 'post type general name' ),
		'singular_name'      => _x( 'Person', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'person' ),
		'add_new_item'       => __( 'Add New Person' ),
		'edit_item'          => __( 'Edit Person' ),
		'new_item'           => __( 'New Person' ),
		'all_items'          => __( 'All People' ),
		'view_item'          => __( 'View Person' ),
		'search_items'       => __( 'Search People' ),
		'not_found'          => __( 'No People found' ),
		'not_found_in_trash' => __( 'No People found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'People'
	);

    $args = array(  
        'labels' => __($labels),  
		'description', 'People',
        'public' => true,
        'show_ui' => true,
		'query_var' => true,
        'capability_type' => 'page',  
        'hierarchical' => false,
        'rewrite' => false,
		'has_archive' => false,
		'show_in_nav_menus' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'supports' => array('page-attributes', 'thumbnail')
//		'taxonomies' => array('post_tag')
       );
  
    register_post_type( 'people' , $args );  
} 

function people_meta_box(){
    add_meta_box("lshift_admin", "Profile", "person_profile", "people", "normal", "high");    
}
  
function people_meta_box_save( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( !wp_verify_nonce( $_POST['people_meta_box_nonce'], plugin_basename( __FILE__ ) ) ) {
		return;
	}
	
	if ( 'people' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ) { 
			return;
		}
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	
	$name = $_POST['name'];
	$position = $_POST['position'];
	$bio = $_POST['bio'];

	update_post_meta( $post_id, '_name', $name );
	update_post_meta( $post_id, '_position', $position );
	update_post_meta( $post_id, '_bio', $bio );
}
  
function person_profile(){    
        global $post;    
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return $post_id;
		}
		
        $custom = get_post_custom($post->ID);    
        $name = $custom["_name"][0];
        $position = $custom["_position"][0];
        $bio = $custom["_bio"][0];
		wp_nonce_field( plugin_basename( __FILE__ ), 'people_meta_box_nonce' );
?>    
    <p><label>Name</label><input type="text" id="name" name="name" value="<?php echo $name ?>" /></p>
	<p><label>Position</label><input type="text" id="position" name="position" value="<?php echo $position ?>" /></p>
	<h2>Bio</h2>
	<p><textarea style="width:100%" rows="10" id="bio" name="bio"><?php echo $bio; ?></textarea></p>

<?php    
}    

function add_new_people_column($people_columns) {
  $people_columns['menu_order'] = "Order";
  return $people_columns;
}

add_action('manage_edit-people_columns', 'add_new_people_column');

function show_order_column($name){
  global $post;

  switch ($name) {
    case 'menu_order':
      $order = $post->menu_order;
      echo $order;
      break;
   default:
      break;
   }
}

add_action('manage_people_posts_custom_column','show_order_column');

function order_column_register_sortable($columns){
  $columns['menu_order'] = 'menu_order';
  return $columns;
}
add_filter('manage_edit-people_sortable_columns','order_column_register_sortable');
?>
