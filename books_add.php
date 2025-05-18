<?php
require('db.php');
/** @var \PgSql\Connection $db */

if (isset($_POST['book_name'])) {
	$result = pg_query_params($db, 'INSERT INTO books (name, author, category, units) VALUES ($1, $2, $3, $4)',
		array(
			$_POST['book_name'],
			$_POST['author'],
			$_POST['category'],
			$_POST['units']
		));
}
header('Location: books.php');
?>