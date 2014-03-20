<?php
/**
 * @package WordPress
 * @subpackage LShift_Theme
 */
?>
<!-- begin sidebar -->
<div id="sidebar" class="column three">
<h3>More in this section:</h3>
<?php

$parent = array_reverse(get_post_ancestors($post->ID));
$first_parent = get_page($parent[0]);
flexipages('show_subpages=1&sort_column=menu_order,name&hierarchy=1&child_of='.$first_parent->ID); ?>
		<?php 	/* Widgetized sidebar, if you have the plugin installed. */
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('page-sidebar') ) : ?>
			<?php // include (TEMPLATEPATH . '/searchform.php'); ?>
			<?php endif ?>
</div>
<!-- end sidebar -->
