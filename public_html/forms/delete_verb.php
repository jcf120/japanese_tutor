<?php
require_once("../../includes/initialize.php");

if (!$session->is_logged_in()){
    redirect_to("../verb_list.php");
}

if (empty($_GET['id'])){
    redirect_to("../verb_list.php");
}

$verb = Verb::find_by_id($_GET['id']);
$verb->delete();

redirect_to("../verb_list.php");

?>