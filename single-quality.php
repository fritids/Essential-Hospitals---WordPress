<?php get_header(); ?>
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
<div id="content" class="single policy quality">
	<div class="container">
		<div id="pageNav"></div>
		<div id="contentPrimary">
			<div class="gutter">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<h2><?php the_title(); ?></h2>
				<div id="postmeta">
					<span class="postmeta"><?php the_time('F, j'); ?> || <em><?php the_author(); ?></em></span> <span class="postcomments"><?php comments_number( '(0) comments', '(1) comment', '(%) comments' ); ?></span>
				</div>
				<div class="postcontent">
					<?php the_content(); ?>
				</div>
			<?php endwhile; ?>
			</div>
		</div>
		<div id="contentSecondary">
			<div class="gutter">
		
			</div>
		</div>
		<div id="contentTertiary">
			<div class="gutter">
			
			</div>
		</div>
	</div>

</div><!-- End of Content -->
<?php get_footer(); ?>