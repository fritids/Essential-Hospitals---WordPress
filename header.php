<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<title><?php wp_title( '|', true, 'right' );  ?>   <?php bloginfo('name'); ?></title>

	<!-- Meta / og: tags -->
	<?php if (have_posts()):while(have_posts()):the_post(); endwhile; endif;?> 

	<!-- if page is content page -->
	<?php if (is_single()) { ?>
	<meta property="og:url" content="<?php the_permalink() ?>"/>
	<meta property="og:title" content="<?php single_post_title(''); ?>" />
	<meta property="og:description" content="<?php echo strip_tags(get_the_excerpt($post->ID)); ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="<?php bloginfo('template_url' );?>/images/century-equities.png" />

	<!-- if page is others -->
	<?php } else { ?>
	<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
	<meta property="og:description" content="<?php bloginfo('description'); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="<?php bloginfo('template_url' );?>/images/century-equities.png" /> <?php } ?>



	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0">
	 

	<!-- FONTS
	================================================== -->
	  <link href='http://fonts.googleapis.com/css?family=Cabin:400,600,700' rel='stylesheet' type='text/css'>

	<!-- CSS (* with Edge Inspect Fix)
    ================================================== -->
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/style.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/style-mockupDefault.css" />
 

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="<?php bloginfo('url' );?>/favicon.ico">
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

	<?php wp_head(); ?>


</head>

<body>


	<!-- Utilities Navigataion -->
	<div id="utility-nav" class="fullwidth">
		<div class="container">
			 <div class="sixteen columns">
			 		<?php 
			 		if(has_nav_menu('main')){
				 		wp_nav_menu( array( 'menu_id' => 'utils-nav', 'theme_location' => 'utility-menu', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'));
			 		} ?>

			 </div>
		</div>
	</div>	
	<!-- END Utilities Navigataion -->


	<!-- Logo/Main Navigataion -->
	<div id="header" class="fullwidth">
		<div class="container">
				 <div class="logo"> 
				 	<a href="<?php bloginfo( 'url' );?>" title="<?php bloginfo( 'name' );?>"><img src="<?php bloginfo('template_url' );?>/images/logo.png" title="<?php bloginfo( 'name' );?>"></a>
				 
			</div>
			<div class="twelve columns navigation">
				<?php
				global $post;
				$thePostID = $post->ID;
				
			    $menu_name = 'primary-menu';
			
			    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
				$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
			
				$menu_items = wp_get_nav_menu_items($menu->term_id);
			
				$menu_list = '<ul id="menu-' . $menu_name . '">';
			
				foreach ( (array) $menu_items as $key => $menu_item ) {
					if($thePostID == $menu_item->object_id){
						$activeClass = 'active';
					}else{
						$activeClass = '';
					}
				    $title = $menu_item->title;
				    $url = $menu_item->url;
				    $desc = $menu_item->description;
				    $menu_list .= '<li class="'.$activeClass.'"><a href="' . $url . '">' . $title . '<span>'.$desc.'</span></a></li>';
				}
				$menu_list .= '</ul>';
			    } else {
				$menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
			    }
			    echo $menu_list;
				?>
			</div>
      	    <div class="clear"></div>
		</div><!-- End of Container -->
		<div class="clear"></div>
	</div> 
	<!-- Logo/Main Navigataion -->


 





