<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function currentUser(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }

    $stmt = db()->prepare('SELECT id, name, email FROM users WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $user = $stmt->fetch();

    return $user ?: null;
}

function requireLogin(): array
{
    $user = currentUser();

    if ($user === null) {
        redirect('login.php');
    }

    return $user;
}

function findTask(int $taskId, int $userId): ?array
{
    $stmt = db()->prepare('SELECT * FROM tasks WHERE id = :id AND user_id = :user_id LIMIT 1');
    $stmt->execute([
        ':id' => $taskId,
        ':user_id' => $userId,
    ]);

    $task = $stmt->fetch();
    return $task ?: null;
}
