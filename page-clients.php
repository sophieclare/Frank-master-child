<?php
/**
 * Template Name: Client List
 * @package WordPress
 * @subpackage LShift_Theme
 *
*/
 
get_header();
?>


<div class="page">
    <div class="column colspan3">
		<h1><?php the_title(); ?></h1>
		<p>These are just a few of our past and current clients:</p>
		<?php query_posts( array('post_type' => 'clients', 'orderby' => 'menu_order title', 'order' => 'asc', 'posts_per_page' => 30)); ?>
		<div class="nestedColumnContainer">
						<ol class="clients">
				<?php if (have_posts()) : while (have_posts()) : the_post(); 
					$id = get_the_ID();
					$project = get_post_meta( $id, '_project', true );
					$sector = get_post_meta( $id, '_sector', true );
				// 
				?>
					<li class="column" style="float: left;">
						<dl>
							<dt class="clienthead">Client:</dt>
								<dd class="clienthead">
									<h3><?php the_title()?></h3>
									<?php echo get_the_post_thumbnail($id, 'full'); ?></dd>
									<?php $related_links = get_related_links(); ?>

								<?php if ($related_links) {?>

								<?php foreach ($related_links as $link): ?>
								
							<dt>Link:</dt>
								<dd><a href="<?php echo $link['url']; ?>" target="<?php echo $link['target']?>"><?php echo $link['title']; if (strpos($link['url'], 'case-studies') !== false) { echo ' case study'; }?></a></dd>
									
								<?php endforeach; ?>
								<?php } ?>
							<dt>Project:</dt>
								<dd><?php echo $project; ?></dd>
							<dt>Sector:</dt>
								<dd><?php echo $sector; ?></dd>
						</dl>
					</li>

				<?php endwhile; ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			</ol>
		</div>
	</div>
	<?php get_sidebar('page'); ?>
</div>
<?php get_footer(); ?>
