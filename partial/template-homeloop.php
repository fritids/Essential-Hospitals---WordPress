<div id="postBox" class="clearfix">
	<div class="fixed-box absolute">

      		<div class="twitter">
      			<img src="<?php bloginfo('template_directory'); ?>/images/twit-icon.png" />
      			<span class="twitred">EssentialHospials </span>
      			 announces webinar on round two of heath care innovation grants <a href="#">http://t.com/QADWCZ</a> via @AlexMac 
      		</div>
 
  			<div class="newsletter">
	            <form>
	              <span>Essential Hospitals news in your inbox:</span>
	              <input type="text" class="newsletter_btn_input" value="Enter Email Here"><input class="newsletter_btn" type="submit" >
	              <div class="clear"></div>
	            </form>
	            <div class="clear"></div>
	        </div>
 			
	        <div class="topics">
	        	<h3> Top Issues and Topics</h3>
	        	<ul>
 
					<li>Patient Safety</li>
					<li>Preventing Readmissions</li>
					<li>HCAHPS</li>
					<li>CLINICIAN-PATIENT COMMUNICATIONS</li>
					<li>PATIENT EXPERIENCE</li>
					<li>Specialty Care </li>
					<li>Quality Metrics</li>
	        	</ul>
	        </div>

      	</div>
	<div id="fader" class="clearfix scrollable">
			<div class="items">
			<?php 
			query_posts( array(
				'post_type' => array('policy','quality','education','institute'),
			) );
			if ( have_posts() ) while ( have_posts() ) : the_post(); 
				$postType = get_post_type( get_the_ID() );
				
				//check post type and apply a color	
				if($postType == 'policy'){
					$postColor = 'redd';
				}else if($postType == 'quality'){
					$postColor = 'greenn';
				}else if($postType == 'education'){
					$postColor = 'grayy';
				}else if($postType == 'institute'){
					$postColor = 'bluee';
				}else{
					$postColor = 'bluee';
				}
			?>
			
			<div class="post long columns <?php echo $postColor; ?>  <?php echo get_post_type( get_the_ID() ); ?> ">
	  			<div class="item-bar"></div>
    			<div class="item-icon"><img src="<?php bloginfo('template_directory'); ?>/images/icon-<?php echo $postType; ?>.png" /></div>
    			<div class="item-content">
	    			<div class="item-header">
	    				<h2><?php the_title(); ?></h2>
	    				<span class="item-date"><?php the_time('M j, Y'); ?> ||</span>
	    				<span class="item-author"><?php the_author(); ?></span>
	    			</div>
	    			<p><?php the_excerpt(); ?><a class="more" href="<?php the_permalink(); ?>"> read more » </a>
	    			</p>
	    			<div class="item-tags">
	    				<?php the_tags(' ',' ',' '); ?>
	    			</div>
	    		</div>
	    		<div class="bot-border"></div>
	  		</div>
			
			
		<?php endwhile; wp_reset_query();?>
			</div>
	</div>
</div>