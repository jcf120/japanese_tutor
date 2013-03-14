<?php
require_once("../../includes/initialize.php");

if (!$session->is_logged_in()){
    redirect_to("../verb_list.php");
}

if (empty($_GET['id']) || empty($_GET['difficulty'])) {
    redirect_to("../verb_list.php");
}

$verb = Verb::find_by_id($_GET['id']);
if ($verb) {
    $verb->difficulty = $_GET['difficulty'];
    $verb->save();
}

redirect_to("../verb_detail.php?verb=".$verb->id);

?>