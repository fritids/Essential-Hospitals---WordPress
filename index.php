<?php get_header(); ?>
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
