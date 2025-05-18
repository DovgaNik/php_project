<?php
require('db.php');
/** @var \PgSql\Connection $db */

$result = pg_query($db, "SELECT * FROM category");
$rows = pg_fetch_all($result);
require ('title.php');
?>

<h1>Categories</h1>
<table border=1>
    <th>Category</th>
	<?php
	for ($i = 0; $i < count($rows); $i++) {
		echo '<tr>';

		echo '<td>' . $rows[$i]['name'] . '</td>';

		echo '<td>' .
			'<form action="category_delete.php" method="post">
                <input type="hidden" value="' . $rows[$i]['category_id'] . '" name="category_id">
                <input type="submit" value="Delete">
            </form>'
			. '</td>';

		echo '</tr>';
	}
	?>
</table>

<form action="category_add.php" method="post">
    <label>
        Category name: <br>
        <input type="text" name="category_name">
    </label>
    <input type="submit" value="Add category">
</form>