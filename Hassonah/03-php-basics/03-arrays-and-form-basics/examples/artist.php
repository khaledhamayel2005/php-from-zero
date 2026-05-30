<?php
// OOP example
// Define class
class Artist
{
    public static $artistCount = 0;
    // Class property
    public $firstName;
    public $lastName;
    public $birthDate;
    public $birthCity;
    public $deathDate;
    function __construct($firstName, $lastName, $city, $birth, $death = null)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthCity = $city;
        $this->birthDate = $birth;
        $this->deathDate = $death;
        self::$artistCount++;
    }

    public function outputAsTable()
    {
        $table = "<table>";
        $table .= "<tr><th colspan='2'>";
        $table .= $this->firstName . " " . $this->lastName;
        $table .= "</th></tr>";
        $table .= "<tr><td>Birth:</td>";
        $table .= "<td>" . $this->birthDate;
        $table .= "(" . $this->birthCity . ")</td></tr>";
        $table .= "<tr><td>Death:</td>";
        $table .= "<td>" . $this->deathDate . "</td></tr>";
        $table .= "</table>";
        return $table;
    }
}
?>
