<?php
/**
 * Template Name: People List
 * @package WordPress
 * @subpackage LShift_Theme
 *
*/
 
get_header();
?>


<div class="page">
    <div class="column colspan3 people">
		<h1><?php the_title(); ?></h1>
		<?php query_posts( array('post_type' => 'people', 'orderby' => 'menu_order', 'order' => 'asc', 'posts_per_page' => -1)); ?>
		<div class="nestedColumnContainer">
			<div id="people">
				<?php $colIndex = 0;
				if (have_posts()) : while (have_posts()) : the_post(); 
				$colIndex = $colIndex + 1;
				if ($colIndex == 1)
				{
					echo '<div class="nestedColumnContainer">';
				}
				$id = get_the_ID();
				$name = get_post_meta( $id, '_name', true );
				$elementId = str_replace(' ', '', $name);
				$bio = get_post_meta( $id, '_bio', true );
				$position = get_post_meta( $id, '_position', true );
				
				if (!empty($position))
				{
					$position = ' - ' . $position;
				}
				?>
				<div class="person column vcard" style="float: left; overflow:">
				<h4 class="fn"><a id="<?php echo $elementId ?>" name="<?php echo $elementId ?>"></a><?php echo $name; ?><span class="title role"><?php echo $position; ?></span></h4>
				<p><?php echo get_the_post_thumbnail($id, 'full',  array('class' => 'photo')) ?><?php echo $bio;?></p></div>
				<?php
				if ($colIndex == 3)
				{
					echo "</div>";
					$colIndex = 0;
				}?>
				<?php endwhile; ?>
				<?php
				if ($colIndex !=0)
				{
					echo "</div>";
				}?>

				<?php endif; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	</div>
	<?php get_sidebar('page'); ?>
</div>
<?php get_footer(); ?>
