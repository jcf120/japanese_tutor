<?php
require_once(LIB_PATH.DS.'database.php');

class PlayList extends DatabaseObject {
    
    protected static $table_name="playlists";
    protected static $db_vars = array('id', 'name');
    protected static $db_funcs = array('verb_ids_imploded');
    
    protected static $max_verbs = 20; // due to varchar limit in database
    
    public $id;
    public $name;
    private $verb_ids = array();
    public $verbs = array();
    public $forms;
    
    protected function verb_ids_imploded($imploded_ids = null) {
        if (!is_null($imploded_ids)) {
            $id_str_array = explode(',',$imploded_ids);
            foreach ($id_str_array as $id_str) {
                array_push($this->verb_ids, (int)$id_str);
            }
            
        }
        global $database;
        return $database->escape_value(implode(',',$this->verb_ids));
    }
    
    public function add_verb_id($id) {
        array_push($this->verb_ids, $id);
    }
    
    public function load_verbs() {
        foreach ($this->verb_ids as $id) {
            array_push($this->verbs, Verb::find_by_id($id));
        }
    }
    
    public function next_question() {
        $form_func = $this->forms[rand(0,count($this->forms)-1)];
        $verb = $this->verbs[rand(0,count($this->verbs)-1)];
        Verb::set_display_mode("hrgn");
        return array('id'=>$verb->id,
                     'dictionary'=>$verb->dictionary_formatted(),
                     'english'=>$verb->English(),
                     'form'=>$form_func,
                     'answer'=>$verb->$form_func());
    }
    
}

class SmartPlayList extends Playlist {
    
    public $difficulty;
    
    public function __construct($diff,$forms=null) {
        $this->difficulty = $diff;
        $this->forms = $forms;
        if ($forms==null) {
            $this->forms = array("pln_pres", "plt_pres", "pln_pres_neg", "plt_pres_neg",
                                 "pln_past", "plt_past", "pln_past_neg", "plt_past_neg");
        }
    }
    
    public function load_verbs() {
        $options = array("Difficulty"=>$this->difficulty);
        $this->verbs = Verb::random_selection(self::$max_verbs, $options);
    }
    
}

?>