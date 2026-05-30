<html>
<head>
</head>
<body>
<?php
// OOP example
// Load file
include "Painting.php";
// Creating an instance of the Painting class
$picassoPainting = new Painting(
    "Guernica",
    "Pablo Picasso",
    1937,
    "Oil on Canvas",
);

echo $picassoPainting->display(); // Outputs the painting details as an HTML table

$paintingsData = [
    [
        "title" => "Guernica",
        "artist" => "Pablo Picasso",
        "year" => 1937,
        "medium" => "Oil on Canvas",
    ],
    [
        "title" => "Mona Lisa",
        "artist" => "Leonardo da Vinci",
        "year" => 1503,
        "medium" => "Oil on Poplar",
    ],
];

// Array to hold Painting objects
$paintings = [];

// Creating Painting objects from the array
foreach ($paintingsData as $data) {
    $paintings[] = new Painting(
        $data["title"],
        $data["artist"],
        $data["year"],
        $data["medium"],
    );
}

// Displaying the painting details
foreach ($paintings as $painting) {
    echo $painting->display();
    echo "<br>"; // Add a line break between tables for better readability
}
?>
</body>
</html>
