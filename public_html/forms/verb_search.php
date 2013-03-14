<?php
require_once("../../includes/initialize.php");

$verbs = array();
if (!empty($_GET['id'])) {
    $id = (int)$_GET['id'];
    array_push($verbs,Verb::find_by_id($id));
}

elseif (!empty($_GET['order']) && !empty($_GET['count']) && !empty($_GET['page'])) {
    $order = $_GET['order']=="english" ? "english" : null;
    $count = (int)$_GET['count'];
    $page = (int)$_GET['page'];
    $pg = new Pagination($page,$count,Verb::count_all(),$order);
    $verbs = Verb::find_by_pagination($pg);
}
Verb::set_display_mode("marked");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<verbs>
<?php foreach ($verbs as $verb): ?>
<verb>
    <id><?php echo $verb->id; ?></id>
    <dictionary><?php echo $verb->dictionary_formatted(); ?></dictionary>
    <type><?php echo $verb->type; ?></type>
    <english><?php echo $verb->English(); ?></english>
    <difficulty><?php echo $verb->difficulty; ?></difficulty>
</verb>
<?php endforeach; ?>
</verbs>