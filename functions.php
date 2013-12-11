<?php
//Roles and Workflow
include('includes/roles.php');
include('includes/workflow.php');
include('includes/email.php');
include('includes/twitter.php');

//Cat and Tags for Media Library
function register_mediaCat_tax() {
  $labels = array(
    'name'          => _x( 'Media Category', 'taxonomy general name' ),
    'singular_name'     => _x( 'Media Category', 'taxonomy singular name' ),
    'add_new'         => 'Add New Media Category',
    'add_new_item'      => __( 'Add New Media Category' ),
    'edit_item'       => __( 'Edit Media Category' ),
    'new_item'        => __( 'New Media Category' ),
    'view_item'       => __( 'View Media Category' ),
    'search_items'      => __( 'Search Media Category' ),
    'not_found'       => __( 'No Media Categories found' ),
    'not_found_in_trash'  => __( 'No Media Categories found in Trash' ),
  );
  $pages = array('attachment');
  $args = array(
    'labels'      => $labels,
    'singular_label'  => __('Media Category'),
    'public'      => false,
    'show_ui'       => true,
    'hierarchical'    => true,
    'show_tagcloud'   => false,
    'show_in_nav_menus' => false,
    'rewrite'       => array('slug' => 'mediaCat', 'with_front' => false ),
   );
  register_taxonomy('mediaCat', $pages, $args);
}
add_action('init', 'register_mediaCat_tax');
add_filter( 'manage_taxonomies_for_attachment_columns', 'activity_type_columns' );
function activity_type_columns( $taxonomies ) {
    $taxonomies[] = 'mediaCat';
    return $taxonomies;
}
function wptp_add_tags_to_attachments() {
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , 'wptp_add_tags_to_attachments' );

//Hide Member Network Pages
add_action( 'pre_get_posts', 'hide_member_network' );
function hide_member_network( $query ) {
	global $post_type, $current_user;
	$userRole = get_current_user_role();
    if ( is_admin() && $query->is_main_query() && $post_type == 'page' && $userRole != 'Administrator' || $query->is_search){
        $query->set('post__not_in', array(271,301,297,295,299,308,330,278,392,244,257,287,248,260,274,280,310,276,290,547));
    }
}


//Get Current User Role
function get_current_user_role() {
	global $wp_roles;
	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	$role = array_shift($roles);
	return isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
}

//Show Future Posts
function show_future_posts($posts)
{
   global $wp_query, $wpdb;
   if(is_single() && $wp_query->post_count == 0)
   {
      $posts = $wpdb->get_results($wp_query->request);
   }
   return $posts;
}
add_filter('the_posts', 'show_future_posts');

//Get All Authors
function get_all_authors($authCount) {
	global $wpdb;
	$i = 0;
	foreach ( $wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = 'post' AND " . get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author") as $row ){

		if($i >= $authCount){ break; }

	    $author = get_userdata( $row->post_author );
	    $authors[$row->post_author]['name'] = $author->display_name;
	    $authors[$row->post_author]['post_count'] = $row->count;
	    $authors[$row->post_author]['ID'] = $author->ID;
	    $authors[$row->post_author]['desc'] = $author->user_description;
	    $authors[$row->post_author]['posts_url'] = get_author_posts_url( $author->ID, $author->user_nicename );
	    $i++;
	}
	return $authors;
}

//Page Columns
function page_columns($columns)
{
	$columns = array(
		'cb'	 	=>  '<input type="checkbox" />',
		'title' 	=>  'Title',
		'author'	=>	'Author',
		'theme'		=>  'Theme',
		'date'		=>	'Date',
	);
	return $columns;
}

function custom_columns($column)
{
	global $post;
	if($column == 'theme')
	{
		echo get_field('theme', $post->ID);
	}
}
function column_register_sortable( $columns )
{
	$columns['theme'] = 'theme';
	return $columns;
}

add_filter("manage_edit-page_sortable_columns", "column_register_sortable" );
add_action("manage_pages_custom_column", "custom_columns");
add_filter("manage_edit-page_columns", "page_columns");

//Branding
function AEH_branding() {
    wp_enqueue_style('AEH-theme', get_template_directory_uri() . '/css/login.css');
}
add_action('login_enqueue_scripts', 'AEH_branding');

function AEH_editor_styles() {
    add_editor_style( 'css/editor.css' );
}
add_action( 'init', 'AEH_editor_styles' );

//Global Variables

add_action('init', 'register_my_menus');
add_action('init', 'loadup_scripts'); // Add Custom Scripts

function register_my_menus() {
	register_nav_menus(
		array(
			'primary-menu'   => __('Primary Menu'),
			'utility-menu'   => __('Utility Navigation'),
			'footer-menu'    => __('Footer Menu'),
			'action-nav'     => __('Action Menu'),
			'quality-nav'    => __('Quality Menu'),
			'institute-nav'  => __('Institute Menu'),
			'education-nav'  => __('Education Menu'),
			'member-network' => __('Member Network'),
			'ehu'            => __('Essential Hospitals U'),
			'general-nav'    => __('General Navigation - used on default page template')
		)
	);
}


//Widget Sections
register_sidebar(array(
  'name' => __( 'Left Footer' ),
  'id' => 'left-footer',
  'description' => __( 'Footer - About' ),
  'before_title' => '<h2>',
  'after_title' => '</h2>',
  'before_widget' => '',
  'after_widget'  => '',
));
register_sidebar(array(
  'name' => __( 'Center Footer' ),
  'id' => 'center-footer',
  'description' => __( 'Footer - Center' ),
  'before_widget' => '',
  'after_widget'  => '',
));
register_sidebar(array(
  'name' => __( 'Right-Top Footer' ),
  'id' => 'righttop-footer',
  'description' => __( 'Footer - Right Top' ),
  'before_widget' => '',
  'after_widget'  => '',
));
register_sidebar(array(
  'name' => __( 'Right-Bottom Footer' ),
  'id' => 'rightbottom-footer',
  'description' => __( 'Footer - Right Bottom' ),
  'before_widget' => '',
  'after_widget'  => '',
));


if (!current_user_can('administrator')):
	show_admin_bar(false);
endif;


