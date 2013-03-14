<?php
require_once("../../includes/initialize.php");

if (!$session->is_logged_in()){
    redirect_to("../verb_list.php");
}

if (empty($_GET['english']) || empty($_GET['type']) || empty($_GET['dictionary'])) {
    redirect_to("../verb_list.php");
}

// Check string is valid for verb type
$type;
if       ($_GET['type'] == 'i') {
    // Ichidan ending must be ru
    if (substr($_GET['dictionary'],-J_SIZE,J_SIZE) != "る") {
        redirect_to("../verb_list.php");
    }
    $type = 'i';
    
} elseif ($_GET['type'] == 'g') {
    // Godan ending must be _u
    $_u = substr($_GET['dictionary'],-J_SIZE,J_SIZE);
    if ($_u !=  "う" &&
        $_u !=  "く" &&
        $_u !=  "ぐ" &&
        $_u !=  "す" &&
        $_u !=  "つ" &&
        $_u !=  "ぬ" &&
        $_u !=  "ぶ" &&
        $_u !=  "む" &&
        $_u !=  "る") {
        redirect_to("../verb_list.php");
    }
    $type = 'g';
    
} elseif ($_GET['type'] == 's') {
    // Suru ending must be suru
    if (substr($_GET['dictionary'],-2*J_SIZE,2*J_SIZE) != "する") {
        redirect_to("../verb_list.php");
    }
    $type = 's';
}

$verb = new Verb();
$verb->english = strtolower($_GET['english']);
$verb->type = $type;
$verb->dictionary = $_GET['dictionary'];
$verb->save();

redirect_to("../verb_list.php");

?>