<?php
session_start();

include '../include/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {

        $query = $pdo->prepare(
            "SELECT * FROM users WHERE username = ?"
        );

        $query->execute([$username]);

        $user = $query->fetch();

        if ($user) {

            if (password_verify($password, $user["password"])) {

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"] = $user["role"];

                header("Location: ../index.php");
                exit;

            } else {

                $message = "Mot de passe incorrect";

            }

        } else {

            $message = "Utilisateur introuvable";

        }

    } else {

        $message = "Remplis tous les champs";

    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>Login FreshMilk</title>
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">

</head>

<body>

<?php include "../include/navbar.php"; ?>

<div class="login-container">

    <div class="login-box">

        <h2>
            Connexion
        </h2>

        <form method="POST" class="login-form">

            <input
                type="text"
                name="username"
                placeholder="Nom d'utilisateur"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Mot de passe"
                required
            >

            <button type="submit">
                Se connecter
            </button>

        </form>

        <p class="login-message">
            <?php echo $message; ?>
        </p>

        <div class="login-register">

            Pas encore de compte ?

            <a href="register.php">
                S'inscrire
            </a>

        </div>

    </div>

</div>

<?php include "../include/footer.php"; ?>
<script src="/js/darkmode.js"></script>
</body>
</html>