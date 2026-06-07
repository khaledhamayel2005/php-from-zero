<?php
/*
Exam: Midterm 2016
Source: PHPMIDTERM/PDF/Midterm_Exam_2016_Key_FZC2iGO_juBy0BM.pdf

Question:
Write a dynamic web page containing HTML and PHP. The HTML page contains a
form that lets users enter a player's number and submits it to players.php by
POST. The PHP script initializes an associative array where the player number
is the key and goal count is the value. It displays the player's goals if the
number exists, displays a "no such player" message if not, and shows a welcome
message when the page is first requested.
*/

$players = [
    10 => 5,
    15 => 8,
    5 => 6,
    12 => 2,
];

$message = 'Welcome. Enter a player number.';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playerId = filter_input(INPUT_POST, 'player_id', FILTER_VALIDATE_INT);

    if ($playerId === null || $playerId === false) {
        $message = 'No player number has been sent.';
    } elseif (array_key_exists($playerId, $players)) {
        // The player exists, so print the stored goal count.
        $message = 'Player number ' . $playerId . ' has registered '
            . $players[$playerId] . ' goals.';
    } else {
        $message = 'Sorry, no player with number ' . $playerId . ' has been found.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Player Scores</title>
</head>
<body>
    <h1>Player Scores</h1>
    <p><?= htmlspecialchars($message) ?></p>

    <form method="post" action="players.php">
        <label>
            Player number:
            <input type="number" name="player_id" required>
        </label>
        <button type="submit">Search</button>
    </form>
</body>
</html>
