<?php get_header(); ?>
<?php
	$queried_object = get_queried_object();
	$term_id = $queried_object->term_id;
	$term_slug = $queried_object->slug;
    $term_meta = get_option( "taxonomy_term_$term_id" );
    $postType = $term_meta['section'];

    if($postType == 'policy'){
		$bannerImg  = get_field('small_banner', 62);
	}elseif($postType == 'quality'){
		$bannerImg  = get_field('small_banner', 64);
	}elseif($postType == 'institute'){
		$bannerImg  = get_field('small_banner', 621);
	}else{
		$bannerImg  = '';
	}




?>
<?php $speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div id="featured-img-small" class="archive series <?php echo $term_meta['section']; ?>" style="background-image:url(<?php echo $bannerImg; ?>);">
	<div class="container">
		<div id="featured-intro">
			<h3 class="tag"> <?php single_tag_title(); ?></h3>
		</div>
	</div>
</div>
<div id="postFeatured">

    <div class ="grayblock"></div>

	<div class="container twelve columns content">


		<div id="contentWrap" class="action <?php echo $term_meta['section']; ?>">
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

					<div id="contentPrimary" class="stream-<?php echo $term_meta['section']; ?>">
						<div class="graybar"></div>
						<div class="graybarX"></div>
						<div class="gutter">
						<?php
							$cUser = wp_get_current_user();
							$cUserMeta = get_user_meta($cUser->ID, 'aeh_member_type', true);
							$term_slug = get_queried_object()->slug;
							if($term_slug == 'action-alerts' || $term_slug == 'action-updates'){
								if($cUserMeta == 'hospital'){
									get_template_part( 'partial/template', 'tagloop' );
								}else{ ?>
									<h1>Restricted Content</h1>
									<p><?php single_tag_title(); ?> entries are restricted to Association Members only.</p>
								<?php }
							}else{
								get_template_part( 'partial/template', 'tagloop' );
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>


	</div><!-- End of Content -->

	<?php
	$cUser = wp_get_current_user();
	$cUserMeta = get_user_meta($cUser->ID, 'aeh_member_type', true);
	$term_slug = get_queried_object()->slug;
	if($term_slug == 'action-alerts' || $term_slug == 'action-updates'){
		if($cUserMeta == 'hospital'){ ?>
			<div id="prev" title="Show previous"> </div>
			<div id="next" title="Show more Articles"> </div>

			<a id="prevbtn" title="Show previous">  </a>
			<a id="nextbtn" title="Show more">  </a>
		<?php }
	}else{ ?>
		<div id="prev" title="Show previous"> </div>
		<div id="next" title="Show more Articles"> </div>

		<a id="prevbtn" title="Show previous">  </a>
		<a id="nextbtn" title="Show more">  </a>
	<?php } ?>



</div>

<?php get_footer(); ?>