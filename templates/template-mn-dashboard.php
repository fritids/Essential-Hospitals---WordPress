<?php /*
 * Template Name: Member Network - Dashboard
 */
 if (!is_user_logged_in()){
	header('Location: '.get_bloginfo('url').'/membernetwork/member-login/');
}
	get_header(); ?>
<?php $currentUser = get_current_user_id();
	$user_info = get_userdata($currentUser);
	$user_avatar = get_avatar($currentUser);
	global $cartpaujPMS;
	$numNew = $cartpaujPMS->getNewMsgs();
	$msgs = $cartpaujPMS->getMsgs();
	$firstrun = get_user_meta($currentUser, 'firstrun', true);
	if(!$firstrun){
		echo '<script src="'.get_bloginfo('template_url').'/js/intro.js"></script>';
		echo '<script src="'.get_bloginfo('template_url').'/js/firstrun.js"></script>';
		echo '<script>
			$(window).bind("load", function() {
			   firstRun('.$currentUser.');
			});</script>';
	}
	 ?>

<div id="membernetwork">
	<div class="container">
		<h1 class="title"><span class="grey">Essential Hospitals</span> Member Network</h1>
		<?php get_template_part('membernetwork/content','usernav'); ?>




		<?php if(is_user_logged_in()){ ?>

		<div id="membercontent" class="group dashboard">
			<div class="graybarleft"></div>
			<div class="graybarright"></div>
			<div class="gutter clearfix">
				<div class="group-details groupcol" id="run-news">
					<div class="panel membernews">
						<?php get_template_part( 'membernetwork/module', 'membernews' ); ?>
					</div>
				</div>

				<div class="group-members groupcol">
					<div class="panel" id="run-groups">
						<h2 class="heading">My Private Groups</h2>
						<?php $groups = get_user_meta($currentUser, 'groupMem', true);
							if($groups){
							foreach($groups as $group){
								$post = get_post($group);
								$title = $post->post_title;
								$desc = $post->post_excerpt;
								$link = get_permalink($group);
								$type = get_post_type($post->ID);
								if($type == 'group'){ ?>
								<div class="grouplist">
									<div class="gutter">
										<span class="title"><a href="<?php echo $link; ?>"><?php echo $title; ?></a></span>
										<span class="desc"><?php echo $desc; ?></span>
									</div>
								</div>
							<?php } } } ?>
						<div class="dashboard-button"> <a href="<?php echo get_permalink(392); ?>" id="addnewgroup">Start a Private Group</a> </div>
					</div>

					<?php get_template_part( 'membernetwork/module', 'educationtopics' ); ?>

					<div class="panel" id="run-discussion">
						<h2 class="heading">My Discussions</h2>
							<?php $comments = get_comments(array('user_id' => $currentUser));
								$commentArray = array();
								foreach($comments as $comment){
									array_push($commentArray,$comment->comment_post_ID);
								}
								$commentArray = array_unique($commentArray);

								if(sizeof($commentArray) > 0){
									$commentArray = array_slice($commentArray,0,3);
									$query = new WP_Query( array( 'post_type' => 'discussion', 'post__in' => $commentArray ) );
									if ( $query->have_posts() ) {
										while ( $query->have_posts() ) {
											$query->the_post(); ?>
											<div class="grouplist">
												<div class="gutter">
													<span class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
													<span class="desc"><?php the_excerpt(); ?></span>
												</div>
											</div>
									<?php } } else { ?>
										<p>You haven't contributed to any discussions. Get on it, skippy!</p>
								<?php } wp_reset_postdata(); }else{
									echo "<p>You haven't contributed to any discussions.</p>";
								} ?>
						<div class="dashboard-button"><a href="<?php echo get_permalink(257); ?>#newdisc?discuss=new">Start a New Discussion</a></div>
					</div>
					<div class="panel" id="run-comments">
						<h2 class="heading">Recent Article Comments</h2>
						<?php $comments = get_comments(array(
											'number'=> 3,
											'post_type' => array('policy','institute','quality','posts'),
											));
							if(sizeof($comments) > 0){
								foreach($comments as $comment){
								$title = get_the_title($comment->comment_post_ID);
								$author = $comment->comment_author;
								$link = get_permalink($comment->comment_post_ID);
								$categories = get_the_category($comment->comment_post_ID);
								$posttype = get_post_type($comment->comment_post_ID); ?>
								<div class="commentlist <?php echo $posttype; ?> <?php foreach($categories as $cat){ echo $cat->slug." "; }?>">
									<div class="gutter">
										<span class="title"><a href="<?php echo $link; ?>"><?php echo $title; ?></a></span>
										<span class="desc"><strong><?php echo $author; ?></strong> commented: <em><?php comment_excerpt($comment->comment_ID); ?></em></span>
										<p class="time"><?php the_time('M j, Y'); ?> at <?php the_time('g:ia'); ?></span>
									</div>
								</div>
							<?php }
							}else{
								echo "<p>There are currently no ongoing discussions on AEH articles.</p>";
							} ?>

					</div>
				</div>

				<div class="group-resources groupcol">
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

							<?php $guestBlog = get_user_meta($currentUser, 'guestBlogger', true);
							if($guestBlog){
								echo '<div id="userBlogger">hello</div>';
							} ?>
						</div>
					</div>
					<div class="panel" id="run-webinars">
						<h2 class="heading">My Webinars</h2>
							<?php $groups = get_user_meta($currentUser, 'groupMem', true);
							if($groups){
							foreach($groups as $group){
								$post = get_post($group);
								$title = $post->post_title;
								$desc = $post->post_excerpt;
								$link = get_permalink($group);
								$type = get_post_type($post->ID);
								$terms = wp_get_post_terms($post->ID, 'webinartopics');
								$termCount = count($terms);
								if($termCount > 0){ ?>
								<div class="grouplist">
									<div class="gutter">
										<span class="title"><a href="<?php echo $link; ?>"><?php echo $title; ?></a></span>
										<span class="desc"><?php echo $desc; ?></span>
									</div>
								</div>
							<?php } } } ?>
					</div>
					<div class="panel msgs clearfix" id="run-msgs">
						<h2 class="heading">My Messages (<?php echo $numNew; ?>)</h2>
						<?php
							foreach($msgs as $msg){
								$fromU = get_userdata($msg->from_user);
								$wholeThread = $cartpaujPMS->getWholeThread($msg->id);
								$lastThread = end($wholeThread);
								$msgExcerpt = substr($lastThread->message_contents, 0, 100); ?>
								<div class="msglist">
									<div class="gutter">
										<a href="<?php bloginfo('url'); ?>/member-network-messages/?pmaction=viewmessage&id=<?php echo $msg->id; ?>"><strong><?php echo $fromU->user_firstname; ?> <?php echo $fromU->user_lastname; ?></strong></a> <em><?php echo $msgExcerpt; ?></em>
									</div>
								</div>
						<?php } ?>
						<a class="readmore" href="<?php echo get_permalink(248); ?>">Read more here >></a>
					</div>
					<div class="panel" id="run-connect">
						<?php get_template_part( 'membernetwork/module', 'connections' ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php } elseif(!is_user_logged_in()){ ?>
			<div id="membercontent" class="group">
				<div class="gutter">
					<h2>You must be logged in to view this page</h2>
				</div>
			</div>
			<?php } ?>

	</div>
</div>

<?php get_footer('sans'); ?>