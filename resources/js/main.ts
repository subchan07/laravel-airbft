const caroul = document.querySelector(".caroul");
const nextBtn = document.querySelector(".caroul-button.next");
const prevbtn = document.querySelector(".caroul-button.prev");
nextBtn?.addEventListener("click", () => {
    caroul?.scrollBy({
        left: caroul.clientWidth,
        behavior: "smooth",
    });
});

prevbtn?.addEventListener("click", () => {
    caroul?.scrollBy({
        left: -caroul.clientWidth,
        behavior: "smooth",
    });
});
