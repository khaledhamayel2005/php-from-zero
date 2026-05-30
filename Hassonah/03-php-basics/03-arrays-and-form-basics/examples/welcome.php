<html>
<!-- welcome.php -->
<body>

Welcome <?php echo $_POST["name"] . "."; ?> <br />
You are <?php echo $_POST["age"]; ?> years old!</br>
You id is <?php if (isset($_POST["id"])) {
    echo $_POST["id"];
} ?> </br>

</body>
</html>
