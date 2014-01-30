<?php get_header(); ?>

<?php $speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div id="featured-img" class="archive tag">
	<div class="container">
		<div id="featured-intro">
			<h3 class="tag"><?php echo get_post_type(); ?> <?php post_type_archive_title(); ?></h3>
		</div>
	</div>
</div>
<div id="postFeatured">
	<div class="container fullborder">
 		<div class="eightteen columns filters">

 		</div>
 	</div>
    <div class ="grayblock"></div>

	<div class="container twelve columns content">


		<div id="contentWrap" class="action archivecss">
			<div class="gutter">
				<div class="container">
					<?php
						if(has_nav_menu('primary-menu')){
							$defaults = array(
								'theme_location'  => 'primary-menu',
								'menu'            => 'primary-menu',
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
								'depth'           => 2,
								'walker'          => ''
							); wp_nav_menu( $defaults );
						}
					?>
					<div id="breadcrumbs">
						<ul>
							<li><a href="<?php echo home_url(); ?>">Home</a>
								<?php
								$defaults = array(
								'theme_location'  => 'primary-menu',
								'menu'            => 'primary-menu',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'menu',
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
							); wp_nav_menu( $defaults ); ?>
							</li>
						</ul>
					</div>
					<div id="contentPrimary">
						<div class="graybar"></div>
						<div class="gutter">
							<?php get_template_part( 'partial/template', 'archive' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>


	</div><!-- End of Content -->
	<div id="prev" title="Show previous"> </div>
	<div id="next" title="Show more Articles"> </div>

	<a id="prevbtn" title="Show previous">  </a>
	<a id="nextbtn" title="Show more">  </a>
</div>

<?php get_footer(); ?>