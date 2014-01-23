<?php get_header();
	global $post;
	$postSt = $post->post_status;
	$current_user = wp_get_current_user();
	$cUID = $current_user->ID;
	$cUStaff = get_user_meta($cUID,'aeh_member_type',true);
	if($postSt == 'private'){
		if($cUStaff == 'hospital'){

		while ( have_posts() ) : the_post();
		$pageTheme = get_field('theme');

		if($pageTheme == 'policy'){
			$menu = 'action';
		}elseif($pageTheme == ''){
			$menu = 'general';
		}elseif($pageTheme != 'policy'){
			$menu = $pageTheme;
		}

		//Get featuredIMG
		if($pageTheme == 'policy'){
			$fPID = 62;
			$speakerIMG = get_field('small_banner', $fPID);
			$bannerSize = "-small"; 
		}elseif($pageTheme == 'quality'){
			$fPID = 64;
			$speakerIMG = get_field('small_banner', $fPID); 
			$bannerSize = "-small";
		}elseif($pageTheme == 'institute'){
			$fPID = 621;
			$speakerIMG = get_field('small_banner', $fPID); 
			$bannerSize = "-small";
		}elseif($pageTheme == 'education'){
			$fPID = 472;
			$speakerIMG = get_field('small_banner', $fPID); 
			$bannerSize = "-small";
		}else{
			$fPID = 645;
			$rand = rand(1,8);
			$speakerIMG = "http://mlinson.staging.wpengine.com/wp-content/uploads/2013/11/AEH_generalbanner" .$rand . "_222.jpg";
			$bannerSize = "";
			$parents = get_post_ancestors( $post->ID );
			$parent_id = ($parents) ? $parents[count($parents)-1]: 0;
			if($parent_id == 645)
				{$bannerSize = "-small";}
		}

		//$speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($fPID) );
		 $bannerTitle = get_field('bannerTitle');  



		 ?>
 
		<div id="featured-img<?php echo $bannerSize;?>" class="page-single  <?php echo $pageTheme; ?>" style="background-image:url(<?php echo $speakerIMG; ?>); ">
			<div class="container">
				<div id="featured-intro">
					<h3><?php if($bannerTitle != '') echo $bannerTitle; else{ the_title(); }?></h3>
				</div>
			</div>
		</div>
		<div id="content" class="page-single default <?php echo $pageTheme; ?>">
			<div class="container">
				<?php
					if(has_nav_menu('general-nav')){
						$defaults = array(
							'theme_location'  => 'general-nav',
							'menu'            => 'general-nav',
							'container'       => 'div',
							'container_class' => '',
							'container_id'    => 'pageNav',
							'menu_class'      => 'quality',
							'menu_id'         => '',
							'echo'            => true,
							'fallback_cb'     => 'wp_page_menu',
							'before'          => '',
							'after'           => '',
							'link_before'     => '',
							'link_after'      => '',
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 0,
							'walker'          => ''
						);
						wp_nav_menu( $defaults );
					}
				?>
				<div id="contentColumnWrap">
					<div class="graybarright"></div>
					<div class="graybarleft"></div>
					<div id="columnBalance">
						<div id="contentPrimary" class="heightcol">
							<div class="gutter">
								<h1><?php the_title(); ?></h1>
								<?php the_content(); ?>
							</div>
						</div>
						<div id="contentSecondary" class="heightcol">
							<div class="gutter">
								<?php the_field('secondColumn'); ?>
							</div>
						</div>
						<div id="contentTertiary" class="heightcol">
							<div class="pagebar"></div>
							<?php
								$defaults = array(
									'theme_location'  => 'primary-menu',
									'menu'            => 'primary-menu',
									'container'       => 'div',
									'container_class' => 'page-nav',
									'container_id'    => '',
									'menu_class'      => '',
									'menu_id'         => '',
									'echo'            => true,
									'fallback_cb'     => 'wp_page_menu',
									'before'          => '',
									'after'           => '',
									'link_before'     => '',
									'link_after'      => '',
									'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
									'depth'           => 0,
									'walker'          => ''
								);
								wp_nav_menu( $defaults );
							?>
							<div class="gutter">
								<?php the_field('thirdColumn'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; // end of the loop. ?>
		</div><!-- End of Content -->
	<?php }else{ while ( have_posts() ) : the_post();
		$pageTheme = get_field('theme');

		if($pageTheme == 'policy'){
			$menu = 'action';
		}elseif($pageTheme == ''){
			$menu = 'general';
		}elseif($pageTheme != 'policy'){
			$menu = $pageTheme;
		}

		//Get featuredIMG
		if($pageTheme == 'policy'){
			$fPID = 62;
			$speakerIMG = get_field('small_banner', $fPID);
			$bannerSize = "-small"; 
		}elseif($pageTheme == 'quality'){
			$fPID = 64;
			$speakerIMG = get_field('small_banner', $fPID); 
			$bannerSize = "-small";
		}elseif($pageTheme == 'institute'){
			$fPID = 621;
			$speakerIMG = get_field('small_banner', $fPID); 
			$bannerSize = "-small";
		}elseif($pageTheme == 'education'){
			$fPID = 472;
			$speakerIMG = get_field('small_banner', $fPID); 
			$bannerSize = "-small";
		}else{
			$fPID = 645;
			$rand = rand(1,8);
			$speakerIMG = "http://mlinson.staging.wpengine.com/wp-content/uploads/2013/11/AEH_generalbanner" .$rand . "_222.jpg";
			$bannerSize = "";
			$parents = get_post_ancestors( $post->ID );
			$parent_id = ($parents) ? $parents[count($parents)-1]: 0;
			if($parent_id == 645)
				{$bannerSize = "-small";}
		}

		//$speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($fPID) );
		 $bannerTitle = get_field('bannerTitle');  



		 ?>
 
		<div id="featured-img<?php echo $bannerSize;?>" class="page-single  <?php echo $pageTheme; ?>" style="background-image:url(<?php echo $speakerIMG; ?>); ">
			<div class="container">
				<div id="featured-intro">
					<h3><?php if($bannerTitle != '') echo $bannerTitle; else{ the_title(); }?></h3>
				</div>
			</div>
		</div>
		<div id="content" class="page-single default <?php echo $pageTheme; ?>">
			<div class="container">
				<?php
					if(has_nav_menu('primary-menu')){
						$defaults = array(
							'theme_location'  => 'primary-menu',
							'menu'            => 'primary-menu',
							'container'       => 'div',
							'container_class' => '',
							'container_id'    => 'pageNav',
							'menu_class'      => 'quality',
							'menu_id'         => '',
							'echo'            => true,
							'fallback_cb'     => 'wp_page_menu',
							'before'          => '',
							'after'           => '',
							'link_before'     => '',
							'link_after'      => '',
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 2,
							'walker'          => ''
						); wp_nav_menu( $defaults );
					}
				?>
				<div id="breadcrumbs">
					<ul>
						<li><a href="<?php echo home_url(); ?>">Home</a>
							<?php
							$defaults = array(
							'theme_location'  => 'primary-menu',
							'menu'            => 'primary-menu',
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => 'menu',
							'menu_id'         => '',
							'echo'            => true,
							'fallback_cb'     => 'wp_page_menu',
							'before'          => '',
							'after'           => '',
							'link_before'     => '',
							'link_after'      => '',
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 0,
							'walker'          => ''
						); wp_nav_menu( $defaults ); ?>
						</li>
					</ul>
				</div>
				<div id="contentColumnWrap">
					<div class="graybarright"></div>
					<div class="graybarleft"></div>
					<div id="columnBalance">
						<div id="contentPrimary" class="heightcol">
						<div class="gutter">
							<h1><?php the_title(); ?></h1>
							<?php the_excerpt(); ?>
							<p id="login-lock">You must be an association member to access this page</p>
						</div>
					</div>
						<div id="contentSecondary" class="heightcol">
						<div class="gutter">

						</div>
					</div>
						<div id="contentTertiary" class="heightcol">
						<div class="pagebar"></div>

					</div>
					</div>
				</div>
			</div>
		<?php endwhile; // end of the loop. ?>
		</div>
	<?php } ?>

	<?php }else{
	 while ( have_posts() ) : the_post();
		$pageTheme = get_field('theme');

		if($pageTheme == 'policy'){
			$menu = 'action';
		}elseif($pageTheme == ''){
			$menu = 'general';
		}elseif($pageTheme != 'policy'){
			$menu = $pageTheme;
		}

		//Get featuredIMG
		if($pageTheme == 'policy'){
			$fPID = 62;
			$speakerIMG = get_field('small_banner', $fPID);
			$bannerSize = "-small"; 
		}elseif($pageTheme == 'quality'){
			$fPID = 64;
			$speakerIMG = get_field('small_banner', $fPID); 
			$bannerSize = "-small";
		}elseif($pageTheme == 'institute'){
			$fPID = 621;
			$speakerIMG = get_field('small_banner', $fPID); 
			$bannerSize = "-small";
		}elseif($pageTheme == 'education'){
			$fPID = 472;
			$speakerIMG = get_field('small_banner', $fPID); 
			$bannerSize = "-small";
		}else{
			$fPID = 645;
			$rand = rand(1,8);
			$speakerIMG = "http://mlinson.staging.wpengine.com/wp-content/uploads/2013/11/AEH_generalbanner" .$rand . "_222.jpg";
			$bannerSize = "";
			$parents = get_post_ancestors( $post->ID );
			$chck_id = ($parents) ? $parents[count($parents)-1]: $parent_id;

			if($chck_id == 645)
				{$bannerSize = "";}
		}

		//$speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($fPID) );
		$bannerTitle = get_field('bannerTitle');  



		 ?>
 
		<div id="featured-img<?php echo $bannerSize;?>" class="page-single  <?php echo $pageTheme; ?>" style="background-image:url(<?php echo $speakerIMG; ?>); ">
			<div class="container">
				<div id="featured-intro">
					<h3><?php if($bannerTitle != '') echo $bannerTitle; else{ the_title(); }?></h3>
				</div>
			</div>
		</div>
		<div id="content" class="page-single default <?php echo $pageTheme; ?>">
			<div class="container">
				<?php
					if(has_nav_menu('primary-menu')){
						$defaults = array(
							'theme_location'  => 'primary-menu',
							'menu'            => 'primary-menu',
							'container'       => 'div',
							'container_class' => '',
							'container_id'    => 'pageNav',
							'menu_class'      => 'quality',
							'menu_id'         => '',
							'echo'            => true,
							'fallback_cb'     => 'wp_page_menu',
							'before'          => '',
							'after'           => '',
							'link_before'     => '',
							'link_after'      => '',
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 2,
							'walker'          => ''
						); wp_nav_menu( $defaults );
					}
				?>
				<div id="breadcrumbs">
					<ul>
						<li><a href="<?php echo home_url(); ?>">Home</a>
							<?php
							$defaults = array(
							'theme_location'  => 'primary-menu',
							'menu'            => 'primary-menu',
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => 'menu',
							'menu_id'         => '',
							'echo'            => true,
							'fallback_cb'     => 'wp_page_menu',
							'before'          => '',
							'after'           => '',
							'link_before'     => '',
							'link_after'      => '',
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 0,
							'walker'          => ''
						); wp_nav_menu( $defaults ); ?>
						</li>
					</ul>
				</div>
				<div id="contentColumnWrap">
					<div class="graybarright"></div>
					<div class="graybarleft"></div>
					<div id="columnBalance">
						<div id="contentPrimary" class="heightcol">
						<div class="gutter">
							<h1><?php the_title(); ?></h1>
							<?php the_content(); ?>
						</div>
					</div>
						<div id="contentSecondary" class="heightcol">
						<div class="gutter">
							<?php the_field('secondColumn'); ?>
						</div>
					</div>
						<div id="contentTertiary" class="heightcol">
						<div class="pagebar"></div>
						<?php
							$defaults = array(
								'theme_location'  => 'primary-menu',
								'menu'            => 'primary-menu',
								'container'       => 'div',
								'container_class' => 'page-nav',
								'container_id'    => '',
								'menu_class'      => '',
								'menu_id'         => '',
								'echo'            => true,
								'fallback_cb'     => 'wp_page_menu',
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'depth'           => 0,
								'walker'          => ''
							);
							wp_nav_menu( $defaults );
						?>
						<div class="gutter">
							<?php the_field('thirdColumn'); ?>
						</div>
					</div>
					</div>
				</div>
			</div>
		<?php endwhile; // end of the loop. ?>
		</div><!-- End of Content -->
	<?php } ?>

<?php get_footer(); ?>