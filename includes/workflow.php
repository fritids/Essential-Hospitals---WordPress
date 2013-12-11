<?php
// ----- Custom Status -----
add_action( 'init', 'custom_stati' );
function custom_stati(){
	register_post_status( 'pending_publication', array(
		'label'                     => _x( 'Pending Publication', 'post' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Pending Publication <span class="count">(%s)</span>', 'Pending Publication <span class="count">(%s)</span>' ),
	) );

	register_post_status( 'pending_review', array(
		'label'                     => _x( 'Pending Review', 'post' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Pending Review VP <span class="count">(%s)</span>', 'Pending Review VP <span class="count">(%s)</span>' ),
	) );
}


// ----- Custom Status selector per role
add_action('admin_footer-post.php', 'status_list');
add_action('admin_footer-post-new.php', 'status_list');
function status_list(){
     global $post;
     global $current_user;
	 get_currentuserinfo();
	 $userRole = implode(', ',$current_user->roles);
     $postStatus = $post->post_status;

	 if($userRole != 'administrator'){
	 	if($post->post_type != 'page'){
			 if($userRole == 'vp' || $userRole == 'avp'){
				 $output .=  "<script>jQuery(document).ready(function($){";
				 if($postStatus == 'pending_publication'){
					$output .= "$('span#post-status-display').text('Pending Publication');";
				 }elseif($postStatus == 'pending_review'){
					 $output .= "$('span#post-status-display').text('Pending Review');";
				 }
			 	 $output .=	 "$('select#post_status').empty();
			 			$('select#post_status').append('<option value=\"pending_publication\">Pending Publication</option><option value=\"pending_review\">Pending Review</option><option value=\"draft\">Draft</option>');
			 			$('input#publish').attr('name','save').val('Update');


			 			$('a.save-post-status').on('click',function(){
			 				var opt = $('select#post_status option:selected').text();
			 				$('span#post-status-display').text(opt);
			 				$('input#save-post').val('Save as '+opt);
			 			});
			 		});
			 	   </script>";
			 }elseif($userRole == 'content_creator'){
				 $output .=  "<script>jQuery(document).ready(function($){";
				 if($postStatus == 'pending_publication'){
					$output .= "$('span#post-status-display').text('Pending Publication');";
				 }elseif($postStatus == 'pending_review'){
					 $output .= "$('span#post-status-display').text('Pending Review');";
				 }
			 	 $output .=	 "$('select#post_status').empty();
			 				$('select#post_status').append('<option value=\"pending\">Pending Review</option><option value=\"draft\">Draft</option>');
			 			$('input#publish').attr('name','save').val('Update');


			 			$('a.save-post-status').on('click',function(){
			 				var opt = $('select#post_status option:selected').text();
			 				console.log(opt);
			 				$('span#post-status-display').text(opt);
			 				$('input#save-post').val('Save as '+opt);
			 			});
			 		});
			 	   </script>";
			 }
	     echo $output;
	     }
	 }

}


// ----- Choose next editor -----
add_action( 'post_submitbox_misc_actions', 'next_editor' );
function next_editor(){
	global $current_user;
	global $post;
	get_currentuserinfo();
	$userRole = implode(', ',$current_user->roles);
	$postType = $post->post_type;

	if($userRole == 'vp' || $userRole == 'avp' || $userRole == 'content_creator'){
		$output .= "<div class='misc-pub-section'><label for='editor'>Editor: </label>";
		if($userRole == 'vp'){
			$args = array(
				'role' => 'administrator'
			);
			$admins = get_users($args);
			$output .= '<select id="editor" name="editor">';
			foreach($admins as $admin){
				$output .= '<option value="'.$admin->ID.'">'.$admin->display_name.'</option>';
			}
			$output .= '</select>';

		}elseif($userRole == 'avp'){
			$args = array(
				'role' => 'vp'
			);
			$editors = get_users($args);
			$args = array(
				'role' => 'administrator'
			);
			$admins = get_users($args);


			$output .= '<select id="editor" name="editor">';
			$output .= '<optgroup label="Admins">';
			foreach($admins as $admin){
				$output .= '<option value="'.$admin->ID.'">'.$admin->display_name.'</option>';
			}
			$output .= '</optgroup>';

			if(count($editors) > 0){
				$output .= '<optgroup label="VPs">';
				foreach($editors as $editor){
					$uMeta = get_user_meta($editor->ID, 'staffPermissions', true);
					if(in_array($postType, $uMeta)){
						$output .= '<option value="'.$editor->ID.'">'.$editor->display_name.'</option>';

					}
				}
				$output .= '</optgroup>';
			}
			$output .= '</select>';
		}elseif($userRole == 'content_creator'){
			$args = array(
				'role' => 'avp'
			);
			$editors = get_users($args);
			if(count($editors) > 0){
			$output .= '<select id="editor" name="editor">';
				foreach($editors as $editor){
					$uMeta = get_user_meta($editor->ID, 'staffPermissions', true);
					if(in_array($postType, $uMeta)){

						$output .= '<option value="'.$editor->ID.'">'.$editor->display_name.'</option>';

					}
				}
			$output .= '</select>';
			}else{
				$output .= "<strong>No Editors found</strong>";
			}
		}
		$output .= "</div>";
		echo $output;
	}
}

