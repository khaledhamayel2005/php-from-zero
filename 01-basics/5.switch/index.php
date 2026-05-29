<?php
// Read the selected day from the query string.
$day = $_GET['day'] ?? 'monday';
$message = '';

switch ($day) {
	case 'monday':
		$message = 'Monday is the first workday of the week.';
		break;
	case 'tuesday':
		$message = 'Tuesday comes after Monday.';
		break;
	case 'wednesday':
		$message = 'Wednesday is the middle of the week.';
		break;
	case 'thursday':
		$message = 'Thursday is almost the weekend.';
		break;
	case 'friday':
		$message = 'Friday is the last workday of the week.';
		break;
	default:
		$message = 'Please choose a weekday from the list.';
		break;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PHP Switch Tutorial</title>
</head>
<body>
	<h1>PHP Switch Statement</h1>
	<p>The <code>switch</code> statement checks one value against many possible cases.</p>

	<form action="index.php" method="get">
		<label for="day">Choose a day:</label>
		<select name="day" id="day">
			<option value="monday" <?php echo $day === 'monday' ? 'selected' : ''; ?>>Monday</option>
			<option value="tuesday" <?php echo $day === 'tuesday' ? 'selected' : ''; ?>>Tuesday</option>
			<option value="wednesday" <?php echo $day === 'wednesday' ? 'selected' : ''; ?>>Wednesday</option>
			<option value="thursday" <?php echo $day === 'thursday' ? 'selected' : ''; ?>>Thursday</option>
			<option value="friday" <?php echo $day === 'friday' ? 'selected' : ''; ?>>Friday</option>
		</select>
		<input type="submit" value="Check Day">
	</form>

	<p><?php echo htmlspecialchars($message); ?></p>
</body>
</html>
