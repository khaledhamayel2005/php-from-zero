<?php
$cookieName = "practice_preferences";
$prefs = array(
    "name" => "Guest",
    "color" => "#ffffff",
    "size" => "16",
);

if (isset($_COOKIE[$cookieName])) {
    $saved = json_decode($_COOKIE[$cookieName], true);
    if (is_array($saved)) {
        $prefs = array_merge($prefs, $saved);
    }
}

if (isset($_GET["reset"])) {
    setcookie($cookieName, "", time() - 3600);
    header("Location: solution.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prefs["name"] = trim($_POST["name"] ?? "Guest");
    $prefs["color"] = $_POST["color"] ?? "#ffffff";
    $prefs["size"] = $_POST["size"] ?? "16";

    setcookie($cookieName, json_encode($prefs), time() + 60 * 60 * 24 * 7);
    header("Location: solution.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Cookie Preferences</title>
  </head>
  <body style="background-color: <?php echo htmlspecialchars($prefs["color"]); ?>; font-size: <?php echo htmlspecialchars($prefs["size"]); ?>px;">
    <h1>Welcome <?php echo htmlspecialchars($prefs["name"]); ?></h1>

    <form method="post" action="solution.php">
      <p>
        <label>Name:
          <input type="text" name="name" value="<?php echo htmlspecialchars($prefs["name"]); ?>">
        </label>
      </p>
      <p>
        <label>Background:
          <select name="color">
            <option value="#ffffff" <?php if ($prefs["color"] == "#ffffff") echo "selected"; ?>>White</option>
            <option value="#eef7ff" <?php if ($prefs["color"] == "#eef7ff") echo "selected"; ?>>Blue</option>
            <option value="#f2fff0" <?php if ($prefs["color"] == "#f2fff0") echo "selected"; ?>>Green</option>
          </select>
        </label>
      </p>
      <p>
        <label>Font size:
          <select name="size">
            <option value="14" <?php if ($prefs["size"] == "14") echo "selected"; ?>>Small</option>
            <option value="16" <?php if ($prefs["size"] == "16") echo "selected"; ?>>Normal</option>
            <option value="20" <?php if ($prefs["size"] == "20") echo "selected"; ?>>Large</option>
          </select>
        </label>
      </p>
      <p><button type="submit">Save</button></p>
    </form>

    <p><a href="solution.php?reset=1">Reset preferences</a></p>
  </body>
</html>

