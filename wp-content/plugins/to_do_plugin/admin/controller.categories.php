<?php
require_once(TDP_PLUGIN_DIR.'classes.php');

class TDP_Categories extends TDPControl{

    private $wp_db;

    public function __construct() {
        global $wpdb;
        $this->wp_db = $wpdb;
    }

    //Add new category
    function tdp_add_new_category($data){
        $table = $this->wp_db->prefix . 'tdp_categories';
        $data = array(
            'title' => sanitize_text_field($data['title'])
        );

        $this->wp_db->insert($table, $data);
        if($this->wp_db->rows_affected) {
            wp_send_json_success();
        }
    }

    //Get categories
    function tdp_get_categories($isAjax){
        $categories = $this->wp_db->get_results("SELECT * FROM {$this->wp_db->prefix}tdp_categories");
        if($isAjax === true){
            wp_send_json($categories);
        }else{
            return $categories;
        }
    }

    //Delete categories
    function tdp_delete_category($category_id){
        $this->wp_db->delete("{$this->wp_db->prefix}tdp_categories",array('id' => $category_id));

        if($this->wp_db->rows_affected) {
            wp_send_json_success();
        }
    }

    //Update category
    function tdp_update_category($category_id,$category_title){
        $this->wp_db->update(
            "{$this->wp_db->prefix}tdp_categories",array('title' => sanitize_text_field($category_title)),array('id' => $category_id));
        
        if($this->wp_db->rows_affected) {
            wp_send_json_success();
        }
    }
}
?>