<?php
require('db.php');
/** @var \PgSql\Connection $db */

if (isset($_POST['name'])) {
	$result = pg_query_params($db, 'INSERT INTO authors (name, last_name) VALUES ($1, $2)', array($_POST['name'], $_POST['last_name']));
}
header('Location: authors.php');
?>