const darkBtn = document.getElementById("darkModeToggle");

/*
|--------------------------------------------------------------------------
| CHARGER LE MODE
|--------------------------------------------------------------------------
*/
if(localStorage.getItem("darkMode") === "enabled"){

    document.body.classList.add("dark");
}

/*
|--------------------------------------------------------------------------
| CLICK
|--------------------------------------------------------------------------
*/
if(darkBtn){

    darkBtn.addEventListener("click", () => {

        document.body.classList.toggle("dark");

        if(document.body.classList.contains("dark")){

            localStorage.setItem("darkMode", "enabled");

        }else{

            localStorage.setItem("darkMode", "disabled");
        }

    });

}