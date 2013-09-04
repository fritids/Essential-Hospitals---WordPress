<?php 
	get_header();
?>
<?php $speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div id="featured-img" class="education webinar" style="background-image:url(<?php echo $speakerIMG; ?>);">
	<div class="container">
		<div id="featured-intro">
			<?php while ( have_posts() ) : the_post(); ?>
				<h3><?php the_field('bannerTitle'); ?></h3>
				<h4><?php the_field('bannerDescription'); ?></h4>
			<?php endwhile; // end of the loop. ?>
		</div>
	</div>
</div>
<div id="contentWrap" class="education">
	<div id="prev" title="Show previous"> </div>
	<div id="next" title="Show more Articles"> </div> 

	<a id="prevbtn" title="Show previous">  </a>
	<a id="nextbtn" title="Show more">  </a> 
	<div class="gutter">
		<div class="container">
			<div id="timeFilter">
				<span class="timePhrase">Filter by Type >></span>
				<div data-time="all" class="timeButton active">
					<a>All</a>
				</div>
				<div data-time="future" class="timeButton">
					<a>Upcoming Webinars</a>
				</div>
				<div data-time="publish" class="timeButton">
					<a>Recorded Webinars</a>
				</div>
			</div>
			<div id="contentPrimary">
				<div class="gutter">
					<span class="filterby">Filter By >></span>
					<ul id="pagefilter" class="webinar" data-query="webinar">
						<?php
						$terms = get_terms('webinartopics', 'orderby=date&hide_empty=0');
						 foreach($terms as $term){ ?>
						 
						 	<li data-filter="<?php echo $term->slug; ?>"><a><?php echo $term->name; ?> (<?php echo $term->count; ?>)</a></li>
						 	
						 <?php } ?>
						<li data-filter="all" class="last"><a>Show All Topics</a></li>
					</ul>
				</div>
			</div>
			<div id="contentSecondary" class="webinar">
				<div class="gutter">
					<?php get_template_part( 'partial/template', 'webinarloop' ); ?> 
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	get_footer();
?>