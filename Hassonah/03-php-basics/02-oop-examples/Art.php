<?php
// OOP example
// Parent Class
// Define class
class Art
{
    // Class property
    protected $title;
    protected $artist;
    protected $year;

    public function __construct($title, $artist, $year)
    {
        $this->title = $title;
        $this->artist = $artist;
        $this->year = $year;
    }

    // Method to display the artwork information as an HTML table
    public function display()
    {
        return "
        <table border='1'>
            <tr>
                <th>Title</th>
                <th>Artist</th>
                <th>Year</th>
            </tr>
            <tr>
                <td>{$this->title}</td>
                <td>{$this->artist}</td>
                <td>{$this->year}</td>
            </tr>
        </table>";
    }
}
?>
