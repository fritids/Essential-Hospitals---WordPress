<?php
//Global Variables

add_action('init', 'register_my_menus');
add_action('init', 'loadup_scripts'); // Add Custom Scripts

function register_my_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __('Primary Menu'),
      'utility-menu' => __('Utility Navigation'),
			'footer-menu' => __('Footer Menu')
		)	
	);
}

 
//show_admin_bar(false);
 

function loadup_scripts()
{
    if (!is_admin()) {
        wp_deregister_script('jquery'); // Deregister WordPress jQuery
        wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js' ); // Google CDN jQuery
        wp_enqueue_script('jquery'); // Enqueue it!


		//Pat Script - registered
        wp_register_script('masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js');
		wp_register_script('jquerytools', get_template_directory_uri() . '/js/jquery.tools.min.js');
		wp_register_script('ajaxquery', get_template_directory_uri() . '/js/script-pat.js');
        
        //Pat Script - queued
        wp_enqueue_script('masonry');
        wp_enqueue_script('jquerytools');
        wp_enqueue_script('ajaxquery');
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

  //add_filter('user_contactmethods','rynonuke_contactmethods',10,1);  // add facebook and twitter account to user profil

  /* Add admin custom actions styles*/
    //add_action('login_head', 'style_my_login_please'); // add a custom css for the login form
    // add_action('admin_head', 'style_my_admin_please'); // add a custom css for the admin area

  
  
  
  
  /***************** Security + header clean-ups ************************/

  /** remove the wlmanifest (useless !!) */
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'rsd_link');
  remove_action( 'wp_head', 'index_rel_link' ); // index link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
  // remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
  // remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
  //remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
  remove_action('wp_head','start_post_rel_link');
  remove_action('wp_head','adjacent_posts_rel_link_wp_head');
  remove_action('wp_head', 'wp_generator'); // remove WP version from header
  remove_action('wp_head','wp_shortlink_wp_head');
  remove_filter( 'the_content', 'capital_P_dangit' ); // Get outta my Wordpress codez dangit!
  remove_filter( 'the_title', 'capital_P_dangit' );
  remove_filter( 'comment_text', 'capital_P_dangit' );

  
  // removes detailed login error information for security
  add_filter('login_errors',create_function('$a', "return null;")); 
  /**---------------------------------------------------------------------------------------------------*/    
  
 




 /* Here come my different fonctions 
  * 
  * 
  * */
  
/*** cleaning up the dashboard- ----------------------------------------*/
function remove_dashboard_widgets(){
  
  //remove_meta_box('dashboard_right_now','dashboard','core'); // right now overview box
  remove_meta_box('dashboard_incoming_links','dashboard','core'); // incoming links box
  remove_meta_box('dashboard_quick_press','dashboard','core'); // quick press box
  remove_meta_box('dashboard_plugins','dashboard','core'); // new plugins box
  remove_meta_box('dashboard_recent_drafts','dashboard','core'); // recent drafts box
  //remove_meta_box('dashboard_recent_comments','dashboard','core'); // recent comments box
  remove_meta_box('dashboard_primary','dashboard','core'); // wordpress development blog box
  remove_meta_box('dashboard_secondary','dashboard','core'); // other wordpress news box
    
  
} 

/*----------------------------------------------------------------------*/


/* Remove some menus froms the admin area*/
function delete_menu_items() {
  
  /*** Remove menu http://codex.wordpress.org/Function_Reference/remove_menu_page 
  syntaxe : remove_menu_page( $menu_slug )  **/
  //remove_menu_page('index.php'); // Dashboard
  //remove_menu_page('edit.php'); // Posts
  //remove_menu_page('upload.php'); // Media
  //remove_menu_page('link-manager.php'); // Links
  //remove_menu_page('edit.php?post_type=page'); // Pages
  //remove_menu_page('edit-comments.php'); // Comments
  //remove_menu_page('themes.php'); // Appearance
  //remove_menu_page('plugins.php'); // Plugins
  //remove_menu_page('users.php'); // Users
  //remove_menu_page('tools.php'); // Tools
  //remove_menu_page('options-general.php'); // Settings
    
    
    
  /*** Remove submenu http://codex.wordpress.org/Function_Reference/remove_submenu_page 
  syntaxe : remove_submenu_page( $menu_slug, $submenu_slug ) **/
  //remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' ); // remove tags from edit
}

/*----------------------------------------------------------------------*/


/* remove some meta boxes from pages and posts -------------------------
feel free to comment / uncomment  */

function customize_meta_boxes() {
  /* Removes meta boxes from Posts */
  //remove_meta_box('postcustom','post','normal'); // custom fields metabox
  //remove_meta_box('trackbacksdiv','post','normal'); // trackbacks metabox 
  //remove_meta_box('commentstatusdiv','post','normal'); // comment status metabox 
  //remove_meta_box('commentsdiv','post','normal'); // comments  metabox 
  //remove_meta_box('postexcerpt','post','normal'); // post excerpts metabox 
  //remove_meta_box('authordiv','post','normal'); // author metabox 
  //remove_meta_box('revisionsdiv','post','normal'); // revisions  metabox 
  //remove_meta_box('tagsdiv-post_tag','post','normal'); // tags
  //remove_meta_box('slugdiv','post','normal'); // slug metabox 
  //remove_meta_box('categorydiv','post','normal'); // comments metabox
  //remove_meta_box('postimagediv','post','normal'); // featured image metabox
  //remove_meta_box('formatdiv','post','normal'); // format metabox 
  
  
  /* Removes meta boxes from pages */   
  remove_meta_box('postcustom','page','normal'); // custom fields metabox
  remove_meta_box('trackbacksdiv','page','normal'); // trackbacks metabox
  //remove_meta_box('commentstatusdiv','page','normal'); // comment status metabox 
  //remove_meta_box('commentsdiv','page','normal'); // comments  metabox 
  //remove_meta_box('authordiv','page','normal'); // author metabox 
  //remove_meta_box('revisionsdiv','page','normal'); // revisions  metabox 
  //remove_meta_box('postimagediv','page','side'); // featured image metabox
  //remove_meta_box('slugdiv','page','normal'); // slug metabox 
 
  
  
  /* remove meta boxes for links **/
  //remove_meta_box('linkcategorydiv','link','normal');
  //remove_meta_box('linkxfndiv','link','normal');
  //remove_meta_box('linkadvanceddiv','link','normal');
  
}

/*-----------------------------------------------------------------------*/





/** removing parts from column ------------------------------------------*/
/* use the column id, if you need to hide more of them
syntaxe : unset($defaults['columnID']);   */

/** remove column entries from posts **/
function custom_post_columns($defaults) {
  //unset($defaults['comments']); // comments 
  //unset($defaults['author']); // authors
  //unset($defaults['tags']); // tag 
  //unset($defaults['date']); // date
  //unset($defaults['categories']); // categories    
  return $defaults;
}


/** remove column entries from pages **/
function custom_pages_columns($defaults) {
  //unset($defaults['comments']); // comments 
  //unset($defaults['author']); // authors
  //unset($defaults['date']);  // date 
  return $defaults;
}

/*-----------------------------------------------------------------------**/


/** remove widgets from the widget page ------------------------------------*/
/* Credits : http://wpmu.org/how-to-remove-default-wordpress-widgets-and-clean-up-your-widgets-page/ 
uncomment what you want to remove  */
 function unregister_default_widgets() {
     // unregister_widget('WP_Widget_Pages');
     // unregister_widget('WP_Widget_Calendar');
     // unregister_widget('WP_Widget_Archives');
    //unregister_widget('WP_Widget_Links');
     // unregister_widget('WP_Widget_Meta');
     // unregister_widget('WP_Widget_Search');
     // unregister_widget('WP_Widget_Text');
     // unregister_widget('WP_Widget_Categories');
     // unregister_widget('WP_Widget_Recent_Posts');
     // unregister_widget('WP_Widget_Recent_Comments');
     // unregister_widget('WP_Widget_RSS');
     // unregister_widget('WP_Widget_Tag_Cloud');
     //unregister_widget('WP_Nav_Menu_Widget');
    //unregister_widget('Twenty_Eleven_Ephemera_Widget');
 }





/****** removings items froms admin bars 
use the last part of the ID after "wp-admin-bar-" to add some menu to the list  exemple for comments : id="wp-admin-bar-comments" so the id to use is "comments"  ***********/
function wce_admin_bar_render() {
global $wp_admin_bar;
  //$wp_admin_bar->remove_menu('comments'); //remove comments
  $wp_admin_bar->remove_menu('wp-logo'); //remove the whole wordpress logo, help etc part
  
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

 
/*----------------------------------------------------------------------- **/



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
/** stylesheet link for login **/
//echo '<link rel="stylesheet" type="text/css" href="' .plugins_url( 'css/custom_login.css' , __FILE__ ). '"/>';
}

/** stylesheet link for admin **/
function style_my_admin_please() {
   // echo '<link rel="stylesheet" type="text/css" href="' .plugins_url( 'css/custom_admin.css' , __FILE__ ).'"/>';
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
// registration code for policy post type
  function register_policy_posttype() {
    $labels = array(
      'name'        => _x( 'Policy', 'post type general name' ),
      'singular_name'   => _x( 'Policy', 'post type singular name' ),
      'add_new'       => __( 'Add New' ),
      'add_new_item'    => __( 'Policy' ),
      'edit_item'     => __( 'Policy' ),
      'new_item'      => __( 'Policy' ),
      'view_item'     => __( 'Policy' ),
      'search_items'    => __( 'Policy' ),
      'not_found'     => __( 'Policy' ),
      'not_found_in_trash'=> __( 'Policy' ),
      'parent_item_colon' => __( 'Policy' ),
      'menu_name'     => __( 'Policy' )
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
      'menu_position'   => 5,
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
      'has_archive'     => true,
      'hierarchical'    => false,
      'rewrite'       => array('slug' => 'quality', 'with_front' => false ),
      'supports'      => $supports,
      'menu_position'   => 5,
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
      'has_archive'     => true,
      'hierarchical'    => false,
      'rewrite'       => array('slug' => 'institute', 'with_front' => false ),
      'supports'      => $supports,
      'menu_position'   => 5,
      'menu_icon'     => get_bloginfo('template_directory').'/images/institute-menu.png',
      'taxonomies'    => $taxonomies
     );
     register_post_type('institute',$post_type_args);
  }
  add_action('init', 'register_institute_posttype');

// registration code for links post type

  function register_externallinks_posttype() {
    $labels = array(
      'name'        => _x( 'External Links', 'post type general name' ),
      'singular_name'   => _x( 'External Link', 'post type singular name' ),
      'add_new'       => __( 'Add New' ),
      'add_new_item'    => __( 'External Links' ),
      'edit_item'     => __( 'External Links' ),
      'new_item'      => __( 'External Links' ),
      'view_item'     => __( 'External Links' ),
      'search_items'    => __( 'External inks' ),
      'not_found'     => __( 'External Links' ),
      'not_found_in_trash'=> __( 'External Links' ),
      'parent_item_colon' => __( 'External Links' ),
      'menu_name'     => __( 'External Links' )
    );
    
     $taxonomies = array('post_tag', 'policytopics', 'educationtopics', 'qualitytopics', 'institutetopics');

    $supports = array('title','editor','author','custom-fields','revisions');
    
    $post_type_args = array(
      'labels'      => $labels,
      'singular_label'  => __('External Link'),
      'public'      => true,
      'show_ui'       => true,
      'publicly_queryable'=> true,
      'query_var'     => true,
      'exclude_from_search'=> false,
      'show_in_nav_menus' => true,
      'capability_type'   => 'post',
      'has_archive'     => true,
      'hierarchical'    => false,
      'rewrite'       => array('slug' => 'externallinks', 'with_front' => false ),
      'supports'      => $supports,
      'menu_position'   => 5,
      'menu_icon'     => get_bloginfo('template_directory').'/images/education-menu.png',
      'taxonomies'    => $taxonomies
     );
     register_post_type('externallinks',$post_type_args);
  }
  add_action('init', 'register_externallinks_posttype');

  //-------------CUSTON TAXONOMIES----------------------------------------------------------------------------//

  // registration code for series taxonomy
    function register_series_tax() {
      $labels = array(
        'name'          => _x( 'Series', 'taxonomy general name' ),
        'singular_name'     => _x( 'Series', 'taxonomy singular name' ),
        'add_new'         => _x( 'Add New Series', 'Series'),
        'add_new_item'      => __( 'Add New Series' ),
        'edit_item'       => __( 'Edit Series' ),
        'new_item'        => __( 'New Series' ),
        'view_item'       => __( 'View Series' ),
        'search_items'      => __( 'Search Series' ),
        'not_found'       => __( 'No Series found' ),
        'not_found_in_trash'  => __( 'No Series found in Trash' ),
      );
      
      $pages = array('policy','quality','externallinks','institute');
      
      $args = array(
        'labels'      => $labels,
        'singular_label'  => __('Series'),
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
      
      $pages = array('policy','quality','institute','externallinks');
      
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
        'name'          => _x( 'Policy Topics', 'taxonomy general name' ),
        'singular_name'     => _x( 'Policy Topic', 'taxonomy singular name' ),
        'add_new'         => _x( 'Add New Policy Topic', 'Policy Topic'),
        'add_new_item'      => __( 'Add New Policy Topic' ),
        'edit_item'       => __( 'Edit Policy Topic' ),
        'new_item'        => __( 'New Policy Topic' ),
        'view_item'       => __( 'View Policy Topic' ),
        'search_items'      => __( 'Search Policy Topics' ),
        'not_found'       => __( 'No Policy Topic found' ),
        'not_found_in_trash'  => __( 'No Policy Topic found in Trash' ),
      );
      
      $pages = array('policy','quality','institute','externallinks');
      
      $args = array(
        'labels'      => $labels,
        'singular_label'  => __('Policy Topic'),
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
      
      $pages = array('policy','quality','institute','externallinks');
      
      $args = array(
        'labels'      => $labels,
        'singular_label'  => __('Institute Center'),
        'public'      => true,
        'show_ui'       => true,
        'hierarchical'    => true,
        'show_tagcloud'   => false,
        'show_in_nav_menus' => true,
        'rewrite'       => array('slug' => 'institutecenters', 'with_front' => false ),
       );
      register_taxonomy('institutecenters', $pages, $args);
    }
    add_action('init', 'register_institutecenters_tax');



?>