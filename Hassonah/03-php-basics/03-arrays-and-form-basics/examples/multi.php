
<html>
<head>
</head>
<body>
	<p>Multi-dimensional array example and using foreach loop to iterate on the array keys and values keys and values.</p>
<?php
// Array/form example
$forecast = ["Mon" => 40, "Tue" => 47, "Wed" => 52, "Thu" => 40, "Fri" => 37];
echo "<p> output of a single dimension array uisng association key</p><hr/>";
foreach ($forecast as $key => $value) {
    echo " day[" . $key . "]=" . $value . "<br/>\n";
}
$aa = [["AMZN", "Amazon"], ["APPL", "Apple"], ["MSFT", "Microsoft"]];
echo "<p> output of a two-dimensions array in which 1st and 2nd subscripts are numeric</p><hr/>";

foreach ($aa as $key => $value) {
    echo "[$key] => ( ";
    foreach ($value as $k => $v) {
        echo "[$k] => " . $v . ", ";
    }
    echo " )<br/>";
}

$bb = [
    "AMZN" => ["Amazon", 234],
    "APPL" => ["Apple", 342],
    "MSFT" => ["Microsoft", 165],
];
echo "<p> output of a two-dimensions array in which 1st is string and 2nd is numeric</p><hr/>";

foreach ($bb as $key => $value) {
    echo "[$key] => ( ";
    foreach ($value as $k => $v) {
        echo "[$k] => " . $v . ", ";
    }
    echo " )<br/>";
}
$cc = [
    "AMZN" => ["name" => "Amazon", "price" => 234],
    "APPL" => ["name" => "Apple", "price" => 342],
    "MSFT" => ["name" => "Microsoft", "price" => 165],
];
echo "<p> output of a two-dimensions array in which 1st and 2nd subscripts are string</p><hr/>";

foreach ($cc as $key => $value) {
    echo "[$key] => ( ";
    foreach ($value as $k => $v) {
        echo "[$k] => " . $v . ", ";
    }
    echo " )<br/>";
}
?>
</body>
</html>
