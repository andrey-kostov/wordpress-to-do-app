<?php
require_once(TDP_PLUGIN_DIR.'classes.php');

class TDP_Tasks extends TDPControl{

    private $wp_db;

    public function __construct() {
        global $wpdb;
        $this->wp_db = $wpdb;
    }
    
    //Add new task
    function tdp_add_new_task($data){
  
        $title = sanitize_text_field($data['title']);
        $description = sanitize_textarea_field($data['description']);
        $assigned = $data['assigned'];
        $category = $data['category'];
        $priority = $data['priority'];
        $due_date = $data['due_date'];

        $table = $this->wp_db->prefix . 'tdp_tasks';
        $data = array(
            'title' => $title,
            'description' =>$description,
            'assigned' =>$assigned,
            'category_id' =>$category,
            'priority' =>$priority,
            'due_date' =>$due_date	
        );

        $this->wp_db->insert($table, $data);
        if($this->wp_db->rows_affected) {
            wp_send_json_success();
        }
        
    }

    //Delete task
    function tdp_delete_task($task_id){
        $this->wp_db->delete("{$this->wp_db->prefix}tdp_tasks",array('id' => $task_id));

        if($this->wp_db->rows_affected) {
            wp_send_json_success();
        }
    }
    //Update task

    //Get all tasks
    function tdp_get_tasks($isAjax){
        $tasks = $this->wp_db->get_results("SELECT * FROM {$this->wp_db->prefix}tdp_tasks");
        if($isAjax === true){
            require_once(TDP_PLUGIN_DIR.'admin/controller.categories.php');
            $categories_instance = new TDP_Categories;
            $categories = $categories_instance->tdp_get_categories(false);

            $tasks_array = array(
                'tasks' => $tasks,
                'users' => get_users(),
                'categories' => $categories
            );
            wp_send_json($tasks_array);
        }else{
            return $tasks;
        }
    }
}