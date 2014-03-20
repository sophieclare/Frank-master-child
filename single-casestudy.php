<?php
/**
 * @package WordPress
 * @subpackage LShift_Theme
 */
get_header();
?>


<div class="page">
    <div class="column colspan3">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<h1><?php echo get_post_meta( get_the_ID(), '_headline', true )?></h1>
				<div class="entry">
					<div xmlns="" class="standFirst" style="background-image: url(/img/etc/mikes.jpg)">
						<p><?php the_excerpt()?></p>
					</div>
					<div xmlns="" class="nestedColumnContainer">
						<div class="column">
							<?php the_post_thumbnail();?>
							<?php echo wpautop(get_post_meta( get_the_ID(), '_intro', true )); ?>
						</div>
						<div class="column">
							<?php the_content(); ?>
							<?php $related_links = get_related_links(); ?>
							<?php if ($related_links) {?>
								<?php foreach ($related_links as $link): ?>
							
								<p><a href="<?php echo $link['url']; ?>" class="external" target="<?php echo $link['target'];?>"><?php echo $link['title']; ?></a></p>
								
								<?php endforeach; ?>
							<?php } ?>
						</div>
						<div class="column">
							<?php the_tags('<h4>Technologies Used</h4><ul class="technologies"><li>','</li><li>','</li></ul>') ?>
						</div>
						<div class="column"></div>
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
