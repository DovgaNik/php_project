<?php
require("db.php");
require("auth.php");
/** @var \PgSql\Connection $db */

$result = pg_query_params($db, 'DELETE FROM authors WHERE author_id = $1', array($_POST['author_id']));
header('Location: authors.php');
?>