// ----- Editor email functions -----
function post_status_changed( $new_status, $old_status, $post ) {
	$postEditorID = $_POST['editor'];
	$old_statusX = $old_status;
	$new_statusX = $new_status;
	$siteURL = site_url();

	if($postEditorID != ''){
		$postEditor = get_userdata($postEditorID);


		$headers[] = 'From: AEH Alert <alert@naph.org>';
		$headers[] = 'Content-type: text/html';
		$subject = 'America\'s Essential Hospitals Content Review Request';



		//Admin email
		if ( $old_status == 'pending' && $new_status == 'pending_publication' || $old_status == 'pending_review' && $new_status == 'pending_publication' ) {
			$to = $postEditor->user_email;
			$article_title = $post->post_title;
			$authorDet = get_userdata($post->post_author);
			$author_name   = $authorDet->display_name;
			$author_notes  = '';

			$post_link     = $siteURL.'/wp-admin/post.php?post='.$post->ID.'&action=edit';
			$post_date     = date("m-d-Y");

			$message .= email_template($old_statusX, $new_statusX, $article_title, $author_name, $author_notes, $post_link, $post_date);

			wp_mail( $to, $subject, $message, $headers );
	    }

		//Editor email
	    if ( $old_status == 'pending' && $new_status == 'pending_review' ) {
			$to = $postEditor->user_email;
			$article_title = $post->post_title;
			$authorDet = get_userdata($post->post_author);
			$author_name   = $authorDet->display_name;
			$author_notes  = '';
			$post_link     = $siteURL.'/wp-admin/post.php?post='.$post->ID.'&action=edit';
			$post_date     = date("m-d-Y");

			$message .= email_template($old_statusX, $new_statusX, $article_title, $author_name, $author_notes, $post_link, $post_date);

			wp_mail( $to, $subject, $message, $headers );
	    }

	    //Author email
	    if ( $old_status == 'draft' && $new_status == 'pending' || $old_status == 'new' && $new_status == 'pending') {
			$to = $postEditor->user_email;
			$article_title = $post->post_title;
			$authorDet = get_userdata($post->post_author);
			$author_name   = $authorDet->display_name;
			$author_notes  = '';
			$post_link     = $siteURL.'/wp-admin/post.php?post='.$post->ID.'&action=edit';
			$post_date     = date("m-d-Y");

			$message .= email_template($old_statusX, $new_statusX, $article_title, $author_name, $author_notes, $post_link, $post_date);

			wp_mail( $to, $subject, $message, $headers );
	    }

    }
}
add_action( 'transition_post_status', 'post_status_changed', 10, 3 );

