<?php get_header();
	global $post;
	$postSt = $post->post_status;
	$current_user = wp_get_current_user();
	$cUID = $current_user->ID;
	$cUStaff = get_user_meta($cUID,'staff_mem',true);
	if($postSt == 'private'){
		if($cUID == 'Y'){ ?>
				<?php while ( have_posts() ) : the_post();
	$speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	$postID     = get_the_ID();
	$postType   = get_post_type($postID);
	if($postType == 'policy'){
		$bannerTitle = '<span class="redd">ACTION</span><br>';
		$bannerDesc  = get_field('bannerTitle',62);
		$bannerImg   = get_the_post_thumbnail(62,'full');
	}elseif($postType == 'quality'){
		$bannerTitle = '<span class="greenn">GREEN</span><br>';
		$bannerDesc  = get_field('bannerTitle',64);
		$bannerImg   = get_the_post_thumbnail(64,'full');
	}elseif($postType == 'institute'){
		$bannerTitle = '<span class="bluee">INSTITUTE</span><br>';
		$bannerDesc  = 'Elevate Care with Sound Advice';
	}else{
		$bannerTitle = the_title();
		$bannerDesc  = '';
	} ?>
<div id="featured-img" class="<?php echo get_post_type($postID); ?>">
	<div class="container">
		<div id="featured-intro">
			<h3><?php echo $bannerTitle; echo $bannerDesc; ?></h3>
			<?php endwhile; // end of the loop. ?>
		</div>
	</div>
</div>
<div id="content" class="single <?php echo get_post_type($postID); ?>">
	<div class="container">
		<?php
			if($postType == 'policy'){
				if(has_nav_menu('action-nav')){
					$defaults = array(
						'theme_location'  => 'action-nav',
						'menu'            => 'action-nav',
						'container'       => 'div',
						'container_class' => '',
						'container_id'    => 'pageNav',
						'menu_class'      => 'action',
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
			}elseif($postType == 'quality'){
				if(has_nav_menu('quality-nav')){
					$defaults = array(
						'theme_location'  => 'quality-nav',
						'menu'            => 'quality-nav',
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
			}elseif($postType == 'institute'){
				if(has_nav_menu('institute-nav')){
					$defaults = array(
						'theme_location'  => 'institute-nav',
						'menu'            => 'institute-nav',
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
			}else{
				echo '<div id="pageNav"></div>';
			} ?>
		<div id="contentPrimary">
			<div class="gutter">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<div id="printbtn" href="javascript:print();">Print</div>
				<div id="postmeta">
					<span class="postmeta"><?php the_time('F, j'); ?> || <em><?php the_author(); ?></em></span> <span class="postcomments"><?php comments_number( '(0) comments', '(1) comment', '(%) comments' ); ?></span>
				<div id="topics">
					<div class="item-tags">
	    				<?php the_tags(' ',' ',' '); ?>
	    			</div>
				</div>
				</div>
				<?php the_post_thumbnail(); ?>
				<div class="postcontent">
					<?php the_content(); ?>
				</div>

			</div>
		</div>
		<div id="contentSecondary">
			<div class="gutter clearfix">
				<div class="panel">
				<h3>Related Articles</h3>
				<?php
				$orig_post = $post;
				global $post;
				$tags = wp_get_post_tags($post->ID);

				if ($tags) {
				$tag_ids = array();
				foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
				$args = array(
					'tag__in'              => $tag_ids,
					'post__not_in'         => array($post->ID),
					'post_count'           => 3,
					'ignore_sticky_posts'  => 1,
					'post_type'            => array('post','quality','institute','policy'),
					'posts_per_page'	   => 3
				);

				$my_query = new wp_query( $args );

				while( $my_query->have_posts() ) {
				$my_query->the_post();
				?>
					<div class="post <?php echo get_post_type(get_the_id()); ?>">
						<h4 class="<?php echo get_post_type(get_the_id()); ?>"><a class="<?php echo get_post_type(get_the_id()); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<span class="author"><?php the_author(); ?></span>
						<a class="more" href="<?php the_permalink(); ?>">More free resources for health care professionals &raquo;</a>
					</div>
				<? }  }
				$post = $orig_post;
				wp_reset_query(); ?>

				</div>
				<?php if(get_field('links')){ ?>
				<div class="panel">
				<h3>External Links</h3>
				<?php $links = get_field('links');
					if($links){
						foreach($links as $link){ ?>
							<div class="post">
								<h4><a href="<?php echo $link['link']; ?>"><?php echo $link['heading']; ?></a></h4>
								<span class="author"><?php echo $link['source']; ?></span>
								<a class="more" href="<?php echo $link['link']; ?>"><?php echo $link['label']; ?></a>
							</div>
				<?php } } } ?>
				</div>
			</div>
		</div>
		<div id="contentTertiary">
			<div class="gutter clearfix">
				<div class="panel">
					<h3>Share</h3>
					<div id="share">
						<span class='st_facebook' displayText='Facebook'></span>
						<span class='st_twitter' displayText='Tweet'></span>
						<span class='st_email' displayText='Email'></span>
						<span class='st_sharethis' displayText='ShareThis'></span>
					</div>
				</div>
				<div class="panel">
					<h3>About the Author</h3>
					<p><?php the_author_description(); ?></p>
				</div>
				<?php if(get_field('notes')){ ?>
				<div class="panel">
					<h3>Notes</h3>
					<p><?php echo get_field('notes'); ?></p>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php endwhile; ?>
</div><!-- End of Content -->
		<?php }else{ ?>
			<div>private</div>
		<?php }
	}else{ ?>
			<?php while ( have_posts() ) : the_post();
	$speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	$postID     = get_the_ID();
	$postType   = get_post_type($postID);
	if($postType == 'policy'){
		$bannerTitle = '<span class="redd">ACTION</span><br>';
		$bannerDesc  = get_field('bannerTitle',62);
		$bannerImg   = get_the_post_thumbnail(62,'full');
	}elseif($postType == 'quality'){
		$bannerTitle = '<span class="greenn">GREEN</span><br>';
		$bannerDesc  = get_field('bannerTitle',64);
		$bannerImg   = get_the_post_thumbnail(64,'full');
	}elseif($postType == 'institute'){
		$bannerTitle = '<span class="bluee">INSTITUTE</span><br>';
		$bannerDesc  = 'Elevate Care with Sound Advice';
	}else{
		$bannerTitle = the_title();
		$bannerDesc  = '';
	} ?>
<div id="featured-img" class="<?php echo get_post_type($postID); ?>">
	<div class="container">
		<div id="featured-intro">
			<h3><?php echo $bannerTitle; echo $bannerDesc; ?></h3>
			<?php endwhile; // end of the loop. ?>
		</div>
	</div>
</div>
<div id="content" class="single <?php echo get_post_type($postID); ?>">
	<div class="container">
		<?php
			if($postType == 'policy'){
				if(has_nav_menu('action-nav')){
					$defaults = array(
						'theme_location'  => 'action-nav',
						'menu'            => 'action-nav',
						'container'       => 'div',
						'container_class' => '',
						'container_id'    => 'pageNav',
						'menu_class'      => 'action',
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
			}elseif($postType == 'quality'){
				if(has_nav_menu('quality-nav')){
					$defaults = array(
						'theme_location'  => 'quality-nav',
						'menu'            => 'quality-nav',
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
			}elseif($postType == 'institute'){
				if(has_nav_menu('institute-nav')){
					$defaults = array(
						'theme_location'  => 'institute-nav',
						'menu'            => 'institute-nav',
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
			}else{
				echo '<div id="pageNav"></div>';
			} ?>
		<div id="contentPrimary">
			<div class="gutter">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<div id="postmeta">
					<span class="postmeta"><?php the_time('F, j'); ?> || <em><?php the_author(); ?></em></span> <span class="postcomments"><?php comments_number( '(0) comments', '(1) comment', '(%) comments' ); ?></span>
				<div id="topics">
					<div class="item-tags">
	    				<?php the_tags(' ',' ',' '); ?>
	    			</div>
				</div>
				</div>
				<?php the_post_thumbnail(); ?>
				<div class="postcontent">
					<?php the_content(); ?>
				</div>

			</div>
		</div>
		<div id="contentSecondary">
			<div class="gutter clearfix">
				<div class="panel">
				<h3>Related Articles</h3>
				<?php
				$orig_post = $post;
				global $post;
				$tags = wp_get_post_tags($post->ID);

				if ($tags) {
				$tag_ids = array();
				foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
				$args = array(
					'tag__in'              => $tag_ids,
					'post__not_in'         => array($post->ID),
					'post_count'           => 3,
					'ignore_sticky_posts'  => 1,
					'post_type'            => array('post','quality','institute','policy'),
					'posts_per_page'	   => 3
				);

				$my_query = new wp_query( $args );

				while( $my_query->have_posts() ) {
				$my_query->the_post();
				?>
					<div class="post <?php echo get_post_type(get_the_id()); ?>">
						<h4 class="<?php echo get_post_type(get_the_id()); ?>"><a class="<?php echo get_post_type(get_the_id()); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<span class="author"><?php the_author(); ?></span>
						<a class="more" href="<?php the_permalink(); ?>">More free resources for health care professionals &raquo;</a>
					</div>
				<? }  }
				$post = $orig_post;
				wp_reset_query(); ?>

				</div>

				<div class="panel">
				<h3>External Links</h3>
				<?php $links = get_field('links');
					if($links){
						foreach($links as $link){ ?>
							<div class="post">
								<h4><a href="<?php echo $link['link']; ?>"><?php echo $link['heading']; ?></a></h4>
								<span class="author"><?php echo $link['source']; ?></span>
								<a class="more" href="<?php echo $link['link']; ?>"><?php echo $link['label']; ?></a>
							</div>
				<?php } } ?>
				</div>
			</div>
		</div>
		<div id="contentTertiary">
			<div class="gutter clearfix">
				<div class="panel">
					<h3>Share</h3>
					<div id="share">
						<span class='st_facebook' displayText='Facebook'></span>
						<span class='st_twitter' displayText='Tweet'></span>
						<span class='st_email' displayText='Email'></span>
						<span class='st_sharethis' displayText='ShareThis'></span>
					</div>
				</div>
				<div class="panel">
					<h3>About the Author</h3>
					<p><?php the_author_description(); ?></p>
				</div>
				<div class="panel">
					<h3>Notes</h3>
					<p><?php echo get_field('notes'); ?></p>
				</div>
			</div>
		</div>
	</div>
<?php endwhile; ?>
</div><!-- End of Content -->
	<?php } ?>


<?php get_footer(); ?>