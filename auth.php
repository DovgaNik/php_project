<?php
function login($username, $password): string
{
	require('db.php');
	/** @var \PgSql\Connection $db */
	$result = pg_query_params($db, 'SELECT user_id, username, password FROM users WHERE username=$1', array($username));
	$row = pg_fetch_all($result)[0];
	if (password_verify($password, $row['password'])) {
		return gen_auth_key($row['user_id']);
	} else {
		return '';
	}
}

function gen_auth_key($user_id): string
{
	require('db.php');
	/** @var \PgSql\Connection $db */
	$result = pg_query_params($db, 'insert into sessions (user_id) values ($1) returning session_id', array($user_id));
	$row = pg_fetch_all($result);
	$session_id = $row[0]['session_id'];
	session_start();
	$_SESSION['session_id'] = $session_id;
	return $session_id;
}

function validate_auth_key($session_id): bool
{
	require('db.php');
	/** @var \PgSql\Connection $db */
	$result = pg_query_params($db, 'SELECT user_id FROM sessions WHERE session_id=$1', array($session_id));
	if (pg_num_rows($result) == 0) {
		return false;
	} else {
		return true;
	}
}