function email_template($old_status, $new_status, $article_title, $author_name, $author_notes, $post_link, $post_date){
 return "<html>
<head>
    <title>test</title>
    <link href=\"ve_iframe_style.jsp?version=2013.5.0-20130531.121450\" rel=\"stylesheet\" type=\"text/css\">
    <link href=\"eve_iframe_style.jsp?version=2013.5.0-20130531.121450\" rel=\"stylesheet\" type=\"text/css\">
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js\" type=\"text/javascript\">
</script>
    <script src=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js\" type=\"text/javascript\">
</script>
    <link href=\"/core/css/jquery-ui/1.8.17/jquery.ui.base.css?version=2013.5.0-20130531.121450\" media=\"all\" rel=\"stylesheet\" type=\"text/css\">
    <script type=\"text/javascript\">
    jQuery.noConflict();
    </script>
    <script type=\"text/javascript\">
var NREUMQ=NREUMQ||[];NREUMQ.push([\"mark\",\"firstbyte\",new Date().getTime()]);
    </script>
    <style type=\"text/css\">
    html {overflow-y: auto !important; }
        .imgRedX {
            background-position: 0 0;
            background-clip: padding-box;
            background-repeat: no-repeat;
            background-image: url(data:image/jpg;base64,/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAAYEBAQFBAYFBQYJBgUGCQsIBgYICwwKCgsKCgwQDAwMDAwMEAwODxAPDgwTExQUExMcGxsbHCAgICAgICAgICD/2wBDAQcHBw0MDRgQEBgaFREVGiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICD/wAARCAAUABQDAREAAhEBAxEB/8QAFwAAAwEAAAAAAAAAAAAAAAAABAUGB//EACwQAAEDAwMBBQkAAAAAAAAAAAIBBAUDBhEAEjEHEyFBUVIVIkJhcZGxwfD/xAAZAQEAAwEBAAAAAAAAAAAAAAADAgQGAQX/xAAsEQACAQIDBQcFAAAAAAAAAAABAgMABBEhMQUSIkFhE1FxsdHh8CMyYoHB/9oADAMBAAIRAxEAPwDXbmuO7LIugpeTqHKWXIKAVtoJvYFwhIg8ivj5/XmrM7Rtvax+XtWjsLW3vYOxXgulxw7pOnQ/PA+9uqLSOZs2dtoMzcEyKLEtqPvjtPisePh/uM67NchRlmx0HzlQbN2K0rsZvpwx/eT5Dr87qoLLjbjj7foULhkPaMqqlUr1sIiCpru7MVRE3IPn+tJCrBeI4mqW0poZJiYF3I+Q/v7pB1MvZtHt0txg0GXuKWHsm0ZjeKCfdvrJ6fkv41Ce43Mhmx0Hr0ptmbPMp7RjuRJmW9OtQEJASvSKUbTUo1pSMU/pDRkXjcM1WRkuVSmvo8/V9s0UhNtxnMHXp7Vobq/TaqmJSUdTioJyfx/Kt0Yvmb9nReM6wuGrgUOjWBciQrwqLr1VYEYisZIhQ7rZEUrjbNt6OnHs42bYlH+O3cGSmuE8A3Z2ouO/HOoCJQxbmaV7uRoxGTwLoKavGbV61qtHdIazasKhVpGmRIV8F0lACQcRrQNt2zEW5FjGRVJaTQTOogkRGu41yveWdHHEEGA0prm5eZ99zi1f/9k=);
            border: 1px inset;
            font-family: arial, sans-serif;
            font-size: 11px;
            font-weight: normal;
            font-style: normal;
            text-align: left;
        }

    </style>
</head>

<body topmargin=\"0\" leftmargin=\"0\" rightmargin=\"0\">
    <div id=\"rootDiv\" style=\"\">
        <div align=\"center\">
            <table style=\"background-color:#d6d6d6;\" bgcolor=\"#D6D6D6\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                <tbody>
                    <tr>
                        <td style=\"padding:14px 14px 14px 14px;\" valign=\"top\" rowspan=\"1\" colspan=\"1\" align=\"center\">
                            <table style=\"background:transparent;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                <tbody>
                                    <tr>
                                        <td valign=\"top\" width=\"100%\" rowspan=\"1\" colspan=\"1\" align=\"center\">
                                            <table style=\"width:600px;\" border=\"0\" width=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                                                <tbody>
                                                    <tr>
                                                        <td style=\"padding:0px 0px 0px 0px;\" valign=\"top\" width=\"100%\" rowspan=\"1\" colspan=\"1\" align=\"center\">
                                                            <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style=\"padding-bottom:11px;height:1px;line-height:1px;\" height=\"1\" rowspan=\"1\" colspan=\"1\" align=\"center\"><img height=\"1\" vspace=\"0\" border=\"0\" hspace=\"0\" width=\"5\" style=\"display: block;\" alt=\"\" src=\"https://imgssl.constantcontact.com/letters/images/1101116784221/S.gif\"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table style=\"width:600px;\" border=\"0\" width=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                                <tbody>
                                    <tr>
                                        <td style=\"background-color:#000000;padding:1px 1px 1px 1px;\" bgcolor=\"#000000\" valign=\"top\" rowspan=\"1\" colspan=\"1\" align=\"center\">
                                            <table style=\"background-color:#ffffff;\" bgcolor=\"#FFFFFF\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                                <tbody>
                                                    <tr>
                                                        <td valign=\"top\" rowspan=\"1\" colspan=\"1\" align=\"center\">
                                                            <table style=\"background:transparent;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style=\"padding:0px 0px 0px 0px;\" valign=\"top\" width=\"100%\" rowspan=\"1\" colspan=\"1\" align=\"center\">


                                                                            <table style=\"overflow: hidden; margin: 0px; padding: 0px; background-color: #ffffff; display: table;\" height=\"100px\" bgcolor=\"#FFFFFF\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" id=\"content_LETTER.BLOCK67\">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style=\"padding:0px 0px 0px 0px;font-size: 8pt; font-family: Arial, Helvetica, sans-serif; color: rgb(90, 90, 90); line-height: 100%; margin-bottom: 0px;\" valign=\"bottom\" rowspan=\"1\" colspan=\"1\" align=\"center\">
                                                                                            <table style=\"border-style: none; border-width: 0px; width: 100%; height: 100px;\" cellspacing=\"0\" cellpadding=\"0\" align=\"none\">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style=\"background-color: #ffffff; padding-left: 0px; word-wrap: break-word; word-break: break-all; vertical-align: bottom; font-family: Arial, Helvetica, sans-serif; color: #5a5a5a; font-size: 8px; font-style: normal; font-weight: normal; width: 290px; height: 100px;\" valign=\"top\" rowspan=\"2\" colspan=\"1\"><img height=\"100\" border=\"0\" name=\"ACCOUNT.IMAGE.127\" width=\"290\" src=\"https://origin.ih.constantcontact.com/fs159/1109452915099/img/127.png\"></td>

                                                                                                        <td style=\"background-color: #ed523c; padding-top: 0px; padding-bottom: 0px; padding-left: 0px; padding-right: 12px; vertical-align: center; color: #ffffff; font-size: 10pt; font-style: normal; font-weight: normal; width: 297px; font-family: Georgia, 'Times New Roman', Times, serif;\" height=\"26\" border=\"0\" rowspan=\"1\" cellpadding=\"0\" colspan=\"1\">

                                                                                                        </td>
                                                                                                    </tr>

                                                                                                    <tr>
                                                                                                        <td style=\"padding-top: 5px; padding-right: 12px; line-height: 24px; color: #5a5a5a; font-size: 18pt;\" valign=\"top\" rowspan=\"1\" colspan=\"1\">
                                                                                                            <div style=\"text-align: right; font-size: 14pt;\" align=\"right\">
                                                                                                                <strong>Content Review Request</strong>
                                                                                                            </div>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <table style=\"background:transparent;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style=\"padding:0px 12px 0px 12px;\" valign=\"top\" width=\"100%\" rowspan=\"1\" colspan=\"1\" align=\"center\">
                                                                            <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style=\"padding-bottom:11px;height:1px;line-height:1px;\" height=\"1\" rowspan=\"1\" colspan=\"1\" align=\"center\"><img height=\"1\" vspace=\"0\" border=\"0\" hspace=\"0\" width=\"5\" style=\"display: block;\" alt=\"\" src=\"https://imgssl.constantcontact.com/letters/images/1101116784221/S.gif\"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table><a name=\"LETTER.BLOCK59\"></a>

                                                                            <table class=\"\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" id=\"content_LETTER.BLOCK59\">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style=\"padding:7px 8px 0px 8px;font-size: 8pt; font-family: Arial, Helvetica, sans-serif; color: rgb(255, 255, 255);\" valign=\"top\" rowspan=\"1\" colspan=\"1\" align=\"center\">
                                                                                            <div>
                                                                                                .
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <table style=\"background:transparent;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style=\"padding:0px 12px 0px 12px;\" valign=\"top\" width=\"100%\" rowspan=\"1\" colspan=\"1\" align=\"center\">


                                                                            <table style=\"border-left-width: 1px; border-left-style: solid; border-left-color: #e9e9e9; border-right-width: 1px; border-right-style: solid; border-right-color: #e9e9e9;\" bgcolor=\"#FFFFFF\" border=\"0\" width=\"100%\" padding=\"0px 0px\" cellpadding=\"0\" cellspacing=\"0\" id=\"content_LETTER.BLOCK70\">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style=\"padding: 3px 0px; font-size: 5pt; font-family: Arial, Helvetica, sans-serif; color: #ffffff;\" valign=\"top\" rowspan=\"1\" colspan=\"1\" align=\"center\">
                                                                                            <table style=\"width: 540px; border-style: none; border-width: 0px; height: 5px; background-color: #ed523c; padding: 0px 0px;\" cellspacing=\"0\" cellpadding=\"0\">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style=\"word-wrap: break-word; word-break: break-all; vertical-align: top; font-family: Arial, Helvetica, sans-serif; color: #ffffff; font-size: 5px; font-style: normal; font-weight: normal; width: 499px; height: 5px;\" rowspan=\"1\" colspan=\"1\">&nbsp;</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table><span>&nbsp;</span>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table><a name=\"LETTER.BLOCK17\"></a>

                                                                            <table style=\"border-left-width: 1px; border-left-style: solid; border-left-color: #e9e9e9; border-right-width: 1px; border-right-style: solid; border-right-color: #e9e9e9; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #e9e9e9; display: table;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" id=\"content_LETTER.BLOCK17\">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style=\"color:#5a5a5a;font-family:Arial,Helvetica,sans-serif;margin-bottom:5px;font-size:10pt;line-height:150%;padding: 7px 40px;\" valign=\"top\" rowspan=\"1\" colspan=\"1\" align=\"left\">
                                                                                            <div>
                                                                                                <div style=\"color:#ED523C;font-family:Arial,Helvetica,sans-serif;font-weight:bold;font-size:10pt;line-height: 150%; margin-bottom: 5px;\">

                                                                                                </div>

                                                                                                <div style=\"color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:10pt;\">
                                                                                                    <div style=\"color: #5a5a5a;\">
                                                                                                        <span style=\"color:#5a5a5a;font-family:Arial,Helvetica,sans-serif;margin-bottom:5px;font-size:10pt;line-height:150%;display:block;\">
                                                                                                        	The following article has been updated from <em>$old_status</em> to <em>$new_status</em> and is awaiting review:<br>
                                                                                                        </span>
                                                                                                        <span style=\"color:#5a5a5a;font-family:Arial,Helvetica,sans-serif;margin-bottom:5px;font-size:10pt;line-height:150%;display:block\">
                                                                                                        	<strong>$article_title</strong>
                                                                                                        </span>
                                                                                                        <span style=\"color:#5a5a5a;font-family:Arial,Helvetica,sans-serif;margin-bottom:5px;font-size:10pt;line-height:150%;display:block\">
                                                                                                        	By: <em>$author_name</em>
                                                                                                        </span>
                                                                                                        <span style=\"color:#5a5a5a;font-family:Arial,Helvetica,sans-serif;margin-bottom:5px;font-size:10pt;line-height:150%;display:block\">
                                                                                                        	Date: $post_date
                                                                                                        </span>
                                                                                                        <span style=\"color:#5a5a5a;font-family:Arial,Helvetica,sans-serif;margin-bottom:5px;font-size:10pt;line-height:150%;display:block\">
                                                                                                        	Notes: $author_notes
                                                                                                        </span>
                                                                                                        <span style=\"color:#5a5a5a;font-family:Arial,Helvetica,sans-serif;margin-bottom:5px;font-size:10pt;line-height:150%;display:block\">
                                                                                                        	<br>Please review the article <a href=\"$post_link\">here</a>.
                                                                                                        </span>

                                                                                                    </div>
                                                                                                </div>

                                                                                                <div style=\"color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:10pt;\">
                                                                                                    <br>
                                                                                                </div>

                                                                                                <div style=\"color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:10pt;\">
                                                                                                    <br>
                                                                                                </div><br>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>

                                                                            <table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"content_LETTER.BLOCK60\">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style=\"color:#5a5a5a;font-family:Arial,Helvetica,sans-serif;margin-bottom:5px;font-size:10pt;line-height:150%;padding:0px 8px 7px 8px;\" valign=\"top\" rowspan=\"1\" colspan=\"1\" align=\"center\"><br></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>

                                                                            <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style=\"padding-bottom:11px;height:1px;line-height:1px;\" height=\"1\" rowspan=\"1\" colspan=\"1\" align=\"center\"><img height=\"1\" vspace=\"0\" border=\"0\" hspace=\"0\" width=\"5\" style=\"display: block;\" alt=\"\" src=\"https://imgssl.constantcontact.com/letters/images/1101116784221/S.gif\"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <table style=\"background:transparent;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style=\"padding:0px 12px 0px 12px;\" valign=\"top\" width=\"100%\" rowspan=\"1\" colspan=\"1\" align=\"center\"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <table style=\"background:transparent;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style=\"padding:0px 0px 0px 0px;\" valign=\"middle\" width=\"100%\" rowspan=\"1\" colspan=\"1\" align=\"center\">
                                                                            <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style=\"padding-bottom:11px;height:1px;line-height:1px;\" height=\"1\" rowspan=\"1\" colspan=\"1\" align=\"center\"><img height=\"1\" vspace=\"0\" border=\"0\" hspace=\"0\" width=\"5\" style=\"display: block;\" alt=\"\" src=\"https://imgssl.constantcontact.com/letters/images/1101116784221/S.gif\"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>

                                                                            <table class=\"\" style=\"background-color: rgb(236, 85, 61);\" bgcolor=\"#EC553D\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" id=\"content_LETTER.BLOCK33\">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style=\"color:#5a5a5a;font-family:Arial,Helvetica,sans-serif;margin-bottom:5px;font-size:10pt;line-height:150%;padding:7px 8px 7px 8px;\" valign=\"top\" rowspan=\"1\" colspan=\"1\" align=\"left\">
                                                                                            <table style=\"margin:0px 0px 0px 0px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style=\"color:#5a5a5a;font-family:Arial,Helvetica,sans-serif;margin-bottom:5px;font-size:10pt;line-height:150%;padding: 4px 0px 0px;\" valign=\"top\" width=\"25%\" rowspan=\"1\" colspan=\"1\" align=\"left\"><a style=\"border: 0px;\" href=\"http://r20.rs6.net/tn.jsp?e=001wuc22-Q6uvBUrZAsXLzUnzDv8G047bVVcW7D_wCcUCRR7nol8DLgVqizFrfVUxW8TbgpgWy8dpsZ50U5Ui-7d9IMM7aiHoRZArpwAcwh1bY=\" shape=\"rect\" target=\"_blank\"><img style=\"border: 0px;\" height=\"14\" vspace=\"5\" border=\"0\" name=\"ACCOUNT.IMAGE.115\" hspace=\"5\" width=\"16\" src=\"https://origin.ih.constantcontact.com/fs159/1109452915099/img/115.png\"></a><a href=\"http://r20.rs6.net/tn.jsp?e=001wuc22-Q6uvBUrZAsXLzUnzDv8G047bVVcW7D_wCcUCRR7nol8DLgVqizFrfVUxW8TbgpgWy8dpvRG1sedtuuTivcnCfn04AE\" shape=\"rect\" target=\"_blank\"><img height=\"14\" vspace=\"5\" border=\"0\" name=\"ACCOUNT.IMAGE.117\" hspace=\"5\" width=\"16\" src=\"https://origin.ih.constantcontact.com/fs159/1109452915099/img/117.png\"></a><a href=\"mailto:info@naph.org\" shape=\"rect\" target=\"_blank\"><img height=\"14\" vspace=\"5\" border=\"0\" name=\"ACCOUNT.IMAGE.114\" hspace=\"5\" width=\"16\" src=\"https://origin.ih.constantcontact.com/fs159/1109452915099/img/114.png\"></a><a href=\"http://r20.rs6.net/tn.jsp?e=001wuc22-Q6uvBUrZAsXLzUnzDv8G047bVVcW7D_wCcUCRR7nol8DLgVqizFrfVUxW8TbgpgWy8dptuw6fc_YFpuq1beiJemPfmPbpeMrVlqCtOrzQM13COGbptcPYPRFeMR48o1HiNTZp7EtWLVocDc036WqwMnBGQWAJeacKJZqhSO2POS-m7joU8oCzz9keO\" shape=\"rect\" target=\"_blank\"><img height=\"14\" vspace=\"5\" border=\"0\" name=\"ACCOUNT.IMAGE.116\" hspace=\"5\" width=\"16\" src=\"https://origin.ih.constantcontact.com/fs159/1109452915099/img/116.png\"></a><br></td>

                                                                                                        <td style=\"font-size: 8pt; font-family: Georgia, 'Times New Roman', Times, serif; color: #ffffff; padding: 5px 10px 0px 0px;\" valign=\"top\" width=\"70%\" rowspan=\"1\" colspan=\"1\" align=\"left\">
                                                                                                            <div>
                                                                                                                <div style=\"text-align: right;\" align=\"right\">
                                                                                                                    <span style=\"font-size: 8pt; line-height: 200%;\">1301 Pennsylvania Ave NW, Suite 950 &nbsp;Washington, D.C. 20004</span>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                            <div style=\"text-align: right;\" align=\"right\">
                                                                                                                <span style=\"color: #ffffff !important; text-decoration: none !important;\"><a style=\"color: rgb(255, 255, 255); text-decoration: none;\" shape=\"rect\" href=\"http://r20.rs6.net/tn.jsp?e=001wuc22-Q6uvBUrZAsXLzUnzDv8G047bVVcW7D_wCcUCRR7nol8DLgVqizFrfVUxW8TbgpgWy8dpu1QABvBsu0aOYGFyEA1nK5xcdmu9-uDis=\" target=\"_blank\">202.585.0100</a></span> &nbsp;|| &nbsp;<a style=\"color: rgb(255, 255, 255); text-decoration: none;\" track=\"on\" href=\"http://r20.rs6.net/tn.jsp?e=001wuc22-Q6uvBUrZAsXLzUnzDv8G047bVVcW7D_wCcUCRR7nol8DLgVqizFrfVUxW8TbgpgWy8dpvW_30BK7x2yMSUV4I7OpQAPmaR13KD-FjniaeNpXUfpQ==\" shape=\"rect\" linktype=\"1\" target=\"_blank\">essentialhospitals.org</a>
                                                                                                            </div>
                                                                                                        </td>

                                                                                                        <td style=\"color:#5a5a5a;font-family:Arial,Helvetica,sans-serif;margin-bottom:5px;font-size:10pt;line-height:150%;text-align: center; padding: 0px;\" valign=\"top\" width=\"5%\" rowspan=\"1\" colspan=\"1\" align=\"center\">
                                                                                                            <div style=\"text-align: center;\" align=\"center\"><img src=\"https://origin.ih.constantcontact.com/fs159/1109452915099/img/112.png\" name=\"ACCOUNT.IMAGE.112\" width=\"29\" vspace=\"12\" border=\"0\" alt=\"newsletter_logo_small\" align=\"right\" height=\"30\" hspace=\"5\"></div>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table style=\"background:transparent;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                <tbody>
                                    <tr>
                                        <td valign=\"top\" width=\"100%\" rowspan=\"1\" colspan=\"1\" align=\"center\">
                                            <table style=\"width:600px;\" border=\"0\" width=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                                                <tbody>
                                                    <tr>
                                                        <td style=\"padding:0px 0px 0px 0px;\" valign=\"top\" width=\"100%\" rowspan=\"1\" colspan=\"1\" align=\"center\"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div><script type=\"text/javascript\">

    document.getElementById(\"rootDiv\").style.overflow=\"\";
    </script>
</body>
</html>
";
}