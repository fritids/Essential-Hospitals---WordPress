<?php
	$args = array(
		'post_type' => array('policy','quality','institute'),
		'meta_key' => 'sticky_topic',
		'meta_value' => 'home',
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
	    			<p><?php
						$exc = get_the_excerpt();
						$line=$exc;
						if (preg_match('/^.{1,100}\b/s', $exc, $match))
						{
						    $line=$match[0];
						}
						echo $line; ?><a class="more" href="<?php the_permalink(); ?>"> read more » </a>
	    			</p>
	    			<div class="item-tags">
	    				<?php the_tags(' ',' ',' '); ?>
	    			</div>
	    		</div>
	    		<div class="bot-border"></div>
	  		</div>
<?php } } wp_reset_query(); ?>