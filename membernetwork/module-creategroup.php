<?php
if (isset($_POST['newgroup'])){
	$groupName = $_POST['group_name'];
	$groupDesc = $_POST['group_desc'];
	$groupMem = $_POST['group_mem'];
	
	$newDesc = '
		<h3>Group Description</h3>'.$groupDesc.'<h3>Group Members</h3>'.$groupMem;
	
	// Create post object
	$newpost = array(
	  'comment_status' => 'open',
	  'post_content'   => $newDesc,
	  'post_status'    => 'pending',
	  'post_title'     => $groupName,
	  'post_type'      => 'group'
	);  
	
	// Insert the post into the database
	$newID = wp_insert_post( $newpost, true );
	$parent_term = term_exists( 'group', 'discussions' ); // array is returned if taxonomy is given
	$parent_term_id = $parent_term['term_id']; // get numeric term id
	wp_insert_term(
	  'group-'.$newID, // the term 
	  'discussions', // the taxonomy
	  array(
	    'slug' => $newID,
	    'parent'=> $parent_term_id
	  )
	);?>
	<div id="createGroup" class="show">
			<div class="gutter">
				<p>Your Group was successfully received and will be reviewed by a moderator.</p>
			</div>
	</div>
<?php }else{ ?>
<div id="createGroup">
		<div class="gutter">
			<form id="newgroup" name="newgroup" method="post">
				<input type="text" name="group_name" placeholder="Group Name">
				<textarea name="group_desc" placeholder="Group description"></textarea>
				<textarea name="group_mem" placeholder="Who do you want to be members?"></textarea>
				<input type="submit" value="Submit" name="newgroup">
			</form>
		</div>
</div>
<?php } ?>