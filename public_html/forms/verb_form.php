<?php
require_once("../../includes/initialize.php");

$verbs = array();
if (empty($_GET['id'])) {
    
    // Choose difficulty
    $difficulty = "b";
    if (!empty($_GET['difficulty'])) {
        $g = $_GET['difficulty'];
        if       ($g=="b") {
            $difficulty = "b";
        } elseif ($g=="i") {
            $difficulty = "i";
        }
    }
    $options = array("Difficulty"=>$difficulty);
    
    // Specify quantity
    $quantity = !empty($_GET['quantity'])? (integer)$_GET['quantity'] : 1;
    
    $verbs = Verb::random_selection($quantity, $options);
} else {
    $verbs.push_back(Verb::find_by_id($_GET['id']));
}

Verb::set_display_mode("hrgn");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<verbs>
<?php foreach ($verbs as $verb): ?>
<verb>
    <id><?php echo $verb->id; ?></id>
    <dictionary><?php echo $verb->dictionary_formatted(); ?></dictionary>
    <english><?php echo $verb->English(); ?></english>
<?php
$form_func;
if (empty($_GET['form'])) {
    $forms = array("pln_pres", "plt_pres", "pln_pres_neg", "plt_pres_neg",
                   "pln_past", "plt_past", "pln_past_neg", "plt_past_neg",
                   "pln_pres_prog", "plt_pres_prog", "pln_pres_prog_neg", "plt_pres_prog_neg",
                   "pln_vol", "plt_vol", "pln_vol_neg", "plt_vol_neg");
    $form_func = $forms[rand(0,count($forms)-1)];
} else {
    $form_func = Verb::find_by_id($_GET['form']);
}
?>
    <form><?php echo $form_func; ?></form>
    <answer><?php echo $verb->$form_func(); ?></answer>
</verb>
<?php endforeach; ?>
</verbs>