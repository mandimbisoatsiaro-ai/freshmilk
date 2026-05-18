<?php

require "../include/db.php";

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {

        $sql = "INSERT INTO messages (name, email, subject, message)
                VALUES (:name, :email, :subject, :message)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([

            ':name' => $name,
            ':email' => $email,
            ':subject' => $subject,
            ':message' => $message

        ]);

        $success = "Votre message a été envoyé avec succès.";

    } else {

        $error = "Veuillez remplir tous les champs obligatoires.";

    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact - FreshMilk</title>

    <link rel="stylesheet" href="/css/navbar.css">

    <link rel="stylesheet" href="../css/style.css?v=999">

    <link rel="stylesheet" href="../css/contact.css?v=999">

</head>

<body class="dark">

<?php include "../include/navbar.php"; ?>

<main class="contact-page">

    <!-- HERO -->
    <section class="contact-hero">

        <h1>Contactez <span>FreshMilk</span></h1>

        <p>Une question ? Une commande ? Notre équipe vous répond rapidement.</p>

    </section>

    <!-- CONTENT -->
    <section class="contact-container">

        <!-- INFOS -->
        <div class="contact-info">

            <h2>Nos informations</h2>

            <div class="info-box">
                📍 Antananarivo, Madagascar
            </div>

            <div class="info-box">
                📞 +261 34 00 000 00
            </div>

            <div class="info-box">
                ✉️ contact@freshmilk.com
            </div>

            <div class="info-box">
                🕒 Lundi - Dimanche : 8h - 20h
            </div>

        </div>

        <!-- FORM -->
        <div class="contact-form-box">

            <?php if ($success): ?>

                <div class="success-message">
                    <?= $success ?>
                </div>

            <?php endif; ?>

            <?php if ($error): ?>

                <div class="error-message">
                    <?= $error ?>
                </div>

            <?php endif; ?>

            <form method="POST">

                <input 
                    type="text" 
                    name="name"
                    placeholder="Votre nom" 
                    required
                >

                <input 
                    type="email" 
                    name="email"
                    placeholder="Votre email" 
                    required
                >

                <input 
                    type="text" 
                    name="subject"
                    placeholder="Sujet"
                >

                <textarea 
                    name="message"
                    placeholder="Votre message" 
                    rows="6" 
                    required
                ></textarea>

                <button type="submit">
                    Envoyer le message
                </button>

            </form>

        </div>

    </section>

    <!-- CTA -->
    <section class="contact-cta">

        <h2>Nous sommes toujours à votre écoute</h2>

        <p>FreshMilk, des produits frais livrés chez vous.</p>

        <a href="../pages/products.php" class="btn">
            Voir les produits
        </a>

    </section>

</main>

<?php include "../include/footer.php"; ?>

<script src="/js/darkmode.js"></script>

</body>

</html>