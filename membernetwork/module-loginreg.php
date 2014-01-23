<div id="loginBoxPanel">
	<div class="container">
	    <div id='loginForm'>
	      <?php $args = array(
		        'echo' => true,
		        'redirect' => site_url('/membernetwork/'), 
		        'form_id' => 'loginform',
		        'label_username' => __( 'Username' ),
		        'label_password' => __( 'Password' ),
		        'label_remember' => __( 'Remember Me' ),
		        'label_log_in' => __( 'Log In' ),
		        'id_username' => 'user_login',
		        'id_password' => 'user_pass',
		        'id_remember' => 'rememberme',
		        'id_submit' => 'wp-submit',
		        'remember' => true,
		        'value_username' => NULL,
		        'value_remember' => false ); ?> 
	      <?php wp_login_form($args); ?>
	     
	    </div>
	</div>
</div>