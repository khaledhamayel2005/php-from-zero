<header> 
    <h1>Welcome <?php echo htmlspecialchars(($_SESSION['fname'] ?? '') . ' ' . ($_SESSION['lname'] ?? '')); ?></h1>
</header>