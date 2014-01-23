<?php
/*
Template Name: Member Network - Connections TEST
*/
if (!is_user_logged_in()){
	header('Location: '.site_url().'/membernetwork/member-login/');
}
get_header();
$currentUser = get_current_user_id();
	$user_info = get_userdata($currentUser);
	$aeh_member = get_user_meta($currentUser,'aeh_member_type',true);
?>
<script src="<?php bloginfo('template_directory'); ?>/js/connections.js"></script>
<div id="membernetwork" class="<?php echo $aeh_member; ?>">
	<div class="container">
		<h1 class="title"><span class="grey">Essential Hospitals</span> Member Network | Contacts</h1>
		<?php get_template_part('membernetwork/content','usernav'); ?>
		<?php if($aeh_member == 'hospital'){ ?>
		<div id="contact-primary" class="group">
			<div class="gutter clearfix">
				<h2 class='heading'>Browse all network members</h1>
				<?php get_template_part( 'membernetwork/module', 'contactsAll' ); ?>
			</div>
		</div>
		<div id='contact-secondary'>
			<?php get_template_part( 'membernetwork/module', 'contactsPending' ); ?>
			<?php get_template_part( 'membernetwork/module', 'contactsMy' ); ?>
		</div>
		<?php }else{
			echo '<h2>You must be an Association Member to access Contacts</h2>';
		} ?>
	</div>
</div>

<?php get_footer('sans'); ?>