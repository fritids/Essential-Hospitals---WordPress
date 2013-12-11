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
			'terms' => array( 'home' )
		)
	)
);
$query = new WP_Query($args);
if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
	$postType = get_post_type( get_the_ID() ); ?>
<div class="post long columns announcement <?php echo get_post_type( get_the_ID() ); ?> ">
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