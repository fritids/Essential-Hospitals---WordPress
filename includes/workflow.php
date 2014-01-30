<?php
//Onsave moderation
function onsave_moderation($post_id){
	$thisPost = get_post($post_id);
	//Check for revision
	if ($parent_id = wp_is_post_revision($post_id)){
		$post_id = $parent_id;
	}
	//Check post type
	$postType = get_post_type($post_id);
	$typeArray = array('policy','quality','institute','post','page','webinar','group');
	$editorID = $_POST['editor'];
	$curEditor = get_post_meta($post_id,'curEdit',true);
	if(in_array($postType, $typeArray) && get_post_status($post_id) != 'publish' && $editorID != $curEditor){
		//Get new moderator
		$thisEditor = get_userdata($editorID);
		$editorEmail = $thisEditor->user_email;
		$postTitle = $thisPost->post_title;
		$postLink = $thisPost->guid;
		//Send to new moderator
		$headers[] = 'Content-type: text/html';
		$subject = 'Article for review';
		$message = "You have been flagged as an editor for $postTitle.<br>
					Go <a href='$postLink'>here</a> to review the publication.";
		wp_mail($editorEmail, $subject, $message, $headers);
		//Add meta for current editor
		add_post_meta($post_id,'curEdit',$editorID,true) || update_post_meta($post_id,'curEdit',$editorID);
	}
}
add_action('save_post','onsave_moderation');

//Editor field
add_action( 'post_submitbox_misc_actions', 'next_editor',90 );
function next_editor(){
	global $current_user;
	global $post;
	get_currentuserinfo();
	$userRole = implode(', ',$current_user->roles);
	$postType = $post->post_type;
	$curEdit = get_post_meta($post->ID,'curEdit',true);
	$typeArray = array('policy','quality','institute','post','page','webinar','group');
	if(in_array($postType, $typeArray)){
		$output .= "<div class='misc-pub-section'><label for='editor'>Editor: </label>";
			$editors = get_users('role=content_creator');
			$admins = get_users('role=administrator');
			$output .= '<select id="editor" name="editor">';
			$output .= '<optgroup label="Admins">';
			foreach($admins as $admin){
				$output .= '<option ';
					if($admin->ID == $curEdit){
						$output .= 'selected ';
					}
				$output .= 'value="'.$admin->ID.'">'.$admin->display_name.'</option>';
			}
			$output .= '</optgroup>';
			if(count($editors) > 0){
				$output .= '<optgroup label="Content Creators">';
				foreach($editors as $editor){
					$uMeta = get_user_meta($editor->ID, 'staffPermissions', true);
					if($uMeta){
						if(in_array($postType, $uMeta)){
							$output .= '<option ';
								if($editor->ID == $curEdit){
									$output .= 'selected ';
								}
							$output .= 'value="'.$editor->ID.'">'.$editor->display_name.'</option>';
						}
					}
				}
				$output .= '</optgroup>';
			}
			$output .= '</select>';
		$output .= "</div>";
		echo $output;
	}
}