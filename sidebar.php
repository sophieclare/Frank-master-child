<?php
/**
 * @package WordPress
 * @subpackage LShift_Theme
 */
?>
<!-- begin sidebar -->
<div class="column">
		<?php 	/* Widgetized sidebar, if you have the plugin installed. */
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

			<?php include (TEMPLATEPATH . '/searchform.php'); ?>

            <h4>Categories</h4>
			<ul class="navV">
			<?php wp_list_categories(array('title_li' => '', 'exclude' => '2')); ?>
            </ul>

			<?php if ( is_404() || is_category() || is_day() || is_month() ||
						is_year() || is_search() || is_paged() ) {
			?> 

			<?php /* If this is a 404 page */ if (is_404()) { ?>
			<?php /* If this is a category archive */ } elseif (is_category()) { ?>
			<p>You are currently browsing the archives for the <?php single_cat_title(''); ?> category.</p>

			<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
			<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
			for the day <?php the_time('l, F jS, Y'); ?>.</p>

			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
			for <?php the_time('F, Y'); ?>.</p>

			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
			for the year <?php the_time('Y'); ?>.</p>

			<?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
			<p>You have searched the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
			for <strong>'<?php the_search_query(); ?>'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>

			<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<p>You are currently browsing the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives.</p>

			<?php } ?>

			<?php }?>


			<?php endif; ?>
            
            <h4>Feeds</h4>
			<ul class="navV">
                    <li><a href="<?php bloginfo('rss2_url'); ?>" class="feed">Entries (RSS)</a></li>
                    <li><a href="<?php bloginfo('comments_rss2_url'); ?>" class="feed">Comments (RSS)</a></li>
            </ul>

			<?php if ( is_singular() ) { /* only show archives lists on non-single post pages */ } else { ?> 
			<h4>Archives</h4>
				<ul class="navV">
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			<?php }?>



</div>
<!-- end sidebar -->
