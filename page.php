<?php /*
 * Default Page Template
 */
?>

<?php get_header(); ?>
<?php get_template_part( 'subheader'); ?>

<div class="container page_content"> 
	
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div class="three columns">
		
			<?php 
            //get parent title
            global $post;
            if(is_page() && $post->post_parent) {
        			$pid = $post->post_parent;
              $thepermalink = get_permalink( $pid );
            } 
			?>
        

	           <!--<h2><a href="<?php echo $thepermalink; ?>"><?php echo get_the_title($pid); ; ?></a></h2>-->
	        	<?php
				 	//list parent child pages
				 	if($post->post_parent)
	  					$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0&depth=1");
	 				 else
	 					 $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&depth=1");
	 				 if ($children) { ?>
	 				 <div class="border_box">
						<div class="border_inner page_nav">
	  						<ul>
	  							<?php echo $children; ?>
	  						</ul>  
	  					</div>		
					</div>		       
	  				<?php }  ?>
	  		

		<div class="border_box page_side testimonials">
			<div class="border_inner testimonials">
				<?php $args = array( 'post_type' => 'quotes', 'posts_per_page' => 1, 'orderby'=> 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post();
					the_content(); 
					?>
					<p class="quote_source">- <?php the_title(); ?></p>
				<?php 
				endwhile;
				wp_reset_query();
				?>
			</div>
		</div>
	</div>	

	<div class="seven offset-by-one columns content">
		<?php the_content(); ?>
	</div>
		  	
<?php endwhile; ?>

</div><!-- End of Container -->







<?php get_footer(); ?>