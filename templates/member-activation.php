<?php
/*
Template Name: Member Activation 
*/

include ('includes/aeh_config.php'); 
include ('includes/aeh-functions.php');
get_header();

/* Retrieve the key */
$confirmkey = (get_query_var('confirmed')) ? get_query_var('confirmed') : null;

global $wpdb;
$user_id = 0; //assume an invalid user because 0 is not a valid WP member ID number
if ($result = $wpdb->get_row("SELECT * FROM `wp_usermeta` WHERE `meta_key` = 'confirmed' AND `meta_value` = '$confirmkey'")){
	$user_id = $result->user_id;
}
	
?>
<div id="membernetwork">
	<div class="container">
		<h1 class="title"><span class="grey">Essential Hospitals</span> Member Network | My Connections</h1>

<?php

	get_template_part('membernetwork/content','usernav');

?>		
		<div id="connectioncontent" class="group">
			<div class="gutter clearfix">
				<h2 class='heading'>Membership Activation</h1>
				
<?php 			
				if($user_id){
				
					echo "You are user: $user_id"; // put a more welcoming message here
				
					/* User has confirmed, delete the activation key */
					delete_user_meta( $user_id, 'confirmed');

					/* Display confirmation message*/
					echo "You have successfully registered. You may now log-in<br />
					Click the button to go to the log-in page
					<div id='login-page'><button>Ok</button></div>";

				}else{
					/* The key is incorrect or the user has already activated their account */
					echo 'Unfortunately you registration key is not valid. This may be because you have already confirmed your registration. Please try logging in. Otherwise, contact support';
				}
?>
					
			</div>
		</div>

		<div id='sidebar-connections'></div>

	</div>
</div>
	
<?php get_footer('sans'); ?>