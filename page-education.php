<?php get_header();
while ( have_posts() ) : the_post();
$speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div id="featured-img" class="education" style="background-image:url(<?php echo $speakerIMG; ?>);">
	<div class="container">
		<div id="featured-intro">
				<h3><?php the_field('bannerTitle'); ?></h3>
				<h4><?php the_field('bannerDescription'); ?></h4>
			<?php endwhile; // end of the loop. ?>
		</div>
	</div>
</div>

<div id="contentWrap" class="education landing">
	<div class="gutter">
		<div class="container">
			<?php
				if(has_nav_menu('education-nav')){
					$defaults = array(
						'theme_location'  => 'education-nav',
						'menu'            => 'education-nav',
						'container'       => 'div',
						'container_class' => '',
						'container_id'    => 'pageNav',
						'menu_class'      => 'institute',
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

			<div id="contentPrimary">
				<div class="graybar"></div>
				<div class="gutter clearix">
					<div id="institutePostBox">
					<div class="stamp first">

						<?php if(!is_user_logged_in()){ ?>
						<div class="panel signin">
							<div class="gutter">
								<h2>Colleague Sign In</h2>
								<p>Head to your dashboard for information on Leadership summits, meetings, Steering Council resources, data collection portal, and more.</p>
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
						<?php }else{
							$currentUser = get_current_user_id();
							$user_info = get_userdata($currentUser);
							$user_avatar = get_avatar($currentUser);
						?>
						<div class="panel signedin">
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
						</div>
						<?php } ?>

						<div class="panel ask">
							<div class="gutter">
								<h2>Ask a Question</h2>
								<p>Contact our team for more information or with suggestions about our education and training opportunities.</p>
								<?php echo do_shortcode('[formidable id=6]'); ?>
							</div>
						</div>
					</div>

					<div class="stamp">
						<?php
							$args = array(
								'post_type' => array('webinar'),
								'posts_per_page'  => 2,
								'post_status' => 'future'
							);
							$posts = get_posts($args);
							if($posts){ ?>
							<div class="panel upcoming">
								<div class="item-icon">
				    				Upcoming Webinars
				    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-education.png" />
				    			</div>
								<div class="gutter clearfix">
								<?php foreach($posts as $post){
								$postType = get_the_terms($post, 'webinartopics');
								$typeArr = array();
								if($postType){
									foreach($postType as $type){
										array_push($typeArr, $type->slug);
									}
								}
								//check post type and apply a color
								if(in_array('policy', $typeArr)){
									$postColor = 'redd';
								}else if(in_array('quality', $typeArr)){
									$postColor = 'greenn';
								}else if(in_array('education', $typeArr)){
									$postColor = 'grayy';
								}else if(in_array('institute', $typeArr)){
									$postColor = 'bluee';
								}else{
									$postColor = 'bluee';
								}  ?>
								<div class="upcoming-entry">
									<span class="upcoming-title"><a class="<?php echo $postColor; ?>" href="<?php echo $post->guid; ?>"><?php echo $post->post_title; ?></a> || <?php echo date('M j',$post->post_date); ?> at <?php echo date('g:i A T',$post->post_date); ?></span>
									<span class="upcoming-description"><?php echo $post->post_excerpt; ?></span>
									<span class="upcoming-register"><a class="<?php echo $postColor; ?>" href="<?php echo $post->guid; ?>">Register here</a></span>
								</div>
								<?php } ?>
								<a class="readmore" href="<?php echo get_post_type_archive_link('webinar'); ?>">See all upcoming webinars &raquo;</a>
								</div>
							</div>
							<?php } ?>
					</div>

					<?php
					$layoutArray = array('tall','short');
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
								'terms' => array( 'education' )
							)
						)
					);
					$query = new WP_Query($args);
					if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
						$postType = get_post_type( get_the_ID() );
						$rand_key = array_rand($layoutArray, 1); ?>
					<div class="post long columns <?php echo $layoutArray[$rand_key]; ?> announcement <?php echo get_post_type( get_the_ID() ); ?> grayy">
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

					<?php

					$terms = get_terms( 'educationtopics', 'orderby=count&hide_empty=0' );
					$termArr = array();
					foreach($terms as $term){
						array_push($termArr, $term->slug);
					}

					$args = array(
						'post_type'  => array('policy','institute','quality','alert'),
						'tax_query'  => array(
								'relation' => 'OR',
								array(
									'taxonomy' => 'educationtopics',
									'field'    => 'slug',
									'terms'    => $termArr
								)
							)

					);
					$query = new WP_Query($args);
					if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
						$rand_key = array_rand($layoutArray, 1);
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
						}else if($postType == 'alert'){
							$postColor = 'grayy';
						}else{
							$postColor = 'bluee';
						}

						if($postType != 'alert'){
					?>
							<div class="post long columns <?php echo $postColor; ?> <?php echo get_post_type( get_the_ID() ); ?> <?php echo $layoutArray[$rand_key]; ?>">
							<div class="graybarright"></div>
				  			<div class="item-bar"></div>
			    			<div class="item-icon">
			    				<?php
			    				$terms = wp_get_post_terms(get_the_ID(), 'series');
			    					if($postType != 'alert'){
				    					if($terms){
					    					$termLink = get_term_link($terms[0], 'series');
						    				echo "<a href='".$termLink."'>".$terms[0]->name."</a>";
					    				}
				    				}else{
					    				echo 'Updates';
				    				}
			    				?>
			    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-education.png" />
			    				<?php if($postType != 'alert'){ ?>
				    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-<?php echo get_post_type( get_the_ID() ); ?>.png" />
			    				<?php } ?>
			    			</div>
			    			<div class="item-content">
				    			<div class="item-header">
				    				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				    				<span class="item-date"><?php the_time('M j, Y'); ?> ||</span>
				    				<span class="item-author"><?php the_author(); ?></span>
				    			</div>
				    			<p><?php $exc = get_the_excerpt(); echo substr($exc, 0, 100); ?><a class="more" href="<?php the_permalink(); ?>"> read more » </a>
				    			</p>
				    			<div class="item-tags">
				    				<?php the_tags(' ',' ',' '); ?>
				    			</div>
				    		</div>
				    		<div class="bot-border"></div>
				  		</div>
				  	<?php }else{ ?>

					  	<div class="post long columns <?php echo $postColor; ?> <?php echo get_post_type( get_the_ID() ); ?> <?php echo $layoutArray[$rand_key]; ?>">
							<div class="graybarright"></div>
				  			<div class="item-bar"></div>
			    			<div class="item-icon">
			    				<?php
			    				$terms = wp_get_post_terms(get_the_ID(), 'series');
			    					if($postType != 'alert'){
				    					if($terms){
					    					$termLink = get_term_link($terms[0], 'series');
						    				echo "<a href='".$termLink."'>".$terms[0]->name."</a>";
					    				}
				    				}else{
					    				echo 'Updates';
				    				}
			    				?>
			    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-education.png" />
			    				<?php if($postType != 'alert'){ ?>
				    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-<?php echo get_post_type( get_the_ID() ); ?>.png" />
			    				<?php } ?>
			    			</div>
			    			<div class="item-content">
				    			<div class="item-header">
				    				<h2><?php the_title(); ?></h2>
				    			</div>
				    			<p><a href="<?php the_field('link'); ?>"><?php the_field('label'); ?> &raquo;</a></p>
				    		</div>
				    		<div class="bot-border"></div>
				  		</div>

				  	<?php } ?>

					<?php } }else{ echo '<div class="post bluee institute short long columns">
						<div class="graybarright"></div>
						<div class="item-bar"></div>
						<div class="item-icon">No Posts <img src="'.get_bloginfo('template_directory').'/images/icon-institute.png" /></div>
						<div class="item-content">
							<h2>No Posts Found</h2>
							<p>check back often, there is more to come</p>
						</div>
						<div class="bot-border"></div>
					</div>'; } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>