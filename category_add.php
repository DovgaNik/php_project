<?php
require('db.php');
/** @var \PgSql\Connection $db */

if (isset($_POST['category_name'])) {
	$result = pg_query_params($db, 'INSERT INTO category (name) VALUES ($1)', array($_POST['category_name']));
}
header('Location: categories.php');
?>
