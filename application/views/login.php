
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css"/>
    <script type="text/javascript" src="<?=base_url()?>/assets/jquery/jquery-1.10.2.js"></script>
</head>

<body>
    <div id="wrapper">
        <div id="journalPage">
            <h1>Health Journal</h1>
            <p id="loginHorizontalLine"></p>
            <br>
            <h2>Login</h2><br>
            <form id ="loginForm" action="/process/process_login" method="post">
                <label>Email:</label>
                <input type="text" name="email"><br>
                <label>Password:</label>
                <input type="text" name="password"><br>
                <input class="journalButton" type="submit" value="Login">
                <input type="hidden" name="action" value="login">
            </form>

            <br>
            <h2>- or -</h2><br>
            <h2>Register</h2><br>
            <form id ="registerForm" action="/process/process_register" method="post">
                <label>Firstname:</label>
                <input type="text" name="firstname"><br>
                <label>Lastname:</label>
                <input type="text" name="lastname"><br>
                <label>Email:</label>
                <input type="text" name="email"><br>
                <label>Password:</label>
                <input type="text" name="password"><br>
                <label>Confrim Password:</label>
                <input type="text" name="confirm_password"><br>
                <input class="journalButton" type="submit" value="Register">
                <input type="hidden" name="action" value="register">
           </form>
        <br>
    </div>
    </div>   <!-- end of wrapper-->
</body>

</html>