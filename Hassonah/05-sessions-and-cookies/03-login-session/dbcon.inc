<?php
$dbhost = 'localhost';
$dbusername = 'httpd';
$dbuserpassword = 'web';
$default_dbname = 'webTest';
$records_per_page = 3;
$user_tablename = 'user';

function html_header(){

   ?>
   <html>
   <head>
   <title>User Record Viewer</title>
   </head>
   <body>
   <?php
}

function html_footer() {
?>
</body>
</html>
<?php
}

function db_connect($dbname = 'webTest', $username = 'httpd', $password = 'web'){
    global $dbhost;

        /*
        * Create the pdo object
        * host: is the host name
        * dbname: database name
        */
try{
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $password);

        return $pdo;

    } catch (PDOException $e) {
         $e->getMessage();
    }
}




function error_message($msg) {
   html_header();
   echo "<p><em> error $msg</em></p>";
   html_footer();
   exit;
}

function enum_options($field, $pdo) {

    $query = "SHOW COLUMNS FROM user LIKE '". $field ."'";
    $result = $pdo->query($query);
    $query_data = $result->fetch();

    $match = [];

    if (preg_match("('.*')", $query_data["Type"], $match)) {
        $enum_str = str_replace("'", "", $match[0]);
        $enum_options = explode(',', $enum_str);
        return $enum_options;
    }

    return 0;
}
?>
