<?php
include './incl/database.php';
include './incl/facebook.php';

/* Facebook Developers API Client Configuration */

	$api_key = '36fd8eab4d42311aa7065a705332b3e1';
	$secret = 'c5929c14dca9a12d42c7ecd27f93b8a1';
	$appcallbackurl = 'http://fbapp-phrasegenerator.mandomandarin.com/';
	$facebook = new Facebook($api_key, $secret);
	if(!isset($skip_login)) $user = $facebook->require_login();
	
/* -------------------------------------------- */
	

/* ------- Database Configuration Values -------- */

	$db_host = 'localhost';
	$db_username = 'mm_fb_phrase_gen';
	$db_password = 'j8&y3$x^b@!>k-px5h&rc<l+i1c?t@s';
	$db_table = 'mandomandarin_facebook_phrase_generator';

/* -------------------------------------------- */

/* ------- Application Configuration Values -------- */
	$email_to = "mike@mandomandarin.com, oscar@mandomandarin.com, questions@mandomandarin.com";
/* -------------------------------------------- */

	$db = new BurstMySQL ($db_host, $db_username, $db_password, $db_table);	


?>
