
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor= "white" >
<table width="100%" border="1">
  <tr><td colspan="2"><font face="Arial, Helvetica, sans-serif" size=
"-1"><b>Displaying Predefined Variables</b></font></td>
  </tr>
  <tr><td width="40%" valign="top"><font face="Arial, Helvetica, sans-serif"
size="-1">Globals - $GLOBALS</font></td>
    <td width="60%"><font face="Arial, Helvetica, sans-serif" size="-2">
<?php
// PHP basics example
echo "<pre>";
// Debug output
print_r($GLOBALS);
echo "</pre>";
?>
</font></td>
  </tr>
  <tr><td width="40%" valign="top"><font face="Arial, Helvetica, sans-serif"
size="-1">Server - $_SERVER</font></td>
    <td width="60%"><font face="Arial, Helvetica, sans-serif" size="-1">
<?php
echo "<pre>";
// Debug output
print_r($_SERVER);
echo "</pre>";
?>
</font></td>
  </tr>
  <tr><td width="40%" valign="top"><font face="Arial, Helvetica, sans-serif"
size="-1">Get - $_GET </font></td>
  <td width="60%"><font face="Arial, Helvetica, sans-serif" size="-1">
<?php
echo "<pre>";
// Debug output
print_r($_GET);
echo "</pre>";
?>
</font></td>
  </tr>
  <tr><td width="40%" valign="top"><font face="Arial, Helvetica, sans-serif"
size="-1">Post - $_POST </font></td>
    <td width="60%"><font face="Arial, Helvetica, sans-serif" size="-1">
<?php
echo "<pre>";
// Debug output
print_r($_POST);
echo "</pre>";
?>
</font></td>
  </tr>
  <tr><td width="40%" valign="top"><font face="Arial, Helvetica, sans-serif"
size="-1">Cookie - $_COOKIE</font></td>
    <td width="60%"><font face="Arial, Helvetica, sans-serif" size="-1">
<?php
echo "<pre>";
// Debug output
print_r($_COOKIE);
echo "</pre>";
?>
</font></td>
  </tr>
  <tr><td width="40%" valign="top"><font face="Arial, Helvetica, sans-serif"
size="-1">Files - $_FILES</font></td>
    <td width="60%"><font face="Arial, Helvetica, sans-serif" size="-1">
<?php
echo "<pre>";
// Debug output
print_r($_FILES);
echo "</pre>";
?>
</font></td>
  </tr>
  <tr><td width="40%" valign="top"><font face="Arial, Helvetica, sans-serif"
size="-1"> Environment - $_ENV</font></td>
    <td width="60%><font face="Arial, Helvetica, sans-serif" size="-1">
<?php
echo "<pre>";
// Debug output
print_r($_ENV);
echo "</pre>";
?>
</font></td>
  </tr>
  <tr><td width="40%" valign="top"><font face="Arial, Helvetica, sans-serif"
size="-1">Request - $_REQUEST</font></td>
    <td width="60%"><font face="Arial, Helvetica, sans-serif" size="-1">
<?php
echo "<pre>";
// Debug output
print_r($_REQUEST);
echo "</pre>";
?>
</font></td>
  </tr>
  <tr><td width="40%" valign="top"><font face="Arial, Helvetica, sans-serif"
size="-1">Session - $_SESSION</font></td>
    <td width="60%"><font face="Arial, Helvetica, sans-serif" size="-1">
<?php
echo "<pre>";
// Debug output
print_r($_SESSION);
echo "</pre>";
?>
</font></td>
  </tr>
</table>
</body>
</html>

