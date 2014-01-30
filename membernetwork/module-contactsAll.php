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

	//Get pending/requested/my contacts
	$contacts = $wpdb->get_results("SELECT user_id, friend_id
											FROM wp_aeh_connections
											WHERE user_ID = $curID
											AND consent_date > 0
											OR friend_id = $curID
											AND consent_date > 0");
	$myContacts = array();
	foreach($contacts as $contact){
		if($contact->user_id = $curID){
			array_push($myContacts, $contact->friend_id);
		}else{
			array_push($myContacts,$contact->user_id);
		}
	}
	$contacts = $wpdb->get_results("SELECT user_id, friend_id
											FROM wp_aeh_connections
											WHERE friend_ID = $curID
											AND consent_date = 0");
	$pendingContacts = array();
	foreach($contacts as $contact){
		array_push($pendingContacts,$contact->user_id);
	}
	$curID = get_current_user_id();
			//echo $curID;
			//Get contacts for current user
			$contacts = $wpdb->get_results("SELECT user_id, friend_id
											FROM wp_aeh_connections
											WHERE user_ID = $curID
											AND consent_date = 0");
	$requestedContacts = array();
	foreach($contacts as $contact){
		array_push($requestedContacts, $contact->friend_id);
	}

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
					<th class="sortby-btn"><div data-sortby="aeh_staff" class="job-title">Association Staff</div></th>
					<th class="sortby-btn"><div data-sortby="job_title" class="job-title">Job Function</div></th>
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

				<?php if(in_array($user->ID, $myContacts)){ ?>
						<div class="my-connection">
							<button class="added-button"><?php echo $fName; ?> is a Contact</button>
						</div>
				<?php	}elseif(in_array($user->ID, $pendingContacts)){ ?>
						<div class="pending-connection">
							<button class="added-button"><?php echo $fName; ?> has added you</button>
						</div>
				<?php	}elseif(in_array($user->ID, $requestedContacts)){ ?>
						<div class="requested-connection">
							<button class="added-button">You have requested <?php echo $fName; ?></button>
						</div>
				<?php	}else{ ?>
						<div class="add-connection">
							<button data-curid="<?php echo get_current_user_id(); ?>" data-uid="<?php echo $user->ID; ?>" title="add <?php echo $fName; ?> to your connections" class="add-button contact-add">Add <?php echo $fName; ?> to Contacts</button>
						</div>
				<?php	} ?>
			</div>
		<?php } ?>
			<div id="infinitescroll"></div>
		</div>
	</div>

