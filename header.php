<?php
/**
 * @package Frank
 */
?>
<!DOCTYPE html>
<!--[if IE 7 | IE 8]>
<html class="ie" lang="en-US">
<![endif]-->
<!--[if (gte IE 9) | !(IE)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

	<title>
		<?php
		wp_title( '&mdash;', true, 'right' );
		bloginfo( 'name' );
		?>
	</title>

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
</head>
<body id="page" <?php body_class(); ?>>
	<!--[if lt IE 9]>
		<div class="chromeframe">Your browser is out of date. Please <a href="http://browsehappy.com/">upgrade your browser </a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a>.</div>
	<![endif]-->
<div class="container">
	<header id="page-header" class="row">
		<hgroup id="site-title-description">
			<h1 id="site-title"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
      
		<nav id="site-nav">         
			<?php if ( !dynamic_sidebar( 'Navigation' ) ) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'frank_primary_navigation', 'container' => false, 'depth'=>1 ) ); ?>
			<?php endif; ?>
      <!--alternative header code:-->
			<!--<?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'depth'=>1 ) ); ?>  -->
		</nav>
    
		</hgroup>


		<?php
        $post_thumbnail_id = get_post_thumbnail_id();
        $header_image = get_header_image();
        if (empty($post_thumbnail_id)) {
        	$bg = "";
        }
        else
        {
        	$feature_image =  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'full' );    
          $feature_image_url =  $feature_image[0]  ;
					if ( function_exists( 'get_custom_header' ) ) {
						$header_image_width  = get_custom_header()->width;
						$header_image_height = get_custom_header()->height;
					} else {
						$header_image_width  = HEADER_IMAGE_WIDTH;
						$header_image_height = HEADER_IMAGE_HEIGHT;
					}      
					?>
          <div id="banner">
				<img src="<?php echo $feature_image_url ?>" width="<?php echo $header_image_width; ?>" height="<?php echo $header_image_height; ?>" alt="" />        
		         </div>
        	<?php  
          
        }
					?>

                          
	</header>
