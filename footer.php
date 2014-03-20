<?php
/**
 * @package Frank
 */
?>
</div>
<?php if ( is_active_sidebar( 'widget-footer' ) ) : ?>
<div id="page-bottom">
	<footer id="page-footer" class="container" role="contentinfo">
		<div class="row">
		<?php if ( ! dynamic_sidebar( 'Footer' ) ) : ?>
             Footer
		<?php endif; ?>
		</div>
	</footer>
</div>
<?php endif; ?>
<div id="page-bottom">
	<footer id="page-footer" class="container" role="contentinfo">
		<div class="row">
		<?php if ( ! dynamic_sidebar( 'Footer' ) ) : ?>
        <ul>                                            
          <li><a href="/news">News</a></li>
          <li><a href="/about">About us</a></li>
          <li><a href="/contact-us">Contact us</a></li>   
          <li><a href="/find-us">Find us</a></li>     
          <li><a href="/people">Who we are</a></li>  
          <li><a href="/sitemap">Sitemap</a></li>
        </ul>
         
<div class="foot">
	<div class="vcard"><span class="copy"> 2000-14 </span><span class="fn org">LShift Ltd</span>, 
        <span class="adr"><abbr class="geo" title="51.527022; -0.081207"><span class="street-address">1st Floor, Hoxton Point, 6 Rufus Street, </span><span class="locality">London</span>, 
        <span class="postal-code">N1 6PE</span>, 
        <span class="country-name">UK</span></abbr></span><span class="tel">+44 (0)20 7729 7060</span>
        <span class="contact">&nbsp;&nbsp;<a  href="/about/contact-us">Contact us</a></span>
</div>

             
		<?php endif; ?>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>