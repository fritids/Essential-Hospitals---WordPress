<?php /*
 * Default Page Template
 */
?>

<?php get_header(); ?>
<?php get_template_part( 'subheader'); ?>

<div class="container page_content"> 
	
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div class="three columns">
		 

		<div class="border_box page_side">
			<div class="border_inner testimonials">
				<?php $args = array( 'post_type' => 'quotes', 'posts_per_page' => 1, 'orderby'=> 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post();
					the_content(); 
				endwhile;
				?>
			</div>
		</div>
	</div>	

	<div class="seven offset-by-one columns content">
		<h1>Page Not Found</h1>
	<p>The page you requested could not be found. Perhaps searching will help.</p>
	</div>
		  	
<?php endwhile; ?>

</div><!-- End of Container -->







<?php get_footer(); ?>