<?php
require_once(LIB_PATH.DS.'database.php');

class Verb extends DatabaseObject {
    
    protected static $table_name="verbs";
    protected static $db_vars = array('id', 'english', 'dictionary', 'type', 'difficulty');
    protected static $db_funcs = array();
    public $id;
    public $english;
    public $dictionary;
    public $type;
    public $difficulty;
    
    // publically verb form library
    
    public static $form_library = array(
    'pln_pres' =>          'Plain Present',
    'plt_pres' =>          'Polite Present',
    'pln_pres_neg' =>      'Plain Present Negative',
    'plt_pres_neg' =>      'Polite Present Negative',
    'pln_past' =>          'Plain Past',
    'plt_past' =>          'Polite Past',
    'pln_past_neg' =>      'Plain Past Negative',
    'plt_past_neg' =>      'Polite Past Negative',
    'pln_pres_prog' =>     'Plain Present Progressive',
    'plt_pres_prog' =>     'Polite Present Progressive',
    'pln_pres_prog_neg' => 'Plain Present Progressive Negative',
    'plt_pres_prog_neg' => 'Polite Present Progressive Negative',
    'pln_vol' =>           'Plain Volitional',
    'plt_vol' =>           'Polite Volitional',
    'pln_vol_neg' =>       'Plain Volitional Negative',
    'plt_vol_neg' =>       'Polite Volitional Negative'
    );
    
    
    // Display mode determined across all instances
    
    protected static $display_mode = "h";
    
    public static function set_display_mode($mode) {
        if       ($mode == "m" || $mode == "marked") {
            static::$display_mode = "m";
        } elseif ($mode == "h" || $mode == "hrgn") {
            static::$display_mode = "h";
        } elseif ($mode == "k" || $mode == "kanji") {
            static::$display_mode = "k";
        } elseif ($mode == "r" || $mode == "ruby") {
            static::$display_mode = "r";
        }
    }
    
    public function dictionary_formatted() {
        if       (static::$display_mode == "m") {
            return $this->dictionary;
        } elseif (static::$display_mode == "h") {
            return marked_to_hrgn($this->dictionary);
        } elseif (static::$display_mode == "k") {
            return marked_to_kanji($this->dictionary);
        } elseif (static::$display_mode == "r") {
            return marked_to_ruby($this->dictionary);
        } else {
            return "invalid display mode";
        }
    }
    
    // Tell mySQL to support japanese characters - not sure where else this is needed
    
    public static function find_by_sql($sql="") {
        global $database;
        $database->query("SET NAMES 'utf8'");
        return parent::find_by_sql($sql);
    }
    
    public function save() {
        global $database;
        $database->query("SET NAMES 'utf8'");
        return parent::save();
    }
    
/*                                                                     */
/*                              Properties                             */
/*                                                                     */
    
    public function English() {
        return ucwords($this->english);
    }
    
    public function Type_str() {
        if       ($this->type == 'i') {
            return "Ichidan";
        } elseif ($this->type == 'g') {
            return "Godan";
        } elseif ($this->type == 's') {
            return "Suru";
        } else {
            return "Undefined";
        }
    }
    
    public function type_kanji() {
        if       ($this->type == 'i') {
            return "一段動詞";
        } elseif ($this->type == 'g') {
            return "五段動詞";
        } elseif ($this->type == 's') {
            return "する";
        } else {
            return "Undefined";
        }
    }
    
        public function Difficulty_str() {
        if       ($this->difficulty == 'b') {
            return "Beginner";
        } elseif ($this->difficulty == 'i') {
            return "Intermediate";
        } elseif ($this->difficulty == 'a') {
            return "Advanced";
        } else {
            return "Undefined";
        }
    }
    
/*                                                                     */
/*                                Bases                                */
/*                                                                     */
    
    public function stem() {
        if ($this->type == 's') {
            // Remove suru if of that type
            return substr($this->dictionary_formatted(), 0, -2*J_SIZE);
        } else {
            return substr($this->dictionary_formatted(), 0, -J_SIZE);
        }
    }
    
    // Only used by Godan verbs
    public function ending() {
        return substr($this->dictionary_formatted(),-J_SIZE,J_SIZE);
    }
    
