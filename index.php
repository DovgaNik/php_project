<?php
require("db.php");
require("auth.php");
/** @var \PgSql\Connection $db */

session_start();
if (!validate_auth_key($_SESSION['session_id'])) {
	header('Location: login.php');
	exit;
}

$user_id = get_user_id($_SESSION['session_id']);

require("title.php");
?>

<?php
$result = pg_query($db, "SELECT books.book_id as book_id, books.name as book_name, books.units as units, authors.name as author_first_name, authors.last_name as author_last_name, category.name as category FROM books JOIN authors ON books.author = authors.author_id JOIN category ON books.category = category.category_id");
$rows = pg_fetch_all($result);
?>
<h1>Books</h1>
<table border=1>
    <th>Name</th>
    <th>Author</th>
    <th>Category</th>
    <th>Units available</th>
    <th>Lend</th>
	<?php
	for ($i = 0; $i < count($rows); $i++) {
        $result2 = pg_query_params($db, 'SELECT count(*) FROM borrows WHERE book_id = $1 AND actual_return_date IS null', array($rows[$i]['book_id']));
        $counted = pg_fetch_all($result2)[0]['count'];
        $units_available = intval($rows[$i]['units']) - $counted;
		echo '<tr>';

		echo '<td>' . $rows[$i]['book_name'] . '</td>';
		echo '<td>' . $rows[$i]['author_first_name'] . ' ' . $rows[$i]['author_last_name'] . '</td>';
		echo '<td>' . $rows[$i]['category'] . '</td>';
		echo '<td>' . $units_available . '</td>';

        if ($units_available > 0) {
	        echo '<td>' .
		        '<form action="lend_book.php" method="post">
                <input type="hidden" value="' . $user_id . '" name="user_id">
                <input type="hidden" value="' . $rows[$i]['book_id'] . '" name="book_id">
                <input type="submit" value="Lend">
            </form>'
		        . '</td>';

	        echo '</tr>';
        }

		echo '</tr>';
	}
	?>
</table>

<?php
$result = pg_query_params($db,
	"SELECT b.name       as book_name,
       a.name       as author_first_name,
       a.last_name  as author_last_name,
       c.name       as category,
       borrow_date,
       return_date,
       actual_return_date,
       borrow_id
FROM borrows
         JOIN public.users u on borrows.user_id = u.user_id
         JOIN public.books b on b.book_id = borrows.book_id
         JOIN public.authors a on b.author = a.author_id
         JOIN public.category c on b.category = c.category_id
WHERE u.user_id=$1", array($user_id));
$rows = pg_fetch_all($result);
?>
<h1>My borrowed books</h1>
<table border=1>
    <th>Book name</th>
    <th>Author</th>
    <th>Category</th>
    <th>Borrow date</th>
    <th>Supposed return date</th>
    <th>Actual return date</th>
    <th>Return</th>
	<?php
	for ($i = 0; $i < count($rows); $i++) {
		echo '<tr>';

		echo '<td>' . $rows[$i]['book_name'] . '</td>';
		echo '<td>' . $rows[$i]['author_first_name'] . ' ' . $rows[$i]['author_last_name'] . '</td>';
		echo '<td>' . $rows[$i]['category'] . '</td>';
		echo '<td>' . $rows[$i]['borrow_date'] . '</td>';
		echo '<td>' . $rows[$i]['return_date'] . '</td>';
		echo '<td>' . $rows[$i]['actual_return_date'] . '</td>';

        if (empty($rows[$i]['actual_return_date'])) {
	        echo '<td>' .
		        '<form action="return_book.php" method="post">
                <input type="hidden" value="' . $rows[$i]['borrow_id'] . '" name="borrow_id">
                <input type="submit" value="Return">
            </form>'
		        . '</td>';

	        echo '</tr>';
        }
	}
	?>
</table>