<?php

// add the featured case study when on homepage
add_action( 'add_meta_boxes', 'lshift_add_featuredcasestudy_box' );

// handle the saving of the stuffs
add_action( 'save_post', 'lshift_save_all_the_things' );

function lshift_add_featuredcasestudy_box() {
	global $post;
	if ( 'page-home.php' == get_post_meta( $post->ID, '_wp_page_template', true ) ) {

		add_meta_box( 
			'lshift_bluebox',
			__( 'The blue box', 'lshift_bluebox' ),
			'lshift_blue_box',
			'page',
			'normal',
			'high'
		);
		
		add_meta_box( 
			'lshift_articles',
			__( 'Featured Articles', 'lshift_articles' ),
			'lshift_featuredcasestudy_box',
			'page',
			'normal',
			'high'
		);
	}
}

function lshift_blue_box( $post ) {

	$custom = get_post_custom($post->ID);    

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'bluebox_noncename');

	for ($i = 1; $i <= 3; $i++) {
		$headline = $custom['_headline'.$i][0];
		$headline_link = $custom['_headline_link'.$i][0];
		$subheadline = $custom['_subheadline'.$i][0];
		$subheadline_link = $custom['_subheadline_link'.$i][0];
	?>
	<h4>Featured Box <?php echo $i ?></h4>
	<p>	
		<label>Headline:</label><span><input type="text" name="headline<?php echo $i ?>" id="headline<?php echo $i ?>" value="<?php echo $headline ?>" /></span>
		<label>Link Url:</label><span><input type="text" name="headline_link<?php echo $i ?>" id="headline_link<?php echo $i ?>" value="<?php echo $headline_link ?>" /></span>
	</p>
	<p>
		<label>Subheading:</label><span><input type="text" name="subheadline<?php echo $i ?>" id="subheadline<?php echo $i ?>" value="<?php echo $subheadline ?>" /></span>
		<label>Link Url:</label><span><input type="text" name="subheadline_link<?php echo $i ?>" id="subheadline_link<?php echo $i ?>" value="<?php echo $subheadline_link ?>" /></span>
	</p>
	<?php
	}
}

function lshift_featuredcasestudy_box( $post ) {

	$custom = get_post_custom($post->ID);    
	$featured_casestudy = $custom["_featured_casestudy"][0];
	$featured_practice = $custom["_featured_practice"][0];
	$practice_excerpt = $custom["_featured_practice_excerpt"][0];
	
	global $caseStudyParentId;
	global $featuredPracticeParentId;
	
     $casestudy_dropdown_args = array(
        'post_type'     => 'casestudy',
		'depth'			=> 1,
		'id' 			=> 'casestudy_id',
		'name'			=> 'casestudy_id',
		'child_of'		=> $caseStudyParentId,
		'selected'		=> $featured_casestudy
    );

	$practice_dropdown_args = array(
        'post_type'     => 'page',
		'depth'			=> 0,
		'id' 			=> 'practice_id',
		'name'			=> 'practice_id',
		'child_of'		=> $featuredPracticeParentId,
		'selected'		=> $featured_practice
    );

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'featuredarticles_noncename');
?>
	<p><label>Case Study:</label><span> <?php wp_dropdown_pages($casestudy_dropdown_args); ?></span></p>
	<p><label>Practice:</label><span> <?php wp_dropdown_pages($practice_dropdown_args);?></span></p>
	<p><label>Practice Description:</label><span> <?php wp_editor($practice_excerpt, 'practice_excerpt');?></span></p>
	<?php
}

function lshift_save_all_the_things( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( !wp_verify_nonce( $_POST['bluebox_noncename'], plugin_basename( __FILE__ ) ) ) {
		return;
	}

	if ( !current_user_can( 'edit_page', $post_id ) ) { 
		return;
	}
		
	global $post;
	if ( 'page-home.php' == get_post_meta( $post->ID, '_wp_page_template', true ) ) {
		for ($i = 1; $i <= 3; $i++) {
			$headline = $_POST['headline'.$i];
			$headline_link = $_POST['headline_link'.$i];
			$subheadline = $_POST['subheadline'.$i];
			$subheadline_link = $_POST['subheadline_link'.$i];
		
			update_post_meta( $post_id, '_headline'.$i, $headline );
			update_post_meta( $post_id, '_headline_link'.$i, $headline_link );
			update_post_meta( $post_id, '_subheadline'.$i, $subheadline );
			update_post_meta( $post_id, '_subheadline_link'.$i, $subheadline_link );
		}

		$casestudy_id = $_POST['casestudy_id'];
		update_post_meta( $post_id, '_featured_casestudy', $casestudy_id );
		$practice_id = $_POST['practice_id'];
		update_post_meta( $post_id, '_featured_practice', $practice_id );
		$practice_excerpt = $_POST['practice_excerpt'];
		update_post_meta( $post_id, '_featured_practice_excerpt', $practice_excerpt );
	}
}


?>