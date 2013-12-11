<?php 
/*
Template Name: Member Network - News Sub
*/
if (is_user_logged_in()){
get_header();
include ("includes/aeh_config.php"); 
include ("includes/aeh-functions.php");
$metakey 	 = "custom_news_feed";
$usermeta    = get_user_meta($userID, $metakey, TRUE);
$currentUser = get_current_user_id();
	$user_info = get_userdata($currentUser);
	$user_avatar = get_avatar($currentUser);
?>
<div id="membernetwork">
	<div class="container">
		<h1 class="title"><span class="grey">Essential Hospitals</span> Member Network | My News</h1>
			<?php get_template_part('membernetwork/content','usernav'); ?>
			
			<div class="group-details groupcol">
				<?php get_template_part( 'membernetwork/module', 'membernewsfull' ); ?>
			</div>
			<div class="group-members groupcol">
				<?php get_template_part( 'membernetwork/module', 'newssubscribe' ); ?>
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
						</div>
			</div>

<?php
			}else{
				header('Location: http://meshdevsite.com/membercenter/member-login/');
		}
?>

	</div>
</div>
	
<?php get_footer('sans'); ?>