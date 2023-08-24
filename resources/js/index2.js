const carousel = document.querySelector(".product-category-carousel");
const leftButton = /**@type {HTMLButtonElement} */ (
    document.querySelector(".product-category .left-button")
);
const rightButton = /**@type {HTMLButtonElement} */ (
    document.querySelector(".product-category .right-button")
);
const cardItem = document.querySelector(".product-category-carousel-item");

leftButton.onclick = () => {
    carousel.scrollLeft -= cardItem.clientWidth;
};

rightButton.onclick = () => {
    carousel.scrollLeft += cardItem.clientWidth;
};
