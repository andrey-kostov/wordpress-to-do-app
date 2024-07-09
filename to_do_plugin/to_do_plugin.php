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

	//Create tasks table
	if ($wpdb->get_var($check_tasks_table) != $tasks_table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        $create_tasks_table = "CREATE TABLE $tasks_table_name (
            id int(9) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            description text NOT NULL,
			assigned varchar(255) NOT NULL,
			category_id int(9) NOT NULL,
			priority int(2) NOT NULL,
            task_status int(1) DEFAULT 0 NOT NULL,
			due_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			updated_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
		// Update the table with dbDelta (handles creation and upgrades of db tables; comes from upgrade.php )
		dbDelta($create_tasks_table);
	}

	//Create categories table
	$categories_table_name = $wpdb->prefix . 'tdp_categories';
	$check_categories_table = $wpdb->prepare("SHOW TABLES LIKE %s", $categories_table_name);

	if ($wpdb->get_var($check_categories_table) != $categories_table_name) {
		$charset_collate = $wpdb->get_charset_collate();
		$create_categories_table = "CREATE TABLE $categories_table_name (
			id int(9) NOT NULL AUTO_INCREMENT,
			title varchar(255) NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";
		// Update the table with dbDelta (handles creation and upgrades of db tables; comes from upgrade.php )
		dbDelta($create_categories_table);
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
	wp_localize_script('admin-js', 'adminAjax', array(
        'ajax_url' => plugin_dir_url(__FILE__) . 'admin/ajax.php'
    ));
}

//Enqueue CSS
add_action('admin_print_styles','admin_css');
function admin_css(){
	wp_enqueue_style('admin-css',plugins_url( 'admin/css/admin.css', __FILE__ ),'',1,'all');
}

//Shortcodes
function tpd_latest_five_shortcode() {
    require_once(plugin_dir_path( __FILE__ ).'/public/class.shortcodes.php');
	$shortcodes_instance = new Shortcodes;
	$content = $shortcodes_instance->latest_five_shortcode();
    // always return
    return $content;
}

function tpd_urgent_five_shortcode() {
	require_once(plugin_dir_path( __FILE__ ).'/public/class.shortcodes.php');
	$shortcodes_instance = new Shortcodes;
	$content = $shortcodes_instance->urgent_five_shortcode();
    // always return
    return $content;
}

function tpd_shortcodes_init() {
	add_shortcode( 'tpd_latest_five', 'tpd_latest_five_shortcode' );
	add_shortcode( 'tpd_urgent_five', 'tpd_urgent_five_shortcode' );
}

add_action( 'init', 'tpd_shortcodes_init' );

function tdp_block_register() {
    // Check if Gutenberg is active
    if ( ! function_exists( 'is_plugin_active' ) ) {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }

    if ( is_plugin_active( 'gutenberg/gutenberg.php' ) || function_exists( 'register_block_type' ) ) {
        // Register the block editor script
        wp_register_script(
            'tdp-block-script',
            plugin_dir_url(__FILE__).'public/js/tdp-block.js',
            array( 'wp-blocks', 'wp-element', 'wp-editor' ),
            filemtime( plugin_dir_path( __FILE__ ).'public/js/tdp-block.js' )
        );

        // Register the block editor styles
        wp_register_style(
            'tdp-block-editor-style',
            plugin_dir_url(__FILE__).'public/css/tdp-block-editor.css',
            array( 'wp-edit-blocks' ),
            filemtime( plugin_dir_path( __FILE__ ).'public/css/tdp-block-editor.css')
        );

        // Register the front-end styles
        wp_register_style(
            'tdp-block-style',
            plugin_dir_url(__FILE__).'public/css/tdp-block.css',
            array(),
            filemtime(plugin_dir_path( __FILE__ ).'public/css/tdp-block.css')
        );

        // Register the block
        register_block_type( 'tdp/tdp-block', array(
            'editor_script' => 'tdp-block-script',
            'editor_style'  => 'tdp-block-editor-style',
            'style'         => 'tdp-block-style',
        ) );
    }
}
add_action( 'init', 'tdp_block_register' );

function enqueue_front_assets() {
    wp_enqueue_style( 'owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array(), '2.3.4' );
    wp_enqueue_style( 'owl-carousel-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css', array(), '2.3.4' );
	wp_enqueue_style('public-css',plugins_url( 'public/css/public.css', __FILE__ ),'',1,'all');

	wp_enqueue_script( 'public-js', plugins_url( 'public/js/public.js', __FILE__ ), array( 'jquery' ), '1', true );
    wp_enqueue_script( 'owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );

    wp_localize_script('public-js', 'publicAjax', array(
        'ajax_url' => plugin_dir_url(__FILE__) . 'public/frontend_ajax.php'
    ));
}
add_action( 'wp_enqueue_scripts', 'enqueue_front_assets' );

?>