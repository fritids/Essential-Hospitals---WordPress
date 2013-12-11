<?php
add_action( 'wp_insert_comment', 'comment_message', 10, 1 );
function comment_message($comment_id, $comment_object){
	$commentCont = $comment_object->comment_content;
	$commentAuth = $comment_object->comment_author;
	$commentPost = $comment_object->comment_post_ID;

	$postAuthID = $post->post_author;
	$postAuthor = get_userdata($postAuthID);
	$postEmail  = $postAuthor->user_email;

	$to = $postEmail;
	$message .= "$comment_id There's a new comment by $commentAuth.";
	$message .= "<br> Comment Content: $commentCont.";
	$headers[] = 'From: AEH Alert <alert@naph.org>';
	$headers[] = 'Content-type: text/html';
	$subject = 'America\'s Essential Hospitals Comment Moderation';


	wp_mail( 'pat@meshfresh.com', $subject, $message, $headers );
}