<?php
/*
Template Name: Member Network - My Profile
*/
// this page displays your own profile information and allows you to edit it
include ("includes/aeh_config.php");
include ("includes/aeh-functions.php");
if (!is_user_logged_in()){
	header('Location: '.get_bloginfo('url').'/membernetwork/member-login/');
}
global $wpdb;
$currentUser = get_current_user_id();
	$user_info = get_userdata($currentUser);
	$user_avatar = get_avatar($currentUser);
get_header();

$usermeta = get_user_meta($userID);
$firstname  = $usermeta['first_name'][0];
$lastname   = $usermeta['last_name'][0];
$nickname   = $usermeta['nickname'][0];
$description= $usermeta['description'][0];
$user_email = $usermeta['user_email'][0];
$membersince= $usermeta['user_registered'];
$twitter    = $usermeta['twitter'][0];
$linkedin   = $usermeta['linkedin'][0];
$jobfunction= $usermeta['job_function'][0];
$employer   = $usermeta['employer'][0];
$title      = $usermeta['title'][0];
$jobtitle   = $usermeta['job_title'][0];
$facebook   = $usermeta['facebook'][0];
$visibility = $usermeta['aeh_visibility'][0];
$aeh_staff  = $usermeta['aeh_staff'][0];
$newsinterest = get_user_meta($userID, 'custom_news_feed', true);

?>
<div id="membernetwork">
	<div class="container">
		<h1 class="title"><span class="grey">Essential Hospitals</span> Member Network | My Profile</h1>
<?php

	get_template_part('membernetwork/content','usernav');

			$output = "";
?>

<div class="group-details groupcol clearfix">
<div id="myprofilecontent" class="group">
				<div class="gutter clearfix">
<?php
					if (is_user_logged_in()){
						if ($hospitalmember){
?>
							<div id="my-profile-custom">
								<div id="profile-left">
									<div id="profile-avatar">
									<?php get_template_part( 'membernetwork/module', 'uploadavatar' );
										$gravatar   = get_avatar($userID, 184);
									?>
									<?php
										if($aeh_staff == 'Y'){
											echo '<div class="hospMem"></div>';
										} echo $gravatar; ?></div>
									<ul id="profile-mod">
										<li class="editprofile"><a href="?a=edit">Edit Profile</a></li>
										<li class="changepass"><a href="?a=pwdchange">Change Password</a></li>
										<li class="changeavatar"><a class="edit-avatar">Upload/Edit Profile Image</a></li>
									</ul>

								</div>
								<div id="profile-right">
									<h2 id="profile-name"><?php echo "$firstname $lastname"; ?></h2>
									<span class="profile-position"><?php echo $jobtitle; ?></span>
									<span class="profile-employer"><?php echo $employer; ?></span>
									<?php if ($twitter) { ?>
										<span class="profile-twitter"><span class="pre">twitter</span><a href="http://www.twitter.com/<?php echo $twitter; ?>">twitter</a></span>
									<?php } ?>
									<?php if ($facebook) { ?>
										<span class="profile-facebook"><span class="pre">facebook</span><a href="http://www.<?php echo $facebook; ?>">facebook</a></span>
									<?php } ?>
									<?php if ($linkedin) { ?>
										<span class="profile-linkedin"><span class="pre">linkedin</span><a href="http://www.<?php echo $linkedin; ?>">linkedin</a></span>
									<?php } ?>
									<div class="profile-interests">
										<?php
											if($newsinterest){ ?>
											<span class="pre">Interested in:</span>
											<?php foreach($newsinterest as $news){
											$result = $wpdb->get_row("SELECT `name` FROM `wp_terms` WHERE `slug` = '$news'");
										?>
											<div class="interest">
												<?php echo $result->name; ?>
											</div>
										<?php } } ?>
									</div>
								</div>
							</div>
		<?php

								if ($aeh_staff=="Y")$output .=  "<div id='profile-staff'>Staff Member</div>";

								echo $output; // output all the optional profile info from the output string.

						}else{
							echo "You are a public member so you cannot access this page.";
						}
?>
<?php
					} ?>
					<div id="my-profile-wpm"><?php the_post(); the_content(); ?></div>
				</div>
			</div>

	</div>


<div class="group-members groupcol">
<h2 class='heading'>Connections</h2>
<?php
	$members = output_connections("",$userID,'friends',8);
	if ($members!=""){ $blocks++; ?>

		<div class='gutter clearfix'>
			<div class="myfriends">

				<div class="pendingnotify"></div>

				<div class="membercontent">

					<?php echo $members; ?>

				</div>

			</div>

		</div>
	<?php } ?>
</div>
<div class="group-resources groupcol">
	<div class="panel">
			<h2 class="heading">Discussions</h2>
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
							<p>You haven't joined any discussions. Get on it, skippy!</p>
					<?php } wp_reset_postdata(); }else{
						echo "<p>You haven't joined any discussions</p>";
					} ?>
	</div>
	<div class="panel">
		<h2 class="heading">Private Groups</h2>
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
			<?php } } }else{
				echo '<p>Not a member of any groups</p>';
			} ?>
	</div>
</div>

	</div>

<?php get_footer('sans'); ?>