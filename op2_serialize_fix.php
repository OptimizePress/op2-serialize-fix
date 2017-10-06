<?php
/**
 * Plugin Name: OptimizePress Serialize Fix
 * Plugin URI:  www.optimizepress.com
 * Description: Fixes corrupt OptimizePress settings that happen in rare cases after migrating OP site
 * Version:     1.1.0
 * Author:      OptimizePress
 * Author URI:  www.optimizepress.com
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . 'class-op2_serialize_fix.php' );

Op_Serialize_Fix::get_instance();