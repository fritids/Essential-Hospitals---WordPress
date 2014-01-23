<?php
/*
Template Name: Member Network - My Profile
*/
// this page displays your own profile information and allows you to edit it
include ("includes/aeh_config.php");
include ("includes/aeh-functions.php");
if (!is_user_logged_in()){
	header('Location: '.site_url().'/membernetwork/member-login/');
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
$aeh_member = $usermeta['aeh_member_type'][0];
$newsinterest = get_user_meta($userID, 'custom_news_feed', true); ?>
    <div id="membernetwork">
        <div class="container">
            <h1 class="title"><span class="grey">Essential Hospitals</span> Member Network | My Profile</h1>
            <?php get_template_part('membernetwork/content','usernav'); $output = "";?>
            <div class="group-details groupcol clearfix">
                <?php include(locate_template('/membernetwork/module-profileData.php'));
                echo $aeh_member; ?>
            </div>

            <?php if($aeh_member == 'hospital'){
            	echo '<div class="group-members groupcol">';
            	include(locate_template('/membernetwork/module-profileContacts.php'));
            	echo '</div>'; } ?>

            <div class="group-resources groupcol">
                <?php include(locate_template('/membernetwork/module-profileDiscussions.php')); ?>
                <?php if($aeh_member == 'hospital'){
                	include(locate_template('/membernetwork/module-profileGroups.php')); } ?>
            </div>
        </div>
<?php get_footer('sans'); ?>