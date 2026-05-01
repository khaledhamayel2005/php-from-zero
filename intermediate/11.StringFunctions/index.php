<!--
    strtolower() - Converts a string to lowercase
    strtoupper() - Converts a string to uppercase
    ucfirst() - Converts the first character of a string to uppercase
    ucwords() - Converts the first character of each word in a string to uppercase
    strlen() - Returns the length of a string
    str_word_count() - Counts the number of words in a string
    strrev() - Reverses a string
    strpos() - Finds the position of the first occurrence of a substring in a string
    str_replace() - Replaces all occurrences of a search string with a replacement string
    str_repeat() - Repeats a string a specified number of times
    substr() - Returns a portion of a string
    equal() - Compares two strings for equality
    concat() - Concatenates two or more strings

-->
<?php

    $txt = "Hello World!";
    echo "The length of the string is: " . strlen($txt);
    echo "<br>";
    echo "The number of words in the string is: " . str_word_count($txt);
    echo "<br>";
    echo "The reversed string is: " . strrev($txt);
    echo "<br>";
    echo "The position of 'World' in the string is: " . strpos($txt, "World");
    echo "<br>";
    echo "The string after replacement is: " . str_replace("World", "PHP", $txt);
    echo "<br>";
    echo "The repeated string is: " . str_repeat($txt, 3);
    echo "<br>";
    echo "The substring from position 0 to 5 is: " . substr($txt, 0, 5);
    echo "<br>";
    echo "The string in lowercase is: " . strtolower($txt);
    echo "<br>";
    echo "The string in uppercase is: " . strtoupper($txt);
    echo "<br>";
    echo "The string with the first character in uppercase is: " . ucfirst($txt);
    echo "<br>";    
    echo "The string with the first character of each word in uppercase is: " . ucwords($txt);
    

?>