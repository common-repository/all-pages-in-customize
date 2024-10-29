<?php
/*
Plugin Name: All Pages In Customize
Description: It gives you the possibility to see every page in the Customizer preview
Author: Jose Mortellaro
Author URI: https://josemortellaro.com
Text Domain: eos-apic
Domain Path: /languages/
Version: 0.0.2
*/
/*  This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

//Definitions
define( 'EOS_APIC_VERSION','0.0.2' );
define( 'EOS_APIC_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'EOS_APIC_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

add_action( 'after_setup_theme','eos_apic_load_customize_controls' );
//Load customize controls
function eos_apic_load_customize_controls(){
	if( is_customize_preview() ) {
		require( EOS_APIC_PLUGIN_DIR. '/inc/apic-customize.php' );
	}
}
