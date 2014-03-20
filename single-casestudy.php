<?php
/**
 * @package WordPress
 * @subpackage LShift_Theme
 */
get_header();
?>

<div id="content" class="page">
  <div class="row">

    <main id="content-primary" class="column six" role="main">

      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article id="case-study">
        <h1><?php echo get_post_meta( get_the_ID(), '_headline', true )?></h1>

        <?php the_excerpt()?>

        <?php the_post_thumbnail();?>
        <?php echo wpautop(get_post_meta( get_the_ID(), '_intro', true )); ?>

        <?php the_content(); ?>

        <?php $related_links = get_related_links(); ?>
        <?php if ($related_links) {?>
          <?php foreach ($related_links as $link): ?>

          <p><a href="<?php echo $link['url']; ?>" class="external" target="<?php echo $link['target'];?>"><?php echo $link['title']; ?></a></p>

          <?php endforeach; ?>
        <?php } ?>

        <?php the_tags('<h4>Technologies Used</h4><ul class="technologies"><li>','</li><li>','</li></ul>') ?>

      </article>
      <?php endwhile; endif; ?>
      <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

    </main>

    <?php get_sidebar('page'); ?>
    <!-- end sidebar -->

  </div>

</div>
<?php get_footer(); ?>