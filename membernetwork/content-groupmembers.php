<?php
global $post;
if($post->post_parent){
	$parent = array_reverse(get_post_ancestors($post->ID));
	$members = get_post_meta($parent[0], 'autp');
}else{
	$members = get_post_meta($post->ID, 'autp');
}
foreach($members as $member){
	foreach($member as $user){
		$id	= $user['user_id'];
		$user_info = get_userdata($id);
		$user_avatar = get_avatar($id); ?>

		<div class="group-memberavatar">
			<span class="group-membername"><?php echo $user_info->user_firstname.' ' .$user_info->user_lastname; ?></span>
			<a href="<?php echo get_permalink(276); ?>?member=<?php echo $id;?>"><?php echo $user_avatar; ?></a>
		</div>


		<!-- echo $user_info->user_firstname.' ' .$user_info->user_lastname;
		echo $user_avatar; !-->
<?php } } ?>