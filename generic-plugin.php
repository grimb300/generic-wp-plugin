<?php

/**
 * Plugin Name:       Generic Plugin
 * Plugin URI:        https://candolatitude.com/
 * Description:       Generic starting point for a plugin.
 * Version:           0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Bob Grim
 * Author URI:        https://candolatitude.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gen-plugin
 */

error_log( 'Executing generic-plugin.php' );

function gen_plugin_activation_notice() {
  error_log( 'Inside gen_plugin_activation_notice' );
  ?>
  <div class="notice notice-success is-dismissible">
    <p>Steamy Kitchen Giveaways Plugin activated</p>
  </div>
  <?php
}

function gen_plugin_activate() {
  // Using option based workaround found in WP documentation
  // https://developer.wordpress.org/reference/functions/register_activation_hook/#process-flow
  // It is not possible to use add_action or add_filter inside the activate function
  error_log( 'Inside gen_plugin_activate' );
  add_option( 'gen-plugin-workaround', 'activated' );
}
register_activation_hook( __FILE__, 'gen_plugin_activate' );

function gen_plugin_workaround() {
  if ( is_admin() && get_option( 'gen-plugin-workaround' ) == 'activated' ) {
    add_action( 'admin_notices', 'gen_plugin_activation_notice');
    delete_option( 'gen-plugin-workaround' );
    error_log( 'Added notice action' );
  }
}
add_action( 'admin_init', 'gen_plugin_workaround', 10 );

// From the WP docs
// https://developer.wordpress.org/plugins/plugin-basics/uninstall-methods/
//
// This table illustrates the differences between deactivation and uninstall.
/////////////////////////////////////////////////////////////////////////////
// Scenario                | Deactivation | Uninstall
//                         | Hook         | Hook
// ------------------------+--------------+-----------
// Flush Cache/Temp        | Yes          | No
// ------------------------+--------------+-----------
// Flush Permalinks        | Yes          | No
// ------------------------+--------------+-----------
// Remove Options from     |              |
// {$wpdb->prefix}_options | No           | Yes
// ------------------------+--------------+-----------
// Remove Tables from wpdb | No           | Yes

function gen_plugin_deactivate() {
  error_log( 'Inside gen_plugin_deactivate' );
}
register_deactivation_hook( __FILE__, 'gen_plugin_deactivate' );

function gen_plugin_uninstall() {
  error_log( 'Inside gen_plugin_uninstall' );
}
register_uninstall_hook( __FILE__, 'gen_plugin_uninstall' );