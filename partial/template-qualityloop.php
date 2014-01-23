<div id="postBox" class="clearfix">
	<div id="fader" class="clearfix scrollable">
	<div id="loader-gif"> Loading more posts</div>
			<div class="items">

			<?php
			$sticky = get_option( 'sticky_posts' );
			$args = array(
				'post_type'    => 'alert',
				'post_count'   => 1,
				'tax_query' => array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'category',
						'field' => 'slug',
						'terms' => array( 'announcement' )
					),
					array(
						'taxonomy' => 'category',
						'field' => 'slug',
						'terms' => array( 'quality' )
					)
				)
			);
			$query = new WP_Query($args);
			if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
				$postType = get_post_type( get_the_ID() ); ?>
			<div class="post long columns announcement <?php echo get_post_type( get_the_ID() ); ?> greenn">
						<div class="graybarright"></div>
						<div class="bgfade">
				  			<div class="item-bar"></div>
							<div class="item-content">
				    			<div class="item-header">
				    				<h2><?php echo get_field('heading'); ?></h2>
				    			</div>
				    			<a class="floatright" href="<?php echo get_field('link'); ?>"><?php echo get_field('label'); ?></a>
				    		</div>
						</div>
			  		</div>
			<?php } } wp_reset_query(); ?>

			<?php
			$args = array(
				'post_type' => array('quality'),
				'meta_key' => 'sticky_topic',
				'meta_value' => 'quality',
				'meta_compare' => '='
			);
			$query = new WP_Query($args);
			if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
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
					} ?>
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
			    			<p><?php the_excerpt(); ?>
			    			</p><a class="more" href="<?php the_permalink(); ?>"> view more » </a>
			    			<div class="item-tags">
			    				<?php $tags = get_the_terms(get_the_ID(),'post_tag');
			    					if($tags){
			    						$cnt = 0;
			    						foreach($tags as $tag)
			    						{
				    						$tagLink = get_term_link($tag->term_id,'post_tag');
				    						$tagSlug = $tag->slug;
				    						$tagSlug = str_replace('-',' ', $tagSlug);
				    						if ($cnt != 0) echo ", ";
					    					echo "<a href='".$tagLink."'>".$tagSlug."</a>";
					    					$cnt++;
					    				}
				    				}?>
			    			</div>
			    		</div>
			    		<div class="bot-border"></div>
			  		</div>
		<?php } } wp_reset_query(); ?>


			<?php
			query_posts( array(
				'post_type'         => 'webinar',
				'webinartopics'     => 'policy',
				'posts_per_page'    => 1,
				'post_status'		=> 'future',
				'meta_query' => array(
					array(
						'key' => 'sticky_topic',
						'compare' => 'NOT EXISTS'
					)
				)
			) );
			if ( have_posts() ) while ( have_posts() ) : the_post();
			?>

			<div class="post long columns greenn webinar">
				<div class="graybarright"></div>
	  			<div class="item-bar"></div>
    			<div class="item-icon">
					Upcoming Webinar
    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-quality.png" />
    			</div>
    			<div class="item-content">
	    			<div class="item-header">
	    				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	    				<span class="item-date"><?php the_time('M j, Y'); ?></span>
	    			</div>
	    			<p><?php
						$exc = get_the_excerpt();
						$line=$exc;
						if (preg_match('/^.{1,100}\b/s', $exc, $match))
						{
						    $line=$match[0];
						}
						echo $exc; ?>
	    			</p><a class="more" href="<?php the_permalink(); ?>"> view more » </a>
	    			<span class="reserve button greenn quality"><a href="<?php the_field('registration_link'); ?>">Reserve Your Spot</a></span>
	    			<div class="item-tags">
	    				<?php $tags = get_the_terms(get_the_ID(),'post_tag');
			    					if($tags){
			    						$cnt = 0;
			    						foreach($tags as $tag)
			    						{
				    						$tagLink = get_term_link($tag->term_id,'post_tag');
				    						$tagSlug = $tag->slug;
				    						$tagSlug = str_replace('-',' ', $tagSlug);
				    						if ($cnt != 0) echo ", ";
					    					echo "<a href='".$tagLink."'>".$tagSlug."</a>";
					    					$cnt++;
					    				}
				    				}?>
	    			</div>
	    		</div>
	    		<div class="bot-border"></div>
	  		</div>


		<?php endwhile; wp_reset_query();?>


		<?php
			query_posts( array(
				'post_type' => array('post','quality'),
				'tax_query' => array(
					'relation' => 'IN',
					array(
						'taxonomy' => 'qualitytopics',
						'field' => 'slug',
						'terms' => get_terms( 'qualitytopics', array( 'fields' => 'names' ) )
					)
				),
				'meta_query' => array(
					array(
						'key' => 'sticky_topic',
						'meta_value' => 'quality',
						'compare' => 'IN',
					)
				)
			) );
			if ( have_posts() ) while ( have_posts() ) : the_post();
				$postType = get_post_type( get_the_ID() );

				//check post type and apply a color
				if($postType == 'policy'){
					$postColor = 'redd';
				}else if($postType == 'quality'){
					$postColor = 'greenn';
				}else if($postType == 'education' || $postType == 'post'){
					$postColor = 'grayy';
				}else if($postType == 'institute'){
					$postColor = 'bluee';
				}else{
					$postColor = 'bluee';
				}
			?>

			<div class="post long columns <?php echo $postColor; ?>  <?php echo get_post_type( get_the_ID() ); ?> ">
				<div class="graybarright"></div>
	  			<div class="item-bar"></div>
    			<div class="item-icon">
    				<?php $terms = wp_get_post_terms(get_the_ID(), 'series');
    					if($terms){
	    					$termLink = get_term_link($terms[0], 'series');
		    				echo "<a href='".$termLink."'>".$terms[0]->name."</a>";
	    				}
    				?>
    				<?php if($postType != 'post'){ ?>
	    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-<?php echo $postType; ?>.png" />
    				<?php } ?>
    			</div>
    			<div class="item-content">
	    			<div class="item-header">
	    				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	    				<span class="item-date"><?php the_time('M j, Y'); ?> ||</span>
	    				<span class="item-author"><?php the_author(); ?></span>
	    			</div>
	    			<p><?php
						$exc = get_the_excerpt();
						$line=$exc;
						if (preg_match('/^.{1,100}\b/s', $exc, $match))
						{
						    $line=$match[0];
						}
						echo $exc; ?>
	    			</p><a class="more" href="<?php the_permalink(); ?>"> view more » </a>
	    			<div class="item-tags">
	    				<?php $tags = get_the_terms(get_the_ID(),'post_tag');
			    					if($tags){
			    						$cnt = 0;
			    						foreach($tags as $tag)
			    						{
				    						$tagLink = get_term_link($tag->term_id,'post_tag');
				    						$tagSlug = $tag->slug;
				    						$tagSlug = str_replace('-',' ', $tagSlug);
				    						if ($cnt != 0) echo ", ";
					    					echo "<a href='".$tagLink."'>".$tagSlug."</a>";
					    					$cnt++;
					    				}
				    				}?>
	    			</div>
	    		</div>
	    		<div class="bot-border"></div>
	  		</div>


		<?php endwhile; wp_reset_query();?>



			<?php
			query_posts( array(
				'post_type' => array('quality','institute'),
				'tax_query' => array(
					'relation' => 'IN',
					array(
						'taxonomy' => 'qualitytopics',
						'field' => 'slug',
						'terms' => get_terms( 'qualitytopics', array( 'fields' => 'names' ) )
					)
				)

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

			<div class="post long columns <?php echo $postColor; ?>  <?php if($postType == 'institute'){ echo 'instafade'; }else{ echo $postType; } ?> ">
				<div class="graybarright"></div>
	  			<div class="item-bar"></div>
    			<div class="item-icon">
    				<?php $terms = wp_get_post_terms(get_the_ID(), 'series');
    					if($terms){
	    					$termLink = get_term_link($terms[0], 'series');
		    				echo "<a href='".$termLink."'>".$terms[0]->name."</a>";
	    				}
    				?>
					<?php if($postType != 'post'){ ?>
	    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-<?php echo $postType; ?>.png" />
    				<?php } ?>
    			</div>
    			<div class="item-content">
	    			<div class="item-header">
	    				<h2><a href="<?php if(get_field('link_to_media')){the_field('uploaded_file');}else{the_permalink();} ?>"><?php the_title(); ?></a></h2>
	    				<span class="item-date"><?php the_time('M j, Y'); ?> ||</span>
	    				<span class="item-author"><?php the_author(); ?></span>
	    			</div>
	    			<?php if(get_field('link_to_media')){ ?>
						<a href="<?php the_field('uploaded_file'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/<?php echo $postType; ?>-doc.png" /></a>
					<?php }else{ ?>
						<p><?php
						$exc = get_the_excerpt();
						$line=$exc;
						if (preg_match('/^.{1,100}\b/s', $exc, $match))
						{
						    $line=$match[0];
						}
						echo $exc; ?></p><a class="more" href="<?php the_permalink(); ?>"> view more » </a>
					<?php } ?>
	    			<div class="item-tags">
	    				<?php $tags = get_the_terms(get_the_ID(),'post_tag');
			    					if($tags){
			    						$cnt = 0;
			    						foreach($tags as $tag)
			    						{
				    						$tagLink = get_term_link($tag->term_id,'post_tag');
				    						$tagSlug = $tag->slug;
				    						$tagSlug = str_replace('-',' ', $tagSlug);
				    						if ($cnt != 0) echo ", ";
					    					echo "<a href='".$tagLink."'>".$tagSlug."</a>";
					    					$cnt++;
					    				}
				    				}?>
	    			</div>
	    		</div>
	    		<div class="bot-border"></div>
	  		</div>


		<?php endwhile; wp_reset_query();?>
			</div>
	</div>
</div>
