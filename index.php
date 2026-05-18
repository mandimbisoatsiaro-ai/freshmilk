<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>FreshMilk</title>

    <link rel="stylesheet"
          href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet"
          href="css/style.css?v=3">

</head>

<body>

    <div id="toast">
        Produit ajouté au panier
    </div>

    <?php include "include/navbar.php"; ?>
    

    <main>

        <!-- HERO -->

        <section class="hero">

            <div class="hero-text" data-aos="fade-up">

                <h1>
                    Fresh<span>Milk</span>
                </h1>

                <p>
                    Produits laitiers frais et naturels.
                </p>

                <a href="#products" class="btn">
                    Voir les produits
                </a>

            </div>

        </section>

        <!-- FEATURES -->

        <section class="features">

            <div class="feature-box" data-aos="zoom-in">

                <div class="feature-icon">
                    🥛
                </div>

                <h3>
                    Produits frais
                </h3>

                <p>
                    Tous nos produits sont frais et sélectionnés chaque jour.
                </p>

            </div>

            <div class="feature-box" data-aos="zoom-in">

                <div class="feature-icon">
                    🚚
                </div>

                <h3>
                    Livraison Rapide
                </h3>

                <p>
                    Livraison rapide et sécurisée partout dans votre ville.
                </p>

            </div>

            <div class="feature-box" data-aos="zoom-in">

                <div class="feature-icon">
                    🌿
                </div>

                <h3>
                    100% Naturel
                </h3>

                <p>
                    Produits bio et naturels sans conservateurs chimiques.
                </p>

            </div>

        </section>

        <!-- STATS -->

        <section class="stats">

            <div class="stat-box" data-aos="flip-left">

                <h2>500+</h2>

                <p>
                    Clients satisfaits
                </p>

            </div>

            <div class="stat-box" data-aos="flip-left">

                <h2>100%</h2>

                <p>
                    Produits naturels
                </p>

            </div>

            <div class="stat-box" data-aos="flip-left">

                <h2>24h</h2>

                <p>
                    Livraison rapide
                </p>

            </div>

            <div class="stat-box" data-aos="flip-left">

                <h2>20+</h2>

                <p>
                    Produits disponibles
                </p>

            </div>

        </section>

        <!-- TESTIMONIALS -->

        <section class="testimonials">

            <h2>
                Ce que disent nos clients
            </h2>

            <div class="testimonial-grid">

                <div class="testimonial-card" data-aos="fade-up">

                    <div class="stars">
                        ⭐⭐⭐⭐⭐
                    </div>

                    <p>
                        “Les produits sont incroyablement frais.
                        La livraison est rapide et le goût est parfait.”
                    </p>

                    <h3>
                        Sophie M.
                    </h3>

                </div>

                <div class="testimonial-card" data-aos="fade-up">

                    <div class="stars">
                        ⭐⭐⭐⭐⭐
                    </div>

                    <p>
                        “FreshMilk est devenu mon magasin préféré
                        pour les produits laitiers naturels.”
                    </p>

                    <h3>
                        Julien R.
                    </h3>

                </div>

                <div class="testimonial-card" data-aos="fade-up">

                    <div class="stars">
                        ⭐⭐⭐⭐⭐
                    </div>

                    <p>
                        “Excellent service et très belle qualité.
                        Je recommande fortement.”
                    </p>

                    <h3>
                        Clara T.
                    </h3>

                </div>

            </div>

        </section>

        <!-- PRODUCTS -->

        <section id="products" class="products">

            <h2>
                Produits populaires
            </h2>

            <input type="text"
                   id="search-input"
                   placeholder="Rechercher un produit...">

            <div class="product-grid">

                <!-- TES PRODUITS PHP ICI -->
                

    <?php


include "include/db.php";

