<?php
/**
 * Template Name: People List
 * @package WordPress
 * @subpackage LShift_Theme
 *
*/

get_header();
?>


<div id="content" class="page">
  <div class="row">

    <main id="content-primary" class="column six" role="main">

      <section id="people">

        <h1><?php the_title(); ?></h1>

        <?php query_posts( array('post_type' => 'people', 'orderby' => 'menu_order', 'order' => 'asc', 'posts_per_page' => -1)); ?>

        <?php $colIndex = 0;
        if (have_posts()) : while (have_posts()) : the_post();
          $colIndex = $colIndex + 1;
          $id = get_the_ID();
          $name = get_post_meta( $id, '_name', true );
          $elementId = str_replace(' ', '', $name);
          $bio = get_post_meta( $id, '_bio', true );
          $position = get_post_meta( $id, '_position', true );

          if (!empty($position)) {
            $position = ' - ' . $position;
          }
        ?>

        <article class="person vcard">
          <h2 class="fn">
            <a id="<?php echo $elementId ?>" name="<?php echo $elementId ?>"></a>
            <?php echo $name; ?><span class="title role"><?php echo $position; ?></span>
          </h2>

          <div class="person-photo"><?php echo get_the_post_thumbnail($id, 'full',  array('class' => 'photo')) ?></div>

          <div><p><?php echo $bio;?></p></div>
        </article>

        <?php
        if ($colIndex == 3)
        {
          //echo "</article>";
          $colIndex = 0;
        }?>
        <?php endwhile; ?>
        <?php
        if ($colIndex !=0)
        {
          //echo "</div>";
        }?>

        <?php endif; ?>
        <?php wp_reset_query(); ?>

      </section>

    </main>


    <?php get_sidebar('page'); ?>
    <!-- end sidebar -->

  </div>



</div>
<?php get_footer(); ?>
