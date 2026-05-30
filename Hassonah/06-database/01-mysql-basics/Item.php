<?php
// Database example
// Define class
class Item
{
    // Class property
    private $ID;
    private $Name;
    private $Price;

    public function outputAsRow()
    {
        $row = <<<REC
            <tr>
                <td>$this->ID</td>
                <td>$this->Name</td>
                <td>$this->Price</td>
            </tr>
        REC;
        return $row;
    }
}
?>
