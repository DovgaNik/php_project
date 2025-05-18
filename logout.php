<?php
require("db.php");
/** @var \PgSql\Connection $db */
session_start();
$session_id = $_SESSION['session_id'];
$result = pg_query_params($db, "UPDATE sessions SET status = 'invalidated' WHERE session_id = $1", array($session_id));
unset($_SESSION['session_id']);
header('Location: login.php');
?>