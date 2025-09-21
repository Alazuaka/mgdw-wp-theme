document.addEventListener("DOMContentLoaded", () => {
    let dropdowns = document.querySelectorAll(".dropdown");
    dropdowns.forEach(el => {
        let btn = el.querySelector(".dropdown__toggle");
        if (btn) { 
            btn.addEventListener("click", () => {
                el.classList.toggle("dropdown--open");
            });
        }
    });
    let burger = document.querySelector(".topbar__toggle");
    if (burger) { 
        let headerBottom = document.querySelector(".header__bottom");
        burger.addEventListener("click", () => {
            headerBottom.classList.toggle("header__bottom--open");
        });
    }
});