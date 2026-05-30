<html>
<head>
<title>An example to handle a Form with two Submit Buttons</title>
</head>
<body>
<?php
// Array/form example
/*
This example illustrates how to get the value from a form input of type submit,
 and then call a function based on the user action.
In this example, we have two submit buttons to add a memory item or to delete it. 
So we have two functions add and delete. 
The action value is retrieved from the $_POST array and used as an expression 
in the switch statement to call the appropriate function. 
*/
function add()
{
    echo "<h6>You are adding an items </h6>";
}
function delete()
{
    echo "<h6>You are deleting an items </h6>";
}
// this loop retrieve the data from the form,
// the idea to illustrate how the submit button value is sent
// as the text input.
foreach ($_POST as $key => $value) {
    echo $key . " = " . $value . "<br/>";
}

echo "<hr/>";
if (isset($_POST["action"])) {
    // Choose case
    switch ($_POST["action"]) {
        // Case option
        case "add":
            add();
            break;
        // Case option
        case "delete":
            delete();
            break;
    }
}
?>
</body>
</html>