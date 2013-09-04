<?php
	// Our include  
	define('WP_USE_THEMES', false);
	require_once('../../../../wp-load.php');
	
	//Get variable from AJAX POST
	$ajaxFilter = $_POST['ajaxFilter'];
	$timeFilter = $_POST['timeFilter'];
	
	//Determine if filter is being reset
	$terms = get_terms('webinartopics', 'orderby=count&hide_empty=0');
	 foreach($terms as $term){
	 	$webinars[] = $term->slug;
	 }
	if($ajaxFilter == 'all'){
		$ajaxFilter = $webinars;
	}
	if($ajaxFilter == ''){
		$ajaxFilter = $webinars;
	}
	if($timeFilter == 'all'){
		$timeFilter = array('publish','future');
	}
	
	//Count our posts and set the $output variable
	$postCount = 0;
	$output = '';
	

	$args = array(
		'post_type' => array('policy','quality','education','institute'),
		'tax_query' => array(
			array(
				'taxonomy' => 'webinartopics',
				'field' => 'slug',
				'terms' => $ajaxFilter
			)
		),
		'post_status' => $timeFilter,
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