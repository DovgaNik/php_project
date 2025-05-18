<?php
require('title.php');
require('db.php');
/** @var \PgSql\Connection $db */

$result = pg_query($db, "SELECT books.book_id as book_id, books.name as book_name, books.units as units, authors.name as author_first_name, authors.last_name as author_last_name, category.name as category FROM books JOIN authors ON books.author = authors.author_id JOIN category ON books.category = category.category_id");
$rows = pg_fetch_all($result);
?>
<h1>Books</h1>
<table border=1>
    <th>Name</th>
    <th>Author</th>
    <th>Category</th>
    <th>Units available</th>
    <th>Delete</th>
	<?php
	for ($i = 0; $i < count($rows); $i++) {
		echo '<tr>';

		echo '<td>' . $rows[$i]['book_name'] . '</td>';
		echo '<td>' . $rows[$i]['author_first_name'] . ' ' . $rows[$i]['author_last_name'] . '</td>';
		echo '<td>' . $rows[$i]['category'] . '</td>';
		echo '<td>' . $rows[$i]['units'] . '</td>';

		echo '<td>' .
			'<form action="books_delete.php" method="post">
                <input type="hidden" value="' . $rows[$i]['book_id'] . '" name="book_id">
                <input type="submit" value="Delete">
            </form>'
			. '</td>';

		echo '</tr>';
	}
	?>
</table>


<form action="books_add.php" method="post">
    Book name: <input type="text" name="book_name"><br>
    Category:
    <select name="category" id="category-select">
        <?php
            $result = pg_query($db, 'SELECT * FROM category');
            $rows = pg_fetch_all($result);

            for ($i = 0; $i < count($rows); $i++) {
                echo '<option value = "' . $rows[$i]['category_id'] . '">' . $rows[$i]['name'] . '</option>';
            }
        ?>
    </select><br>

    Category:
    <select name="author" id="author-select">
		<?php
		$result = pg_query($db, 'SELECT * FROM authors');
		$rows = pg_fetch_all($result);

		for ($i = 0; $i < count($rows); $i++) {
			echo '<option value = "' . $rows[$i]['author_id'] . '">' . $rows[$i]['name'] . ' ' . $rows[$i]['last_name'] . '</option>';
		}
		?>
    </select><br>
    Units: <input type="text" name="units"><br>
    <input type="submit" value="Add book">
</form>