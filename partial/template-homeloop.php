<nav id="demo">
	<li><a data-filter="">All Posts</a></li>
	<li><a data-filter="news">News</a></li>
</nav>
<div id="postBox">
	<div id="fader">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			
			<div class="post">
				<div class="gutter">
					<h2><a href="</h2><?php the_permalink(); ?>"><?php the_title();?></a></h2>
					<?php the_content(); ?>
				</div>
			</div>
			
		<?php endwhile; wp_reset_query();?>
	</div>
</div>