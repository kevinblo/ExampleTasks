<?php
header('Content-Type: application/json');

// Настройка соединения с базой данных MariaDB
$dsn = 'mysql:host=localhost;dbname=testtasks;charset=utf8';
$username = 'testtasks';  // Имя пользователя MariaDB
$password = '@YOWoXFUZXVao_lj';  // Пароль пользователя MariaDB

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    exit;
}

// Маршрутизация по URL
$uri = $_SERVER['REQUEST_URI'];

if (preg_match('/^\/api\/v1\/task\/(\d+)$/', $uri, $matches)) {
    // Получение задачи по ID
    $id = $matches[1];
    $stmt = $pdo->prepare('SELECT id, title, date, author, status, description FROM tasks WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($task) {
        echo json_encode($task);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Task not found']);
    }
} else {
    // Получение всех задач
    $stmt = $pdo->query('SELECT id, title, date FROM tasks LIMIT 1000');
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tasks);
}

