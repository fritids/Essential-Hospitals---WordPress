<?php get_header();
	if ( have_posts() ) { while ( have_posts() ) { the_post();  ?>

	<?php $speakerIMG = wp_get_attachment_url( get_post_thumbnail_id(472) ); ?>
<div id="membernetwork" class="mnbanner">

	<div id="featured-img" class="page-single education" style="background-image:url(<?php echo $speakerIMG; ?>); ">
		<div class="container">
			<div id="featured-intro">
				<!--<h3><?php if($bannerTitle != '') echo $bannerTitle; else{ the_title(); }?></h3>-->
				<h3><span class="grey">EDUCATION</span> <br/> <?php the_title(); ?></h3>
			</div>
		</div>
	</div>


	<div class="container">
		<?php
			$memberArray = array();
			$currentUser = get_current_user_id();
			$members = get_post_meta($post->ID, 'autp');
				foreach($members as $member){
					foreach($member as $user){
						$id = $user['user_id'];
						array_push($memberArray,$id);
					}  }
				if (in_array($currentUser, $memberArray)) {
				    $checker = true;
				}else{
					$checker = false;
				}
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

		<div id="membercontent" class="group groupcont">
			<div class="graybarleft"></div>
			<div class="graybarright"></div>
			<div class="gutter clearfix">
				<div class="group-details groupcol">
					<div class="panel description">
						<h2 class="heading"><?php the_title(); ?></h2>
							<div class="gutter">
								<?php
								$today = mktime(0, 0, 0, date('n'), date('j'));
								$webDate = get_post_meta($post->ID,'webinar_date',true);

								if(is_user_logged_in() && $checker == true && $today < $webDate){
									the_content();
									echo '<span class="education reserve button single-webinar"><a href="'.get_field('registration_link').'">Reserve Your Spot</a></span>';
								}else{
									echo "<p>";
									the_field('teaser');
									echo "</p>";
									echo "<h4>You have not registered for this webinar.</h4>";
								}
								?>
							</div>
					</div>
					<?php if(is_user_logged_in() && $checker == true){
						  get_template_part('membernetwork/content','groupdiscussion'); } ?>
					</div>

				<div class="group-members groupcol">
					<div class="panel">
						<h2 class="heading">Webinar Attendees</h2>
						<?php get_template_part('membernetwork/content','groupmembers'); ?>
					</div>
					<?php if(is_user_logged_in() && $checker == true || $today > $webDate){
					if(get_field('middle_column')){ while(has_sub_field('middle_column')){ ?>
						<div class="panel colrepeat">
							<h2 class="heading"><?php the_sub_field('title'); ?></h2>
							<div class="gutter">
								<?php the_sub_field('content'); ?>
							</div>
						</div>
					<?php } } } ?>

				</div>

				<div class="group-resources groupcol">
					<?php if(is_user_logged_in() && $checker == true){
						$currentUser = get_current_user_id();
						$user_info = get_userdata($currentUser);
						$user_avatar = get_avatar($currentUser); ?>
						<div id="userProfile">
							<div class="gutter clearfix">
								<div id="userAvatar" class="clearfix">
									<div class="group-memberavatar">
										<span class="group-membername"><?php echo $user_info->user_firstname.' ' .$user_info->user_lastname; ?></span>
										<a href="<?php echo get_permalink(274); ?>"><?php echo $user_avatar; ?></a>
									</div>
								</div>
								<div id="userInfo">
									<span class="uinfo fName"><?php echo $user_info->user_firstname; ?></span>
									<span class="uinfo jobTitle"><?php echo $user_info->job_title; ?></span>
									<span class="uinfo org"><?php echo $user_info->employer; ?></span>
									<span class="uinfo hosp">Hospital Name</span>
									<span class="uinfo email"><a href="mailto:<?php echo $user_info->user_email; ?>"><?php echo $user_info->user_email; ?></a></span>
								</div>
								<div id="userMeta">
									<ul class="social">
										<?php if ($user_info->linkedin) { ?>
											<li class="linkedin"><a href="<?php echo $user_info->linkedin; ?>">linkedin</a></li>
										<?php } ?>
										<?php if ($user_info->twitter) { ?>
											<li class="twitter"><a href="<?php echo $user_info->twitter; ?>">twitter</a></li>
										<?php } ?>
										<?php if ($user_info->facebook) { ?>
											<li class="facebook"><a href="<?php echo $user_info->facebook; ?>">facebook</a></li>
										<?php } ?>
										<li class="mail"><a href="mailto:<?php echo $user_info->user_email; ?>">mail</a></li>
									</ul>
									<span class="edit"><a href="<?php echo get_permalink(274); ?>?a=edit">[edit profile]</a></span>
								</div>
							</div>
						</div>

						<?php if(get_field('right_column')){ while(has_sub_field('right_column')){ ?>
							<div class="panel colrepeat">
								<h2 class="heading"><?php the_sub_field('title'); ?></h2>
								<div class="gutter">
									<?php the_sub_field('content'); ?>
								</div>
							</div>
						<?php }
						} ?>
					<?php }elseif(is_user_logged_in() && $checker == false){
						$currentUser = get_current_user_id();
						$user_info = get_userdata($currentUser);
						$user_avatar = get_avatar($currentUser); ?>
						<div id="userProfile">
							<div class="gutter clearfix">
								<div id="userAvatar" class="clearfix">
									<div class="group-memberavatar">
										<span class="group-membername"><?php echo $user_info->user_firstname.' ' .$user_info->user_lastname; ?></span>
										<a href="<?php echo get_permalink(274); ?>"><?php echo $user_avatar; ?></a>
									</div>
								</div>
								<div id="userInfo">
									<span class="uinfo fName"><?php echo $user_info->user_firstname; ?></span>
									<span class="uinfo jobTitle"><?php echo $user_info->job_title; ?></span>
									<span class="uinfo org"><?php echo $user_info->employer; ?></span>
									<span class="uinfo hosp">Hospital Name</span>
									<span class="uinfo email"><a href="mailto:<?php echo $user_info->user_email; ?>"><?php echo $user_info->user_email; ?></a></span>
								</div>
								<div id="userMeta">
									<ul class="social">
										<?php if ($user_info->linkedin) { ?>
											<li class="linkedin"><a href="<?php echo $user_info->linkedin; ?>">linkedin</a></li>
										<?php } ?>
										<?php if ($user_info->twitter) { ?>
											<li class="twitter"><a href="<?php echo $user_info->twitter; ?>">twitter</a></li>
										<?php } ?>
										<?php if ($user_info->facebook) { ?>
											<li class="facebook"><a href="<?php echo $user_info->facebook; ?>">facebook</a></li>
										<?php } ?>
										<li class="mail"><a href="mailto:<?php echo $user_info->user_email; ?>">mail</a></li>
									</ul>
									<span class="edit"><a href="<?php echo get_permalink(274); ?>?a=edit">[edit profile]</a></span>
								</div>
							</div>
						</div>




					<?php if($today > $webDate){ ?>
						<?php if(get_field('right_column')){ while(has_sub_field('right_column')){ ?>
							<div class="panel colrepeat">
								<h2 class="heading"><?php the_sub_field('title'); ?></h2>
								<div class="gutter">
									<?php the_sub_field('content'); ?>
								</div>
							</div>
						<?php } ?>
					<?php } } ?>





					<?php }else{ ?>
						<div class="panel signin">
							<div class="gutter">
								<h2>Sign In</h2>
								<p>Sign in to register for this webinar</p>
								 <?php $args = array(
						        'echo' => true,
						        'redirect' => site_url( $_SERVER['REQUEST_URI'] ),
						        'form_id' => 'loginform',
						        'label_username' => __( 'Username' ),
						        'label_password' => __( 'Password' ),
						        'label_remember' => __( 'Remember Me' ),
						        'label_log_in' => __( '&raquo;' ),
						        'id_username' => 'user_login',
						        'id_password' => 'user_pass',
						        'id_remember' => 'rememberme',
						        'id_submit' => 'wp-submit',
						        'remember' => false,
						        'value_username' => NULL,
						        'value_remember' => false );
						        wp_login_form($args); ?>
							</div>
						</div>




						<?php if($today > $webDate){ ?>
						<?php if(get_field('right_column')){ while(has_sub_field('right_column')){ ?>
							<div class="panel colrepeat">
								<h2 class="heading"><?php the_sub_field('title'); ?></h2>
								<div class="gutter">
									<?php the_sub_field('content'); ?>
								</div>
							</div>
						<?php } ?>
					<?php } } ?>




					<?php } ?>
				</div>
			</div>
		</div>


		</div>
	</div>

<?php } } get_footer('sans'); ?>