<?php
require("db.php");
require("auth.php");
/** @var \PgSql\Connection $db */

$result = pg_query_params($db, 'DELETE FROM category WHERE category_id = $1', array($_POST['category_id']));
header('Location: categories.php');
?>