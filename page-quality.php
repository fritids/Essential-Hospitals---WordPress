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
<?php
	get_footer();
?>