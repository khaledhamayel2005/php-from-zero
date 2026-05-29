<?php
// Indexed arrays store values using numeric keys that start at 0.
$foodItems = ["pizza", "burger", "pasta", "sushi"];

// The older array() syntax works the same way.
$foodList = array("pizza", "burger", "pasta", "sushi");

// Associative arrays use meaningful string keys.
$capitals = array(
    "USA" => "Washington D.C.",
    "France" => "Paris",
    "Japan" => "Tokyo"
);

$selectedCountry = $_POST['country'] ?? '';
$indexedArrayCount = count($foodList);
$updatedFoodList = $foodList;

// Array functions change or inspect the array.
array_push($updatedFoodList, "ice cream");
$poppedItem = array_pop($updatedFoodList);
$shiftedItem = array_shift($updatedFoodList);
$reversedFoodList = array_reverse($updatedFoodList);
?>


<?php

    $arr = array(
    "Sturday" => 0,
    "Sunday"  => 1

    );




?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Arrays Tutorial</title>
</head>
<body>
    <h1>PHP Arrays</h1>
    <p>This page explains indexed arrays, loops, array functions, and associative arrays.</p>

    <section>
        <h2>1. Indexed Arrays</h2>
        <p>An indexed array stores values at numeric positions.</p>
        <p>First item: <?php echo htmlspecialchars($foodItems[0]); ?></p>
        <p>Second item: <?php echo htmlspecialchars($foodItems[1]); ?></p>
        <p>Third item: <?php echo htmlspecialchars($foodItems[2]); ?></p>
        <p>Fourth item: <?php echo htmlspecialchars($foodItems[3]); ?></p>
    </section>

    <section>
        <h2>2. Looping Through Arrays</h2>
        <p>The <code>foreach</code> loop reads every value in the array one by one.</p>
        <ul>
            <?php foreach ($foodList as $singleFood): ?>
                <li><?php echo htmlspecialchars($singleFood); ?></li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section>
        <h2>3. Array Functions</h2>
        <p><code>array_push()</code> adds a value, <code>array_pop()</code> removes the last one, and <code>array_shift()</code> removes the first one.</p>
        <p>Items after push: <?php echo htmlspecialchars(implode(', ', $foodList)); ?></p>
        <p>Item removed by pop: <?php echo htmlspecialchars($poppedItem); ?></p>
        <p>Item removed by shift: <?php echo htmlspecialchars($shiftedItem); ?></p>
        <p>Items after reverse: <?php echo htmlspecialchars(implode(', ', $reversedFoodList)); ?></p>
        <p>Total items in the original list: <?php echo $indexedArrayCount; ?></p>
    </section>

    <section>
        <h2>4. Associative Arrays</h2>
        <p>Here the key is the country name and the value is its capital city.</p>

        <ul>
            <?php foreach ($capitals as $country => $capitalCity): ?>
                <li>The capital of <?php echo htmlspecialchars($country); ?> is <?php echo htmlspecialchars($capitalCity); ?>.</li>
            <?php endforeach; ?>
        </ul>

        <form action="index.php" method="post">
            <label for="country">Choose a country to look up:</label>
            <input type="text" name="country" id="country" placeholder="USA, France, or Japan" value="<?php echo htmlspecialchars($selectedCountry); ?>">
            <input type="submit" value="Find Capital">
        </form>

        <?php if ($selectedCountry !== ''): ?>
            <?php if (isset($capitals[$selectedCountry])): ?>
                <p>The capital of <?php echo htmlspecialchars($selectedCountry); ?> is <?php echo htmlspecialchars($capitals[$selectedCountry]); ?>.</p>
            <?php else: ?>
                <p>Capital not found. Try typing one of the exact country names from the list above.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Enter a country name to test the associative array lookup.</p>
        <?php endif; ?>
    </section>
            <?php
            echo $arr['Sturday'];
            echo $arr['Sunday'];
            print_r($arr);
            echo "<br>";

            $multiArray = [];

            $multiArray[] = array(
                "id" => 1,
                "age" => 22,
                "city"=> "ramllah"
            );

              echo "<br>";
            $multiArray[] = array(
                "id" => 2,
                "age" => 22,
                "city"=> "derjrer"
            );
  echo "<br>";

            print_r($multiArray[0]);
              echo "<br>";
            print_r($multiArray[1]);
              echo "<br>";

            $Stocks = [
                ["omar", "khaled"],
                ["Abed", "wassem"]
            ];

            print_r($Stocks[0][0]);
                             echo "<br>";
 
            print_r($Stocks[0][1]);
                              echo "<br>";

            print_r($Stocks[1][0]);
                              echo "<br>";

            print_r($Stocks[1][1]);
            
            

            ?>
</body>
</html>
