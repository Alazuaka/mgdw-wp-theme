document.addEventListener("DOMContentLoaded", () => {
    console.log('JS загружен, милый!'); // Добавь это, чтоб увидеть в консоли
    let dropdowns = document.querySelectorAll(".dropdown");
    dropdowns.forEach(el => {
        let btn = el.querySelector(".dropdown__toggle");
        if (btn) {
            btn.addEventListener("click", () => {
                console.log('Клик по дропдауну!'); // Тест
                el.classList.toggle("dropdown--open");
            });
        }
    });
    let burger = document.querySelector(".topbar__toggle");
    if (burger) {
        let headerBottom = document.querySelector(".header__bottom");
        burger.addEventListener("click", () => {
            console.log('Бургер жрёт!'); // Тест
            headerBottom.classList.toggle("header__bottom--open");
        });
    }
});