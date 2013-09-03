<?php
	// Our include  
	define('WP_USE_THEMES', false);
	require_once('../../../../wp-load.php');
	
	//Get variable from AJAX POST
	$ajaxFilter = $_POST['ajaxFilter'];
	
	//Determine if filter is being reset
	if($ajaxFilter == 'show-all-topics'){
		$ajaxFilter = '';
	}
	
	//Count our posts and set the $output variable
	$postCount = 0;
	$output = '';
	

	$args = array(
		'post_type' => 'quality',
		'policytopics' => $ajaxFilter,
	);
	query_posts( $args ); while ( have_posts() ) : the_post();
		$postTitle = get_the_title();
		$postExcerpt = get_the_excerpt();
		$postColor = '';
		$postTime = get_the_time('M j, Y');
		$templateDIR = get_bloginfo('template_directory');
		$postAuthor = get_the_author();
		$postLink = get_permalink();
		$postTags = get_the_tags();
		
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
		
	    $output .= '<div class="close post long columns '. $postColor .' '. $postType .' ">
	  			<div class="item-bar"></div>
    			<div class="item-icon"><img src="'. $templateDIR .'/images/icon-'. $postType .'.png" /></div>
    			<div class="item-content">
	    			<div class="item-header">
	    				<h2>'. $postTitle .'</h2>
	    				<span class="item-date">'. $postTime .' ||</span>
	    				<span class="item-author">'. $postAuthor .'</span>
	    			</div>
	    			<p>'. $postExcerpt .'<a class="more" href="'. $postLink .'"> read more » </a>
	    			</p>
	    			<div class="item-tags">
	    				'. $postTags .'
	    			</div>
	    		</div>
	    		<div class="bot-border"></div>
	  		</div>';
    
	$postCount = $postCount++;
	endwhile; wp_reset_query(); 
	echo $output; ?>