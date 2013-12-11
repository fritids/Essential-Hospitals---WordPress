<?php
	$userID		 = get_current_user_id();
	$metakey 	 = "custom_news_feed";
	$usermeta    = get_user_meta($userID, $metakey, TRUE);
	$newsArray = array();
	if ($_SERVER['REQUEST_METHOD'] == "POST"){
		foreach ($_POST as $param_name => $param_val) {
			$newsVal = substr($param_val, 1);
		    array_push($newsArray,$newsVal);
		}
		update_user_meta($userID, $metakey, $newsArray);
	}
	
	$usermeta  = get_user_meta($userID, $metakey, TRUE);
			
?>
	<h2 class='heading'>My Custom News Feed</h1>
		<p>Customize your news feed by selecting categories you would like to receive articles on</p> 
		
		<form id="addNews" method="post" name="customnews">
			<?php 
				// no default values. using these as examples
				$taxonomies = array('educationtopics', 'qualitytopics', 'policytopics', 'institutetopics' );
				
				$args = array(
				    'orderby'       => 'name', 
				    'order'         => 'ASC',
				    'hide_empty'    => false, 
				    'exclude'       => array(), 
				    'exclude_tree'  => array(), 
				    'include'       => array(),
				    'number'        => '', 
				    'fields'        => 'all', 
				    'slug'          => '', 
				    'parent'         => '',
				    'hierarchical'  => true, 
				    'child_of'      => 0, 
				    'get'           => '', 
				    'name__like'    => '',
				    'pad_counts'    => false, 
				    'offset'        => '', 
				    'search'        => '', 
				    'cache_domain'  => 'core'
				);
				$taxs = get_terms( $taxonomies, $args );
				foreach($taxs as $tax){
				?>
					<div class="newsSelection <?php echo substr($tax->taxonomy,0,-6)?>">
						<div class="gutter clearfix">
							
							<input name="X<?php echo $tax->slug; ?>" type="checkbox" value="X<?php echo $tax->slug; ?>" <?php if($usermeta){if(in_array($tax->slug, $usermeta)) {  echo "checked='checked'"; }else{ echo ""; }} ?>>
							<label for="<?php $tax->slug; ?>"><?php echo $tax->name; ?> (<?php echo $tax->count; ?>)</label>
							<span class="newsDesc"><?php echo $tax->description; ?></span>
						</div>
					</div>
				<?php } ?>
	<span style="padding:8px 10px 0 0;margin:5px 0 0"><a href="javascript:void();" onclick="javascript:checkAll('customnews', true);">Check All</a></span>
	<span style="padding:3px 10px 0 0"><a href="javascript:void();" onclick="javascript:checkAll('customnews', false);">Uncheck All</a><br /></span><br />
	<input type="submit" value="Save" />
</form>