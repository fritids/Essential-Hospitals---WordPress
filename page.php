<?php get_header();
	global $post;
	$postSt = $post->post_status;
	$current_user = wp_get_current_user();
	$cUID = $current_user->ID;
	$cUStaff = get_user_meta($cUID,'staff_mem',true);
	if($postSt == 'private'){
		if($cUStaff == 'Y'){ ?>
			<?php while ( have_posts() ) : the_post();
		$pageTheme = get_field('theme');

		if($pageTheme == 'policy'){
			$menu = 'action';
		}elseif($pageTheme != 'policy'){
			$menu = $pageTheme;
		}elseif(!$pageTheme){
			$menu = 'general';
		}

		$speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
		<div id="featured-img" class="page-single <?php echo $pageTheme; ?>" style="background-image:url(<?php echo $speakerIMG; ?>);">
			<div class="container">
				<div id="featured-intro">
					<h3><?php the_title(); ?></h3>
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
						<div class="gutter">
							<?php
								if(has_nav_menu('general-nav')){
									$defaults = array(
										'theme_location'  => 'general-nav',
										'menu'            => 'general-nav',
										'container'       => 'div',
										'container_class' => 'panel subnav',
										'container_id'    => '',
										'menu_class'      => '',
										'menu_id'         => '',
										'echo'            => true,
										'fallback_cb'     => 'wp_page_menu',
										'before'          => '',
										'after'           => '',
										'link_before'     => '',
										'link_after'      => '',
										'items_wrap'      => '<div class="gutter"><ul id="%1$s" class="%2$s">%3$s</ul></div>',
										'depth'           => 0,
										'walker'          => ''
									);
									wp_nav_menu( $defaults );
								}
							?>
							<?php the_field('thirdColumn'); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; // end of the loop. ?>
		</div><!-- End of Content -->
	<?php }else{ ?>
		<div>Private</div>
	<?php } ?>

	<?php }else{ ?>
		<?php while ( have_posts() ) : the_post();
		$pageTheme = get_field('theme');

		if($pageTheme == 'policy'){
			$menu = 'action';
		}elseif($pageTheme == ''){
			$menu = 'general';
		}elseif($pageTheme != 'policy'){
			$menu = $pageTheme;
		}

		$speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
		<div id="featured-img" class="page-single <?php echo $pageTheme; ?>" style="background-image:url(<?php echo $speakerIMG; ?>);">
			<div class="container">
				<div id="featured-intro">
					<h3><?php the_title(); ?></h3>
				</div>
			</div>
		</div>
		<div id="content" class="page-single default <?php echo $pageTheme; ?>">
			<div class="container">
				<?php
					if(has_nav_menu($menu.'-nav')){
						$defaults = array(
							'theme_location'  => $menu.'-nav',
							'menu'            => $menu.'-nav',
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
						<div class="gutter">
							<?php
								if(has_nav_menu('general-nav')){
									$defaults = array(
										'theme_location'  => 'general-nav',
										'menu'            => 'general-nav',
										'container'       => 'div',
										'container_class' => 'panel subnav',
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
								}
							?>
							<?php the_field('thirdColumn'); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; // end of the loop. ?>
		</div><!-- End of Content -->
	<?php } ?>

<?php get_footer(); ?>