<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Qadyate Store Assignment 2</title>
</head>
<body>
<?php require_once('header.inc.php'); ?>
<main>
    <section>
        <h2>Assignment 2 Index</h2>
        <p><a href="products.php">Open Products Page</a></p>
    </section>

    <section>
        <h2>Student Information</h2>
        <p>Name: Khaled Hamayel</p>
        <p>Student ID: 1231439</p>
        <p>Address: Abu Falah Village, Ramallah, Palestine</p>
        <p>Mobile: +970 569698697</p>
        <p>Email: 1231439@student.birzeit.edu</p>
    </section>

    <section>
        <h2>Testing Accounts</h2>
        <table border="1">
            <tr>
                <th>Role</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
            <tr>
                <td>Customer</td>
                <td>layla@qadyate.ps</td>
                <td>Customer123</td>
            </tr>
            <tr>
                <td>Customer</td>
                <td>omar@qadyate.ps</td>
                <td>Customer123</td>
            </tr>
            <tr>
                <td>Employee</td>
                <td>1231439@student.birzeit.edu</td>
                <td>Employee123</td>
            </tr>
        </table>
    </section>
</main>
<?php require_once('footer.inc.php'); ?>
</body>
</html>
