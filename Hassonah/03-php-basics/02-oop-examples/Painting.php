<?php
// OOP example
// Child Class
// Load file
include "Art.php";
// Define class
class Painting extends Art
{
    // Class property
    private $medium;

    public function __construct($title, $artist, $year, $medium)
    {
        parent::__construct($title, $artist, $year);
        $this->medium = $medium;
    }

    // Overriding the display method to include the medium
    public function display()
    {
        return "
        <table border='1'>
            <tr>
                <th>Title</th>
                <th>Artist</th>
                <th>Year</th>
                <th>Medium</th>
            </tr>
            <tr>
                <td>{$this->title}</td>
                <td>{$this->artist}</td>
                <td>{$this->year}</td>
                <td>{$this->medium}</td>
            </tr>
        </table>";
    }
}
?>
