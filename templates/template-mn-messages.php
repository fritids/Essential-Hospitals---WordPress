<?php /*
 * Template Name: Member Network - Messages
 */
 if (!is_user_logged_in()){
	header('Location: '.get_bloginfo('url').'/membernetwork/member-login/');
}
	get_header(); ?>

<?php $currentUser = get_current_user_id();
	$user_info = get_userdata($currentUser); 
	global $cartpaujPMS;
	$numNew = $cartpaujPMS->getNewMsgs();
	$msgs = $cartpaujPMS->getMsgs(); ?>
	
<div id="membernetwork">
	<div class="container">
		<h1 class="title"><span class="grey">Essential Hospitals</span> Member Network | My Messages</h1>
		
		<?php get_template_part('membernetwork/content','usernav'); ?>
		
		
					
		
		<?php if(is_user_logged_in()){ ?>
		
		<div id="membercontent" class="messages">
			<div class="gutter clearfix">
				<div class="groupcol onefourth user-messages">
					<div class="panel">
						<div class="gutter clearfix">
							<span class="title"><?php echo $user_info->user_firstname; ?> <?php echo $user_info->user_lastname; ?></span>
							<span class="desc">you have <span class="orange">(<?php echo $numNew; ?> new messages)</span></span>
							<span class="send"><a href="?pmaction=newmessage">Send</a> a message</span>
						</div>
					</div>
				</div>
				
				<div class="groupcol threefourth mess-messages">
					<div class="panel">
						<div class="gutter">
							<?php the_content(); ?>
						</div>
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