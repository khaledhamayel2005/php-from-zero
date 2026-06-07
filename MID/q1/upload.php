

<?php 


        $errors = []; 

        if($_SERVER['REQUEST_METHOD']  === 'POST'){

            

                $filename = $_FILES['file']['name'];
                $tmpname = $_FILES['file']['tmp_name'];
                $size = $_FILES['file']['size'];

                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $extension = pathinfo($filename, PATHINFO_EXTENSION);


                if(!in_array($allowed, $extension)){
                    $errors[] = "Not same extesion ";
                }elseif($size > 2 *1024 * 1024){
                    $errors[] = "file size must be less than 2MB";
                }else{

                    $newName = "place_" . time()."." . $extension;
                    $destination = "uploads/" .$newName;

                    move_uploaded_file($tmpname, $destination);

                    header("Location: display.php?title=$title, filename=$filename");
                }
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    


        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

                <label for="title">Title : </label>
                <input type="text" id="title" name="title">


                <br>

                <label for="file">File : </label>
                <input type="file" id="file" name="file">
                <br>


                <input type="submit" value="UPLOAD">
        </form>
</body>
</html>