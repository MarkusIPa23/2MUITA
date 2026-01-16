<?php
if (isset($_SESSION['user_id'])) {
    header("Location: /");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $db->query("SELECT * FROM users WHERE username = :username", [
        'username' => $username
    ])->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        echo json_encode([
            "status" => "success", 
            "message" => "Sveiks, " . $user['username'] . "!"
        ]);
        exit();
    }

    echo json_encode(["status" => "error", "message" => "Nepareizs lietotājvārds vai parole!"]);
    exit();
}

$pageTitle = "Pieslēgties";