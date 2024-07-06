<?php
require_once('../../../../wp-load.php');
require_once(plugin_dir_path( __FILE__ ).'/controller.categories.php');
require_once(plugin_dir_path( __FILE__ ).'/controller.tasks.php');

$categories_instance = new TDP_Categories;
$tasks_instance = new TDP_Tasks;

add_action('wp_ajax_tdp_add_new_task', 'tdp_add_new_task');
add_action('wp_ajax_tdp_add_new_category', 'tdp_add_new_category');
add_action('wp_ajax_tdp_get_categories', 'tdp_get_categories');

switch ($_POST['action']) {
    case 'tdp_add_new_task':
        $tasks_instance->tdp_add_new_task($_POST);
        break;
    case 'tdp_get_tasks':
        $tasks_instance->tdp_get_tasks(true);
        break;
    case 'tdp_add_new_category':
        $categories_instance->tdp_add_new_category($_POST);
        break;
    case 'tdp_get_categories':
        $categories_instance->tdp_get_categories(true);
        break;
    case 'tdp_delete_category':
        $categories_instance->tdp_delete_category($_POST['category_id']);
        break;
    case 'tdp_update_category':
        $categories_instance->tdp_update_category($_POST['category_id'],$_POST['category_title']);
        break;
}





?>