    public function base1() {
        
        if ($this->type == 'i') {
            // Ichidan simply drops the ru
            return $this->stem();
            
        } elseif ($this->type == 'g') {
            // Godan turns last _u to an _a
            $u = $this->ending();
            $a = "missing _u";
            if     ($u=="う") {$a="わ";}
            elseif ($u=="く") {$a="か";}
            elseif ($u=="ぐ") {$a="が";}
            elseif ($u=="す") {$a="さ";}
            elseif ($u=="つ") {$a="た";}
            elseif ($u=="ぬ") {$a="な";}
            elseif ($u=="ぶ") {$a="ば";}
            elseif ($u=="む") {$a="ま";}
            elseif ($u=="る") {$a="ら";}
            return $this->stem() . $a;
        
        } elseif ($this->type == 's') {
            // Replace suru with shi
            return $this->stem()."し";
        
        } else {
            return "undefined";
        }
    }
    
    public function base2() {
        
        if ($this->type == 'i') {
            // Ichidan simply drops the ru
            return $this->stem();
            
        } elseif ($this->type == 'g') {
            // Godan turns last _u to an _i
            $u = $this->ending();
            $i = "missing _u";
            if     ($u=="う") {$i="い";}
            elseif ($u=="く") {$i="き";}
            elseif ($u=="ぐ") {$i="ぎ";}
            elseif ($u=="す") {$i="し";}
            elseif ($u=="つ") {$i="ち";}
            elseif ($u=="ぬ") {$i="に";}
            elseif ($u=="ぶ") {$i="び";}
            elseif ($u=="む") {$i="み";}
            elseif ($u=="る") {$i="り";}
            return $this->stem() . $i;
        
        } elseif ($this->type == 's') {
            // Replace suru with shi
            return $this->stem()."し";
            
        } else {
            return "undefined";
        }
    }
    
    public function base3() {
        return $this->dictionary_formatted();
    }
    
    public function base4() {
        
        if ($this->type == 'i') {
            // Ichidan turns ru to re
            return $this->stem() . "れ";
            
        } elseif ($this->type == 'g') {
            // Godan turns last _u to an _i
            $u = $this->ending();
            $e = "missing _u";
            if     ($u=="う") {$e="え";}
            elseif ($u=="く") {$e="け";}
            elseif ($u=="ぐ") {$e="げ";}
            elseif ($u=="す") {$e="せ";}
            elseif ($u=="つ") {$e="て";}
            elseif ($u=="ぬ") {$e="ね";}
            elseif ($u=="ぶ") {$e="べ";}
            elseif ($u=="む") {$e="め";}
            elseif ($u=="る") {$e="れ";}
            return $this->stem() . $e;
        
        } elseif ($this->type == 's') {
            // Replace suru with sure
            return $this->stem()."すれ";
            
        } else {
            return "undefined";
        }
    }
    
    public function base5() {
        
        if ($this->type == 'i') {
            // Ichidan turns ru to you
            return $this->stem() . "よう";
            
        } elseif ($this->type == 'g') {
            // Godan turns last _u to an _i
            $u = $this->ending();
            $o = "missing _u";
            if     ($u=="う") {$o="おう";}
            elseif ($u=="く") {$o="こう";}
            elseif ($u=="ぐ") {$o="ごう";}
            elseif ($u=="す") {$o="そう";}
            elseif ($u=="つ") {$o="とう";}
            elseif ($u=="ぬ") {$o="のう";}
            elseif ($u=="ぶ") {$o="ぼう";}
            elseif ($u=="む") {$o="もう";}
            elseif ($u=="る") {$o="ろう";}
            return $this->stem() . $o;
        
        } elseif ($this->type == 's') {
            // Replace suru with shiyou
            return $this->stem()."しよう";
            
        } else {
            return "undefined";
        }
    }
    
    public function basete() {
        
        if ($this->type == 'i') {
            // Ichidan turns ru to te
            return $this->stem() . "て";
            
        } elseif ($this->type == 'g') {
            // Godan depends on ending
            $u = $this->ending();
            $te = "missing _u";
            if     (($u=="う")||($u=="つ")||($u=="る")) {$te="って";}
            elseif (($u=="ぶ")||($u=="む")||($u=="ぬ")) {$te="んで";}
            elseif ($u=="く") {$te="いて";}
            elseif ($u=="ぐ") {$te="いで";}
            elseif ($u=="す") {$te="して";}
            return $this->stem() . $te;
        
        } elseif ($this->type == 's') {
            // Replace suru with shite
            return $this->stem()."して";
            
        } else {
            return "undefined";
        }
    }
    
