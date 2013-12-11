<?php get_header(); ?>

<?php $speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div id="featured-img" class="archive series jobs">
	<div class="container">
		<div id="featured-intro">
			<h3 class="tag">Stream Archive: <?php single_tag_title(); ?></h3>
		</div>
	</div>
</div>
<div id="postFeatured">

    <div class ="grayblock"></div>

	<div class="container twelve columns content">
		<div id="pagefilter" data-query="jobs"></div>
		<div id="jobFilter">
				<div id="filterContRight">
					<span class="timePhrase">Jobs at >></span>
					<div data-time="all" class="timeButton">
						<a>All</a>
					</div>
					<div data-time="at-americas-essential-hospitals" class="timeButton">
						<a>America's Essential Hospitals</a>
					</div>
					<div data-time="at-our-member-hospitals" class="timeButton">
						<a>Our Member Hospitals</a>
					</div>
				</div>
			</div>

		<div id="contentWrap" class="action">
			<div class="gutter">
				<div class="container">
					<div id="contentPrimary">
						<div class="graybar"></div>
						<div class="gutter">
							<?php get_template_part( 'partial/template', 'jobloop' ); ?>
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