<?php
	/* Template Name: Institute */
	get_header();
?>

<?php if ( have_posts() ) { while ( have_posts() ) { the_post();
	$speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div id="featured-img" class="institute" style="background-image:url(<?php echo $speakerIMG; ?>);">
	<div class="container">
		<div id="featured-intro">
			<h3><span class="bluee">ESSENTIAL HOSPITALS INSTITUTE</span><br><?php the_field('bannerTitle'); ?></h3>
		</div>
	</div>
</div>
<?php } } ?>
<!--<script src="<?php bloginfo('template_directory'); ?>/js/infinite.js"></script>!-->
<div id="contentWrap" class="institute">
	<div class="gutter">
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
			<?php
			$args = array(
			    'orderby'       => 'id',
			    'order'         => 'DESC',
			    'hide_empty'    => false,
			    'exclude'       => array(),
			    'exclude_tree'  => array(),
			    'include'       => array(),
			    'number'        => '',
			    'fields'        => 'all',
			    'slug'          => '',
			    'parent'         => '',
			    'hierarchical'  => true,
			    'child_of'      => 0,
			    'get'           => '',
			    'name__like'    => '',
			    'pad_counts'    => false,
			    'offset'        => '',
			    'search'        => '',
			    'cache_domain'  => 'core'
			);
			$terms = get_terms('centers', $args); ?>
			<div id="instituteCenters" class="num<?php echo count($terms); ?>">
				<?php foreach($terms as $term){
					$term_link = get_term_link($term, 'centers'); ?>
					<div class="center">
						<a class="clearfix" href="<?php echo $term_link; ?>">
							<div class="gutter clearfix">
								<span class="next"><img src="<?php bloginfo('template_directory'); ?>/images/instituteArrows.png" /></span>
								<h4><?php echo $term->name; ?></h4>
								<p><?php echo $term->description; ?></p>
							</div>
						</a>
					</div>
				<?php } ?>
			</div>

			<div id="contentPrimary">
				<div class="graybar"></div>
				<div class="graybarX"></div>
				<div class="gutter clearfix">
					<div id="institutePostBox" class="infinite" data-center="">

					<?php
					$args = array(
						'post_type' => 'alert',
						'orderby'   => 'date',
						'order'     => 'asc',
						'tax_query' => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'category',
								'field'    => 'slug',
								'terms'    => array( 'announcements' )
							),
							array(
								'taxonomy' => 'category',
								'field'    => 'slug',
								'terms'    => array( 'institute' )
							),
							array(
								'taxonomy' => 'category',
								'field'    => 'slug',
								'terms'    => array( 'updates' ),
								'operator' => 'NOT IN'
							)
						)
					);
					$query = new WP_Query($args);
					if ( $query->have_posts() ) {
					echo '<div class="stamp first">';
					while ( $query->have_posts() ) { $query->the_post(); ?>
						<div class="panel announcement stamp">
							<div class="bottombar"></div>
							<div class="next"><img src="<?php bloginfo('template_directory'); ?>/images/instituteAnnouncement.png" /></div>
							<div class="gutter">
								<h2><?php the_field('heading'); ?></h2>
								<a href="<?php the_field('link'); ?>"><?php the_field('label'); ?> &raquo;</a>
							</div>
						</div>
					<?php }
					echo '</div>'; } wp_reset_query(); ?>


					<?php
						$args = array(
						    'orderby'       => 'count',
						    'order'         => 'ASC',
						    'hide_empty'    => false,
						    'exclude'       => array(),
						    'exclude_tree'  => array(),
						    'include'       => array(),
						    'number'        => '',
						    'fields'        => 'all',
						    'slug'          => '',
						    'parent'        => '',
						    'hierarchical'  => true,
						    'child_of'      => 0,
						    'get'           => '',
						    'name__like'    => '',
						    'pad_counts'    => false,
						    'offset'        => '',
						    'search'        => '',
						    'cache_domain'  => 'core'
						);
						$terms = get_terms('institutetopics', $args);
						if($terms){ ?>
						<div class="stamp">
							<div class="panel topics">
								<div class="gutter">
									<h2>Top Issues and Topics</h2>
									<div class="whitebar"></div>
									<ul>
									<?php foreach($terms as $term){ ?>
										<li><a href="<?php echo get_term_link($term, 'institutetopics')?>"><?php echo $term->name; ?></a></li>
									<?php } ?>
									</ul>
								</div>
							</div>
						</div>
					<?php } ?>

					<div class="panel white post short fluid stamp">
						<div class="graybarright"></div>
						<div class="item-bar bluee"></div>
						<div class="item-icon bluee">Webinars
						<img src="<?php bloginfo('template_directory'); ?>/images/icon-education.png" />
						<img src="<?php bloginfo('template_directory'); ?>/images/icon-institute.png" /></div>
						<?php $args = array(
								'post_type'       => 'webinar',
								'posts_per_page'  => 4,
								'post_status'     => 'future',
								'tax_query' 	  => array(
										array(
											'taxonomy' => 'webinartopics',
											'field' => 'slug',
											'terms' => 'institute'
										)
									)
								);
						$query = new WP_Query($args);
						if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
						$postType = get_the_terms($post, 'webinartopics');
						$typeArr = array();
						foreach($postType as $type){
							array_push($typeArr, $type->slug);
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
						} ?>
							<div class="entry webinar">
								<div class="gutter clearfix">
									<div class="entry-lock <?php echo $postColor; ?>">
										<div class="lock"></div>
									</div>
									<div class="entry-content">
										<p><span class="title <?php echo $postColor; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span> | <span class="date"><?php the_time('M j, g A'); ?></span> | <span class="excerpt"><?php $exc = get_the_excerpt(); echo substr($exc, 0, 50); ?></span></p>
										<a class="readmore bluee" href="<?php the_permalink(); ?>">Colleague only resource. Sign in to register &raquo;</a>
									</div>
								</div>
							</div>
						<?php }
						echo '<a class="readmore" href="'.get_post_type_archive_link('webinar').'/?timeFilter=future">All Upcoming Webinars &raquo;</a>';
						}else{
							echo '<p>No Upcoming Webinars</p>';
						} ?>
						<div class="bot-border"></div>
					</div>


					<?php
					$args = array(
						'post_type'  => 'institute',
						'posts_per_page' => 1,
						'series' => 'publications'
					);
					$query = new WP_Query($args);
					$layoutArray = array('tall','short');
					if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
						$rand_key = array_rand($layoutArray, 1);
					?>
							<div class="post long columns fluid clearfix <?php echo $layoutArray[$rand_key]; ?> bluee institute">
								<div class="graybarright"></div>
					  			<div class="item-bar"></div>
				    			<div class="item-icon">
				    				<?php $terms = wp_get_post_terms(get_the_ID(), 'series');
				    					if($terms){
					    					$termLink = get_term_link($terms[0], 'series');
						    				echo "<a href='".$termLink."'>".$terms[0]->name."</a>";
					    				}
				    				?>
									<?php if($postType != 'post'){ ?>
					    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-institute.png" />
				    				<?php } ?>
				    			</div>
				    			<div class="item-content">
					    			<div class="item-header">
					    				<h2><a href="<?php if(get_field('link_to_media')){the_field('uploaded_file');}else{the_permalink();} ?>"><?php the_title(); ?></a></h2>
					    				<span class="item-date"><?php the_time('M j, Y'); ?> ||</span>
					    				<span class="item-author"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>/?prof=article"><?php the_author(); ?></a></span>
					    			</div>
					    			<?php if(get_field('link_to_media')){ ?>
										<a href="<?php the_field('uploaded_file'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/institute-doc.png" /></a>
									<?php }else{ ?>
										<p><?php $exc = get_the_excerpt(); echo $exc; ?><a class="more" href="<?php the_permalink(); ?>"> view more » </a></p>
									<?php } ?>
					    			<div class="item-tags">
					    				<?php the_tags(' ',' ',' '); ?>
					    			</div>
					    		</div>
					    		<div class="bot-border"></div>
					  		</div>

					<?php } } ?>

					<?php
					$args = array(
						'post_type'  => 'institute',
						'posts_per_page' => 1,
						'series' => 'ehen-outcomes'
					);
					$query = new WP_Query($args);
					$layoutArray = array('tall','short');
					if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
						$rand_key = array_rand($layoutArray, 1);
					?>
							<div class="post long columns fluid clearfix <?php echo $layoutArray[$rand_key]; ?> bluee institute">
								<div class="graybarright"></div>
					  			<div class="item-bar"></div>
				    			<div class="item-icon">
				    				<?php $terms = wp_get_post_terms(get_the_ID(), 'series');
				    					if($terms){
					    					$termLink = get_term_link($terms[0], 'series');
						    				echo "<a href='".$termLink."'>".$terms[0]->name."</a>";
					    				}
				    				?>
									<?php if($postType != 'post'){ ?>
					    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-institute.png" />
				    				<?php } ?>
				    			</div>
				    			<div class="item-content">
					    			<div class="item-header">
					    				<h2><a href="<?php if(get_field('link_to_media')){the_field('uploaded_file');}else{the_permalink();} ?>"><?php the_title(); ?></a></h2>
					    				<span class="item-date"><?php the_time('M j, Y'); ?> ||</span>
					    				<span class="item-author"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>/?prof=article"><?php the_author(); ?></a></span>
					    			</div>
					    			<?php if(get_field('link_to_media')){ ?>
										<a href="<?php the_field('uploaded_file'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/institute-doc.png" /></a>
									<?php }else{ ?>
										<p><?php $exc = get_the_excerpt(); echo $exc; ?><a class="more" href="<?php the_permalink(); ?>"> view more » </a></p>
									<?php } ?>
					    			<div class="item-tags">
					    				<?php the_tags(' ',' ',' '); ?>
					    			</div>
					    		</div>
					    		<div class="bot-border"></div>
					  		</div>

					<?php } } ?>


					<?php
					$args = array(
						'post_type'  => 'institute',
						'posts_per_page' => -1,
						'meta_query' => array(
							array(
								'key' => 'sticky_topic',
								'value' => 'institute'
							)
						)
					);
					$query = new WP_Query($args);
					$layoutArray = array('tall','short');
					if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
						$rand_key = array_rand($layoutArray, 1);
					?>
							<div class="post long columns fluid clearfix <?php echo $layoutArray[$rand_key]; ?> bluee institute">
								<div class="graybarright"></div>
					  			<div class="item-bar"></div>
				    			<div class="item-icon">
				    				<?php $terms = wp_get_post_terms(get_the_ID(), 'series');
				    					if($terms){
					    					$termLink = get_term_link($terms[0], 'series');
						    				echo "<a href='".$termLink."'>".$terms[0]->name."</a>";
					    				}
				    				?>
									<?php if($postType != 'post'){ ?>
					    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-institute.png" />
				    				<?php } ?>
				    			</div>
				    			<div class="item-content">
					    			<div class="item-header">
					    				<h2><a href="<?php if(get_field('link_to_media')){the_field('uploaded_file');}else{the_permalink();} ?>"><?php the_title(); ?></a></h2>
					    				<span class="item-date"><?php the_time('M j, Y'); ?> ||</span>
					    				<span class="item-author"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>/?prof=article"><?php the_author(); ?></a></span>
					    			</div>
					    			<?php if(get_field('link_to_media')){ ?>
										<a href="<?php the_field('uploaded_file'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/institute-doc.png" /></a>
									<?php }else{ ?>
										<p><?php $exc = get_the_excerpt(); echo $exc; ?><a class="more" href="<?php the_permalink(); ?>"> view more » </a></p>
									<?php } ?>
					    			<div class="item-tags">
					    				<?php the_tags(' ',' ',' '); ?>
					    			</div>
					    		</div>
					    		<div class="bot-border"></div>
					  		</div>

					<?php } } ?>



					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<?php
	get_footer();
?>