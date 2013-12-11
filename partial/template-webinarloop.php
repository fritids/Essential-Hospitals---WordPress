<?php
	 $terms = get_terms('webinartopics', 'orderby=count&hide_empty=0');
	 $webinars = array();
	 foreach($terms as $term){
	 	$webinars[] = $term->slug;
	 }
	 $webinararray = array(implode(',',$webinars));
	 if(isset($_GET['timeFilter'])){
		$time = $_GET['timeFilter'];
	 }else{
		 $time = 'all';
	 }
?>
<div id="postBox" class="clearfix">
	<div id="fader" class="clearfix scrollable">
			<div class="items">
			<?php
				if($time = 'future' || $time == 'all'){
				query_posts( array(
					'post_type' => 'webinar',
					'post_status' => 'future',
					'orderby' => 'date',
					'order' => 'asc',
					'tax_query' => array(
						array(
							'taxonomy' => 'webinartopics',
							'field' => 'slug',
							'terms' => $webinars
						)
					)
				) );
				if ( have_posts() ) while ( have_posts() ) : the_post();
					$postType = get_post_type( get_the_ID() );

					$postTerms = wp_get_post_terms( get_the_ID(), 'webinartopics' );
					$newTerm = array();
					foreach($postTerms as $term){
						array_push($newTerm, $term->slug);
					}
					//check post type and apply a color
					if(in_array('policy',$newTerm)){
						$postColor = 'redd';
						$postType  = 'policy';
					}else if(in_array('quality',$newTerm)){
						$postColor = 'greenn';
						$postType  = 'quality';
					}else if(in_array('education',$newTerm)){
						$postColor = 'grayy';
						$postType  = 'education';
					}else if(in_array('institute',$newTerm)){
						$postColor = 'bluee';
						$postType  = 'institute';
					}else{
						$postColor = 'grayy';
						$postType  = 'education';
					}
				?>

				<div class="post long columns <?php echo $postColor; ?>  <?php echo get_post_type( get_the_ID() ); ?> ">
					<div class="graybarright"></div>
		  			<div class="item-bar"></div>
	    			<div class="item-icon"><img src="<?php bloginfo('template_directory'); ?>/images/icon-<?php echo $postType; ?>.png" /></div>
	    			<div class="item-content">
		    			<div class="item-header">
		    				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		    				<span class="item-date"><?php the_time('M j, Y'); ?> ||</span>
		    				<span class="item-author"><?php the_author(); ?></span>
		    			</div>

		    			<?php
			    			if ( get_post_status ( $ID ) == 'future' ) {
								echo '<span class="reserve button '.$postType.'"><a href="'.get_field('registration_link').'">Reserve Your Spot</a></span>';
							}else{ ?>
								<p><?php the_field('teaser'); ?> - <a class="more" href="<?php the_permalink(); ?>">Read More &raquo;</a></p>
						<?php } ?>

		    			<div class="item-tags">
		    				<?php the_tags(' ',' ',' '); ?>
		    			</div>
		    		</div>
		    		<div class="bot-border"></div>
		  		</div>


			<?php endwhile; wp_reset_query(); } ?>


			<?php
			if($time = 'publish' || $time == 'all'){
			query_posts( array(
				'post_type' => 'webinar',
				'post_status' => 'publish',
				'orderby' => 'date',
				'order' => 'desc',
				'tax_query' => array(
					array(
						'taxonomy' => 'webinartopics',
						'field' => 'slug',
						'terms' => $webinars
					)
				)
			) );
			if ( have_posts() ) while ( have_posts() ) : the_post();
				$postType = get_post_type( get_the_ID() );

				$postTerms = wp_get_post_terms( get_the_ID(), 'webinartopics' );
				$newTerm = array();
				foreach($postTerms as $term){
					array_push($newTerm, $term->slug);
				}
				//check post type and apply a color
				if(in_array('policy',$newTerm)){
					$postColor = 'redd';
					$postType  = 'policy';
				}else if(in_array('quality',$newTerm)){
					$postColor = 'greenn';
					$postType  = 'quality';
				}else if(in_array('education',$newTerm)){
					$postColor = 'grayy';
					$postType  = 'education';
				}else if(in_array('institute',$newTerm)){
					$postColor = 'bluee';
					$postType  = 'institute';
				}else{
					$postColor = 'grayy';
					$postType  = 'education';
				}
			?>

			<div class="post long columns <?php echo $postColor; ?>  <?php echo get_post_type( get_the_ID() ); ?> ">
				<div class="graybarright"></div>
	  			<div class="item-bar"></div>
    			<div class="item-icon"><img src="<?php bloginfo('template_directory'); ?>/images/icon-<?php echo $postType; ?>.png" /></div>
    			<div class="item-content">
	    			<div class="item-header">
	    				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	    				<span class="item-date"><?php the_time('M j, Y'); ?> ||</span>
	    				<span class="item-author"><?php the_author(); ?></span>
	    			</div>
	    			<p><?php the_field('teaser'); ?> - <a class="more" href="<?php the_permalink(); ?>">Read More &raquo;</a>
	    			<?php
		    			if ( get_post_status ( $ID ) == 'future' ) {
							echo '<span class="reserve button '.$postType.'"><a>Reserve Your Spot</a></span>';
						}
	    			?>
	    			</p>
	    			<div class="item-tags">
	    				<?php the_tags(' ',' ',' '); ?>
	    			</div>
	    		</div>
	    		<div class="bot-border"></div>
	  		</div>


		<?php endwhile; wp_reset_query(); } ?>



			</div>
	</div>
</div>