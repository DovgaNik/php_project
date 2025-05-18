<?php
require("db.php");
require("auth.php");
/** @var \PgSql\Connection $db */

$result = pg_query_params($db, 'DELETE FROM books WHERE book_id = $1', array($_POST['book_id']));
header('Location: books.php');
?>