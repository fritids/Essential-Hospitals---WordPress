<?php
	global $wpdb;
	$curID = get_current_user_id();

	//GET for page
	if(isset($_GET['cpage']) || isset($_POST['cpage'])){
		$page = $_GET['cpage'];
	}else{
		$page = 0;
	}
	//GET for offset
	if(isset($_GET['coffset']) || isset($_POST['coffset'])){
		$offset = $_GET['coffset'];
	}else{
		$offset = 20;
	}
	//GET for search (search resets page variable)
	if(isset($_GET['csearch']) || isset($_POST['csearch'])){
		$search = $_GET['csearch'];
		$page = 0;
	}
	//GET for sort
	if(isset($_GET['csort']) || isset($_POST['csort'])){
		$sort = $_GET['csort'];
	}else{
		$sort = 'last_name';
	}
	$renderStart = $page * $offset;

	//Query users
	$membercount = $wpdb->get_results("SELECT ID
								 FROM $wpdb->users
								 WHERE display_name != ''
								 AND ID != $curID");

	$users = $wpdb->get_results("SELECT DISTINCT $wpdb->users.ID
								 FROM $wpdb->users, $wpdb->usermeta
								 WHERE $wpdb->users.ID = $wpdb->usermeta.user_id
								 AND $wpdb->usermeta.meta_key = 'job_title'
								 AND $wpdb->users.display_name != ''
								 AND $wpdb->users.ID != $curID
								 AND ($wpdb->users.display_name LIKE '%$search%' OR $wpdb->usermeta.meta_value LIKE '%$search%')
								 ORDER BY $wpdb->users.ID ASC
								 LIMIT $renderStart , $offset"); ?>

	<!-- Filters and Search !-->
	<div id="contact-forms">
		<table id="contact-table">
			<thead>
				<tr>
					<th class="profilesearch"><input type="text" id="profile-search" value="" placeholder="Search by Name or Job Title"></th>
					<th class="sortby">Sort By:</th>
					<th class="sortby-btn"><div data-sortby="job_title" class="job-title">Job Title</div></th>
					<th class="sortby-btn"><div data-sortby="last_name" class="last-name">Last Name</div></th>
				</tr>
			</thead>
		</table>
		<div class="pageselect-cont">
			<div class="perpagesel">
				<div class="styled-select">
					<select id="perpage">
						<option value="10">10 per page</option>
						<option value="20" selected="selected">20 per page</option>
						<option value="50">50 per page</option>
						<option value="100">100 per page</option>
					</select>
				</div>
				<div class="styled-reset">
					<div id="reset-btn">Reset Filters</div>
				</div>
			</div>
		</div>
		<div id="queryholder" data-search="" data-page="0" data-perpage="" data-sortby=""></div>
	</div>
	<div id="allContacts">
		<div id="loader-gif">Loading Users</div>
		<div id="membercount">
			<?php echo count($membercount); ?> Members
		</div>
		<div id="contactRender">
		<?php //Render users
		foreach($users as $user){
			$uData = get_userdata($user->ID);
			$fName = $uData->first_name;
			$lName = $uData->last_name;
			$staff = get_usermeta($user->ID,'aeh_staff');
			$title = get_usermeta($user->ID,'job_title');
			$ava = get_avatar($user->ID, 128); ?>
			<div id="add<?php echo $user->ID; ?>" class="member-meta">
				<a href="<?php echo get_permalink(276); ?>?member=<?php echo $user->ID; ?>">
					<div class="grav-style">
						<?php if($staff == 'Y'){echo '<div class="hospMem"></div>';}?>
						<?php echo $ava; ?>
					</div>
					<div class="member-style"><?php echo $fName.' '.$lName;?></div>
					<div class="job-style"><?php echo $title; ?></div>
					<div class="org-style"></div>
				</a>
				<div class="add-connection">
				<button data-curid="<?php echo get_current_user_id(); ?>" data-uid="<?php echo $user->ID; ?>" title="add <?php echo $fName; ?> to your connections" class="add-button contact-add">Add <?php echo $fName; ?> as a Contact</button></div>
			</div>
		<?php } ?>
			<div id="infinitescroll"></div>
		</div>
	</div>

