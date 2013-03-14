<?php
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'pagination.php');

class DatabaseObject {
    
    protected static $table_name;
    protected static $db_vars;
    protected static $db_funcs;
    
    public static function find_all() {
        return static::find_by_sql("SELECT * FROM ".static::$table_name);
    }
    
    public static function find_by_id($id=0) {
        $sql  = "SELECT * FROM ".static::$table_name." ";
        $sql .= "WHERE id={$id} LIMIT 1";
        $result_array = static::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function find_by_sql($sql="") {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    }
    
    public static function find_by_pagination($pagination) {
        $sql  = "SELECT * FROM ".static::$table_name." ";
        // check order_by_column name exists in pagination and table
        if (($pagination->order_by != null) &&
            (in_array($pagination->order_by, static::$db_vars))) {
            $sql .= "ORDER BY {$pagination->order_by} ";
        }
        $sql .= "LIMIT {$pagination->per_page} ";
        $sql .= "OFFSET {$pagination->offset()}";
        return static::find_by_sql($sql);
    }
    
    public static function random_selection($size, $options) {
        $sql  = "SELECT * FROM ".static::$table_name." ";
        
        $i = 0;
        foreach ($options as $key => $val) {
            if ($i==0) {
                $sql .= "WHERE ";
            }
            $sql .= "{$key}='{$val}' ";
            $i++;
            if ($i<count($options)) {
                $sql .= "AND ";
            }
        }
        
        $sql .= "ORDER BY RAND() ";
        $sql .= "LIMIT {$size}";
        return static::find_by_sql($sql);
    }
    
    public function count_all() {
        global $database;
        $sql = "SELECT COUNT(*) FROM " .static::$table_name;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    private static function instantiate( $record ) {
        $class_name = get_called_class();
        $object = new $class_name;
        foreach ($record as $attribute=>$value) {
            if (in_array($attribute, static::$db_vars)) {
                $object->$attribute = $value;
            } elseif (in_array($attribute, static::$db_funcs)) {
                $object->$attribute($value);
            }
            /*if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }*/
        }
        return $object;
    }
    
    protected function attributes() {
        // return an array of attribute keys and their values
        $attributes = array();
        // first attributes directly from variables
        foreach (static::$db_vars as $field) {
            if (property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        // then attributes returned by fuctions
        foreach (static::$db_funcs as $field) {
            if (method_exists($this, $field)) {
                $attributes[$field] = $this->$field();
            }
        }
        return $attributes;
    }
    
    protected function sanitized_attributes() {
        global $database;
        $clean_attributes = array();
        // sanitize the values before submitting
        // Note: does not alter the actual value of each attribute
        foreach ($this->attributes() as $key => $value) {
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }
    
    public function save() {
        // A new record won't have an id yet
        return isset($this->id) ? $this->update() : $this->create();
    }
    
    protected function create() {
        global $database;
        $attributes = $this->sanitized_attributes();
        $sql  = "INSERT INTO ".static::$table_name." (";
        $sql .= join(", ",array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '",array_values($attributes));
        $sql .= "')";
        if ( $database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }
    
    protected function update() {
        global $database;
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach ($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql  = "UPDATE ".static::$table_name." SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id=". $database->escape_value($this->id);
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;        
    }
    
    public function delete() {
        global $database;
        $sql  = "DELETE FROM ".static::$table_name." ";
        $sql .= "WHERE id=". $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
    
}

?>