<?php
    class Shortcodes{

        private $wp_db;

        public function __construct() {
            global $wpdb;
            $this->wp_db = $wpdb;
        }

        function get_tasks_shortcode($filter,$limit){
            $tasks = $this->wp_db->get_results("SELECT * FROM {$this->wp_db->prefix}tdp_tasks $filter LIMIT $limit");

            return $tasks;
        }

        function build_task_div($tasks){
            // var_dump($tasks);
            $tasks_div = '<div class="tdp-shortcode-wrapper">';
                $tasks_div .= '<div class="tdp-shortcode-alert-wrapper">
                <div class="shortcode-popup-actions"><button id="shortcode-alert-close">X</button></div>
                <div class="shortcode-popup-info"></div></div>';
                $tasks_div .= '<div class="owl-carousel">';
                foreach($tasks as $task){
                    $tasks_div .= '<div class="tdp-single-task item">';
                        $tasks_div .= '<div class="tdp-single-task-title">'.$task->title.'</div>';
                        $task_description = (strlen($task->description) > 200) ? substr($task->description,0,200).'...' : $task->description;
                        $tasks_div .= '<div class="tdp-single-task-description">'.$task_description.'</div>';
                        if(strtotime($task->due_date)>0){
                            $tasks_div .= '<div class="tdp-single-task-due-date">Due to '.$task->due_date.'</div>';
                        }
                        $tasks_div .= '<div class="tdp-task-actions">';
                            $tasks_div .= '<button data-id="'.$task->id.'" class="tdp-task-info-btn">Task info</button>';
                            $tasks_div .= '<select data-id="'.$task->id.'">';
                               $tasks_div .='<option value="0" '.(($task->task_status == 0) ? 'selected' : '' ).'>Pending</option>';
                               $tasks_div .='<option value="1" '.(($task->task_status == 1) ? 'selected' : '' ).'>Worked on</option>';
                               $tasks_div .='<option value="2" '.(($task->task_status == 2) ? 'selected' : '' ).'>Completed</option>';
                            $tasks_div .= '</select>';                            
                        $tasks_div .= '</div>';
                        
                    $tasks_div .= '</div>';
                }
                $tasks_div .= '</div>';
            $tasks_div .= '</div>';
            return $tasks_div;
        }

        function latest_five_shortcode(){
            $filter = 'ORDER BY `created_at` DESC';
            $tasks = $this->get_tasks_shortcode($filter,5);
            $content = $this->build_task_div($tasks);

            return $content;
        }

        function urgent_five_shortcode(){
            $filter = 'ORDER BY `priority` DESC';
            $tasks = $this->get_tasks_shortcode($filter,5);
            $content = $this->build_task_div($tasks);

            return $content;
        }
    }
?>