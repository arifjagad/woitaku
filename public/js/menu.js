document
    .getElementById("navbarToggle")
    .addEventListener("click", function () {
        var navbarLinks = document.getElementById("navbarLinks");
        if (window.getComputedStyle(navbarLinks).display === "flex") {
            navbarLinks.style.display = "none";
        } else {
            navbarLinks.style.display = "flex";
        }
    });

window.addEventListener("resize", function () {
    var navbarLinks = document.getElementById("navbarLinks");
    if (window.innerWidth >= 768) {
        navbarLinks.style.display = "flex";
    } else {
        navbarLinks.style.display = "none";
    }
});