    public function baseta() {
        
        if ($this->type == 'i') {
            // Ichidan turns ru to ta
            return $this->stem() . "た";
            
        } elseif ($this->type == 'g') {
            // Godan depends on ending
            $u = $this->ending();
            $ta = "missing _u";
            if     (($u=="う")||($u=="つ")||($u=="る")) {$ta="った";}
            elseif (($u=="ぶ")||($u=="む")||($u=="ぬ")) {$ta="んだ";}
            elseif ($u=="く") {$ta="いた";}
            elseif ($u=="ぐ") {$ta="いだ";}
            elseif ($u=="す") {$ta="した";}
            return $this->stem() . $ta;
        
        } elseif ($this->type == 's') {
            // Replace suru with shita
            return $this->stem()."した";
            
        } else {
            return "undefined";
        }
    }
    
/*                                                                     */
/*                                Forms                                */
/*                                                                     */

// Present

    public function pln_pres() {
        return $this->base3();
    }
    
    public function plt_pres() {
        return $this->base2() . "ます";
    }
    
    public function pln_pres_neg() {
        return $this->base1() . "ない";
    }
    
    public function plt_pres_neg() {
        return $this->base2() . "ません";
    }

// Past

    public function pln_past() {
        return $this->baseta();
    }
    
    public function plt_past() {
        return $this->base2() . "ました";
    }
    
    public function pln_past_neg() {
        return $this->base1() . "なかった";
    }
    
    public function plt_past_neg() {
        return $this->base2() . "ませんでした";
    }
    
// Present Progressive
    
    public function pln_pres_prog() {
        return $this->basete() . "いる";
    }
    
    public function plt_pres_prog() {
        return $this->basete() . "います";
    }
    
    public function pln_pres_prog_neg() {
        return $this->basete() . "いない";
    }
    
    public function plt_pres_prog_neg() {
        return $this->basete() . "いません";
    }

// Past Progressive
    
    public function pln_past_prog() {
        return $this->basete() . "いた";
    }
    
    public function plt_past_prog() {
        return $this->basete() . "いました";
    }
    
    public function pln_past_prog_neg() {
        return $this->basete() . "いなかった";
    }
    
    public function plt_past_prog_neg() {
        return $this->basete() . "いませんでした";
    }
    
// Potential
    
    public function pln_pot() {
        if       ($this->type == "g") {
            return $this->base4() . "る";
        } elseif ($this->type == "i") {
            return $this->base1() . "られる";
        } elseif ($this->type == "s") {
            return $this->stem() . "できる";
        } else {
            return "unimplemented";
        }
    }
    
    public function plt_pot() {
        if       ($this->type == "g") {
            return $this->base4() . "ます";
        } elseif ($this->type == "i") {
            return $this->base1() . "られます";
        } elseif ($this->type == "s") {
            return $this->stem() . "できます";
        } else {
            return "unimplemented";
        }
    }
    
    public function pln_pot_neg() {
        if       ($this->type == "g") {
            return $this->base4() . "ない";
        } elseif ($this->type == "i") {
            return $this->base1() . "られない";
        } elseif ($this->type == "s") {
            return $this->stem() . "できない";
        } else {
            return "unimplemented";
        }
    }
    
    public function plt_pot_neg() {
        if       ($this->type == "g") {
            return $this->base4() . "ません";
        } elseif ($this->type == "i") {
            return $this->base1() . "られません";
        } elseif ($this->type == "s") {
            return $this->stem() . "できません";
        } else {
            return "unimplemented";
        }
    }

// Volitional
    
    public function pln_vol() {
        return $this->base5();
    }
    
    public function plt_vol() {
        return $this->base2() . "ましょう";
    }
    
    public function pln_vol_neg() {
        if       ($this->type == "g") {
            return $this->base3() . "まい";
        } elseif ($this->type == "i") {
            return $this->base2() . "まい";
        } elseif ($this->type == "s") {
            return $this->base3() . "まい";
        } else {
            return "unimplemented";
        }
    }
    
    public function plt_vol_neg() {
        if       ($this->type == "g") {
            return $this->base2() . "ますまい";
        } elseif ($this->type == "i") {
            return $this->base2() . "ますまい";
        } elseif ($this->type == "s") {
            return $this->base2() . "ないでしょう";
        } else {
            return "unimplemented";
        }
    }
    
}

?>