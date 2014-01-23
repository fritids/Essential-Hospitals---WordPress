<?php 

/*

Template Name: Member Network - Registration

*/



include ('includes/aeh_config.php'); 

include ("includes/aeh-functions.php");

get_header();



?>

<div id="membernetwork">

	<div class="container">

		<h1 class="title"><span class="grey">Essential Hospitals</span> Member Network</h1>	

		<div id="registrationcontent" class="group">

			<div class="gutter clearfix">

				<h2 class='heading'>Login & Registration</h2>

<?php  				

				the_post();

				the_content();

?>

			</div>

		</div>



	</div>

</div>

	

<?php get_footer('sans'); ?>