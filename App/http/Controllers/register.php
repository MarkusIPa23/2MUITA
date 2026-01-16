<?php
if (isset($_SESSION['user_id'])) {
    header("Location: /");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Visi lauki ir obligāti!"]);
        exit();
    }


    $userExists = $db->query("SELECT id FROM users WHERE username = :username", [
        'username' => $username
    ])->fetch();

    if ($userExists) {
        echo json_encode(["status" => "error", "message" => "Lietotājvārds jau ir aizņemts!"]);
        exit();
    }


    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    $db->query("INSERT INTO users (username, password) VALUES (:username, :password)", [
        'username' => $username,
        'password' => $hashedPassword
    ]);

    echo json_encode(["status" => "success", "message" => "Reģistrācija veiksmīga!"]);
    exit();
}

$pageTitle = "Reģistrēties";
require "views/register.view.php";