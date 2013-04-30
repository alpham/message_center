<?php
if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
}

?>

<html >
    <head>
        <title><?php echo PRO_TITLE . " | Login"; ?></title>
        <link href="public/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <script src="public/js/jquery-latest.js"></script>
        <script src="public/js/bootstrap.min.js"></script>
    </head>
    <body>
        <form action="<?php echo ABSOLUTE_PATH . "login"; ?>" method="post">
            <label for="username">Username: </label>
            <input type="text" placeholder="username" name="username" />
            <br />

            <label for="password">Password: </label>
            <input type="password" placeholder="password" name="password" />
            <br />

            <input type="submit" value="Login" name="login" /> or <a href="#myModal" class="btn-link" data-toggle="modal">Signup!</a>
        </form>
        <?php        require_once 'views/signup.php';?>
    </body>
</html>
