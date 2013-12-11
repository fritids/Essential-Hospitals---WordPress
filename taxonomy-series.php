<?php get_header(); ?>

<?php $speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div id="featured-img" class="archive series">
	<div class="container">
		<div id="featured-intro">
			<h3 class="tag">Stream Archive: <?php single_tag_title(); ?></h3>
		</div>
	</div>
</div>
<div id="postFeatured">

    <div class ="grayblock"></div>

	<div class="container twelve columns content">


		<div id="contentWrap" class="action">
			<div class="gutter">
				<div class="container">
					<div id="contentPrimary">
						<div class="graybar"></div>
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