function loadup_scripts()
{
    if (!is_admin()) {
        wp_deregister_script('jquery'); // Deregister WordPress jQuery
        wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js' ); // Google CDN jQuery
        wp_enqueue_script('jquery'); // Enqueue it!


		//Pat Script - registered
        wp_register_script('masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js');
		wp_register_script('jquerytools', get_template_directory_uri() . '/js/jquery.tools.min.js');
		wp_register_script('themetools', get_template_directory_uri() . '/js/script-pat.js');
		wp_register_script('membernetwork', get_template_directory_uri() . '/js/theme.script.js');

        //Pat Script - queued
        wp_enqueue_script('masonry');
        wp_enqueue_script('jquerytools');
        wp_enqueue_script('themetools');
        wp_enqueue_script('membernetwork');
    }
}

// Add Thumbnail Theme Support
add_theme_support('post-thumbnails');
add_image_size('large', 700, '', true); // Large Thumbnail
add_image_size('medium', 250, '', true); // Medium Thumbnail
add_image_size('small', 120, '', true); // Small Thumbnail
add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

// Register Widget Area for the Sidebar
register_sidebar( array(
	'name' => __( 'Primary Widget Area', 'Sidebar' ),
	'id' => 'primary-widget-area',
	'description' => __( 'The primary widget area', 'Sidebar' ),
	'before_widget' => '<div class="box">',
	'after_widget' => '</div>',
	'before_title' => '<h1>',
	'after_title' => '</h1>',
) );

// Load Optimised Google Analytics in the footer
// Change the UA-XXXXXXXX-X to your Account ID
function add_google_analytics()
{
    $google = "<!-- Google Analytics -->";
    $google .= "<script>";
    $google .= "var _gaq=[['_setAccount','UA-XXXXXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));";
    $google .= "</script>";
    echo $google;
}

add_action('wp_footer', 'add_google_analytics'); // Google Analytics optimised in footer


/*** CLEAN UP FUNCTIONS ----------------------------------------*/

  /* admin part cleanups */
  add_action('admin_menu','remove_dashboard_widgets'); // cleaning dashboard widgets
  add_action('admin_menu', 'delete_menu_items'); // deleting menu items from admin area
  add_action('admin_menu','customize_meta_boxes'); // remove some meta boxes from pages and posts edition page
  add_filter('manage_posts_columns', 'custom_post_columns'); // remove column entries from list of posts
  add_filter('manage_pages_columns', 'custom_pages_columns'); // remove column entries from list of page
  add_action('wp_before_admin_bar_render', 'wce_admin_bar_render' ); // clean up the admin bar
  add_action('widgets_init', 'unregister_default_widgets', 11); // remove widgets from the widget page

  /* selfish frshstart plugins code parts*/
  add_action('admin_notices','rynonuke_update_notification_nonadmins',1); // remove notification for enayone but admin
  add_action('pre_ping','rynonuke_self_pings'); // disable self-trackbacking


  /***************** Security + header clean-ups ************************/

  /** remove the wlmanifest (useless !!) */
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'rsd_link');
  remove_action( 'wp_head', 'index_rel_link' ); // index link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
  remove_action('wp_head','start_post_rel_link');
  remove_action('wp_head','adjacent_posts_rel_link_wp_head');
  remove_action('wp_head', 'wp_generator'); // remove WP version from header
  remove_action('wp_head','wp_shortlink_wp_head');
  remove_filter( 'the_content', 'capital_P_dangit' ); // Get outta my Wordpress codez dangit!
  remove_filter( 'the_title', 'capital_P_dangit' );
  remove_filter( 'comment_text', 'capital_P_dangit' );


  // removes detailed login error information for security
  add_filter('login_errors',create_function('$a', "return null;"));

/*** cleaning up the dashboard- ----------------------------------------*/
function remove_dashboard_widgets(){

  //remove_meta_box('dashboard_right_now','dashboard','core'); // right now overview box
  remove_meta_box('dashboard_incoming_links','dashboard','core'); // incoming links box
  remove_meta_box('dashboard_quick_press','dashboard','core'); // quick press box
  remove_meta_box('dashboard_plugins','dashboard','core'); // new plugins box
  remove_meta_box('dashboard_recent_drafts','dashboard','core'); // recent drafts box
  remove_meta_box('dashboard_primary','dashboard','core'); // wordpress development blog box
  remove_meta_box('dashboard_secondary','dashboard','core'); // other wordpress news box


}

/* Remove some menus froms the admin area*/
function delete_menu_items() {
}

/* remove some meta boxes from pages and posts -------------------------
feel free to comment / uncomment  */

function customize_meta_boxes() {
  /* Removes meta boxes from pages */
  remove_meta_box('postcustom','page','normal'); // custom fields metabox
  remove_meta_box('trackbacksdiv','page','normal'); // trackbacks metabox
}

/** removing parts from column ------------------------------------------*/
/* use the column id, if you need to hide more of them
syntaxe : unset($defaults['columnID']);   */

/** remove column entries from posts **/
function custom_post_columns($defaults) {
  return $defaults;
}


/** remove column entries from pages **/
function custom_pages_columns($defaults) {
  return $defaults;
}

/** remove widgets from the widget page ------------------------------------*/
/* Credits : http://wpmu.org/how-to-remove-default-wordpress-widgets-and-clean-up-your-widgets-page/
uncomment what you want to remove  */
 function unregister_default_widgets() {
 }

/****** removings items froms admin bars
use the last part of the ID after "wp-admin-bar-" to add some menu to the list  exemple for comments : id="wp-admin-bar-comments" so the id to use is "comments"  ***********/
function wce_admin_bar_render() {
global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wp-logo');
  $wp_admin_bar->remove_menu('updates');
  $wp_admin_bar->remove_menu('comments');
  $wp_admin_bar->remove_menu('new-content');

}
/*-----------------------------------------------------------------------**/




/**  Other usefull cleanups from selfish fresh start plugin http://wordpress.org/extend/plugins/selfish-fresh-start/ --------------------*/

// remove update notifications for everybody except admin users
function rynonuke_update_notification_nonadmins() {
  if (!current_user_can('administrator'))
    remove_action('admin_notices','update_nag',3);
}

// disable self-trackbacking
function rynonuke_self_pings( &$links ) {
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, home_url() ) )
            unset($links[$l]);
}

/** WordPress user profil cleanups  ------------------------------------*/

/* remove the color scheme options */
  function admin_color_scheme() {
   global $_wp_admin_css_colors;
   $_wp_admin_css_colors = 0;
}

// add_action('admin_head', 'admin_color_scheme');

// rem/add user profile fields
function rynonuke_contactmethods($contactmethods) {
  unset($contactmethods['yim']);
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  $contactmethods['rynonuke_twitter']='Twitter';
  $contactmethods['rynonuke_facebook']='Facebook';
  return $contactmethods;
}


