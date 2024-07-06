<?php
/*
 * Plugin Name:       To-do Plugin
 * Description:       Adds to-do app features.
 * Version:           1
 * Author:            Andrey Kostov
 * Author URI:        https://www.linkedin.com/in/andreikostov/
 * Text Domain:       to-do-plugin
 */
//Define constants

use ParagonIE\Sodium\Core\Curve25519\Ge\P2;

define( 'TDP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

//Activation
function tdp_activationFunction(){
	//Create Tables
	global $wpdb; //wp db constant
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); // contains dbDelta function

	$tasks_table_name = $wpdb->prefix . 'tdp_tasks';
	$check_tasks_table = $wpdb->prepare("SHOW TABLES LIKE %s", $tasks_table_name);

	if ($wpdb->get_var($check_tasks_table) != $tasks_table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        $create_tasks_table = "CREATE TABLE $tasks_table_name (
            id int(9) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            description text NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			updated_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
		// Update the table with dbDelta (handles creation and upgrades of db tables; comes from upgrade.php )
		dbDelta($create_tasks_table);
	}

	add_option( 'TDP_Activated', true );
	add_action( 'admin_menu', 'tdp_top_menu' );
	add_action( 'admin_menu', 'tdp_add_submenus' );
}
add_action('init','tdp_activationFunction');

//Deactivation
function tdp_deactivationFunction(){
	add_option( 'TDP_Activated', false );
	add_action( 'admin_menu', 'tdp_remove_top_menu', 99 );
	add_action( 'admin_menu', 'tdp_remove_submenus', 99 );
}
add_action('init','tdp_deactivationFunction');

//Hook registration
register_activation_hook(__FILE__,'tdp_activationFunction');
register_deactivation_hook(__FILE__,'tdp_deactivationFunction');

//Add Administration Top Menu
function tdp_top_menu() {
    add_menu_page(
        'Task administration',
        'To Do Plugin',
        'manage_options',
        TDP_PLUGIN_DIR . 'admin/tasks.php',
        null,
        '',
        20
    );
}

//Remove Administration Menu
function tdp_remove_top_menu() {
    remove_menu_page( TDP_PLUGIN_DIR . 'admin/tasks.php' );
}

//Add Submenus
function tdp_add_submenus(){
	add_submenu_page(TDP_PLUGIN_DIR . 'admin/tasks.php','TDP - Tasks','Tasks','manage_options',TDP_PLUGIN_DIR . 'admin/tasks.php','',10);
	add_submenu_page(TDP_PLUGIN_DIR . 'admin/tasks.php','TDP - Categories','Categories','manage_options',TDP_PLUGIN_DIR . 'admin/categories.php','',11);
}
//Remove Submenus
function tdp_remove_submenus(){
	remove_submenu_page(TDP_PLUGIN_DIR . 'admin/tasks.php',TDP_PLUGIN_DIR . 'admin/tasks.php');
	remove_submenu_page(TDP_PLUGIN_DIR . 'admin/tasks.php',TDP_PLUGIN_DIR . 'admin/categories.php');
}

//Enqueue JS
add_action( 'admin_enqueue_scripts', 'admin_js' );
function admin_js() {
	wp_enqueue_script(
		'admin-js',
		plugins_url( 'admin/js/admin.js', __FILE__ ),
		array( 'jquery' ),
		'1.0.0',
		array(
		   'in_footer' => true,
		)
	);
	//Localize script to pass PHP variables in JS file
	wp_localize_script('admin-js', 'addNewTaskForm', array(
        'ajax_url' => plugin_dir_url(__FILE__) . 'admin/ajax.php',
        'nonce'    => wp_create_nonce('tdp_add_new_task_nonce')
    ));
}


?>