<?php require_once("../includes/initialize.php"); ?>

<?php include_layout_template('header.php'); ?>
<script src="javascripts/jquery.js"></script>
<script src="javascripts/verb_list.js"></script>
<h2>Verb List</h2>

<?php
$pagination = new Pagination(!empty($_GET['page']) ? (int)$_GET['page'] : 1,
                             14,
                             Verb::count_all(),
                             "english");
$found_verbs = Verb::find_by_pagination($pagination);
Verb::set_display_mode("ruby");
?>

<table id="verbs">
    <tr>
        <th>English</th>
        <th>Type</th>
        <th>Base 3</th>
    </tr>
<?php foreach ($found_verbs as $verb): ?>
    <tr>
        <td><?php echo $verb->English(); ?></td>
        <td><?php echo $verb->type_kanji(); ?></td>
        <td><?php echo $verb->base3(); ?></td>
        <td><a href="verb_detail.php?verb=<?php echo $verb->id ?>">details</a></td>
    </tr>
<?php endforeach; ?>
</table>

<?php echo $pagination->display("verb_list.php?page="); ?>

<?php if ($session->is_logged_in()) { ?>

<h3>New Verb</h3>

<table id="new-verb">
    <tr>
        <form action="forms/new_verb.php" method="get">
        <td><input type="text" name="english" /></td>
        <td>
            <div class="styled-select"><select name="type">
                <option value="none">Select Type</option>
                <option value="i">一段動詞</option>
                <option value="g">五段動詞</option>
                <option value="s">する</option>
            </select></div>
        </td>
        <td><input type="text" name="dictionary" /></td>
        <td><input type="submit" value="Add" name="submit" /></td>
        </form>
    </tr>
</table>

<?php } ?>


<?php include_layout_template('footer.php'); ?>