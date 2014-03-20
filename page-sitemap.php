<?php
/**
 * Template Name: Sitemap
 * @package WordPress
 * @subpackage LShift_Theme
 */
get_header();
?>


<div class="page">
    <div class="column colspan3">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
			<h1><?php the_title(); ?></h1>
				<div class="entry">
					<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
					<div class="nestedColumnContainer sitemap">
						<?php flexipages('show_subpages=1&sort_column=menu_order,name&hierarchy=1&child_of=0'); ?>
					</div>

				</div>
			</div>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
&nbsp;
	</div>
<?php get_sidebar('page'); ?>
</div>
<?php get_footer(); ?>
