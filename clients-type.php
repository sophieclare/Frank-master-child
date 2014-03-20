<?php

// Register the custom post type
add_action('init', 'clients_register');  

// meta box added for custom fields box.
add_action("admin_init", "clients_meta_box");  

// handle the saving of the custom fields.
add_action( 'save_post', 'clients_meta_box_save' );
  
function clients_register() {  
	$labels = array(
		'name'               => _x( 'Clients', 'post type general name' ),
		'singular_name'      => _x( 'Client', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'client' ),
		'add_new_item'       => __( 'Add New Client' ),
		'edit_item'          => __( 'Edit Client' ),
		'new_item'           => __( 'New Client' ),
		'all_items'          => __( 'All Client' ),
		'view_item'          => __( 'View Client' ),
		'search_items'       => __( 'Search Clients' ),
		'not_found'          => __( 'No Clients found' ),
		'not_found_in_trash' => __( 'No Clients found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Clients'
	);

    $args = array(  
        'labels' => __($labels),  
		'description', 'Clients',
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
		'supports' => array('title', 'page-attributes', 'thumbnail')
       );  
  
    register_post_type( 'clients' , $args );  
} 

function clients_meta_box(){
    add_meta_box("lshift_admin", "Client categories", "clients_intro", "clients", "normal", "high");    
}     
  
function clients_meta_box_save( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( !wp_verify_nonce( $_POST['clients_meta_box_nonce'], plugin_basename( __FILE__ ) ) ) {
		return;
	}
	
	if ( 'clients' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ) { 
			return;
		}
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	
	$project = $_POST['project'];
	$sector = $_POST['sector'];
	update_post_meta( $post_id, '_project', $project );
	update_post_meta( $post_id, '_sector', $sector );
}
  
function clients_intro(){    
        global $post;    
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return $post_id;
		}
		
        $custom = get_post_custom($post->ID);    
        $project = $custom["_project"][0];
        $sector = $custom["_sector"][0];
		wp_nonce_field( plugin_basename( __FILE__ ), 'clients_meta_box_nonce' );
?>    
    <p><label>Project</label><input type="text" id="project" name="project" value="<?php echo $project ?>" /></p>
	<p><label>Sector</label><input type="text" id="sector" name="sector" value="<?php echo $sector ?>" /></p>

<?php    
}    

function add_new_clients_column($clients_columns) {
  $clients_columns['menu_order'] = "Order";
  return $clients_columns;
}

add_action('manage_edit-clients_columns', 'add_new_clients_column');

add_action('manage_clients_posts_custom_column','show_order_column');

add_filter('manage_edit-clients_sortable_columns','order_column_register_sortable');
?>
