
<?php
$name = 'Khaled';
$email = 'khaled.hamayel@gmail.com';
$id = '1231439';
$omar = 'Omar';
$age = 22;
$user = 'randy'
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Fundamentals Tutorial</title>
</head>
<body>



    <h1>PHP Fundamentals</h1>
    <p>This page shows how to store values in variables and print them in the browser.</p>


    <section>
        <h2>Variables</h2>
        <p>Name: <?php echo htmlspecialchars($name); ?></p> 
        <p>Email: <?php echo htmlspecialchars($email); ?></p>
        <p>ID: <?php echo htmlspecialchars($id); ?></p>
        <p> <?php 
           echo htmlspecialchars($omar); 
        ?> </p>


        <!--
            Output will be:
            Name: Khaled
            Email:khaled.hamayel@gmail.com
            ID: 1231439
        -->
    </section>

    <section>
        <h2>String Concatenation</h2>
        <p><?php echo 'My name is ' . htmlspecialchars($name); ?></p>
        <p><?php echo 'My email is ' . htmlspecialchars($email); ?></p>

        
        <p><?php echo "My id is {$id}"; ?></p>
        <p>
            <?php 
                echo "<Strong>";
                echo "$user";
                echo "</Strong>";

?>
        </p>

    </section>
    
    <section>
        <h2>Output Example</h2>
        <pre>
My name is Khaled
My email is khaled.hamayel@gmail.com
My id is 1231439
        </pre>
    </section>
</body>
</html>

