<?php

class IDManager {
    
    private $last_id = 0;
    private $objects = array();
    
    
    public function add_object($object) {
        $this->last_id++;
        $this->objects["#"+$this->last_id] = $object;
        return $this->last_id;
    }
    
    public function object_for_id($id) {
        $key = "#"+$id;
        if (array_key_exists($key,$this->objects)) {
            return $this->objects[$key];
        } else {
            return false;
        }
    }
    
    public function remove_object_for_id($id) {
        $array_key = "#"+$id;
        if (array_key_exists($key,$this->objects)) {
            unset($this->objects[$key]);
            return true;
        } else {
            return false;
        }
    }
    
    
}

?>