<?php
// ----- User Roles Setup ----- //
//function AEH_roles_setup(){
	// ----- Remove old roles
	global $wp_roles;
	$roles = $wp_roles->roles;
	unset($roles['administrator']);
	$roles = array_keys($roles);
	foreach($roles as $role){
		remove_role($role);
	}

	//Content Creator
	$capabilities = array(
	    'delete_posts'			   => true,
		'delete_published_posts'   => true,
		'edit_posts'			   => true,
		'edit_published_posts'	   => true,
		'read'					   => true,
		'upload_files'			   => true,
		'moderate_comments'		   => true,
		'read_private_posts' 	   => true,
		'read_private_pages' 	   => true,
		'edit_pages'           	   => true,
	    'edit_others_pages'	   	   => true,
	    'edit_published_pages' 	   => true,
	    'level_2' => true,);
	add_role(content_creator, 'Content Creator', $capabilities );

	//Member
	$capabilities = array(
		'read' 				 => true,
		'read_private_posts' => true,
		'read_private_pages' => true,
		'level_2' => true,);
	add_role(member, 'Member', $capabilities );


/*}
// ----- Trigger on theme activation ----- //
add_action( 'after_setup_theme', 'AEH_roles_setup' );*/


// ----- Roles Capabilities Meta ----- //
function AEH_user_fields( $user ) {
	global $current_user;
	get_currentuserinfo();
	$adminRole = implode(', ',$current_user->roles);
	$postTypes = get_post_types();
	$staffPermission = get_the_author_meta( 'staffPermissions', $user->ID );
	$guestBlogger = get_the_author_meta( 'guestBlogger', $user->ID );
	$userRole = implode(', ',$user->roles);

	if($adminRole == 'administrator'){
		if($userRole == 'content_creator'){ ?>
		<h3>Staff permissions</h3>

		<table class="form-table">
			<tr>
				<th><label for="staffPermissions">Staff Permissions</label><br>
					<span class="description">Sections that site staff can access</span>
				</th>
				<td>
					<input type="checkbox" name="staffPermissions[]" value="post" <?php if($staffPermission){if(in_array('post', $staffPermission)){ echo 'checked="checked"'; }} ?>> Posts<br>
					<input type="checkbox" name="staffPermissions[]" value="page" <?php if($staffPermission){if(in_array('page', $staffPermission)){ echo 'checked="checked"'; }} ?>> Pages<br>
					<input type="checkbox" name="staffPermissions[]" value="policy" <?php if($staffPermission){if(in_array('policy', $staffPermission)){ echo 'checked="checked"'; }} ?>> Policy<br>
					<input type="checkbox" name="staffPermissions[]" value="quality" <?php if($staffPermission){if(in_array('quality', $staffPermission)){ echo 'checked="checked"'; }} ?>> Quality<br>
					<input type="checkbox" name="staffPermissions[]" value="institute" <?php if($staffPermission){if(in_array('institute', $staffPermission)){ echo 'checked="checked"'; }} ?>> Institute<br>
					<input type="checkbox" name="staffPermissions[]" value="group" <?php if($staffPermission){if(in_array('group', $staffPermission)){ echo 'checked="checked"'; }} ?>> Groups<br>
					<input type="checkbox" name="staffPermissions[]" value="webinar" <?php if($staffPermission){if(in_array('webinar', $staffPermission)){ echo 'checked="checked"'; }} ?>> Webinars<br>
					<input type="checkbox" name="staffPermissions[]" value="alert" <?php if($staffPermission){if(in_array('alert', $staffPermission)){ echo 'checked="checked"'; }} ?>> Alerts
				</td>
			</tr>



		</table>
		<?php }elseif($userRole == 'member'){ ?>
			<h3>Member Permissions</h3>
			<?php echo $guestBlogger; ?>
			<table class="form-table">
				<tr>
					<th><label for="guestBlogger">Guest Blogger?</label><br>
						<span class="description">Can Member post to Blog?</span>
					</th>
					<td>
						<input type="checkbox" name="guestBlogger" value="true" <?php if($guestBlogger){ echo "checked='checked''"; } ?> >
					</td>
				</tr>
			</table>
		<?php }
	}
}
add_action( 'show_user_profile', 'AEH_user_fields' );
add_action( 'edit_user_profile', 'AEH_user_fields' );

function AEH_save_user_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, 'staffPermissions', $_POST['staffPermissions'] );
	update_usermeta( $user_id, 'guestBlogger', $_POST['guestBlogger'] );
}
add_action( 'personal_options_update', 'AEH_save_user_fields' );
add_action( 'edit_user_profile_update', 'AEH_save_user_fields' );



// ----- Roles Dashboard Restrictions ----- //
function wps_get_comment_list_by_user($clauses) {
	if (is_admin()) {
		global $user_ID, $wpdb;
		$clauses['join'] = ", wp_posts";
		$clauses['where'] .= " AND wp_posts.post_author = ".$user_ID."
		AND wp_comments.comment_post_ID = wp_posts.ID";
	};
		return $clauses;
	};
	if(!current_user_can('edit_others_posts')) {
	add_filter('comments_clauses', 'wps_get_comment_list_by_user');
}

function AEH_roles_restrictions($user){
	global $current_user;
	get_currentuserinfo();
	$staffPermission = get_the_author_meta( 'staffPermissions', $current_user->ID );
	if(!$staffPermission){ $staffPermission = array(); }
	$userRole = implode(', ',$current_user->roles);
	$permArray = array('policy','quality','institute','webinar','alert','group','post','page');
	$diffArray = array_diff($permArray,$staffPermission);

	//remove menu items without permission
	if($userRole == 'administrator'){

	}elseif($staffPermission){
		remove_menu_page('tools.php');
		foreach($diffArray as $term){
			if($term == 'post'){
				remove_menu_page('edit.php');
			}else{
				remove_menu_page('edit.php?post_type='.$term);
			}
		}
		remove_menu_page('tools.php');
	}else{
		remove_menu_page('edit.php?post_type=page');			//Pages
		remove_menu_page('edit.php?post_type=policy');			//Policy
		remove_menu_page('edit.php?post_type=quality');			//Quality
		remove_menu_page('edit.php?post_type=institute');		//Institute
		remove_menu_page('edit.php?post_type=webinar');			//Webinar
		remove_menu_page('edit.php?post_type=alert');			//Alert
		remove_menu_page('edit.php?post_type=group');			//Group
		//remove_menu_page('edit.php?post_type=discussion');		//Discussion
		remove_menu_page('edit.php');							//Posts
		remove_menu_page('tools.php');
	}
}
add_action( 'admin_menu', 'AEH_roles_restrictions' );

// ----- Rename Posts to Blog ----- //
function edit_admin_menus() {
	global $menu;

	$menu[5][0] = 'Blog'; // Change Posts to Recipes
}
add_action( 'admin_menu', 'edit_admin_menus' );
