<?php
// var_dump();
    require_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/to_do_plugin/classes.php');
    
    class TDP_Ajax extends TDPControl{
        public function tdp_add_new_task(){
            $this->loadNeeded();
            $checkNonce = $this->checkNonce($_POST['nonce'],$_POST['action']);
            if($checkNonce === true){
                // Sanitize and process form data
                $title = sanitize_text_field($_POST['title']);
                $description = sanitize_email($_POST['description']);
        
                // Handle form data (e.g., save to database, send email, etc.)
                wp_send_json('test');
            }
    
        }
    }
?>