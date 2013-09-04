<?php
	 $terms = get_terms('webinartopics', 'orderby=count&hide_empty=0');
	 $webinars = array();
	 foreach($terms as $term){
	 	$webinars[] = $term->slug;
	 }
	 $webinararray = array(implode(',',$webinars));
?>
<div id="postBox" class="clearfix">
	<div id="fader" class="clearfix scrollable">
			<div class="items">
			<?php
			query_posts( array(
				'post_type' => array('policy','quality','education','institute'),
				'tax_query' => array(
					array(
						'taxonomy' => 'webinartopics',
						'field' => 'slug',
						'terms' => $webinars
					)
				),
				'post_status' => array('publish','future'),
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
	    			<p><?php the_excerpt(); ?><a class="more" href="<?php the_permalink(); ?>"></a>
	    			<?php 
		    			if ( get_post_status ( $ID ) == 'future' ) {
							echo '<span class="button '.$postType.'"><a>Reserve Your Spot</a></span>';
						}
	    			?>
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