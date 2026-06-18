<?php
require_once "config.inc.php";

$q = trim($_GET["q"] ?? "");
$rows = array();
$error = "";

try {
    $pdo = db_connect();

    if ($q == "") {
        $sql = "SELECT id, title, author, price FROM practice_books ORDER BY title";
        $result = $pdo->query($sql);
    } else {
        $sql = "SELECT id, title, author, price FROM practice_books
                WHERE title LIKE :q OR author LIKE :q
                ORDER BY title";
        $result = $pdo->prepare($sql);
        $result->bindValue(":q", "%" . $q . "%");
        $result->execute();
    }

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $row;
    }

    $pdo = null;
} catch (PDOException $e) {
    $error = $e->getMessage();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Book Search</title>
  </head>
  <body>
    <h1>Book Search</h1>

    <form method="get" action="solution.php">
      <p>
        <label>Search:
          <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>">
        </label>
        <button type="submit">Go</button>
      </p>
    </form>

    <?php if ($error != ""): ?>
      <p><?php echo htmlspecialchars($error); ?></p>
    <?php else: ?>
      <table border="1" cellpadding="6">
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Author</th>
          <th>Price</th>
        </tr>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo htmlspecialchars($row["title"]); ?></td>
            <td><?php echo htmlspecialchars($row["author"]); ?></td>
            <td><?php echo $row["price"]; ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
  </body>
</html>

