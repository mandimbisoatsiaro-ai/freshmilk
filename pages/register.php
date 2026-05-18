<?php

include '../include/db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);

    $email = trim($_POST['email']);

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = $pdo->prepare(
        "INSERT INTO users (username, email, password)
         VALUES (?, ?, ?)"
    );

    $success = $query->execute([
        $username,
        $email,
        $password
    ]);

    if ($success) {

        $message = "Compte créé avec succès";

    } else {

        $message = "Erreur inscription";

    }

}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>
        Inscription - FreshMilk
    </title>
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet"
          href="../css/style.css">

</head>

<body>

<?php include '../include/navbar.php'; ?>

<div class="auth-container">

    <form method="POST" class="auth-form">

        <h1>
            Inscription
        </h1>

        <input
            type="text"
            name="username"
            placeholder="Nom utilisateur"
            required
        >

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Mot de passe"
            required
        >

        <button type="submit">

            Créer un compte

        </button>

        <p>
            <?php echo $message; ?>
        </p>

    </form>

</div>

<?php include '../include/footer.php'; ?>
<script src="/js/darkmode.js"></script>
</body>
</html>