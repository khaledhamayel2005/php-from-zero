# Practical Exam Cheat Sheet

## POST Form Pattern

```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
}
```

## Safe Output Pattern

```php
echo htmlspecialchars($value);
```

## Checkbox Pattern

```php
$items = $_POST["items"] ?? array();

foreach ($items as $item) {
    echo htmlspecialchars($item);
}
```

## Session Pattern

```php
session_start();

$_SESSION["userid"] = $userid;

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
```

## Cookie Pattern

```php
setcookie("pref", "blue", time() + 60 * 60 * 24 * 7);

if (isset($_COOKIE["pref"])) {
    echo $_COOKIE["pref"];
}
```

## JSON Cookie Pattern

```php
$data = array("name" => "Ali", "color" => "blue");
setcookie("pref", json_encode($data), time() + 60 * 60 * 24 * 7);

$saved = json_decode($_COOKIE["pref"], true);
```

## PDO Config Pattern

```php
define("DBHOST", "localhost");
define("DBNAME", "webTest");
define("DBUSER", "httpd");
define("DBPASS", "web");

function db_connect()
{
    try {
        $pdo = new PDO(
            "mysql:host=" . DBHOST . ";dbname=" . DBNAME,
            DBUSER,
            DBPASS
        );
        return $pdo;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
```

## PDO Query and Fetch

```php
$pdo = db_connect();
$result = $pdo->query("SELECT id, title FROM books ORDER BY title");

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo $row["title"];
}

$pdo = null;
```

## PDO Prepared SELECT

```php
$sql = "SELECT title FROM books WHERE id = ?";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $_GET["id"]);
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);
```

## PDO Prepared INSERT With md5

```php
$sql = "INSERT INTO user (userid, userpassword, username)
        VALUES (?, md5(?), ?)";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $_POST["userid"]);
$statement->bindValue(2, $_POST["password"]);
$statement->bindValue(3, $_POST["username"]);
$statement->execute();
```

## Login With md5

```php
$sql = "SELECT userid FROM user
        WHERE userid = ? AND userpassword = md5(?)";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $_POST["userid"]);
$statement->bindValue(2, $_POST["password"]);
$statement->execute();

if ($statement->fetch()) {
    $_SESSION["userid"] = $_POST["userid"];
}
```

