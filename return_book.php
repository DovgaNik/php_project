<?php
require("db.php");
require("auth.php");
/** @var \PgSql\Connection $db */

$result = pg_query_params($db, 'UPDATE borrows SET actual_return_date = now() WHERE borrow_id = $1', array($_POST['borrow_id']));
header('Location: index.php');
?>