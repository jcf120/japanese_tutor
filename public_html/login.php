<?php

require_once("../includes/initialize.php"); 

// Redirect if already logged in
if ($session->is_logged_in()) {
    redirect_to("index.php");
}

// Form Validation

if (isset($_POST['submit'])) {
    
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $found_user = User::authenticate($username,$password);
    
    if ($found_user) {
        $session->login($found_user);
        redirect_to("index.php");
    } else {
        // User does not exist
        $message = "Username or password invalid";
    }

} else {
    // before submission
    $username = "";
    $password = "";
}

?>

<?php include_layout_template('header.php'); ?>

<form action="login.php" method="post">
    <table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="username"
                       value="<?php echo htmlentities($username) ?>"/></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" /></td>
        </tr>
    </table>
    <input type="submit" name="submit" />
</form>

<p><?php echo $message; ?></p>


<?php include_layout_template('footer.php'); ?>