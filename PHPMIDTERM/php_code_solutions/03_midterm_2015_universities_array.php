<?php
/*
Exam: Midterm 2015
Source: PHPMIDTERM/PDF/Midterm_2015_bprVw3h_eKcec51.pdf

Question:
Write a PHP script called uni.php that stores information about Palestinian
universities in an associative array. When executed, the script generates an
HTML page that displays the university name and county in a table. The
university name should link to the university homepage.
*/

$universities = [
    'BZU' => [
        'name' => 'Birzeit',
        'url' => 'http://www.birzeit.edu',
        'county' => 'Ramallah',
    ],
    'AQU' => [
        'name' => 'Al-Quds',
        'url' => 'http://www.alquds.edu',
        'county' => 'Al-Quds',
    ],
    'PPU' => [
        'name' => 'Palestine Polytechnic',
        'url' => 'http://www.ppu.edu',
        'county' => 'Hebron',
    ],
    'Najah' => [
        'name' => 'An-Najah',
        'url' => 'http://www.najah.edu',
        'county' => 'Nablus',
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Palestinian Universities</title>
</head>
<body>
    <table border="1" cellpadding="6">
        <tr>
            <th>University</th>
            <th>County</th>
        </tr>
        <?php foreach ($universities as $university): ?>
            <tr>
                <td>
                    <!-- Print the university name as a link. -->
                    <a href="<?= htmlspecialchars($university['url']) ?>">
                        <?= htmlspecialchars($university['name']) ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($university['county']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
