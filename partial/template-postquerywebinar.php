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

	//Count our posts and set the $output variable
	$postCount = 0;
	$output = '';


	$args = array(
		'post_type' => array('webinar'),
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

		$line=$postExcerpt;
		if (preg_match('/^.{1,100}\b/s', $postExcerpt, $match))
		{
		    $postExcerpt=$match[0];
		}

		$postColor = '';
		$postTime = get_the_time('M j, Y');
		$templateDIR = get_bloginfo('template_directory');
		$postAuthor = get_the_author();
		$postLink = get_permalink();
		$postTags = get_the_tags();

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

	    $output .= '<div class="close post long columns '. $postColor .' '. $postType .' ">
	    		<div class="graybarright"></div>
	  			<div class="item-bar"></div>
    			<div class="item-icon"><img src="'. $templateDIR .'/images/icon-'. $postType .'.png" /></div>
    			<div class="item-content">
	    			<div class="item-header">
	    				<h2><a href="'.$postLink.'">'. $postTitle .'</a></h2>
	    				<span class="item-date">'. $postTime .' ||</span>
	    				<span class="item-author">'. $postAuthor .'</span>
	    			</div>
	    			<p>'. $postExcerpt .'<a class="more" href="'. $postLink .'"> read more &raquo; </a>
	    			</p>';
	    if ( get_post_status ( $ID ) == 'future' ) {
			$output .= '<span class="reserve button '.$postType.'"><a href='.get_field('registration_link').'>Reserve Your Spot</a></span>';
		}

	    $output .=  '<div class="item-tags">';
	    if($postTags){
		    foreach($postTags as $tag){
			    $output .= '<a href="'.get_bloginfo('url').'/tag/'.$tag->slug.'">'.$tag->name.'</a>, ';
		    }
	    }
	    $output .= '</div>
	    		</div>
	    		<div class="bot-border"></div>
	  		</div>';

	$postCount = $postCount++;
	endwhile; wp_reset_query();
	echo $output; ?>