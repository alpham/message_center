<html >
    <head>
        <title>
            <?php echo PRO_TITLE." | Login"; ?>
        </title>
    </head>
    <body>
        <form action="<?php echo ABSOLUTE_PATH . "login/doLogin"; ?>" method="post">
            <label>Username: </label>
            <input type="text" placeholder="username" name="username" /><br />
            
            <label>Password: </label>
            <input type="password" placeholder="password" name="password" /><br />
            
            <input type="checkbox" name="remember" /><label>Remember me ?</label><br />
            
            <input type="submit" value="Login" name="submit" />
        </form> 
    </body>
</html>