/*----------------------------------------------------------------------- **/

/*** Add a login stylesheet and a wordpress specific stylesheet------------
stylesheets are in the plugin directory, you can change the content to make it suite your needs. You'll also find a logo.png file, to brand the login form using your personnal logo
-----------*/

function style_my_login_please() {
}

/** stylesheet link for admin **/
function style_my_admin_please() {
}


/*-------------------FUNCTIONS--------------------- */
function wp_list_categories_for_post_type($post_type, $args = '') {
    $exclude = array();

    // Check ALL categories for posts of given post type
    foreach (get_categories() as $category) {
        $posts = get_posts(array('post_type' => $post_type, 'category' => $category->cat_ID));

        // If no posts found, ...
        if (empty($posts))
            // ...add category to exclude list
            $exclude[] = $category->cat_ID;
    }

    // Set up args
    if (! empty($exclude)) {
        $args .= ('' === $args) ? '' : '&';
        $args .= 'exclude='.implode(',', $exclude);
    }

    // List categories
    //wp_get_categories($args);
    return $args;
}



/*---------------------------CUSTOM POST TYPES----------------------------- **/

$themeDIR = get_bloginfo('template_directory');
	// registration code for general post type
  function register_general_posttype() {
    $labels = array(
      'name'        => _x( 'General', 'post type general name' ),
      'singular_name'   => _x( 'General', 'post type singular name' ),
      'add_new'       => __( 'Add New' ),
      'add_new_item'    => __( 'General' ),
      'edit_item'     => __( 'General' ),
      'new_item'      => __( 'General' ),
      'view_item'     => __( 'General' ),
      'search_items'    => __( 'General' ),
      'not_found'     => __( 'General' ),
      'not_found_in_trash'=> __( 'General' ),
      'parent_item_colon' => __( 'General' ),
      'menu_name'     => __( 'General' )
    );

    $taxonomies = array('series','category','post_tag');

    $supports = array('title','editor','thumbnail','excerpt','custom-fields','comments','revisions');

    $post_type_args = array(
      'labels'      => $labels,
      'singular_label'  => __('General'),
      'public'      => true,
      'show_ui'       => true,
      'publicly_queryable'=> true,
      'query_var'     => true,
      'exclude_from_search'=> false,
      'show_in_nav_menus' => false,
      'capability_type'   => 'post',
      'has_archive'     => true,
      'hierarchical'    => true,
      'rewrite'       => array('slug' => 'general', 'with_front' => false ),
      'supports'      => $supports,
      'menu_position'   => 5,
      'taxonomies'    => $taxonomies
     );
     register_post_type('general',$post_type_args);
  }
  add_action('init', 'register_general_posttype');


  // registration code for webinars post type
  function register_webinar_posttype() {
    $labels = array(
      'name'        => _x( 'Webinars', 'post type general name' ),
      'singular_name'   => _x( 'Webinar', 'post type singular name' ),
      'add_new'       => __( 'Add New' ),
      'add_new_item'    => __( 'Webinar' ),
      'edit_item'     => __( 'Webinar' ),
      'new_item'      => __( 'Webinar' ),
      'view_item'     => __( 'Webinar' ),
      'search_items'    => __( 'Webinar' ),
      'not_found'     => __( 'Webinar' ),
      'not_found_in_trash'=> __( 'Webinar' ),
      'parent_item_colon' => __( 'Webinar' ),
      'menu_name'     => __( 'Webinars' )
    );

    $taxonomies = array('post_tag', 'policytopics', 'educationtopics', 'qualitytopics', 'institutetopics','webinartopics');

    $supports = array('title','editor','thumbnail','excerpt','custom-fields','comments','revisions');

    $post_type_args = array(
      'labels'      => $labels,
      'singular_label'  => __('Webinar'),
      'public'      => true,
      'show_ui'       => true,
      'publicly_queryable'=> true,
      'query_var'     => true,
      'exclude_from_search'=> false,
      'show_in_nav_menus' => false,
      'capability_type'   => 'post',
      'has_archive'     => true,
      'hierarchical'    => true,
      'rewrite'       => array('slug' => 'webinar', 'with_front' => false ),
      'supports'      => $supports,
      'menu_position'   => 5,
      'menu_icon'     => get_bloginfo('template_directory').'/images/education-menu.png',
      'taxonomies'    => $taxonomies
     );
     register_post_type('webinar',$post_type_args);
  }
  add_action('init', 'register_webinar_posttype');

  // registration code for alerts post type
  function register_alerts_posttype() {
    $labels = array(
      'name'        => _x( 'Alerts', 'post type general name' ),
      'singular_name'   => _x( 'Alert', 'post type singular name' ),
      'add_new'       => __( 'Add New' ),
      'add_new_item'    => __( 'Alert' ),
      'edit_item'     => __( 'Alert' ),
      'new_item'      => __( 'Alert' ),
      'view_item'     => __( 'Alert' ),
      'search_items'    => __( 'Alert' ),
      'not_found'     => __( 'Alert' ),
      'not_found_in_trash'=> __( 'Alert' ),
      'parent_item_colon' => __( 'Alert' ),
      'menu_name'     => __( 'Announcements' )
    );

    $taxonomies = array('post_tag', 'policytopics', 'educationtopics', 'qualitytopics', 'institutetopics','category');

    $supports = array('title','excerpt');

    $post_type_args = array(
      'labels'      => $labels,
      'singular_label'  => __('Alert'),
      'public'      => true,
      'show_ui'       => true,
      'publicly_queryable'=> true,
      'query_var'     => true,
      'exclude_from_search'=> false,
      'show_in_nav_menus' => false,
      'capability_type'   => 'post',
      'has_archive'     => true,
      'hierarchical'    => true,
      'rewrite'       => array('slug' => 'alert', 'with_front' => false ),
      'supports'      => $supports,
      'menu_position'   => 5,
      'taxonomies'    => $taxonomies
     );
     register_post_type('alert',$post_type_args);
  }
  add_action('init', 'register_alerts_posttype');

  // registration code for policy post type
  function register_policy_posttype() {
    $labels = array(
      'name'        => _x( 'Action', 'post type general name' ),
      'singular_name'   => _x( 'Action', 'post type singular name' ),
      'add_new'       => __( 'Add New' ),
      'add_new_item'    => __( 'Action' ),
      'edit_item'     => __( 'Action' ),
      'new_item'      => __( 'Action' ),
      'view_item'     => __( 'Action' ),
      'search_items'    => __( 'Action' ),
      'not_found'     => __( 'Action' ),
      'not_found_in_trash'=> __( 'Action' ),
      'parent_item_colon' => __( 'Action' ),
      'menu_name'     => __( 'Action' )
    );

    $taxonomies = array('post_tag', 'policytopics', 'educationtopics', 'qualitytopics', 'institutetopics');

    $supports = array('title','editor','author','thumbnail','excerpt','custom-fields','comments','revisions');

    $post_type_args = array(
      'labels'      => $labels,
      'singular_label'  => __('Policy'),
      'public'      => true,
      'show_ui'       => true,
      'publicly_queryable'=> true,
      'query_var'     => true,
      'exclude_from_search'=> false,
      'show_in_nav_menus' => false,
      'capability_type'   => 'post',
      'has_archive'     => true,
      'hierarchical'    => true,
      'rewrite'       => array('slug' => 'policy', 'with_front' => false ),
      'supports'      => $supports,
      'menu_position'   => 2,
      'menu_icon'     => get_bloginfo('template_directory').'/images/policy-menu.png',
      'taxonomies'    => $taxonomies
     );
     register_post_type('policy',$post_type_args);
  }
  add_action('init', 'register_policy_posttype');

  // registration code for quality post type
  function register_quality_posttype() {
    $labels = array(
      'name'        => _x( 'Quality', 'post type general name' ),
      'singular_name'   => _x( 'Quality', 'post type singular name' ),
      'add_new'       => __( 'Add New' ),
      'add_new_item'    => __( 'Quality' ),
      'edit_item'     => __( 'Quality' ),
      'new_item'      => __( 'Quality' ),
      'view_item'     => __( 'Quality' ),
      'search_items'    => __( 'Quality' ),
      'not_found'     => __( 'Quality' ),
      'not_found_in_trash'=> __( 'Quality' ),
      'parent_item_colon' => __( 'Quality' ),
      'menu_name'     => __( 'Quality' )
    );

     $taxonomies = array('post_tag', 'policytopics', 'educationtopics', 'qualitytopics', 'institutetopics');

    $supports = array('title','editor','author','thumbnail','excerpt','custom-fields','comments','revisions');

    $post_type_args = array(
      'labels'      => $labels,
      'singular_label'  => __('Quality'),
      'public'      => true,
      'show_ui'       => true,
      'publicly_queryable'=> true,
      'query_var'     => true,
      'exclude_from_search'=> false,
      'show_in_nav_menus' => true,
      'capability_type'   => 'post',
      'has_archive'     => false,
      'hierarchical'    => false,
      'rewrite'       => array('slug' => 'quality', 'with_front' => false ),
      'supports'      => $supports,
      'menu_position'   => 3,
      'menu_icon'     => get_bloginfo('template_directory').'//images/quality-menu.png',
      'taxonomies'    => $taxonomies
     );
     register_post_type('quality',$post_type_args);
  }
  add_action('init', 'register_quality_posttype');

  // registration code for institute post type
  function register_institute_posttype() {
    $labels = array(
      'name'        => _x( 'Institute', 'post type general name' ),
      'singular_name'   => _x( 'Institute', 'post type singular name' ),
      'add_new'       => __( 'Add New' ),
      'add_new_item'    => __( 'Institute' ),
      'edit_item'     => __( 'Institute' ),
      'new_item'      => __( 'Institute' ),
      'view_item'     => __( 'Institute' ),
      'search_items'    => __( 'Institute' ),
      'not_found'     => __( 'Institute' ),
      'not_found_in_trash'=> __( 'Institute' ),
      'parent_item_colon' => __( 'Institute' ),
      'menu_name'     => __( 'Institute' )
    );

    $taxonomies = array('post_tag', 'policytopics', 'educationtopics', 'qualitytopics', 'institutetopics');

    $supports = array('title','editor','author','thumbnail','excerpt','custom-fields','comments','revisions');

    $post_type_args = array(
      'labels'      => $labels,
      'singular_label'  => __('Institute'),
      'public'      => true,
      'show_ui'       => true,
      'publicly_queryable'=> true,
      'query_var'     => true,
      'exclude_from_search'=> false,
      'show_in_nav_menus' => true,
      'capability_type'   => 'post',
      'has_archive'     => false,
      'hierarchical'    => false,
      'rewrite'       => array('slug' => 'institute', 'with_front' => false ),
      'supports'      => $supports,
      'menu_position'   => 4,
      'menu_icon'     => get_bloginfo('template_directory').'/images/institute-menu.png',
      'taxonomies'    => $taxonomies
     );
     register_post_type('institute',$post_type_args);
  }
  add_action('init', 'register_institute_posttype');

  // registration code for discussion post type
  function register_discussion_posttype() {
    $labels = array(
      'name'        => _x( 'Discussions', 'post type general name' ),
      'singular_name'   => _x( 'Discussion', 'post type singular name' ),
      'add_new'       => __( 'Add New' ),
      'add_new_item'    => __( 'Discussion' ),
      'edit_item'     => __( 'Discussion' ),
      'new_item'      => __( 'Discussion' ),
      'view_item'     => __( 'Discussion' ),
      'search_items'    => __( 'Discussion' ),
      'not_found'     => __( 'Discussion' ),
      'not_found_in_trash'=> __( 'Discussion' ),
      'parent_item_colon' => __( 'Discussion' ),
      'menu_name'     => __( 'Discussions' )
    );

     $taxonomies = array('discussions','discussion_tags');

    $supports = array('title','editor','author','comments');

    $post_type_args = array(
      'labels'      => $labels,
      'singular_label'  => __('Discussion'),
      'public'      => true,
      'show_ui'       => true,
      'publicly_queryable'=> true,
      'query_var'     => true,
      'exclude_from_search'=> false,
      'show_in_nav_menus' => true,
      'capability_type'   => 'post',
      'has_archive'     => true,
      'hierarchical'    => false,
      'rewrite'       => array('slug' => 'discussions', 'with_front' => false ),
      'supports'      => $supports,
      'menu_position'   => 5,
      //'menu_icon'     => get_bloginfo('template_directory').'//images/quality-menu.png',
      'taxonomies'    => $taxonomies,
      'exclude_from_search' => true
     );
     register_post_type('discussion',$post_type_args);
  }
  add_action('init', 'register_discussion_posttype');

  // registration code for discussion post type
  function register_group_posttype() {
    $labels = array(
      'name'        => _x( 'Groups', 'post type general name' ),
      'singular_name'   => _x( 'Group', 'post type singular name' ),
      'add_new'       => __( 'Add New' ),
      'add_new_item'    => __( 'Group' ),
      'edit_item'     => __( 'Group' ),
      'new_item'      => __( 'Group' ),
      'view_item'     => __( 'Group' ),
      'search_items'    => __( 'Group' ),
      'not_found'     => __( 'Group' ),
      'not_found_in_trash'=> __( 'Group' ),
      'parent_item_colon' => __( 'Group' ),
      'menu_name'     => __( 'Groups' )
    );

     $taxonomies = array('post_tag', 'groups');

    $supports = array('title','editor','author','comments','page-attributes');

    $post_type_args = array(
      'labels'      => $labels,
      'singular_label'  => __('Group'),
      'public'      => true,
      'show_ui'       => true,
      'publicly_queryable'=> true,
      'query_var'     => true,
      'exclude_from_search'=> false,
      'show_in_nav_menus' => true,
      'capability_type'   => 'post',
      'has_archive'     => true,
      'hierarchical'    => true,
      'rewrite'       => array('slug' => 'groups', 'with_front' => false ),
      'supports'      => $supports,
      'menu_position'   => 5,
      //'menu_icon'     => get_bloginfo('template_directory').'//images/quality-menu.png',
      'taxonomies'    => $taxonomies,
      'exclude_from_search' => true
     );
     register_post_type('group',$post_type_args);
  }
  add_action('init', 'register_group_posttype');

  //Menu Order
  function custom_menu_order($menu_ord) {
	    if (!$menu_ord) return true;

	    return array(
	        'index.php', 							// Dashboard
	        'edit.php?post_type=policy', 			// Policy
	        'edit.php?post_type=quality', 			// Quality
	        'edit.php?post_type=institute',			// Insitute
	        'edit.php?post_type=webinar',			// Webinars
	        'separator1', 							// First separator
	        'edit.php?post_type=alert',				// Alerts
	        'edit.php?post_type=group',				// Groups
	        'edit.php?post_type=discussion',		// Discussions
	        'edit.php', 							// Posts
	        'edit.php?post_type=page', 				// Pages
	        'upload.php', 							// Media
	        'edit-comments.php', 					// Comments
	        'separator2', 							// Second separator
	        'themes.php', 							// Appearance
	        'plugins.php', 							// Plugins
	        'users.php', 							// Users
	        'tools.php', 							// Tools
	        'options-general.php',					// Settings
	        'separator-last', 						// Last separator
	    );
	}
	add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order
	add_filter('menu_order', 'custom_menu_order');



  //-------------CUSTOM TAXONOMIES----------------------------------------------------------------------------//

  	// registration code for series taxonomy
    function register_series_tax() {
      $labels = array(
        'name'          => _x( 'Stream', 'taxonomy general name' ),
        'singular_name'     => _x( 'Stream', 'taxonomy singular name' ),
        'add_new'         => _x( 'Add New Stream', 'Stream'),
        'add_new_item'      => __( 'Add New Stream' ),
        'edit_item'       => __( 'Edit Stream' ),
        'new_item'        => __( 'New Stream' ),
        'view_item'       => __( 'View Stream' ),
        'search_items'      => __( 'Search Streams' ),
        'not_found'       => __( 'No Streams found' ),
        'not_found_in_trash'  => __( 'No Streams found in Trash' ),
      );

      $pages = array('policy','quality','externallinks','institute','general');

      $args = array(
        'labels'      => $labels,
        'singular_label'  => __('Stream'),
        'public'      => true,
        'show_ui'       => true,
        'hierarchical'    => true,
        'show_tagcloud'   => false,
        'show_in_nav_menus' => true,
        'rewrite'       => array('slug' => 'series', 'with_front' => false ),
       );
      register_taxonomy('series', $pages, $args);
    }
    add_action('init', 'register_series_tax');

    // registration code for educationtopics taxonomy
    function register_educationtopics_tax() {
      $labels = array(
        'name'          => _x( 'Education Topics', 'taxonomy general name' ),
        'singular_name'     => _x( 'Education Topic', 'taxonomy singular name' ),
        'add_new'         => _x( 'Add New Education Topic', 'Education Topic'),
        'add_new_item'      => __( 'Add New Education Topic' ),
        'edit_item'       => __( 'Edit Education Topic' ),
        'new_item'        => __( 'New Education Topic' ),
        'view_item'       => __( 'View Education Topic' ),
        'search_items'      => __( 'Search Education Topics' ),
        'not_found'       => __( 'No Education Topic found' ),
        'not_found_in_trash'  => __( 'No Education Topic found in Trash' ),
      );

      $pages = array('policy','quality','institute','externallinks');

      $args = array(
        'labels'      => $labels,
        'singular_label'  => __('Education Topic'),
        'public'      => true,
        'show_ui'       => true,
        'hierarchical'    => true,
        'show_tagcloud'   => false,
        'show_in_nav_menus' => true,
        'rewrite'       => array('slug' => 'educationtopics', 'with_front' => false ),
       );
      register_taxonomy('educationtopics', $pages, $args);
    }
    add_action('init', 'register_educationtopics_tax');

    // registration code for educationtopics taxonomy
    function register_qualitytopics_tax() {
      $labels = array(
        'name'          => _x( 'Quality Topics', 'taxonomy general name' ),
        'singular_name'     => _x( 'Quality Topic', 'taxonomy singular name' ),
        'add_new'         => _x( 'Add New Quality Topic', 'Quality Topic'),
        'add_new_item'      => __( 'Add New Quality Topic' ),
        'edit_item'       => __( 'Edit Quality Topic' ),
        'new_item'        => __( 'New Quality Topic' ),
        'view_item'       => __( 'View Quality Topic' ),
        'search_items'      => __( 'Search Quality Topics' ),
        'not_found'       => __( 'No Quality Topic found' ),
        'not_found_in_trash'  => __( 'No Quality Topic found in Trash' ),
      );

      $pages = array('policy','quality','institute','externallinks','post');

      $args = array(
        'labels'      => $labels,
        'singular_label'  => __('Quality Topic'),
        'public'      => true,
        'show_ui'       => true,
        'hierarchical'    => true,
        'show_tagcloud'   => false,
        'show_in_nav_menus' => true,
        'rewrite'       => array('slug' => 'qualitytopics', 'with_front' => false ),
       );
      register_taxonomy('qualitytopics', $pages, $args);
    }
    add_action('init', 'register_qualitytopics_tax');


    // registration code for educationtopics taxonomy
    function register_policytopics_tax() {
      $labels = array(
        'name'          => _x( 'Action Topics', 'taxonomy general name' ),
        'singular_name'     => _x( 'Action Topic', 'taxonomy singular name' ),
        'add_new'         => _x( 'Add New Action Topic', 'Policy Topic'),
        'add_new_item'      => __( 'Add New Action Topic' ),
        'edit_item'       => __( 'Edit Action Topic' ),
        'new_item'        => __( 'New Action Topic' ),
        'view_item'       => __( 'View Action Topic' ),
        'search_items'      => __( 'Search Action Topics' ),
        'not_found'       => __( 'No Action Topic found' ),
        'not_found_in_trash'  => __( 'No Action Topic found in Trash' ),
      );

      $pages = array('policy','quality','institute','externallinks','post');

      $args = array(
        'labels'      => $labels,
        'singular_label'  => __('Action Topic'),
        'public'      => true,
        'show_ui'       => true,
        'hierarchical'    => true,
        'show_tagcloud'   => false,
        'show_in_nav_menus' => true,
        'rewrite'       => array('slug' => 'policytopics', 'with_front' => false ),
       );
      register_taxonomy('policytopics', $pages, $args);
    }
    add_action('init', 'register_policytopics_tax');


    // registration code for educationtopics taxonomy
    function register_institutetopics_tax() {
      $labels = array(
        'name'          => _x( 'Institute Topics', 'taxonomy general name' ),
        'singular_name'     => _x( 'Institute Topic', 'taxonomy singular name' ),
        'add_new'         => _x( 'Add New Institute Topic', 'Institute Topic'),
        'add_new_item'      => __( 'Add New Institute Topic' ),
        'edit_item'       => __( 'Edit Institute Topic' ),
        'new_item'        => __( 'New Institute Topic' ),
        'view_item'       => __( 'View Institute Topic' ),
        'search_items'      => __( 'Search Institute Topics' ),
        'not_found'       => __( 'No Institute Topic found' ),
        'not_found_in_trash'  => __( 'No Institute Topic found in Trash' ),
      );

      $pages = array('policy','quality','institute','externallinks');

      $args = array(
        'labels'      => $labels,
        'singular_label'  => __('Institute Topic'),
        'public'      => true,
        'show_ui'       => true,
        'hierarchical'    => true,
        'show_tagcloud'   => false,
        'show_in_nav_menus' => true,
        'rewrite'       => array('slug' => 'institutetopics', 'with_front' => false ),
       );
      register_taxonomy('institutetopics', $pages, $args);
    }
    add_action('init', 'register_institutetopics_tax');

    // registration code for institute centers taxonomy
    function register_institutecenters_tax() {
      $labels = array(
        'name'          => _x( 'Institute Centers', 'taxonomy general name' ),
        'singular_name'     => _x( 'Institute Center', 'taxonomy singular name' ),
        'add_new'         => _x( 'Add New Institute Center', 'Institute Center'),
        'add_new_item'      => __( 'Add New Institute Center' ),
        'edit_item'       => __( 'Edit Institute Center' ),
        'new_item'        => __( 'New Institute Center' ),
        'view_item'       => __( 'View Institute Center' ),
        'search_items'      => __( 'Search Institute Centers' ),
        'not_found'       => __( 'No Institute Center found' ),
        'not_found_in_trash'  => __( 'No Institute Center found in Trash' ),
      );

      $pages = array('institute','externallinks');

      $args = array(
        'labels'      => $labels,
        'singular_label'  => __('Institute Center'),
        'public'      => true,
        'show_ui'       => true,
        'hierarchical'    => true,
        'show_tagcloud'   => false,
        'show_in_nav_menus' => true,
        'has_archive' => true,
        'rewrite'       => array('slug' => 'center', 'with_front' => false ),
       );
      register_taxonomy('centers', $pages, $args);
    }
    add_action('init', 'register_institutecenters_tax');

    //Description Field for Centers
    function centers_tax_fields($tag){
	    // Check for existing taxonomy meta for the term you're editing
	    $t_id = $tag->term_id; // Get the ID of the term you're editing
	    $term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check
	?>

	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="presenter_id">About this Center</label>
		</th>
		<td>
			<textarea type="text" name="term_meta[about_center]" id="term_meta[about_center]" rows="5" style="width:95%;"><?php echo $term_meta['about_center'] ? $term_meta['about_center'] : ''; ?></textarea><br />
			<span class="description">About paragraph that will display on the archive page</span>
		</td>
	</tr>

	<?php
    }
    function centers_save_tax_fields($term_id){
	    if ( isset( $_POST['term_meta'] ) ) {
		        $t_id = $term_id;
		        $term_meta = get_option( "taxonomy_term_$t_id" );
		        $cat_keys = array_keys( $_POST['term_meta'] );
		            foreach ( $cat_keys as $key ){
		            if ( isset( $_POST['term_meta'][$key] ) ){
		                $term_meta[$key] = $_POST['term_meta'][$key];
		            }
		        }
		        //save the option array
		        update_option( "taxonomy_term_$t_id", $term_meta );
		    }
		}
    add_action( 'centers_edit_form_fields', 'centers_tax_fields', 10, 2 );
    add_action( 'edited_centers', 'centers_save_tax_fields', 10, 2 );

	// registration code for webinar topics taxonomy
    function register_webinartopics_tax() {
      $labels = array(
        'name'          => _x( 'Webinar Topics', 'taxonomy general name' ),
        'singular_name'     => _x( 'Webinar Topic', 'taxonomy singular name' ),
        'add_new'         => _x( 'Add New Webinar Topic', 'Institute Center'),
        'add_new_item'      => __( 'Add New Webinar Topic' ),
        'edit_item'       => __( 'Edit Webinar Topic' ),
        'new_item'        => __( 'New Webinar Topic' ),
        'view_item'       => __( 'View Webinar Topic' ),
        'search_items'      => __( 'Search Webinar Topics' ),
        'not_found'       => __( 'No Webinar Topics found' ),
        'not_found_in_trash'  => __( 'No Webinar Topics found in Trash' ),
      );

      $pages = array('webinar');

      $args = array(
        'labels'      => $labels,
        'singular_label'  => __('Webinar Topic'),
        'public'      => true,
        'show_ui'       => true,
        'hierarchical'    => true,
        'show_tagcloud'   => false,
        'show_in_nav_menus' => true,
        'has_archive' => true,
        'rewrite'       => array('slug' => 'webinars', 'with_front' => false ),
       );
      register_taxonomy('webinartopics', $pages, $args);
    }
    add_action('init', 'register_webinartopics_tax');

    // registration code for discussion taxonomy
    function register_discussion_tax() {
      $labels = array(
        'name'          => _x( 'Discussions', 'taxonomy general name' ),
        'singular_name'     => _x( 'Discussion', 'taxonomy singular name' ),
        'add_new'         => _x( 'Add New Discussion', 'Institute Center'),
        'add_new_item'      => __( 'Add New Discussion' ),
        'edit_item'       => __( 'Edit Discussion' ),
        'new_item'        => __( 'New Discussion' ),
        'view_item'       => __( 'View Discussions' ),
        'search_items'      => __( 'Search Discussions' ),
        'not_found'       => __( 'No Discussions found' ),
        'not_found_in_trash'  => __( 'No Discussions found in Trash' ),
      );

      $pages = array('discussion');

      $args = array(
        'labels'      => $labels,
        'singular_label'  => __('Discussion'),
        'public'      => true,
        'show_ui'       => true,
        'hierarchical'    => true,
        'show_tagcloud'   => false,
        'show_in_nav_menus' => false,
        'rewrite'       => array('slug' => 'discussions', 'with_front' => false ),
       );
      register_taxonomy('discussions', $pages, $args);
    }
    add_action('init', 'register_discussion_tax');

     // registration code for discussion tags taxonomy
    function register_discussionTags_tax() {
      $labels = array(
        'name'          => _x( 'Discussion Tags', 'taxonomy general name' ),
        'singular_name'     => _x( 'Discussion Tag', 'taxonomy singular name' ),
        'add_new'         => _x( 'Add New Discussion Tag', 'Institute Center'),
        'add_new_item'      => __( 'Add New Discussion Tag' ),
        'edit_item'       => __( 'Edit Discussion Tag' ),
        'new_item'        => __( 'New Discussion Tag' ),
        'view_item'       => __( 'View Discussion Tags' ),
        'search_items'      => __( 'Search Discussion Tags' ),
        'not_found'       => __( 'No Discussion Tags found' ),
        'not_found_in_trash'  => __( 'No Discussion Tags found in Trash' ),
      );

      $pages = array('discussion');

      $args = array(
        'labels'      => $labels,
        'singular_label'  => __('Discussion Tags'),
        'public'      => true,
        'show_ui'       => true,
        'hierarchical'    => true,
        'show_tagcloud'   => true,
        'show_in_nav_menus' => false,
        'has_archive' => true,
        'rewrite'       => array('slug' => 'discussion_tags', 'with_front' => false ),
       );
      register_taxonomy('discussion_tags', $pages, $args);
    }
    add_action('init', 'register_discussionTags_tax');



    function new_excerpt_more( $more ) {
        return ' ';
    }
    add_filter('excerpt_more', 'new_excerpt_more');

    add_filter('the_excerpt', 'my_excerpts');

    function my_excerpts($content = false) {
            global $post;
            $mycontent = $post->post_excerpt;

            $mycontent = $post->post_content;
            $mycontent = strip_shortcodes($mycontent);
            $mycontent = str_replace(']]>', ']]&gt;', $mycontent);
            $mycontent = strip_tags($mycontent);
            $excerpt_length = 30;
            $words = explode(' ', $mycontent, $excerpt_length + 1);
            if(count($words) > $excerpt_length) :
                array_pop($words);
                array_push($words, '...');
                $mycontent = implode(' ', $words);
            endif;
            $mycontent = '<p>' . $mycontent . '</p>';
    // Make sure to return the content
    return $mycontent;
}

