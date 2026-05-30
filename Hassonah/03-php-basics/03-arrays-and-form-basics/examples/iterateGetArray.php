<html>
    <head>
        <title>Iterate $_GET array</title>
    </head>
<body>

 /*
this example check of the user has sent any input 
using get methods, using count function. 
if any data has been sent, printed usig foreach loop  
*/ /*
this example check of the user has sent any input 
using get methods, using count function. 
if any data has been sent, printed usig foreach loop  
*/<?php /*
this example check of the user has sent any input 
using get methods, using count function. 
if any data has been sent, printed usig foreach loop  
*/
if (count($_GET) != 0) {
    foreach ($_GET as $key => $value) {
        echo $key . " = " . $value . "<br/>";
    }
} ?>
 </body>
 </html>
