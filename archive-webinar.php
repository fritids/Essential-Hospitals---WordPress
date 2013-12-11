<?php
	get_header();
?>
<?php $speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div id="featured-img" class="education webinar archive" style="background-image:url(<?php echo $speakerIMG; ?>);">
	<div class="container">
		<div id="featured-intro">
			<?php while ( have_posts() ) : the_post(); ?>
				<h3><?php the_field('bannerTitle'); ?></h3>
				<h4><?php the_field('bannerDescription'); ?></h4>
			<?php endwhile; // end of the loop. ?>
		</div>
	</div>
</div>
<div id="contentWrap" class="education webinar archive">
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
						'menu_class'      => 'education',
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
			<div id="breadcrumbs">
				<ul>

					<li><a href="<?php echo site_url(); ?>">Home</a>
						<ul>
							<li><a href="<?php echo get_post_type_archive_link('webinar'); ?>">Institute</a>
								<?php
								if(has_nav_menu('webinar-nav')){
									$defaults = array(
										'theme_location'  => 'webinar-nav',
										'menu'            => 'webinar-nav',
										'container'       => '',
										'container_class' => '',
										'container_id'    => '',
										'menu_class'      => 'institute-breadcrumbs',
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
							</li>
						</ul>
					</li>

				</ul>
			</div>

			<div id="timeFilter">
				<?php if(isset($_GET['timeFilter'])){
						$time = $_GET['timeFilter'];
					}
				?>
				<div id="filterContRight">
					<span class="timePhrase">Filter by Type >></span>
					<div data-time="all" class="timeButton <?php if(!isset($time)){ echo 'active'; } ?>">
						<a>All</a>
					</div>
					<div data-time="future" class="timeButton <?php if($time == 'future'){ echo 'active'; }?>">
						<a>Upcoming Webinars</a>
					</div>
					<div data-time="publish" class="timeButton <?php if($time == 'publish'){ echo 'active'; }?>">
						<a>Recorded Webinars</a>
					</div>
				</div>
			</div>

			<div id="contentPrimary">
				<div class="graybar"></div>
				<div class="gutter clearfix">
					<span class="filterby">Filter By Topic >></span>
					<?php
						$args = array(
						    'orderby'       => 'name',
						    'order'         => 'ASC',
						    'hide_empty'    => false,
						    'exclude'       => array(104),
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
						$terms = get_terms( 'webinartopics', $args );
						if(count($terms) > 0){ ?>
							<ul id="pagefilter" class="webinar" data-query="webinar">
							<?php foreach($terms as $term){ ?>
								<li data-filter="<?php echo $term->slug; ?>"><a><?php echo $term->name; ?></a></li>
							<?php } ?>
								<li class="last"><a>Show All Topics</a></li>
							</ul>
						<?php } ?>
				</div>
			</div>

			<div id="contentSecondary">
				<div class="graybar"></div>
				<div class="gutter clearfix">
					<?php get_template_part( 'partial/template', 'webinarloop' ); ?>
				</div>
			</div>

		</div>
	</div>
</div>
<?php
	get_footer();
?>