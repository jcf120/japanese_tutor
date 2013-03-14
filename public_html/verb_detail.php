<?php require_once("../includes/initialize.php"); ?>
<?php if (empty($_GET['verb'])) redirect_to('index.php'); ?>
<?php include_layout_template('header.php'); ?>

<?php if ($session->is_logged_in()) { ?>
<script type="text/javascript">
<!--
    document.getElementById('wrapper').style.visibility = 'hidden';
-->
</script>
<?php } ?>

<script src="javascripts/functions.js" type="text/javascript"></script>

<?php
$verb = Verb::find_by_id((int)$_GET['verb']);
Verb::set_display_mode("ruby");
?>

<a href="verb_list.php">&laquo Back</a>

<h2><?php echo $verb->English() . " – " . $verb->base3(); ?></h2>

<table id="tenses">
    <tr>
        <th></th>
        <th>Plain</th>
        <th>Polite</th>
    </tr>
    <tr class="block-start">
        <td>Present/Future</td>
        <td><?php echo $verb->pln_pres(); ?></td>
        <td><?php echo $verb->plt_pres(); ?></td>
    </tr>
    <tr class="block-end">
        <td></td>
        <td><?php echo $verb->pln_pres_neg(); ?></td>
        <td><?php echo $verb->plt_pres_neg(); ?></td>
    </tr>
    <tr class="block-start">
        <td>Past</td>
        <td><?php echo $verb->pln_past(); ?></td>
        <td><?php echo $verb->plt_past(); ?></td>
    </tr>
    <tr class="block-end">
        <td></td>
        <td><?php echo $verb->pln_past_neg(); ?></td>
        <td><?php echo $verb->plt_past_neg(); ?></td>
    </tr>
    <tr class="block-start">
        <td>Present Progressive</td>
        <td><?php echo $verb->pln_pres_prog(); ?></td>
        <td><?php echo $verb->plt_pres_prog(); ?></td>
    </tr>
    <tr class="block-end">
        <td></td>
        <td><?php echo $verb->pln_pres_prog_neg(); ?></td>
        <td><?php echo $verb->plt_pres_prog_neg(); ?></td>
    </tr>
    <tr class="block-start">
        <td>Past Progressive</td>
        <td><?php echo $verb->pln_past_prog(); ?></td>
        <td><?php echo $verb->plt_past_prog(); ?></td>
    </tr>
    <tr class="block-end">
        <td></td>
        <td><?php echo $verb->pln_past_prog_neg(); ?></td>
        <td><?php echo $verb->plt_past_prog_neg(); ?></td>
    </tr>
    <tr class="block-start">
        <td>Potential</td>
        <td><?php echo $verb->pln_pot(); ?></td>
        <td><?php echo $verb->plt_pot(); ?></td>
    </tr>
    <tr class="block-end">
        <td></td>
        <td><?php echo $verb->pln_pot_neg(); ?></td>
        <td><?php echo $verb->plt_pot_neg(); ?></td>
    </tr>
    <tr class="block-start">
        <td>Volitional</td>
        <td><?php echo $verb->pln_vol(); ?></td>
        <td><?php echo $verb->plt_vol(); ?></td>
    </tr>
    <tr class="block-end">
        <td></td>
        <td><?php echo $verb->pln_vol_neg(); ?></td>
        <td><?php echo $verb->plt_vol_neg(); ?></td>
    </tr>
    <?php if ($session->is_logged_in()) { ?>
    <tr>
        <td><a id="delete" href="forms/delete_verb.php?id=<?php echo $verb->id; ?>">Delete</a></td>
        <form action="forms/edit_verb.php" method="get">
            <td>
                <input type="hidden" name="id" value="<?php echo $verb->id; ?>">
                <select name="difficulty">
                    <option value="none">Select Level</option>
                    <option value="b"<?php if($verb->difficulty=="b")
                    echo "selected=\"selected\"" ?>>Beginner</option>
                    <option value="i"<?php if($verb->difficulty=="i")
                    echo "selected=\"selected\"" ?>>Intermediate</option>
                    <option value="a"<?php if($verb->difficulty=="a")
                    echo "selected=\"selected\"" ?>>Advanced</option>
                </select>
            </td>
            <td><input type="submit" name="submit" value="Change Level"></td>
        </form>
    </tr>
    <script src="javascripts/verb_detail.js" type="text/javascript"></script>
    <?php } ?>
</table>

<?php include_layout_template('footer.php'); ?>