$query = $pdo->query("
    SELECT *
    FROM products
    ORDER BY id DESC
");

$products = $query->fetchAll(PDO::FETCH_ASSOC);

?>

    <?php foreach($products as $product): ?>

<div class="card">

    <img
        src="/assets/images/products/<?= $product['image'] ?>"
        alt="<?= $product['name'] ?>">

    <h3>
        <?php echo $product['name']; ?>
    </h3>

    <p>
        <?php echo $product['price']; ?> €
    </p>

</div>

<?php endforeach; ?>





</div>

            </div>

        </section>
        <section class="gallery">

    <h2>
        Notre Galerie
    </h2>

    <div class="gallery-grid">

        <img src="https://images.unsplash.com/photo-1550583724-b2692b85b150?q=80&w=1200"
             alt="Lait">

        <img src="https://images.unsplash.com/photo-1628088062854-d1870b4553da?q=80&w=1200"
             alt="Fromage">

        <img src="https://images.unsplash.com/photo-1563805042-7684c019e1cb?q=80&w=1200"
             alt="Glace">

        <img src="https://images.unsplash.com/photo-1571212515416-fef01fc43637?q=80&w=1200"
             alt="Yaourt">

    </div>

</section>
        <section class="newsletter">

    <div class="newsletter-content" data-aos="zoom-in">

        <h2>
            Rejoignez FreshMilk
        </h2>

        <p>
            Recevez nos nouveautés et promotions exclusives.
        </p>

        <form class="newsletter-form">

            <input type="email"
                   placeholder="Votre adresse email">

            <button type="submit">
                S'inscrire
            </button>

        </form>

    </div>

</section>

<section class="contact-section">

    <div class="contact-container">

        <div class="contact-info">

            <h2>
                Contactez-nous
            </h2>

            <p>
                Une question ? Notre équipe FreshMilk est disponible tous les jours.
            </p>

            <div class="contact-details">

                <p>
                    📍 Antananarivo, Madagascar
                </p>

                <p>
                    📞 +261 34 00 000 00
                </p>

                <p>
                    ✉️ contact@freshmilk.com
                </p>

            </div>

        </div>

        <form class="contact-form">

            <input type="text"
                   placeholder="Votre nom">

            <input type="email"
                   placeholder="Votre email">

            <textarea placeholder="Votre message"></textarea>

            <button type="submit">
                Envoyer
            </button>

        </form>

    </div>

</section>
    </main>


    <?php include "include/footer.php"; ?>

    <!-- SCRIPTS -->

<script src="./js/app.js"></script>

<script src="./js/search.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>

        AOS.init({

            duration: 1000,
            once: true

        });

    </script>
    <script>

const darkModeBtn =
document.getElementById("dark-mode-toggle");

/* Vérifie le mode sauvegardé */

if(localStorage.getItem("darkMode") === "enabled"){

    document.body.classList.add("dark");

}

/* Click bouton */

darkModeBtn.addEventListener("click", () => {

    document.body.classList.toggle("dark");

    /* Sauvegarde */

    if(document.body.classList.contains("dark")){

        localStorage.setItem(
            "darkMode",
            "enabled"
        );

    }else{

        localStorage.setItem(
            "darkMode",
            "disabled"
        );
    }

});
    
</script>
<script>

const counters =
document.querySelectorAll(".stat-box h2");

counters.forEach(counter => {

    const updateCounter = () => {

        const target =
        Number(counter.innerText.replace("+","").replace("%","").replace("h",""));

        let current =
        Number(counter.innerText.replace("+","").replace("%","").replace("h",""));

        current = 0;

        const increment =
        target / 100;

        const interval = setInterval(() => {

            current += increment;

            if(current >= target){

                counter.innerText =
                counter.dataset.original;

                clearInterval(interval);

            }else{

                counter.innerText =
                Math.floor(current);
            }

        },20);

    };

    counter.dataset.original =
    counter.innerText;

    updateCounter();

});

</script>
<script src="/js/darkmode.js"></script>
</body>
<script>

const menuToggle =
document.getElementById("menu-toggle");

const navLinks =
document.getElementById("nav-links");

menuToggle.addEventListener("click", () => {

    navLinks.classList.toggle("active");

});

</script>

</html>