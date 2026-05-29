<!--Functions in PHP-->
<?php
    function writeMsg(){
        echo "Hello world!";
    }   

    writeMsg(); // call the function
?>  
<!--Function with parameters-->
<?php
    function familyName($fname){
        echo "$fname Refsnes.<br>";
    }   

    familyName("Jani");
    familyName("Hege");  

    familyName("Stale");

    //Function with more parameters
    function familyName2($fname, $year){
        echo "$fname Refsnes. Born in $year <br>";      

    }
    familyName2("Hege", "1975");
    familyName2("Stale", "1978");
    familyName2("Kai Jim", "1983");


    ?>
<!--Function with default parameter-->
<?php
    function setHeight($minheight = 50){    
        echo "The height is : $minheight <br>";      
    }
    setHeight(350);
    setHeight(); // will use the default value of 50
    setHeight(135);
    setHeight(80);
?>

<!--Function with return value-->
<?php
    function sum($x, $y){
        $z = $x + $y;
        return $z;
    }


    echo "5 + 10 = " . sum(5, 10);
?>
