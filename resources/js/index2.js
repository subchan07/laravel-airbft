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

const reviewCarousel = document.querySelector(".review-carousel");
const leftButtonReview = /**@type {HTMLButtonElement} */ (
    document.querySelector(".review .left-button")
);
const rightButtonReview = /**@type {HTMLButtonElement} */ (
    document.querySelector(".review .right-button")
);

const cardItemReview = document.querySelector(".review-caousel-item");

leftButtonReview.onclick = () => {
    reviewCarousel.scrollLeft -= cardItem.clientWidth;
};

rightButtonReview.onclick = () => {
    reviewCarousel.scrollLeft += cardItem.clientWidth;
};
