<?php
class Course
{
    public $code;
    public $title;
    public $credits;
    public $type;

    function __construct($code, $title, $credits, $type)
    {
        $this->code = $code;
        $this->title = $title;
        $this->credits = $credits;
        $this->type = $type;
    }

    function isLab()
    {
        return $this->type == "lab";
    }
}

$courses = array(
    new Course("COMP231", "Web Programming", 3, "lecture"),
    new Course("COMP232", "Web Lab", 1, "lab"),
    new Course("COMP240", "Database", 3, "lecture"),
    new Course("COMP241", "Database Lab", 1, "lab"),
);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Courses</title>
  </head>
  <body>
    <h1>Courses</h1>
    <table border="1" cellpadding="6">
      <tr>
        <th>Code</th>
        <th>Title</th>
        <th>Credits</th>
        <th>Type</th>
        <th>Lab?</th>
      </tr>
      <?php foreach ($courses as $course): ?>
        <tr>
          <td><?php echo htmlspecialchars($course->code); ?></td>
          <td><?php echo htmlspecialchars($course->title); ?></td>
          <td><?php echo $course->credits; ?></td>
          <td><?php echo htmlspecialchars($course->type); ?></td>
          <td><?php echo $course->isLab() ? "Yes" : "No"; ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </body>
</html>

