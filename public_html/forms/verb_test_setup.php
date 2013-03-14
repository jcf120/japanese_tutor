<?php
require_once("../../includes/initialize.php");


if (!empty($_GET['finished']) && !empty($_GET['test_id'])) {
    if ($_GET['finished']=='true') {
        $session->end_test($_GET['test_id']);
    }
} else {
    
    // build new playlist
    
    $diff = null;
    if       ($_GET['diff']=='b') {
        $diff = 'b';
    } elseif ($_GET['diff']=='i') {
        $diff = 'i';
    } elseif ($_GET['diff']=='a') {
        $diff = 'a';
    }
    
    // parse forms
    $forms = null;
    if (!empty($_GET['forms'])) {
        $dirty_forms = explode(',',$_GET['forms']);
        $forms = array();
        foreach($dirty_forms as $dirty_form) {
            if (key_exists($dirty_form,Verb::$form_library)) {
                array_push($forms,(string)$dirty_form);
            }
        }
    }
    
    $playlist = null;
    
    if (!is_null($diff)) {
        $playlist = new SmartPlayList($diff,$forms);
        $playlist->load_verbs();
    }
    
    if (!is_null($playlist)) {
        
        // add new playlist to test manager and get id
        $test_id = $session->test_playlist($playlist);
        
        // return id to client
        echo $test_id;
        
    } else {
        
        // setup failed
        echo "false";
        
    }
}


?>