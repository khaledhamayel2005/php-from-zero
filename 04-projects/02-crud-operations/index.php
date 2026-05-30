<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

$rows = [];
$error = '';

try {
    $connection = dbConnection();
    $result = $connection->query("SELECT id, fname, lname, email FROM users ORDER BY id DESC");

    if ($result === false) {
        $error = 'Query failed: ' . $connection->error;
    } else {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
    }

    $connection->close();
} catch (Throwable $throwable) {
    $error = $throwable->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="page">
        <div class="header-row">
            <div>
                <h1>Users CRUD</h1>
                <p class="subtitle">
                    Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>
                </p>
            </div>
            <div class="actions">
                <a class="button" href="add.php">+ Add User</a>
                <a class="button secondary" href="../01-login-registration/simple_login.php?action=logout">Logout</a>
            </div>
        </div>

        <?php if ($error !== ''): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (empty($rows)): ?>
            <div class="empty-state">No users found.</div>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?php echo (int) $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['fname']); ?></td>
                                <td><?php echo htmlspecialchars($row['lname']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td class="actions">
                                    <a class="link" href="edit.php?id=<?php echo (int) $row['id']; ?>">Edit</a>
                                    <a class="link danger" href="delete.php?id=<?php echo (int) $row['id']; ?>" onclick="return confirm('Delete this user?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
