<html><head></head>
<!-- scalars.php COMP334 -->
<body>  <p>
<?php
// PHP basics example
$foo = true;
if ($foo) {
    echo "It is TRUE! <br/> \n";
}
$txt = "1234";
echo "$txt <br/> \n";
$a = 1234;
echo "$a <br/> \n";
$a = -123;
echo "$a <br/> \n";
$a = 1.234;
echo "$a <br /> \n";
$a = 1.2e3;
echo "$a <br /> \n";
$a = 7e-10;
echo "$a <br /> \n";
echo 'Ali once said: "I\'ll be back"', "<br /> \n";
$coffee = "Java";
echo "$coffee's taste is great <br /> \n";
$str = <<<EOD
<pre>
Example of string
spanning multiple lines
using heredoc syntax.
</pre>
EOD;
echo $str;
?>  </p>
</body>
</html>
