<?php
require('db.php');
/** @var \PgSql\Connection $db */
require('auth.php');

session_start();
if (validate_auth_key($_SESSION['session_id'])) {
	if (check_admin($_SESSION['session_id'])) {
		header('Location: admin_panel.php');
		exit;
	} else {
		header('Location: index.php');
		exit;
	}
}

require("title.php");
?>

<form action="login.php" method="post">

    <label>
        Login:
        <input type="text" name="username">
    </label>
    <br>

    <label>
        Password:
        <input type="password" name="password">
    </label>
    <br>
    <input type="submit" value="Login">

</form>

<?php
if (isset($_POST['username'])) { // By checking where username var is set, we know whether the request is get or post
	if (empty($_POST['username'])) {
		echo("The username is empty <br>");
		exit;
	}
	if (empty($_POST['password'])) {
		echo("The password is empty <br>");
		exit;
	}
	login($_POST['username'], $_POST['password']);
	header("Refresh: 0");
}
?>
