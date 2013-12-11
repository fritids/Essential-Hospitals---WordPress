<?php if ( have_posts() ) : ?>
		<div id="featured-img" class="page-single">
			<div class="container">
				<div id="featured-intro">
					<h3><?php printf( __( 'Search Results for: %s' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
				</div>
			</div>
		</div>
		<div id="content" class="page-single default">
				<div class="container">
					<div id="contentColumnWrap">
						<div class="graybarright"></div>
						<div class="graybarleft"></div>
						<div id="contentPrimary" class="heightcol">
							<div class="gutter">
		<?php while ( have_posts() ) : the_post(); ?>

			<div class="post">
				<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
				<?php if(get_post_type() == 'post'){ ?>
					<p class="postinfo">By <?php the_author(); ?> | Categories: <?php the_category(', '); ?> | <?php comments_popup_link(); ?></p>
				<?php } ?>
				<p><?php the_excerpt(); ?></p>
			</div>
			<hr>
		<?php endwhile; ?>
						</div><!-- End of Content -->
					</div>
				</div>
			</div>
		</div>

	<?php else : ?>
		<h1>Nothing Found</h1>
		<p>Nothing matched your search criteria. Please try again with some different keywords.</p>

		<?php get_search_form(); ?>
	<?php endif; ?>