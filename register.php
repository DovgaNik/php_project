<?php
require("title.php");
require('auth.php');
require('db.php');
/** @var \PgSql\Connection $db */
?>

    <form action="register.php" method="post">

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

        <label>
            First name:
            <input type="text" name="first_name">
        </label>
        <br>

        <label>
            Last name:
            <input type="text" name="last_name">
        </label>
        <br>

        <input type="submit" value="Register">

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
	if (empty($_POST['first_name'])) {
		echo("The first name is empty <br>");
		exit;
	}
	if (empty($_POST['last_name'])) {
		echo("The last name is empty <br>");
		exit;
	}

	// if we reach this point, all the vars are set
	$password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

	$result = pg_query_params($db,
		'insert into users (username, password, first_name, last_name) values ($1, $2, $3, $4) returning user_id',
		array(
			$_POST['username'],
			$password_hash,
			$_POST['first_name'],
			$_POST['last_name']
		));
    $row = pg_fetch_assoc($result);
    gen_auth_key($row['user_id']);
}
?>