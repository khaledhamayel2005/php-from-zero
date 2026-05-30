<?php
// Session/cookie example
// JSON cookie handling
$cookieData = [];

// Load saved cookie data
if (!empty($_COOKIE["preferences"])) {
  $decoded = json_decode($_COOKIE["preferences"], true);
  // Return an array instead of an object
  if (is_array($decoded)) {
    $cookieData = $decoded;
  }
}

// Add new form values
if (!empty($_POST["type_sel"])) {
  $cookieData["Type"] = $_POST["type_sel"];
}

if (!empty($_POST["size_sel"])) {
  $cookieData["Size"] = $_POST["size_sel"];
}

// Store preferences as JSON
if (!empty($_POST["type_sel"]) || !empty($_POST["size_sel"])) {
  $jsonPayload = json_encode($cookieData);
  // Set cookie
  setcookie("preferences", $jsonPayload, time() + 3600);
}

// Read cookie JSON
$prefs = [];
if (!empty($_COOKIE["preferences"])) {
  $prefs = json_decode($_COOKIE["preferences"], true) ?? [];
}

// Build POST preview data
$postData = [];
if (!empty($_POST["type_sel"])) {
  $postData["Type"] = $_POST["type_sel"];
}
if (!empty($_POST["size_sel"])) {
  $postData["Size"] = $_POST["size_sel"];
}

// Safely read display values
function jsonGet(array $data, string $key): string
{
  return isset($data[$key]) ? htmlspecialchars((string) $data[$key], ENT_QUOTES) : "";
}

$cookieType = jsonGet($prefs, "Type");
$cookieSize = jsonGet($prefs, "Size");
$postType = jsonGet($postData, "Type");
$postSize = jsonGet($postData, "Size");

// Form options
$type = ["arial", "helvetica", "sans-serif", "courier"];
$size = ["1", "2", "3", "4", "5", "6", "7"];

// Render page
?>
<html>

<head>
  <title>Cookie Test</title>
</head>

<body>
  <div align='center'>

    <form method='POST'>
      What font type would you like to use?
      <select name='type_sel'>
        <option selected value=''>default</option>
        <?php foreach ($type as $var): ?>
          <option><?= htmlspecialchars($var) ?></option>
        <?php endforeach; ?>
      </select><br><br>

      What font size would you like to use?
      <select name='size_sel'>
        <option selected value=''>default</option>
        <?php foreach ($size as $var): ?>
          <option><?= htmlspecialchars($var) ?></option>
        <?php endforeach; ?>
      </select><br><br>

      <input type='submit'>
    </form>

    <b>Your cookies say:</b><br>
    <font <?= $cookieType ? "face='$cookieType'" : "" ?> <?= $cookieSize ? "size='$cookieSize'" : "" ?>>
      <?php if ($cookieType): ?>Type = <?= $cookieType ?><br><?php endif; ?>
      <?php if ($cookieSize): ?>Size = <?= $cookieSize ?><br><?php endif; ?>
    </font>

    <b>Your form variables say:</b><br>
    <font <?= $postType ? "face='$postType'" : "" ?> <?= $postSize ? "size='$postSize'" : "" ?>>
      <?php if ($postType): ?>Type = <?= $postType ?><br><?php endif; ?>
      <?php if ($postSize): ?>Size = <?= $postSize ?><br><?php endif; ?>
    </font>

  </div>
</body>

</html>