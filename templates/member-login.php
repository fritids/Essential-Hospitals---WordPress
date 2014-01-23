<?php 

/*

Template Name: Member Network - Login

*/
include ("includes/aeh_config.php"); 
include ("includes/aeh-functions.php");
get_header();



?>

<div id="membernetwork">

	<div class="container">

		<h1 class="title"><span class="grey">Essential Hospitals</span> Member Network | My Connections</h1>

		

<?php



	get_template_part('membernetwork/content','usernav');



?>		

		<div id="logincontent" class="group">

			<div class="gutter clearfix">

				<h2 class='heading'>Member Login</h1>

<?php  				

				the_post();

				the_content();
				
				echo "<p>Custom Content from the template file goes here...</p>";
				echo "<p>Could be a redirect or some icons to click to take you somewhere...</p>";

?>

			</div>

		</div>



	</div>

</div>

	

<?php get_footer('sans'); ?>