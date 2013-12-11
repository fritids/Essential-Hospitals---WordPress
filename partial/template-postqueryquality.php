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
		'post_type' => array('quality','institute'),
		'qualitytopics' => $ajaxFilter,
	);
	query_posts( $args );

	if ( have_posts() ) { while ( have_posts() ) { the_post();
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

		//check post type and apply a color
		if($postType == 'policy'){
			$postColor = 'redd';
		}else if($postType == 'quality'){
			$postColor = 'greenn';
		}else if($postType == 'education'){
			$postColor = 'grayy';
		}else if($postType == 'institute'){
			$postColor = 'bluee';
			$postType = 'instafade';
		}else{
			$postColor = 'bluee';
		}
		$terms = wp_get_post_terms(get_the_ID(), 'series');
		if($terms){
			$termLink = get_term_link($terms[0], 'series');
		}

	    $output .= '<div class="close post long columns '. $postColor .' '. $postType .' ">
	    		<div class="graybarright"></div>
	  			<div class="item-bar"></div>
    			<div class="item-icon"><a href="'.$termLink.'">'.$terms[0]->name.'</a><img src="'. $templateDIR .'/images/icon-'. $postType .'.png" /></div>
    			<div class="item-content">
	    			<div class="item-header">
	    				<h2><a href="'. $postLink .'">'. $postTitle .'</a></h2>
	    				<span class="item-date">'. $postTime .' ||</span>
	    				<span class="item-author">'. $postAuthor .'</span>
	    			</div>
	    			<p>'. $postExcerpt .'<a class="more" href="'. $postLink .'"> read more » </a>
	    			</p>
	    			<div class="item-tags">';
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
	} }else{
		$output = '<div class="close post long columns greenn quality">
		    		<div class="graybarright"></div>
		  			<div class="item-bar"></div>
	    			<div class="item-content">
		    			<div class="item-header">
		    				<h2>No Articles Found</h2>
		    			</div>
		    			<p>No articles were found with under that Topic. Try another topic.</a>
		    			</p>
		    		</div>
	    		</div>';
	} wp_reset_query();
	echo $output; ?>