function mytheme_enqueue_comment_reply() {
    // on single blog post pages with comments open and threaded comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        // enqueue the javascript that performs in-link comment reply fanciness
        wp_enqueue_script( 'comment-reply' );
    }
}
// Hook into wp_enqueue_scripts
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_comment_reply' );

function wpa_cpt_tags( $query ) {
    if ( $query->is_tag() && $query->is_main_query() ) {
        $query->set( 'post_type', array( 'policy', 'quality', 'institute' ) );
    }
}
add_action( 'pre_get_posts', 'wpa_cpt_tags' );

	///////////////////////////////////////
	// Register Custom Menu Function
	///////////////////////////////////////
	if (function_exists('register_nav_menus')) {
		register_nav_menus( array(
			'main-nav' => __( 'Main Navigation', 'themify' ),
			'alt-nav' => __( 'Logged-in Navigation', 'themify' ),
			'footer-nav' => __( 'Footer Navigation', 'themify' ),
		) );
	}

    ///////////////////////////////////////
	// Default Alternative Nav Function (When Already Logged in)
	///////////////////////////////////////
	function default_alt_nav() {
		echo '<ul id="alt-nav" class="alt-nav clearfix">';
		wp_list_pages('title_li=');
		echo '</ul>';
	}


    ///////////////////////////////////////
	// Content for the Member Profile page
	///////////////////////////////////////

