<div id="orginfo">
<div id="base" class="container" >
	<div class="graybarleft"></div>
	<div class="graybarright"></div>
	<div class="gutter">
	    <div class="eight columns about" id="col1">
	        <?php dynamic_sidebar('left-footer'); ?>
	    </div>

	    <div class="four columns" id="col2">
	        <div class="section">
	        <?php dynamic_sidebar('center-footer'); ?>
	        </div>

	    </div>

	    <div class="four columns sidebar" id="col3">
	        <div class="sidesection top">
	          <?php dynamic_sidebar('righttop-footer'); ?>
	        </div>

	        <div class="sidesection bottom">
	          <?php dynamic_sidebar('rightbottom-footer'); ?>
	        </div>
	    </div>

	    <div class="clear"></div>
	  </div>
  </div>
</div>








	<div id="footer" class="fullwidth g4">
		<div class="container">

				 <div id="footer_address" class="four columns element">
				 	<div class="footer-address">
			  <span class="footHead">AMERICA'S ESSENTIAL HOSPITALS</span>
              <br />
              <span class="serif">1301 Pennsylvania Ave. NW, Suite 950
              <br />
              Washington, DC 20004</span>
              <br />
              <br />
              202.585.0100
              <br />
              info@essentialhospitals.org
              <br />
              <br />
           </div>
          <div id="newsletter">
            <form>
              <?php echo do_shortcode('[constantcontactapi formid="1" lists="1"]'); ?>
              <div class="clear"></div>
            </form>
            <div class="clear"></div>
          </div>
				 </div>



				 <div id="footer_contact" class="four columns element"><div class="gutter">
				 	<div class="contact-section">
			          <span class="footHead">Media Inquiries</span><br />
			          <span class="serif">Carl Graziano | 202.585.0102</span>
			          <br /><br />
				 	</div>
				 	<div class="contact-section">

			          <span class="footHead">Association Membership</span><br />
			          <span class="serif">Kristine Metter | 202.585.0573</span>
			          <br /><br />
				 	</div>
				 	<div class="contact-section">

			          <span class="footHead">Meetings and Conferences</span><br />
			          <span class="serif">Nneka St. Gerard | 202.585.0131</span>
			          <br /><br />
				 	</div>
				 	<div class="contact-section">

			          <span class="footHead">Website Admin and<br />
			          Sign in Questions</span><br />
			          <span class="serif">Maeceon Lewis | 202.585.0559</span>
				 	</div>

				 </div></div>

        <div class="eight columns element" id="footer_columns"><div class="gutter">

          <div class="col1">
          <!--Col1-->
          <dl>
            <dt class="color_policy"><a href="">Action</a></dt>
	  		  <dd><a href="">Current Advocacy Work</a></dd>
	  		  <dd><a href="">Industry News</a></dd>
	  		  <dd><a href="">Issue Analysis</a></dd>
	  
          </dl>

          

          </div>

           <div class="col2">
          <!--Col2-->
          <dl>
            <dt class="color_quality"><a href="">Quality</a></dt>
              <dd><a href="">Current Quality Improvement Work</a></dd>
	  		  <dd><a href="">Hospital Success Stories</a></dd>
	  		  <dd><a href="">Implementation Tools</a></dd>
          </dl>
           

          </div>
           <div class="col3">
          <!--Col3-->
          <dl>
            <dt class="color_institute"><a href="">Institute</a></dt>
              <dd><a href="">About the Institute</a></dd>
              <dd><a href="">Our Latest Work</a></dd>
              <dd><a href="">Research Center</a></dd>
              <dd><a href="">Transformation Center</a></dd>
			  
          </dl>
          </div>
           <div class="col4">
          <!--Col4-->
          <dl>
            <dt class="color_education"><a href="">Education</a></dt>
              <dd><a href="">Webinars</a></dd>
              <dd><a href="">Member Network Access</a></dd> 
          </dl>
          <dl class="dfour">
              <dt><a href="">About Us</a></dt>
              <dd><a href="">Our Members and Staff</a></dd>

    
          </dl>
          </div>

				</div></div>


		<div id="footer-brandSocial">
	        <div id="footer_logo">
	          <a href="<?php echo site_url(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/footer_logo.png" /></a>
	        </div>


	       <div id="social">
	          <div class="addthis_toolbox addthis_32x32_style" style="">
	          	<a class="addthis_button_linkedin"></a>
				<a class="addthis_button_facebook"></a>
				<a class="addthis_button_twitter"></a>
				<a class="addthis_button_email"></a>
				<a class="addthis_button_compact"></a>
			  </div>
				<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=naphsyscom"></script>
	        </div>
		</div>



        <div class="clear"></div>

      <!-- END CONTAINER -->
			</div>

		<div class="clear"></div>
 
  <!-- END FOOTER -->
	</div>
	</div>

	<?php wp_footer(); ?>

	<script src="<?php bloginfo('template_url'); ?>/js/jquery-ui-1.8.23.js" type="text/javascript"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/jquery.mousewheel.min.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/smoothdivscroll.js"></script>

	<script src="<?php bloginfo('template_url'); ?>/js/scripts-josh.js"></script>

	​<script type="text/javascript">
		var addthis_config = addthis_config||{};
		addthis_config.data_track_addressbar = false;
		addthis_config.data_track_clickback = false;
	</script>


</body>
</html>
