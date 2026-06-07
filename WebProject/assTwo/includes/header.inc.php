<header>
    <h1>Qadyate Store</h1>
    <figure>
        <img src="assets/images/logo.jpeg" alt="Qadyate Store Logo" width="120" height="80">
    </figure>
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { ?>
        <p>
            Welcome,
            <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>
            (<?php echo htmlspecialchars($_SESSION['role']); ?>)
        </p>
    <?php } ?>
    <nav>
        <a href="products.php">Products</a> |
        <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { ?>
            <a href="register.php">Register</a> |
            <a href="login.php">Login</a> |
        <?php } else { ?>
            <a href="logout.php">Logout</a> |
        <?php } ?>
        <a href="basket.php">Basket</a>
    </nav>
    <hr>
</header>
