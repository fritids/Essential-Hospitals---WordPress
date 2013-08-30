<?php 
	get_header();
?>
<?php $speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div id="featured-img" class="action" style="background-image:url(<?php echo $speakerIMG; ?>);">
	<div class="container">
		<div id="featured-intro">
			<?php while ( have_posts() ) : the_post(); ?>
				<h3><?php the_field('bannerTitle'); ?></h3>
				<h4><?php the_field('bannerDescription'); ?></h4>
			<?php endwhile; // end of the loop. ?>
		</div>
	</div>
</div>
<div id="contentWrap" class="action">
	<div class="gutter">
		<div class="container">
			<?php
				if(has_nav_menu('action-nav')){
					$defaults = array(
						'theme_location'  => 'action-nav',
						'menu'            => 'action-nav',
						'container'       => 'div',
						'container_class' => '',
						'container_id'    => 'pageNav',
						'menu_class'      => 'about',
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
					<ul>
						<li><a>Health Care Reform and ACA</a></li>
						<li><a>Medicaid and DSH</a></li>
						<li><a>Advocacy Agenda</a></li>
						<li><a>Integrated Care</a></li>
						<li><a>Disaster Preparedness</a></li>
						<li><a>Accountable Care Organizations</a></li>
						<li class="last"><a>Show All Topics</a></li>
					</ul>
				</div>
			</div>
			<div id="contentSecondary">
				<div class="gutter">
					<div id="postBox">
					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	get_footer();
?>