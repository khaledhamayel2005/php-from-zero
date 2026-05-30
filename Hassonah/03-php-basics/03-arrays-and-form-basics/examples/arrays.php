<html><head><title>Arrays</title></head>
<!-- arrays.php COMP334 -->
<body>

<?php
// Array/form example
$arr = ["foo" => "bar", 12 => true];
echo $arr["foo"], "<br/> \n"; // bar
echo $arr[12], "<br/> </br> \n";

// 1
?>

<?php
$arr = [5 => 43, 32, 56, "b" => 12];
foreach ($arr as $key => $value) {
    echo $key, "=>", $value, ",";
}
echo "</br> \n";
//$arr=array(5 => 43, 6 => 32, 7 => 56, "b" => 12);
$arr = ["x" => 43, "y" => 32, 56, "b" => 12];
foreach ($arr as $key => $value) {
    echo $key, "=>", $value, ",";
}
echo "</br></br> \n";
?>

<?php
$arr = [5 => 1, 12 => 2];
foreach ($arr as $key => $value) {
    echo $key, "=>", $value, ",";
}
echo "</br> \n";
$arr[] = 56; // the same as $arr[13] = 56;
foreach ($arr as $key => $value) {
    echo $key, "=>", $value, ",";
}
echo "</br> \n";
$arr["x"] = 42; // adds a new element
foreach ($arr as $key => $value) {
    echo $key, "=>", $value, ",";
}
echo "</br> \n";
unset($arr[5]); // removes the element
foreach ($arr as $key => $value) {
    echo $key, "=>", $value, ",";
}
echo "</br> \n";
unset($arr); // deletes the whole array
$a = [1 => "one", 2 => "two", 3 => "three"];
foreach ($a as $key => $value) {
    echo $key, "=>", $value, ",";
}
echo "</br> \n";
unset($a[2]);
$b = array_values($a);
foreach ($b as $key => $value) {
    echo $key, "=>", $value, ",";
}
echo "</br> \n";
?>


</body>
</html>
