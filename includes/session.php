<?php
// A class to help work with Sessions
// In our case, primarily to manage logging users in and out

// Keep i mind when working with sessions that it is generally
// inadvisable to store DB-related objects in sessions

class Session {
    
    private $logged_in=false;
    public $user_id;
    
    public $test_manager;
    
    function __construct() {
        session_start();
        $this->check_login();
        if ($this->logged_in) {
            // imdediate actions if logged in
        } else {
            // imdediate actions if not logged in
        }
        
        // Create or load test manager
        $this->load_test_manager();
    }
    
    public function is_logged_in() {
        return $this->logged_in;
    }
    
    public function login($user) {
        // database should finduser based on username and password
        if ($user) {
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->logged_in = true;
        }
    }
    
    public function logout() {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->logged_in = false;
    }
    
    private function check_login() {
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }
    
    
    // Test manager
    
    private function load_test_manager() {
        if (isset($_SESSION['test_manager'])) {
            $this->test_manager = $_SESSION['test_manager'];
        } else {
            $this->test_manager = new IDManager();
        }
    }
    
    public function test_playlist($pl) {
        if ($pl) {
            $test_id = $this->test_manager->add_object($pl);
            // update session copy
            $_SESSION['test_manager'] = $this->test_manager;
            return $test_id;
        } else {
            return false;
        }
    }
    
    public function playlist_for_test_id($id) {
        return $this->test_manager->object_for_id($id);
    }
    
    public function end_test($id) {
        $this->test_manager->remove_object_for_id($id);
        // update session copy
        $_SESSION['test_manager'] = $this->test_manager;
    }
    
}

?>