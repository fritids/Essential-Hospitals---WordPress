<div id="membernetwork">
	<div class="container">
		<h1 class="title"><span class="grey">Essential Hospitals</span> Member Network | Discussions</h1>
		
		<?php get_template_part('membernetwork/content','usernav'); ?>
		
		<?php $memberArray = array();
			$currentUser = get_current_user_id(); ?>
					
		<?php if(is_user_logged_in()){ ?>
		
		<div id="membercontent" class="group">
			<div class="gutter clearfix">
				<h2 class="heading">Discussions</h2>
				<div class="onefourth disc-dashboard">
					<div class="panel">
						<div class="gutter clearfix">
							<?php get_template_part('membernetwork/searchform','discussion'); ?>
						</div>
					</div>
					<div class="panel date">
						<div class="gutter clearfix">
							<span class="bump sortdate">Sort by Date &raquo;</span>
						</div>
					</div>
					<div class="panel topic">
						<div class="gutter clearfix">
							<p class="topic"><strong>POPULAR TOPICS</strong></p>
								<ul id="discussiontags">
							 <?php $tags = wp_tag_cloud( array( 'taxonomy' => 'discussion_tags', 'orderby' => 'count', 'format' => 'array', 'smallest' => 11, 'largest' => 11, 'unit' => 'px' ) );  
								 foreach($tags as $tag){ ?>
								 	<li><?php echo $tag; ?></li>
								 <?php } ?> 
								</ul>
						</div>
					</div>
				</div>
				<div class="threefourth disc-content">
					<div class="panel">
						<div class="gutter clearfix">
							<?php $s = get_query_var('s'); ?>
							<h2 class="heading quality">Discussion Search for "<?php echo $s; ?>"</h2>
							<div id="wrapDisc">
								<?php 
									$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
									$postType = get_query_var('post_type');
									query_posts("s=$s&paged=$page&post_type=$postType");
								if ( have_posts() ) : ?>
									<div class="panel post">
										<div class="gutter">
											<h3><?php printf( __( 'Search Results for %s' ), '<span class="italic">' . get_search_query() . '</span>'); ?></h3>
										</div>
									</div>
								<?php while ( have_posts() ) : the_post();
									$authID = get_the_author_meta('ID');
									$author = get_userdata($authID);
									$authAv = get_avatar($authID, 78);
									$postID = get_the_ID(); ?>
										<div class="discussion-entry">
											<div class="gutter clearfix">
												<div class="discussion-meta">
													<h3 class="discussion"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
													<p>Discussion Started by <?php the_author(); ?> on <?php the_time('M j, g:i a');?> || <span class="orange"><em><?php comments_number( '(0 replies)', '(1 reply)', '(% replies)' ); ?></em></span></p>
												</div>
												<div class="discussion-user">
													<span><?php the_author(); ?></span>
													<?php echo $authAv; ?>
												</div>
												<div class="discussion-content">
													<?php
														$args = array(
															'number' => '3',
															'post_id' => $postID, // use post_id, not post_ID
														);
														$comments = get_comments($args);
														foreach($comments as $comment){ ?>
															<span class="discussion-comment"><?php echo $comment->comment_content; ?> | <?php comment_date( 'M j, g:i a', $comment->comment_ID ); ?> <a href="<?php the_permalink(); ?>">read more &raquo;</a></span>
													<?php } ?>
												</div>
												<div class="discussion-tax">
													
													<span class="tag">
														<?php
															$terms = wp_get_post_terms( $postID, 'discussion_tags', $args );
															foreach($terms as $term){
																echo $term->name.' ';
															}
														?>
													</span>
												</div>
											</div>
										</div>
								<?php endwhile;?>
								<?php else : ?>
								<div class="panel post">
									<div class="gutter">
										<h3><?php printf( __( 'No Results for %s' ), '<span>' . get_search_query() . '</span>'); ?></h3>
										<p>No results found. Try searching again or checking the navigation to the left and top.</p>
									</div>
								</div>
							<?php endif; ?>
							</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php  } else{ ?>
			<div id="membercontent" class="group">
				<div class="gutter">
					<h2>You must be logged in to view this page</h2>
				</div>
			</div>
			<?php } ?>
		
		</div>
	</div>
</div>