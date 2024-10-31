<?php

/*
Plugin Name: Patreon Connect: Safety Jacket
Plugin URI:https://uiux.me/patreon-connect-safety-jacket
Description: A safety jacket for Patreon Connect
Version: 1.0
Author: UIUX <me@uiux.me>
Author URI: https://uiux.me
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

include 'classes/patreon_connect_safety_jacket.php';
include 'classes/patreon_connect_safety_jacket_options.php';

new Patreon_Connect_Safety_Jacket;
new Patreon_Connect_Safety_Jacket_Options;


?>