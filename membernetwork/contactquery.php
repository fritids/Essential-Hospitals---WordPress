<?php
	// Our include
	define('WP_USE_THEMES', false);
	require_once('../../../../wp-load.php');

	global $wpdb;
	$curID = get_current_user_id();

	//GET for action
	if(isset($_POST['caction'])){
		$action = $_POST['caction'];
	}else{
		$action = 'reset';
	}
	//GET for page
	if(isset($_POST['cpage'])){
		$page = $_POST['cpage'];
	}else{
		$page = 0;
	}
	//GET for offset
	if(isset($_POST['coffset'])){
		$offset = $_POST['coffset'];
	}else{
		$offset = 20;
	}
	//GET for search (search resets page variable)
	if(isset($_POST['csearch'])){
		$search = $_POST['csearch'];
		$page = 0;
	}
	//GET for sort
	if(isset($_POST['csort'])){
		if($_POST['csort'] == ''){
			$sort = 'last_name';
		}else{
			$sort = $_POST['csort'];
		}
	}else{
		$sort = 'last_name';
	}
	$renderStart = $page * $offset;

	if($action == 'reset'){
		$page = 0;
		$offset = 20;
		$sort = 'last_name';
		$search = '';
	}

	//Query users
	$users = $wpdb->get_results("SELECT DISTINCT $wpdb->users.ID
			 FROM $wpdb->users, $wpdb->usermeta
			 WHERE $wpdb->users.ID = $wpdb->usermeta.user_id
			 AND $wpdb->usermeta.meta_key = '$sort'
			 AND $wpdb->usermeta.meta_value != ''
			 AND $wpdb->users.display_name != ''
			 AND $wpdb->users.ID != $curID
			 AND ($wpdb->users.display_name LIKE '%$search%' OR $wpdb->usermeta.meta_value LIKE '%$search%')
			 ORDER BY ".(($action == 'sortby') ? "$wpdb->usermeta.meta_value" : "$wpdb->users.ID")." ASC ".(($action != 'search') ? "LIMIT $renderStart , $offset" : ""));

	//Render Member Count and render Users
	//$output .= '<div id="membercount">'.count($membercount).' Members Found</div>';
	$curid = get_current_user_id();
	foreach($users as $user){
		$uData = get_userdata($user->ID);
		$user_id = $user->ID;
		$fName = $uData->first_name;
		$lName = $uData->last_name;
		$staff = get_usermeta($user->ID,'aeh_staff');
		$title = get_usermeta($user->ID,'job_title');
		$ava = get_avatar($user->ID, 128);

		$output .= "<div id='add".$user->ID."' class='member-meta'>
			<a href='".get_permalink(276)."?member=".$user->ID."'>
				<div class='grav-style'>";
		if($staff == 'Y'){$output .= '<div class="hospMem"></div>';}
		$output .= "$ava
				</div>
				<div class='member-style'>$fName $lName</div>
				<div class='job-style'>$title</div>
				<div class='org-style'></div>
			</a>
			<div class='add-connection'>
			<button data-curid='$curid' data-uid='$user_id' title='add $fName to your connections' class='add-button contact-add'>Add $fName as a Contact</button></div>
		</div>";

		}
		if($action != 'paginate' && $action != 'search'){
			$output .= '<div id="infinitescroll"></div>';
		}
		echo $output;
?>