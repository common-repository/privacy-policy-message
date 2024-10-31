<?php
/**
 * @package PrivacyPolicyMessagePlugin
 */ 

/* 
Plugin Name: Privacy Policy Message
Plugin URI: http://demo.kamilnowak.com/privacy-policy-message/
Description: Cookie message box for privacy policy
Version: 1.0
Author: Kamil Nowak
Author URI: http://kamilnowak.com/
License: GPLv2 or later
Text Domain: prvpmsg
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define( 'PRVPMSG_VERSION', '1.0.0' );
define( 'PRVPMSG__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( PRVPMSG__PLUGIN_DIR . 'class.privacypolicymessage.php' );

if(class_exists('PrivacyPolicyMessage')){
    $privacypolicymessage = new PrivacyPolicyMessage();
}

if ( is_admin() ) {
    require_once( PRVPMSG__PLUGIN_DIR . 'class.privacypolicymessage-admin.php' );
    $privacypolicymessage_admin = new PrivacyPolicyMessageAdmin();
}

// activation
register_activation_hook(__FILE__, array( $privacypolicymessage, 'activation' ) );

// deactivation
register_deactivation_hook(__FILE__, array( $privacypolicymessage, 'deactivation' ) );

// unintall