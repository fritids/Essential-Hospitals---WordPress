<?php
// ----- Email alerts (groups/webinars/messages located in their plugins)
	//New comment alert
add_action( 'wp_insert_comment', 'comment_message', 10, 1 );
function comment_message($comment_id, $comment_object){

	$commentX = get_comment($comment_id);
	if(is_object_in_term($commentX->comment_post_ID, 'discussions')){
		$parentID = get_post_meta($commentX->comment_post_ID,'parentID',true);
		$parentID = intval($parentID);

		$post = get_post($parentID);
		$postName = $post->post_title;
		$postLink = $post->guid;

		$postMeta = get_post_meta($parentID, 'mod', true);
		$mod = get_userdata($postMeta);
		$modEmail = $mod->user_email;

		$comCont = $commentX->comment_content;
		$comAuth = $commentX->comment_author;

		$headers[] = 'From: America\'s Essential Hospitals <contact@naph.org>';
		$headers[] = 'Content-type: text/html';
		$message .= "New Comment by: $comAuth on <a href='$postLink'>$postName</a>";
		$message .= "<br>Comment: $comCont";

		wp_mail( $modEmail, 'AEH Comment Alert', $message, $headers );
	}
}
	//New User Registration
	if ( !function_exists('wp_new_user_notification') ) {
        function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
            $user = new WP_User($user_id);
            $user_login = stripslashes($user->user_login);
            $user_email = stripslashes($user->user_email);
            $user_pass = $user->user_pass;
            $user_first_name = get_user_meta( $user_id, 'first_name', true );
            $user_last_name = get_user_meta( $user_id, 'last_name', true );
            $fullname = ($user_first_name." ". $user_last_name);
            $login_url = home_url().'membernetwork/registration/';

            if ( empty($plaintext_pass) )
            return;

            // Users Notification Email
            $message = "$fullname,<br><br>
						Thank you for joining the Member Network at America's Essential Hospitals. You’re in the company of caring, expert health care professionals and administrators.<br><br>

						Your account information:
						username: $user_login
						password: $user_pass<br><br>

						login page:$login_url<br><br>

						Log in for a quick orientation on features like customizing a news feed, connecting with other members, accessing special resources, and joining community discussions.

						To change your password: [Link to password change in profile.]";

            wp_mail($user_email, $subject, $message);

        }
    }



// ----- Email template constructors and settings
	//HTML content type
add_filter ("wp_mail_content_type", "email_content_type");
function email_content_type() {
	return "text/html";
}
	//Email from name set
add_filter ("wp_mail_from_name", "email_from_name");
function email_from_name() {
	return "America's Essential Hospitals";
}
	//wp_mail filter to use HTML theme
add_filter ('wp_mail','email_theme');
function email_theme($vars){
	//check if $vars['message'] is an array
	if(is_array($vars['message'])){
		if($vars['message']['theme'] == true){
			//send with membernetwork template
			$vars['message'] = MN_email_construct($vars['subject'],$vars['message']['content']);
		}else{
			//send with standard template
			$vars['message'] = email_construct($vars['subject'],$vars['message']['content']);
		}
	}else{
		//send with standard template
		$vars['message'] = email_construct($vars['subject'],$vars['message']);
	}

	return $vars;
}
	//Function that constructs the HTML theme
function email_construct($title,$content){
	$header = file_get_contents('email-header.php',true);
	$mid = file_get_contents('email-mid.php',true);
	$footer = file_get_contents('email-footer.php',true);

	$output = $header.$title.$mid.$content.$footer;
	return $output;
}
	//Function that constructs Member Network HTML theme
function MN_email_construct($title,$content){
	$header = file_get_contents('MNemail-header.php',true);
	$mid = file_get_contents('MNemail-mid.php',true);
	$footer = file_get_contents('MNemail-footer.php',true);

	$output = $header.$title.$mid.$content.$footer;
	return $output;
}