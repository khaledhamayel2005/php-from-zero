<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/functions.php';

$user = requireLogin();
$errors = [];
$editingTask = null;

if (isset($_GET['edit'])) {
    $editingTask = findTask((int) $_GET['edit'], (int) $user['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $taskId = (int) ($_POST['task_id'] ?? 0);

    if ($action === 'create') {
        $title = trim($_POST['title'] ?? '');
        $priority = $_POST['priority'] ?? 'normal';

        if ($title === '') {
            $errors[] = 'Task title is required.';
        }

        if (!in_array($priority, ['low', 'normal', 'high'], true)) {
            $priority = 'normal';
        }

        if ($errors === []) {
            $stmt = db()->prepare(
                'INSERT INTO tasks (user_id, title, priority) VALUES (:user_id, :title, :priority)'
            );
            $stmt->execute([
                ':user_id' => $user['id'],
                ':title' => $title,
                ':priority' => $priority,
            ]);
            redirect('index.php');
        }
    }

    if ($action === 'update') {
        $title = trim($_POST['title'] ?? '');
        $priority = $_POST['priority'] ?? 'normal';

        if ($title === '') {
            $errors[] = 'Task title is required.';
        }

        if ($errors === [] && findTask($taskId, (int) $user['id']) !== null) {
            $stmt = db()->prepare(
                'UPDATE tasks SET title = :title, priority = :priority WHERE id = :id AND user_id = :user_id'
            );
            $stmt->execute([
                ':title' => $title,
                ':priority' => $priority,
                ':id' => $taskId,
                ':user_id' => $user['id'],
            ]);
            redirect('index.php');
        }
    }

    if ($action === 'toggle' && findTask($taskId, (int) $user['id']) !== null) {
        $stmt = db()->prepare(
            'UPDATE tasks SET is_done = NOT is_done WHERE id = :id AND user_id = :user_id'
        );
        $stmt->execute([
            ':id' => $taskId,
            ':user_id' => $user['id'],
        ]);
        redirect('index.php');
    }

    if ($action === 'delete' && findTask($taskId, (int) $user['id']) !== null) {
        $stmt = db()->prepare('DELETE FROM tasks WHERE id = :id AND user_id = :user_id');
        $stmt->execute([
            ':id' => $taskId,
            ':user_id' => $user['id'],
        ]);
        redirect('index.php');
    }
}

$stmt = db()->prepare(
    'SELECT * FROM tasks WHERE user_id = :user_id ORDER BY is_done, FIELD(priority, "high", "normal", "low"), created_at DESC'
);
$stmt->execute([':user_id' => $user['id']]);
$tasks = $stmt->fetchAll();

$stats = [
    'total' => count($tasks),
    'done' => count(array_filter($tasks, fn (array $task): bool => (bool) $task['is_done'])),
];
$stats['open'] = $stats['total'] - $stats['done'];
$visitorName = $_COOKIE['visitor_name'] ?? $user['name'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo Manager | Final Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="app">
    <header class="topbar">
        <div>
            <h1>Todo Manager</h1>
            <p class="muted">Welcome, <?= e($visitorName) ?></p>
        </div>
        <a class="logout" href="logout.php">Logout</a>
    </header>

    <section class="stats">
        <article><strong><?= $stats['total'] ?></strong><span>Total</span></article>
        <article><strong><?= $stats['open'] ?></strong><span>Open</span></article>
        <article><strong><?= $stats['done'] ?></strong><span>Done</span></article>
    </section>

    <section class="panel">
        <h2><?= $editingTask ? 'Edit task' : 'Add task' ?></h2>

        <?php if ($errors !== []): ?>
            <div class="alert">
                <?php foreach ($errors as $error): ?>
                    <p><?= e($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" class="task-form">
            <input type="hidden" name="action" value="<?= $editingTask ? 'update' : 'create' ?>">
            <?php if ($editingTask): ?>
                <input type="hidden" name="task_id" value="<?= (int) $editingTask['id'] ?>">
            <?php endif; ?>

            <label>
                Task title
                <input
                    type="text"
                    name="title"
                    value="<?= e($editingTask['title'] ?? '') ?>"
                    placeholder="Example: Review PDO prepared statements"
                    required
                >
            </label>

            <label>
                Priority
                <select name="priority">
                    <?php foreach (['low', 'normal', 'high'] as $priority): ?>
                        <option value="<?= $priority ?>" <?= ($editingTask['priority'] ?? 'normal') === $priority ? 'selected' : '' ?>>
                            <?= ucfirst($priority) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <button type="submit"><?= $editingTask ? 'Save changes' : 'Add task' ?></button>
            <?php if ($editingTask): ?>
                <a class="cancel" href="index.php">Cancel</a>
            <?php endif; ?>
        </form>
    </section>

    <section class="panel">
        <h2>Your tasks</h2>

        <?php if ($tasks === []): ?>
            <p class="empty">No tasks yet.</p>
        <?php endif; ?>

        <div class="task-list">
            <?php foreach ($tasks as $task): ?>
                <article class="task <?= $task['is_done'] ? 'done' : '' ?>">
                    <div>
                        <strong><?= e($task['title']) ?></strong>
                        <span class="badge"><?= e($task['priority']) ?></span>
                    </div>

                    <div class="actions">
                        <form method="post">
                            <input type="hidden" name="action" value="toggle">
                            <input type="hidden" name="task_id" value="<?= (int) $task['id'] ?>">
                            <button type="submit"><?= $task['is_done'] ? 'Undo' : 'Done' ?></button>
                        </form>

                        <a href="index.php?edit=<?= (int) $task['id'] ?>">Edit</a>

                        <form method="post">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="task_id" value="<?= (int) $task['id'] ?>">
                            <button class="danger" type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>
</body>
</html>
