<?php

/**
 * UserManage Uninstall
 * 
 * @package UserManage/Uninstaller/
 * @version 1.0.0
 */
defined('WP_UNINSTALL_PLUGIN') || exit;

/**
 * Drop The table when plugin is uninstalled
 */
global $wpdb, $table_prefix;
$wp_emp = $table_prefix . 'emp';
$query = "DROP TABLE `$wp_emp`";

$wpdb->query($query);
