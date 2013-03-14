<?php
require_once(LIB_PATH.DS.'database.php');

class User extends DatabaseObject {
    
    protected static $table_name="users";
    protected static $db_vars = array('id', 'username', 'first_name', 'last_name');
    protected static $db_funcs = array('hashed_password');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    
    public function full_name() {
        if ( isset($this->first_name) && isset($this->last_name)) {
            return $this->first_name . " " . $this->last_name;
        } else {
            return "";
        }
    }
    
    protected function hashed_password() {
        global $database;
        return sha1($database->escape_value($this->password));
    }
    
    public static function authenticate($username="", $password="") {
        global $database;
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);
        $hashed_password = sha1($password);
        
        $sql  = "SELECT id, username ";
        $sql .= "FROM users ";
        $sql .= "WHERE username = '{$username}' ";
        $sql .= "AND hashed_password = '{$hashed_password}' ";
        $sql .= "LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
}

?>