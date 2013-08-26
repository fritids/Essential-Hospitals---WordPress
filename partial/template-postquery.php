<?php
	// Our include  
	define('WP_USE_THEMES', false);
	require_once('../../../../wp-load.php');
	
	//Get variable from AJAX POST
	$ajaxFilter = $_POST['ajaxFilter'];
	
	//Determine if filter is being reset
	if($ajaxFilter == 'reset'){
		$ajaxFilter = '';
	}
	
	//Count our posts and set the $output variable
	$postCount = 0;
	$output = '';
	

	$args = array(
		'posts_per_page' => '-1',
		'category_name' => $ajaxFilter,
	);
	query_posts( $args ); while ( have_posts() ) : the_post();
		$postTitle = get_the_title();
		$postContent = get_the_content();
		
	    $output .= '<div class="post">
	    	<div class="gutter">
	    		<h1>'.$postTitle.'</h1>
	    		'.$postContent.'
	    	</div>
	    </div>';
    
	$postCount = $postCount++;
	endwhile; wp_reset_query(); 
	echo $output; ?>