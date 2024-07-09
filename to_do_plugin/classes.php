<?php 
    class TDPControl{
        public function loadNeeded(){
            require_once('../../../../wp-load.php');
        }

        public function checkNonce($nonce,$action){
            // Check nonce for security
            if (isset($nonce) || wp_verify_nonce($nonce, $action)) {
                return true;
            }else{
                return false;
            }
        }
    }
?>