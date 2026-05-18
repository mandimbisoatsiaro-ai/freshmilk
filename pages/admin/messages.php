<?php

require "../../include/db.php";

$sql = "SELECT * FROM messages ORDER BY created_at DESC";

$stmt = $pdo->query($sql);

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Messages - Admin FreshMilk</title>
    <link rel="stylesheet" href="/css/message.css">

    <link rel="stylesheet"
          href="/css/style.css?v=3">
        <link rel="stylesheet" href="../../css/admin.css">

</head>

<body class="dark">
<?php include "../../include/admin-navbar.php"; ?>
<div class="admin-container">

    <h1>Messages reçus</h1>

    <?php foreach ($messages as $message): ?>

        <div class="message-card">

            <h2>
                <?= htmlspecialchars($message['name']) ?>
            </h2>

            <p>
                <strong>Email :</strong>
                <?= htmlspecialchars($message['email']) ?>
            </p>

            <p>
                <strong>Sujet :</strong>
                <?= htmlspecialchars($message['subject']) ?>
            </p>

            <p>
                <?= nl2br(htmlspecialchars($message['message'])) ?>
            </p>

            <small>
                <?= $message['created_at'] ?>
            </small>

        </div>

    <?php endforeach; ?>

</div>
<?php include "../../include/footer.php"; ?>
</body>

</html>