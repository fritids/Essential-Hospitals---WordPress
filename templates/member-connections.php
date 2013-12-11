<?php 
/*
Template Name: Member Network - Connections
*/
include ("includes/aeh_config.php"); 
include ("includes/aeh-functions.php");
if (is_user_logged_in()){
get_header();

?>
<div id="membernetwork">
	<div class="container">
		<h1 class="title"><span class="grey">Essential Hospitals</span> Member Network | Connections</h1>
		
<?php

	get_template_part('membernetwork/content','usernav');
	
		if ($hospitalmember){
?>		
		<div id="connectioncontent" class="group">
			<div class="gutter clearfix">
				<h2 class='heading'>All Members</h1>
				<div class='clisting'>
					<ul id="paginationc">

					</ul>
				</div>
			</div>
		</div>

		<div id='sidebar-connections'></div>
<?php
		}else{
			echo "You are a public member so you cannot access this page.";
		}
	}else{
		header('Location: '.get_bloginfo('url').'/membernetwork/member-login/');
	}
?>

	</div>
</div>
	
<?php get_footer('sans'); ?>