<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? "MUITA" ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <?php if (isset($cssFile)) : ?>
        <link rel="stylesheet" href="/css/<?= $cssFile ?>">
    <?php endif; ?>
</head>
<body>

<?php if (isset($_SESSION['user_id'])) : ?>
    <div class="user-bar">
        <div>
            Sveiks, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!
        </div>
        <div class="user-actions">
            <a href="/logout" class="logout-btn">Iziet</a>
        </div>
    </div>
<?php endif; ?>