<?php
require_once('../../../../wp-load.php');
switch ($_POST['action']) {
    case 'tdp_task_info':
        tdp_task_info($_POST['task_id']);
        break;
    case 'tdp_task_status':
        tdp_task_status($_POST);
        break;
    }

    function tdp_task_info($task_id){
        global $wpdb;
        $tasks = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}tdp_tasks WHERE id=".$task_id."");
        wp_send_json_success($tasks);
    }

    function tdp_task_status($data){
        global $wpdb;
        $wpdb->update(
            "{$wpdb->prefix}tdp_tasks",
            array(
                'task_status' =>$data['task_status'],
                'updated_at' => date('Y-m-d\TH:i:sP')
            ),
            array('id' => $data['task_id']));
        

        if($wpdb->rows_affected) {
            wp_send_json_success();
        }
    }

?>