<?php
require("db.php");
require("auth.php");
/** @var \PgSql\Connection $db */

$result = pg_query_params($db, 'INSERT INTO borrows (user_id, book_id, borrow_date, return_date) values ($1, $2, now(), current_date + 7)', array($_POST['user_id'], $_POST['book_id']));
header('Location: index.php');
?>
