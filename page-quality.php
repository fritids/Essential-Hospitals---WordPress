<?php 
	get_header();
?>
<?php $speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div id="featured-img" class="quality" style="background-image:url(<?php echo $speakerIMG; ?>);">
	<div class="container">
		<div id="featured-intro">
			<?php while ( have_posts() ) : the_post(); ?>
				<h3><?php the_field('bannerTitle'); ?></h3>
				<h4><?php the_field('bannerDescription'); ?></h4>
			<?php endwhile; // end of the loop. ?>
		</div>
	</div>
</div>
<div id="contentWrap" class="quality">
	<div id="prev" title="Show previous"> </div>
	<div id="next" title="Show more Articles"> </div> 

	<a id="prevbtn" title="Show previous">  </a>
	<a id="nextbtn" title="Show more">  </a> 
	<div class="gutter">
		<div class="container">
			<?php
				if(has_nav_menu('quality-nav')){
					$defaults = array(
						'theme_location'  => 'quality-nav',
						'menu'            => 'quality-nav',
						'container'       => 'div',
						'container_class' => '',
						'container_id'    => 'pageNav',
						'menu_class'      => 'quality',
						'menu_id'         => '',
						'echo'            => true,
						'fallback_cb'     => 'wp_page_menu',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 0,
						'walker'          => ''
					);
					wp_nav_menu( $defaults ); 	
				}
			?>
			<div id="contentPrimary">
				<div class="gutter">
					<span class="filterby">Filter By >></span>
					<ul id="pagefilter" data-query="quality">
						<li><a>Specialty Care</a></li>
						<li><a>Population Health</a></li>
						<li><a>Patient-Centered Care</a></li>
						<li><a>Patient Safety</a></li>
						<li><a>Health Care Disparities</a></li>
						<li><a>Cost + Resource Efficiency</a></li>
						<li><a>community Outreach</a></li>
						<li class="last"><a>Show All Topics</a></li>
					</ul>
				</div>
			</div>
			<div id="contentSecondary">
				<div class="gutter">
					<?php get_template_part( 'partial/template', 'qualityloop' ); ?> 
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	get_footer();
?>