add_filter( 'wpmem_member_links', 'my_member_links' );
function my_member_links( $links )
{
// get the current_user object
global $current_user;
get_currentuserinfo();

     // format the date they registered
$regdate = strtotime( $current_user->user_registered );

// and the user info
$str = '<div id="theuser">
<h3 id="userlogin"><span style="color: white">' . $current_user->user_login . '</span></h3>
        <div id="useravatar">' . get_avatar( $current_user->ID, '82' ) . '</div>
          <dl id="userinfo">
			  <dt>Member Since</dt>
			  <dd>' . date( 'M d, Y', $regdate ) . '</dd>
			  <dt>Website</dt>
			  <dd><a class="url" href="' . $current_user->user_url . '" rel="nofollow">' . $current_user->user_url . '</a></dd>
			  <dt>Location</dt>
			  <dd>'
				. get_user_meta( $current_user->ID, 'city', true )
				. ', '
				. get_user_meta( $current_user->ID, 'thestate', true )
				. '</dd>
          </dl>
        </div>
        <hr />';

     // tag the original links on to the end
     $string = $str . $links;

     // send back our content
     return $string;
}

	///////////////////////////////////////
	// Register Sidebar A and B
	///////////////////////////////////////
	if ( function_exists('register_sidebar') ) {
		register_sidebar(array(
			'name' => 'Sidebar A',
			'id' => 'sidebara',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		));
	}
	if ( function_exists('register_sidebar') ) {
		register_sidebar(array(
			'name' => 'Sidebar B',
			'id' => 'sidebarb',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		));
	}

	/* get featured image url function */
	function mdw_featured_img_url( $mdw_featured_img_size ) {
		$mdw_image_id = get_post_thumbnail_id();
		$mdw_image_url = wp_get_attachment_image_src( $mdw_image_id, $mdw_featured_img_size );
		$mdw_image_url = $mdw_image_url[0];
		return $mdw_image_url;
	}

