const searchInput =
document.getElementById("search-input");

if (searchInput) {

    searchInput.addEventListener("keyup", () => {

        const value =
        searchInput.value.toLowerCase();

        const products =
        document.querySelectorAll(
            ".searchable-product"
        );

        products.forEach(product => {

            const name =
            product.dataset.name;

            if (name.includes(value)) {

                product.style.display = "block";

            } else {

                product.style.display = "none";
            }

        });

    });

}