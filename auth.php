<?php
function login($username, $password): bool
{
	require('db.php');
	/** @var \PgSql\Connection $db */
	$result = pg_query_params($db, 'SELECT user_id, username, password FROM users WHERE username=$1', array($username));
	$row = pg_fetch_all($result)[0];
	return (password_verify($password, $row['password']));
}

function gen_auth_key()
{

}