add_image_size('cat-thumb', 120, 90);

/***************************************************************************************************/
function aeh_member($user_id) {
global $wpdb;
	$domain_table = $wpdb->prefix . "aeh_email";
	$user_info = get_userdata($user_id);
	$email = $user_info->user_email;
	$return = explode('@', $email);
	$domain = $return[1]; 									/* this is the email domain of the registered user */
	update_user_meta( $user_id, 'email_domain', $domain );	/* save the domain in a new user_meta value */
	$result = $wpdb->get_row("SELECT * FROM $domain_table WHERE `domain` = '$domain'");

	$aeh_staff = "N";
	if ($result->domain == $domain){
		$member_type = 'hospital';
		$aeh_staff = $result->staff;
	}else{
		$member_type = 'public';
	}
	update_user_meta( $user_id, 'aeh_member_type', $member_type); // initialize the member type in meta table
	update_user_meta( $user_id, 'aeh_staff', $aeh_staff);		  // initialize the staff type in meta table
	update_user_meta( $user_id, 'title', "");
	update_user_meta( $user_id, 'job_title', "");
	update_user_meta( $user_id, 'job_function', "");
	update_user_meta( $user_id, 'employer', "");
	update_user_meta( $user_id, 'tos', 'agree');
	delete_user_meta( $user_id, 'password'); //remove the plaintext password from the DB
}
add_action('profile_update', 'aeh_member', 10, 2);
//add_action('bp_core_signup_user', 'aeh_member', 10, 2);

