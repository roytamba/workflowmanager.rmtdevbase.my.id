window.addEventListener("load", () => {
    const leftCard = document.querySelector(".col-md-8 .card");
    const rightCard = document.querySelector(".col-md-4 .card");

    const maxHeight = Math.max(leftCard.offsetHeight, rightCard.offsetHeight);
    leftCard.style.height = rightCard.style.height = maxHeight + "px";
});
