<?php
/**
 * @package WordPress
 * @subpackage lshift
 */

require_once('homepage-functions.php');

 require_once('casestudy-type.php');
 require_once('clients-type.php');
 require_once('people-type.php');

// tag hooks
add_action('admin_head', 'add_css_to_admin');
add_action( 'init', 'init_theme' );
add_action('pre_get_posts', 'tags_support_query');
add_action('after_setup_theme', 'add_image_sizes');

// this filter runs whenever WordPress requests a post permalink, i.e. get_permalink(), etc.
// if the post type is a case study, alter the permalink path.
// We do this because WP doesn't normally support custom post types as children of a different post type.
add_filter( 'post_type_link', 'lshift_filter_post_type_link', 1, 4 );

global $casestudyParentId;
global $newsCategoryId;
global $featuredPracticeParentId;

$newsCategoryId = 186; // TODO: get rid of the magic number at some point

$myquery = new WP_Query( "post_type=page&meta_key=is_casestudy_parent&meta_value=1" );
if($myquery->have_posts())
{
	while($myquery->have_posts()) {
		$myquery->the_post();
		$caseStudyParentId = get_the_ID();
	}
}	

$myquery = new WP_Query( "post_type=page&meta_key=is_featured_practice_parent&meta_value=1" );
if($myquery->have_posts())
{
	while($myquery->have_posts()) {
		$myquery->the_post();
		$featuredPracticeParentId = get_the_ID();
	}
}	

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'id' => 'post-sidebar',
		'name' => 'Post Sidebar',
		'before_widget' => '',
		'after_widget' => '</ul>',
		'before_title' => '<h4>',
		'after_title' => '</h4><ul class="navV"',
	)); 

	register_sidebar( array(
			'id' => 'page-sidebar',
			'name' => __( 'Page Sidebar' ),
			'description' => __( 'Sidebar for all user created pages.' ),
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget' => '</li>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>'
	) );
}
	
function add_css_to_admin() {
   echo '<style type="text/css">
			#lshift_admin p label { width: 80px; !important; display:inline-block; text-align:right;padding-right:10px;}
			#lshift_admin p span input { width:275px; margin-right:10px; border:1px solid #000 }
         </style>';
}

function add_image_sizes() {
	add_theme_support( 'post-thumbnails', array( 'post', 'page', 'casestudy','people','clients' ) );

	set_post_thumbnail_size( 110, 100, true ); // Normal post thumbnails  
	add_image_size( 'banner', 230, 210, true );
	add_image_size( 'people', 100, 100, true );
	add_image_size( 'clients', 110, 110, true );

    function my_image_sizes($sizes){
        $custom_sizes = array(
            'banner' => 'Page Banner',
            'people' => 'Profile Pic',
            'clients' => 'Client Logo'
        );
		
        return array_merge( $sizes, $custom_sizes );
    }
	
	add_filter('image_size_names_choose', 'my_image_sizes');
}
	
function init_theme() {
	add_post_type_support( 'page', 'excerpt' );
	register_taxonomy_for_object_type('post_tag', 'page');
	register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
}	
                         
function get_first_paragraph(){
	global $post;
	                                                 
	$str = wpautop( get_the_content() );
	$str = substr( $str, 0, strpos( $str, '</p>' ) + 4 );
	$str = strip_tags($str, '');
 
	return '<p>' . $str . '</p>';
}

// ensure all tags are included in queries
function tags_support_query($wp_query) {
	if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}

function lshift_filter_post_type_link( $post_link, $post, $leavename, $sample ) {
    if ($post->post_type == 'casestudy')
	{
		$post_link = '/services/case-studies/'.$post->post_name;
	}
    return $post_link;
}


// apply additional logic upon saving.  This is here has it relates to multiple CPTs
add_filter( 'wp_insert_post_data' , 'autogenerate_fields' , 99, 2 );

function autogenerate_fields($data, $postarr){
	
	$postType = get_post_type();
	
	if ($postType == 'casestudy')
	{
		global $caseStudyParentId;
		$data["post_parent"] = $caseStudyParentId;
		$postarr["parent_id"] = $caseStudyParentId;
		$postarr["post_parent"] = $caseStudyParentId;
	}
	
	if ($postType == 'people' || ($data['post_type'] == 'people' && isset($data['post_type'])))
	{
		$name = get_post_meta($postarr['ID'],'_name',true);
		$position = get_post_meta($postarr['ID'], '_position' , true);
		$post_title = $name . ' - ' . $position;
		$post_slug = sanitize_title_with_dashes ($post_title,'','save');
		$post_slugsan = sanitize_title($post_slug);

		$data['post_title'] = $post_title;
		$data['post_name'] = $post_slugsan;
	}

    return $data;
}

?>