<?php
	/* Template Name: Blog */
get_header(); ?>
<div id="featured-img" class="blog" >
	<div class="container">
		<div id="featured-intro">
		<?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>
			<h3>Essential Insights</h3>
			<h4><?php the_field('bannerTitle'); ?></h4>
		</div>
	</div>
</div>
<?php $authorID = get_the_author_id();
	$speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div id="content" class="page-single blog" style="background-image:url(<?php if($speakerIMG){echo $speakerIMG; } ?>);">
	<div class="container">
		<div id="contentColumnWrap">
			<?php } } ?>

			<div id="contentPrimary" class="heightcol">
				<div class="gutter">
					<?php
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => 5,
						'paged' => $paged
					);
					$query = new WP_Query($args);
					if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
						$authorID = get_the_author_id(); ?>
						<div class="blog-post <?php if( $query->current_post == 0 && !is_paged() ) { echo "first-post"; } ?>">
							<div class="gutter">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="blog-postmeta"><span class="item-date"><?php the_time('M j, Y'); ?> || </span><span class="item-comments"><?php comments_number('(0) comments', '(1) comment', '(%) comments')?></span></div>
								<div class="blog-author">
									<div class="blog-author-avatar">
										<?php echo get_avatar( $authorID, 37 ); ?>
									</div>
									<div class="blog-author-details">
										<span class="blog-author-name"><?php the_author(); ?></span>
										<span class="blog-author-bio"><?php the_author_meta('user_description'); ?></span>
									</div>
								</div>
								<div class="blog-excerpt">
									<?php if( $wp_query->current_post == 0 && !is_paged() ) {
										the_content(); }else{ the_excerpt(); } ?>
									<a class="readmore" href="<?php the_permalink(); ?>">read more &raquo;</a>
								</div>
								<div class="blog-tax">
									<span class="blog-cat">
									<?php $categories = get_the_category();
										if($categories){
										$catName = $categories[0]->name;
										$catLink = get_term_link($categories[0]->slug, 'category');
										echo "<a href='$catLink'>$catName</a>";
										}
									?>
									</span>
									<span class="blog-tag"><?php the_tags('',','); ?></span>
								</div>
							</div>
						</div>
					<?php }
						$big = 999999999;
						echo '<div id="blog-pagination">';
						echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $query->max_num_pages
						) );
						echo '</div>';
					} ?>
				</div>
			</div>


			<div id="contentSecondary" class="heightcol">
				<div class="gutter">

					<div class="blog-panel">
						<h4>Categories</h4>
						<div class="gutter">
							<?php $args = array(
								    'orderby'       => 'name',
								    'order'         => 'ASC',
								    'hide_empty'    => true,
								    'exclude'       => array(),
								    'exclude_tree'  => array(94,1,102),
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
								$terms = get_terms('category',$args);
								if($terms){
									echo "<ul>";
									foreach($terms as $term){
										$termLink = get_term_link($term->slug,'category');
										echo "<li><a href='".$termLink."'>".$term->name."</a></li>";
									}
									echo "</ul>";
								}
							?>
						</div>
					</div>

					<div class="blog-panel authors">
						<h4>Authors</h4>
						<div class="gutter">
							<?php $authors = get_all_authors(10);
							if($authors){
							foreach($authors as $author){
								$authName = $author['name'];
								$authID = $author['ID'];
								$authAva = get_avatar( $authID, 37 );
								$authDesc = $author['desc'];
								$authURL = get_author_posts_url($authID);
								$pos = strpos($authDesc, '.');
								$authDesc = substr($authDesc, 0, $pos+1);
								echo "<div class='blog-author'>
										<a href='$authURL'>
										<div class='blog-author-avatar'>
											$authAva
										</div>
										<div class='blog-author-details'>
											<span class='blog-author-name'>
												$authName
											</span>
											<span class='blog-author-bio'>
												$authDesc
											</span>
										</div>
										</a>
									  </div>";
							} } ?>
						</div>
					</div>

				</div>
			</div>
			<div id="contentTertiary" class="heightcol">
				<div class="gutter">
					<div class="blog-btn rss">
						<a href="<?php bloginfo('rss2_url'); ?>">Subscribe Now</a>
					</div>
					<div class="blog-search">
						<?php get_template_part( 'searchform', 'blog' ); ?>
					</div>
					<div class="blog-panel">
						<h4>Share</h4>
						<div class="gutter">
							<div class="blog-social">
								<div>
								<span class='st_facebook_large left' displayText='Facebook'></span>
								<span class='st_twitter_large center' displayText='Tweet'></span>
								<span class='st_googleplus_large right' displayText='Google +'></span>
								</div>
								<div>
								<span class='st_linkedin_large left' displayText='LinkedIn'></span>
								<span class='st_email_large center' displayText='Email'></span>
								<span class='st_sharethis_large right' displayText='Share This'></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer('sans'); ?>