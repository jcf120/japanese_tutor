<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
        <script src="javascripts/jquery.js" type="text/javascript"></script>
        <title>Japanese Tutor</title>
    </head>
    <body>
        <div id="wrapper" >
            <p id="login-out">
                <?php
                // Login status
                global $session;
                if ($session->is_logged_in()) {
                    $user = User::find_by_id($session->user_id);
                    echo "Logged in as {$user->first_name}, ";
                    echo "<a href=\"logout.php\">logout</a>";
                } else {
                    echo "<a href=\"login.php\">login</a>";
                }
                ?>
            </p>
            
            <h1><a href="index.php">Japanese Tutor</a></h1>