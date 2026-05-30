<?php
// Session/cookie example
// Define class
class Person
{
    var $name, $age, $number;

    function __construct($new_name, $new_age, $new_number)
    {
        $this->name = $new_name;
        $this->age = $new_age;
        $this->number = $new_number;
    }

    function get_name()
    {
        return $this->name;
    }

    function get_number()
    {
        return $this->number;
    }

    function get_age()
    {
        return $this->age;
    }
} ?>

