<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet"
href="https://unpkg.com/aos@2.3.1/dist/aos.css">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>FreshMilk</title>

    <link rel="stylesheet" href="css/style.css?v=2">

</head>
<div id="toast">

    Produit ajouté au panier

</div>


<script>

AOS.init({

    duration:1000,

    once:true

});

</script>
<body>

    <?php include "include/navbar.php"; ?>

    <main>

        <section class="hero">

            <div class="hero-text" data-aos="fade-up">

                <h1>
                    Fresh<span>Milk</span>
                </h1>

                <p>
                    Produits laitiers frais et naturels.
                </p>

                <a href="#products"
                   class="btn">

                    Voir les produits

                </a>

            </div>

        </section >

        <section class="features">
            <div class="feature-box" data-aos="zoom-in">
                <div class="feature-icon">
                    🥛

                </div>
                <h3>
                    Produits frais
                </h3>
                <p>
                    Tous nos produit son frais et sélectionnés chaque jour.

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
        <section class="stats" data-aos="flip-left">

    <div class="stat-box">

        <h2>
            500+
        </h2>

        <p>
            Clients satisfaits
        </p>

    </div>

    <div class="stat-box" data-aos="flip-left">

        <h2>
            100%
        </h2>

        <p>
            Produits naturels
        </p>

    </div>

    <div class="stat-box" data-aos="flip-left">

        <h2>
            24h
        </h2>

        <p>
            Livraison rapide
        </p>

    </div>

    <div class="stat-box" data-aos="flip-left">

        <h2>
            20+
        </h2>

        <p>
            Produits disponibles
        </p>

    </div>

</section>
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

        <section id="products"
         class="products">

    <h2>
        Produits populaires
    </h2>

    <input type="text"
           id="search-input"
           placeholder="Rechercher un produit...">

    <div class="product-grid">

        <?php

        $products = [

            [
                "name" => "Lait Frais",
                "price" => 3,
                "image" => "https://images.unsplash.com/photo-1550583724-b2692b85b150?q=80&w=800"
            ],

            [
                "name" => "Fromage",
                "price" => 6,
                "image" => "https://images.unsplash.com/photo-1628088062854-d1870b4553da?q=80&w=800"
            ],

            [
                "name" => "Yaourt Nature",
                "price" => 2,
                "image" => "https://images.unsplash.com/photo-1571212515416-fef01fc43637?q=80&w=800"
            ],

            [
                "name" => "Beurre",
                "price" => 4,
                "image" => "https://images.unsplash.com/photo-1589985270958-b3f7b6c7f2ab?q=80&w=800"
            ],

            [
                "name" => "Crème Fraîche",
                "price" => 5,
                "image" => "https://images.unsplash.com/photo-1603052875302-d376b7c0638a?q=80&w=800"
            ],

            [
                "name" => "Lait Chocolaté",
                "price" => 4,
                "image" => "https://images.unsplash.com/photo-1519864600265-abb23847ef2c?q=80&w=800"
            ],

            [
                "name" => "Mozzarella",
                "price" => 7,
                "image" => "https://images.unsplash.com/photo-1573812461383-e5f8b759d12f?q=80&w=800"
            ],

            [
                "name" => "Glace Vanille",
                "price" => 5,
                "image" => "https://images.unsplash.com/photo-1563805042-7684c019e1cb?q=80&w=800"
            ],

            [
                "name" => "Yaourt Fraise",
                "price" => 3,
                "image" => "https://images.unsplash.com/photo-1488477181946-6428a0291777?q=80&w=800"
            ],

            [
                "name" => "Camembert",
                "price" => 8,
                "image" => "https://images.unsplash.com/photo-1452195100486-9cc805987862?q=80&w=800"
            ],

            [
                "name" => "Lait Bio",
                "price" => 5,
                "image" => "https://images.unsplash.com/photo-1517448931760-9bf4414148c5?q=80&w=800"
            ],

            [
                "name" => "Milkshake Vanille",
                "price" => 6,
                "image" => "https://images.unsplash.com/photo-1579954115545-a95591f28bfc?q=80&w=800"
            ],

            [
                "name" => "Parmesan",
                "price" => 9,
                "image" => "https://images.unsplash.com/photo-1618164436241-4473940d1f5c?q=80&w=800"
            ],

            [
                "name" => "Crème Chantilly",
                "price" => 4,
                "image" => "https://images.unsplash.com/photo-1625944525533-473f1b3d54b3?q=80&w=800"
            ],

            [
                "name" => "Lait de Coco",
                "price" => 5,
                "image" => "https://images.unsplash.com/photo-1600788907416-456578634209?q=80&w=800"
            ],

            [
                "name" => "Glace Chocolat",
                "price" => 6,
                "image" => "https://images.unsplash.com/photo-1570197788417-0e82375c9371?q=80&w=800"
            ],

            [
                "name" => "Cheddar",
                "price" => 7,
                "image" => "https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?q=80&w=800"
            ],

            [
                "name" => "Yaourt Grec",
                "price" => 4,
                "image" => "https://images.unsplash.com/photo-1505253716362-afaea6fcf7af?q=80&w=800"
            ],

            [
                "name" => "Lait Amande",
                "price" => 5,
                "image" => "https://images.unsplash.com/photo-1514996937319-344454492b37?q=80&w=800"
            ],

            [
                "name" => "Ricotta",
                "price" => 6,
                "image" => "https://images.unsplash.com/photo-1626200419199-391ae4be7a41?q=80&w=800"
            ]


        ];

        foreach($products as $product){

        ?>

            <div class="card" data-aos="fade-up">

                <img src="<?php echo $product['image']; ?>"
                     alt="<?php echo $product['name']; ?>">

                <h3>
                    <?php echo $product['name']; ?>
                </h3>

                <p>
                    <?php echo $product['price']; ?>€
                </p>

                <button class="add-to-cart"

                    data-name="<?php echo $product['name']; ?>"

                    data-price="<?php echo $product['price']; ?>"

                    data-image="<?php echo $product['image']; ?>">

                    Ajouter au panier

                </button>

            </div>

        <?php

        }

        ?>

    </div>

</section>

    </main>

    <?php include "include/footer.php"; ?>

    <script src="/js/app.js"></script>

    <script src="/js/cart.js"></script>

</body>


</html>