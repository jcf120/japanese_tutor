<?php
require_once("../../includes/initialize.php");

if (!empty($_GET['test_id'])) {
    
    // retrieve playlist
    if ($pl=$session->playlist_for_test_id($_GET['test_id'])) {
        $quantity = !empty($_GET['quantity']) ? $_GET['quantity'] : 10;
        $questions = array();
        for ($i=0; $i<$quantity; $i++) {
            array_push($questions,$pl->next_question());
        }
    }
    
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<verbs>
<?php foreach ($questions as $question): ?>
<verb>
    <id><?php echo $question['id']; ?></id>
    <dictionary><?php echo $question['dictionary']; ?></dictionary>
    <english><?php echo $question['english']; ?></english>
    <form><?php echo $question['form'] ?></form>
    <answer><?php echo $question['answer'] ?></answer>
</verb>
<?php endforeach; ?>
</verbs>
<?php
} else {
    echo "false";
}
?>