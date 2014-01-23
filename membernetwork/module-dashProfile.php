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
			</ul>
			<span class="edit"><a href="<?php echo get_permalink(274); ?>?a=edit">edit profile</a></span>
		</div>

		<?php $guestBlog = get_user_meta($currentUser, 'guestBlogger', true);
		if($guestBlog){
			echo '<div id="userBlogger">hello</div>';
		} ?>
	</div>
</div>