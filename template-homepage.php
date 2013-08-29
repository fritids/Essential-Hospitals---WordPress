<?php /*
 * Template Name: Homepage Template
 */
?>
<?php get_header(); ?>
<div id="banner" class="fullwidth g1">
		<!--<div class="container">-->
			<div class="sixteen columns featured">
      
      <div id="banner_text">
        <span class="orange">
          <em>Essential People.</em><br />
          <em>Essential Communities.</em> <br />
          <span class="bold">Essential Hospitals.</span> <br />
        </span>
        
        <br />
        
        <em>We are the providers<br />
        of quality care our<br />
        communities need.</em>

      </div>

      <div id="people">
         <?php while ( have_posts() ) : the_post(); 
		
		if(get_field('featured_stories'))
		{
			while(has_sub_field('featured_stories')){ ?>
			
			<div class="people_box">
        	<img src="<?php echo get_sub_field('featuredPortrait'); ?>" id="starter"/>
        	<div class="p_hover">
        		<div class="p_name">
        			<span class="p_georgia">Name: </span> <?php echo get_sub_field('featuredName'); ?>
        		</div>

        		<div class="p_info">
					<span class="p_georgia">Occupation:</span> <?php echo get_sub_field('featuredOccupation'); ?> <br>
					<span class="p_georgia">Hospital: </span> <?php echo get_sub_field('featuredHospital'); ?>
				</div>	
				 
				<p><span class="p_georgia">Legacy: </span>  <?php echo get_sub_field('featuredLegacy'); ?></p>
        	</div>
        </div>
				
			<?php }
		}
		
		?>
 
		<?php endwhile; wp_reset_query();// end of the loop. ?>
		
       
       
 


      </div>
				
			</div> 
		<!--</div>-->
    
		<div class="clear"></div>
	</div><!-- End of featured -->
<div id="postFeatured">
	<div class="container fullborder">
 		<div class="eightteen columns filters">
 			<span> FILTER BY &rsaquo;&rsaquo;</span>
 			<div id="red_btn" data-filter="policy" class="filter_btn "> 
 				<img src="<?php bloginfo('template_directory'); ?>/images/policy.png"> <span>Public Policy</span>
 			</div>
 			<div id="green_btn" data-filter="quality" class="filter_btn ">
 				<img src="<?php bloginfo('template_directory'); ?>/images/quality.png"> <span>Quality</span>
 			</div>
 			<div id="gray_btn" data-filter="education" class="filter_btn ">
 				<img src="<?php bloginfo('template_directory'); ?>/images/edu.png"> <span>Education</span>
 			</div>
 			<div id="blue_btn" data-filter="institute" class="filter_btn ">
 				<img src="<?php bloginfo('template_directory'); ?>/images/inst.png"> <span>Institute</span>
 			</div>
 			<div id="all" data-filter="*" class="filter_btn all"><span>Reset</a></div>
 		</div>
 	</div> 
    <div class ="grayblock"></div>
    
	<div class="container twelve columns content">
		
		<?php get_template_part('partial/template','homeloop'); ?>
		
		
		
	</div><!-- End of Content -->
	<div id="prev" title="Show previous"> </div>
	<div id="next" title="Show more Articles"> </div> 

	<a id="prevbtn" title="Show previous">  </a>
	<a id="nextbtn" title="Show more">  </a> 
</div>
 
<?php get_footer(); ?>
