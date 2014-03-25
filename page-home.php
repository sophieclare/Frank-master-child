<?php
/**
 * Template Name: Homepage
 * @package WordPress
 * @subpackage LShift_Theme
 */
get_header();
?>

    
<div class="page">

<section id="highlights">
      				               
    <div id="features" class="row">
      <div class="six columns">		
      
  				<?php
  				$featured_practice_id = get_post_meta( get_the_ID(), '_featured_practice', true );
  				$featured_practice = get_post($featured_practice_id);
  				$featured_practice_link = get_permalink($featured_practice->ID);
  				$featured_practice_excerpt = get_post_meta( get_the_ID(), '_featured_practice_excerpt', true );
  				?> 
          
					<h3><?php echo $featured_practice->post_title;?></h3>	                                                                      
					<a href="<?php echo $featured_practice_link;?>"><?php echo get_the_post_thumbnail($featured_practice->ID, 'full')?></a>
					<?php echo $featured_practice_excerpt;?>    						
					<p>More about <a href="<?php echo $featured_practice_link; ?>">these services</a>.</p>
			</div>        
        
      <div class="three columns">	                   
					<h3><a href="/experience/clients">Some of our clients</a></h3>

					<a href="/experience/clients"><img src="/img/various/clients-home.png" width="210" height="185" alt="" /></a>          
			</div>        
        
      <div class="three columns">				
  				<?php
  				$featured_casestudy_id = get_post_meta( get_the_ID(), '_featured_casestudy', true );
  				$featured_casestudy = get_post($featured_casestudy_id);
  				?>
  				
    			<h3>A case study <a href="/services/case-studies">[More]</a></h3>
  				<h4><?php echo $featured_casestudy->post_title;?></h4>
  				<p><?php echo $featured_casestudy->post_excerpt;?></p> 
  				<p>Full <a href="<?php echo get_permalink($featured_casestudy->ID);?>"><?php echo $featured_casestudy->post_title;?> case study</a></p>
				
			 </div>	
       	
			</div>
			                                      
			<div class="feature row">
				<div class="six columns">
					<div class="blog">                              
					<h3><a href="/blog/">Blog latest</a></h3>
						<ol xmlns:rss1="http://purl.org/rss/1.0/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/" class="feed">
							<?php $recent = new WP_Query("cat=-2&showposts=2"); while($recent->have_posts()) : $recent->the_post();?>
							<li><h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
							<?php echo get_first_paragraph() ?>
							<div class="meta">
								<p><?php the_author() ?> | <?php echo get_the_date('d M Y') ?></p>
							</div>
							</li>
							<?php endwhile; ?>

						</ol>    
					</div>
				</div>
        
			<div class="six columns">

				<div class="homeModule">
					<div class="news">                                             
					<h3>News Latest <a href="about/news/">[Archive]</a></h3>
						<ol xmlns:rss1="http://purl.org/rss/1.0/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/" class="feed">			
							<?php 
							global $newsCategoryId;
							$recent = new WP_Query("category_name=News&showposts=3"); while($recent->have_posts()) : $recent->the_post();?>
							<li><h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
							<?php echo get_first_paragraph() ?></li>
							<?php endwhile; ?>
						</ol>
					</div>	
				</div>			
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
