<?php
require('auth.php');
require('db.php');
/** @var \PgSql\Connection $db */

session_start();
if (!validate_auth_key($_SESSION['session_id'])) {
	header('Location: login.php');
	exit;
}

if (!check_admin($_SESSION['session_id'])) {
	header('Location: index.php');
	exit;
}

require('title.php');
?>

<?php
$result = pg_query($db, "SELECT * FROM users");
$rows = pg_fetch_all($result);
?>
<h1>Users</h1>
<table border=1>
    <th>Username</th>
    <th>Name</th>
	<?php
	for ($i = 0; $i < count($rows); $i++) {
		echo '<tr>';

		echo '<td>' . $rows[$i]['username'] . '</td>';
		echo '<td>' . $rows[$i]['first_name'] . ' ' . $rows[$i]['last_name'] . '</td>';

		echo '</tr>';
	}
	?>
</table>

<?php
$result = pg_query($db, "SELECT * FROM category");
$rows = pg_fetch_all($result);
?>
<h1><a href="categories.php">Categories</a></h1>
<table border=1>
    <th>Category</th>
	<?php
	for ($i = 0; $i < count($rows); $i++) {
		echo '<tr>';

		echo '<td>' . $rows[$i]['name'] . '</td>';

		echo '</tr>';
	}
	?>
</table>


<?php
$result = pg_query($db, "SELECT * FROM authors");
$rows = pg_fetch_all($result);
?>
<h1><a href="authors.php">Authors</a></h1>
<table border=1>
    <th>Name</th>
    <th>Last name</th>
	<?php
	for ($i = 0; $i < count($rows); $i++) {
		echo '<tr>';

		echo '<td>' . $rows[$i]['name'] . '</td>';
		echo '<td>' . $rows[$i]['last_name'] . '</td>';

		echo '</tr>';
	}
	?>
</table>

<?php
$result = pg_query($db, "SELECT books.name as book_name, books.units as units, authors.name as author_first_name, authors.last_name as author_last_name, category.name as category FROM books JOIN authors ON books.author = authors.author_id JOIN category ON books.category = category.category_id");
$rows = pg_fetch_all($result);
?>
<h1><a href="books.php">Books</a></h1>
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

<?php
$result = pg_query($db,
	"SELECT b.name       as book_name,
       a.name       as author_first_name,
       a.last_name  as author_last_name,
       c.name       as category,
       u.first_name as user_first_name,
       u.last_name as user_last_name,
       borrow_date,
       return_date,
       actual_return_date
FROM borrows
         JOIN public.users u on borrows.user_id = u.user_id
         JOIN public.books b on b.book_id = borrows.book_id
         JOIN public.authors a on b.author = a.author_id
         JOIN public.category c on b.category = c.category_id");
$rows = pg_fetch_all($result);
?>
<h1>Borrows</h1>
<table border=1>
    <th>Book name</th>
    <th>Author</th>
    <th>Category</th>
    <th>Name of borrower</th>
    <th>Borrow date</th>
    <th>Supposed return date</th>
    <th>Actual return date</th>
	<?php
	for ($i = 0; $i < count($rows); $i++) {
		echo '<tr>';

		echo '<td>' . $rows[$i]['book_name'] . '</td>';
		echo '<td>' . $rows[$i]['author_first_name'] . ' ' . $rows[$i]['author_last_name'] . '</td>';
		echo '<td>' . $rows[$i]['category'] . '</td>';
		echo '<td>' . $rows[$i]['user_first_name'] . ' ' . $rows[$i]['user_last_name'] . '</td>';
		echo '<td>' . $rows[$i]['borrow_date'] . '</td>';
		echo '<td>' . $rows[$i]['return_date'] . '</td>';
		echo '<td>' . $rows[$i]['actual_return_date'] . '</td>';

		echo '</tr>';
	}
	?>
</table>