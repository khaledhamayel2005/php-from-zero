<?php
// Database example
// Define class
class Course
{
    // Class property
    private $courseID;
    private $courseName;
    private $creditHrs;

    function __construct($record)
    {
        $this->courseID = $record["ID"];
        $this->courseName = $record["Name"];
        $this->creditHrs = $record["hrs"];
    }

    public function outputAsRow()
    {
        $row = <<<REC
            <tr>
                <td>$this->courseID</td>
                <td>$this->courseName</td>
                <td>$this->creditHrs</td>
            </tr>

        REC;
        return $row;
    }
}
?>
