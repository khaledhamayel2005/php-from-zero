<?php
    $food = ["pizza", "burger", "pasta", "sushi"];

    $foods = array("pizza", "burger", "pasta", "sushi");

    echo $food[0];


    echo $food[1] . "<br>";
    echo $food[2] . "<br>";
    echo $food[3] . "<br>";



    foreach($foods as $food){
        echo $food[0] ."<br>";
    }

    array_push($foods, "ice cream");
    array_pop($foods);
    array_shift($foods);
    array_reverse($foods);
    echo count($foods);



    $capatlies = array(
        "USA" => "Washington D.C.",
        "France" => "Paris",
        "Japan" => "Tokyo"
    );

    $capital = $_POST['name'] ?? '';
    echo $capital;

    foreach($capatlies as $country => $capital){
        echo "The capital of $country is $capital <br>";

    }

    if(isset($capatlies[$capital])){
        echo "The capital of $capital is " . $capatlies[$capital];
    } else {
        echo "Capital not found.";
    }

    if(empty($capital)){
        echo "Please enter a capital.";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="post">
        <input type="text" name="name" placeholder="Enter your name">
        <input type="submit" value="Submit">
    </form>

</body>
</html>
