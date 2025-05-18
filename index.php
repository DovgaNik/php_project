<?php
require("db.php");
require("auth.php");
/** @var \PgSql\Connection $db */

session_start();
if (!validate_auth_key($_SESSION['session_id'])) {
	header('Location: login.php');
	exit;
}

require("title.php");
?>

<?php
$result = pg_query($db, "SELECT books.name as book_name, books.units as units, authors.name as author_first_name, authors.last_name as author_last_name, category.name as category FROM books JOIN authors ON books.author = authors.author_id JOIN category ON books.category = category.category_id");
$rows = pg_fetch_all($result);
?>
<h1>Books</h1>
<table border=1>
    <th>Name</th>
    <th>Author</th>
    <th>Category</th>
    <th>Units available</th>
	<?php
	for ($i = 0; $i < count($rows); $i++) {
		echo '<tr>';

		echo '<td>' . $rows[$i]['book_name'] . '</td>';
		echo '<td>' . $rows[$i]['author_first_name'] . ' ' . $rows[$i]['author_last_name'] . '</td>';
		echo '<td>' . $rows[$i]['category'] . '</td>';
		echo '<td>' . $rows[$i]['units'] . '</td>';

		echo '</tr>';
	}
	?>
</table>