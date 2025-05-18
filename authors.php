<?php
require('db.php');
/** @var \PgSql\Connection $db */

$result = pg_query($db, "SELECT * FROM authors");
$rows = pg_fetch_all($result);
require ('title.php');
?>

<h1>Authors</h1>
<table border=1>
    <th>Name</th>
	<th>Last name</th>
	<?php
	for ($i = 0; $i < count($rows); $i++) {
		echo '<tr>';

		echo '<td>' . $rows[$i]['name'] . '</td>';
		echo '<td>' . $rows[$i]['last_name'] . '</td>';

		echo '<td>' .
			'<form action="authors_delete.php" method="post">
                <input type="hidden" value="' . $rows[$i]['author_id'] . '" name="author_id">
                <input type="submit" value="Delete">
            </form>'
			. '</td>';

		echo '</tr>';
	}
	?>
</table>

<form action="authors_add.php" method="post">
    <label>
        First name: <br>
        <input type="text" name="name">
    </label><br>
	<label>
		Last name: <br>
		<input type="text" name="last_name">
	</label><br>
    <input type="submit" value="Add an author">
</form>