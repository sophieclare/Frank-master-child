<?php
/**
 * Template Name: News
 * @package WordPress
 * @subpackage LShift_Theme
 *
*/
 
get_header();
?>


<div class="page">
    <div class="column colspan3">
		<h1 <?php echo $first ?>><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php 
		global $newsCategoryId;
		if ( get_query_var('paged') ) { 
			$paged = get_query_var('paged');
		} 
		else if ( get_query_var('page') ) {
			$paged = get_query_var('page'); 
		} 
		else {
			$paged = 1; 
		}
		query_posts('category_name=News&paged='.$paged); ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="blog entry" id="post-<?php the_ID(); ?>">
						<div>
						<h2 <?php echo $first ?>><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<?php the_content(__('Read more...')); ?>

						<?php $related_links = get_related_links(); ?>
						<?php if ($related_links) {?>
						<div class="seeAlso">
							<h6>See Also:</h6>
							<div class="nestedColumnContainer">
								<ul>
									<?php foreach ($related_links as $link): ?>
								
									<li class="column">
										<a href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a>
									</li>
									
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
						<?php } ?>

						</div>
					<div class="meta">
						<div class="nestedColumnContainer">	
							<dl class="column"> 
								<dt>by</dt>
								<dd><?php the_author() ?></dd>
						   </dl>
							<dl class="column"> 
								<dt>on</dt>                        
								<dd><?php the_date('d/m/y'); ?> </dd>
							</dl>
							 <a href="<?php comments_link(); ?>" title="Comment on <?php the_title(); ?>">
								 <dl class="commentsLink column"> 
									<dt>Comments</dt>
									<dd><?php comments_number('[+]', '1', '%'); ?></dd>
								</dl>
							</a>
						</div>
					</div>
				</div>
       
    <?php $first=""; ?>
    <?php endwhile; else: ?>
    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
    
    <p><?php posts_nav_link('&nbsp;', __('&laquo; Newer Posts'), __('Older Posts &raquo;')); ?>
    </p>
    
   	</div>

<?php wp_reset_query();
	get_sidebar('page'); ?>
</div>
<?php get_footer(); ?>