define ("CUSTOM_NEWS_URL", home_url("custom-news-feed/"));

function get_member_type(){
	$member = array();
	$current_user= wp_get_current_user();
	$member[0]   = $current_user->ID;
	$member[1]   = get_user_meta($member[0], 'aeh_member_type', TRUE);
	$member[2]   = get_user_meta($member[0], 'email_domain', TRUE);
	return $member;
}

function alertbox_check($userID){
	$return = ""; //presume no need for alerts at first
	if (get_user_meta($userID, 'custom_news_feed', TRUE) == ""){
		$return = "You have not set up your custom news feed yet.<br /><a href=" . CUSTOM_NEWS_URL . ">Click here to set up your custom news settings.</a>"; //user has no custom news feed so signal an alert
	}
	return $return;
}

function get_excerpt_by_id($post_id, $words){
	$the_post = get_post($post_id); //Gets post ID
	$the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
	$excerpt_length = $words; //Sets excerpt length by word count
	$the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
	$words = explode(' ', $the_excerpt, $excerpt_length + 1);
	if(count($words) > $excerpt_length) :
		array_pop($words);
		array_push($words, '…');
		$the_excerpt = implode(' ', $words);
	endif;
	//$the_excerpt = '<p>' . $the_excerpt . '</p>';
	return $the_excerpt;
}

//Create new Group/Webinar cat on publication
function new_cat_group( $new_status, $old_status, $post ) {
    if ( $old_status != 'publish' && $new_status == 'publish' ) {
        $postType = $_POST['post_type'];
        if($postType == 'group' || $postType == 'webinar'){
	        $postID = $_POST['ID'];
			$parent_term = term_exists( $postType, 'discussions' ); // array is returned if taxonomy is given
			$parent_term_id = $parent_term['term_id']; // get numeric term id
			wp_insert_term(
			  $postType.'-'.$postID, // the term
			  'discussions', // the taxonomy
			  array(
			    'slug' => $postID,
			    'parent'=> $parent_term_id
			  )
			);
        }
    }
}
add_action( 'transition_post_status', 'new_cat_group', 10, 3 );

//Create Webinar discussion tax



// ----- Member Network -----

class myUsers {
	static function init() {
		// Change the user's display name after insertion
		add_action( 'user_register', array( __CLASS__, 'change_display_name' ) );
	}

	static function change_display_name( $user_id ) {
		$info = get_userdata( $user_id );

		$args = array(
			'ID' => $user_id,
			'display_name' => $info->first_name . ' ' . $info->last_name
		);

		wp_update_user( $args ) ;
	}
}

myUsers::init();


add_filter( 'wpmem_login_redirect', 'my_login_redirect' );

function my_login_redirect()
{
	// return the url that the login should redirect to
	return site_url( 'membernetwork/dashboard' );
}

function remove_from_db( $user_id ) {
	global $wpdb;
	$wpdb->query( "DELETE FROM `wp_aeh_connections` WHERE `user_ID` = $user_id OR `friend_ID` = $user_id" );
}
add_action( 'delete_user', 'remove_from_db' );


//Change Private to Association Members Only
function custom_admin_js() {
    $url = get_option('siteurl');
    $url = get_bloginfo('template_directory') . '/js/wp-admin.js';
    echo '"<script type="text/javascript" src="'. $url . '"></script>"';
}
add_action('admin_footer', 'custom_admin_js');


//Staff Settings Admin Panel & Email Verification
add_filter('admin_init', 'my_general_settings_register_fields');

function my_general_settings_register_fields()
{
    register_setting('general', 'email_ver', 'esc_attr');
    add_settings_field('email_ver', '<label for="email_ver">'.__('Verified Email Addresses' , 'my_field' ).'</label>' , 'my_general_settings_fields_html', 'general');
}

function my_general_settings_fields_html()
{
    $value = get_option( 'email_ver', '' );

}

add_action('user_register', 'email_verification');
function email_verification($user_id) {
    if ( isset( $_POST['user_email'] ) ){
        $uEmail = $_POST['user_email'];
		if(strpos($uEmail,'essentialhospitals.org') !== false){
			update_user_meta($user_id,'staff_mem','Y');
		}else{
			update_user_meta($user_id,'staff_mem','N');
		}
    }
}

?>