document.addEventListener("DOMContentLoaded", function () {
  const allBookContainers = document.querySelectorAll(".books-container");

  allBookContainers.forEach((container) => {
    const bookGrid = container.querySelector(".book-grid");
    const scrollLeftBtn = container.querySelector(".scroll-btn.left");
    const scrollRightBtn = container.querySelector(".scroll-btn.right");

    if (!bookGrid || !scrollLeftBtn || !scrollRightBtn) {
      return;
    }

    function updateButtons() {
      const canScrollLeft = bookGrid.scrollLeft > 10;
      const canScrollRight =
        bookGrid.scrollWidth - bookGrid.clientWidth - bookGrid.scrollLeft > 10;

      scrollLeftBtn.style.display = canScrollLeft ? "flex" : "none";
      scrollRightBtn.style.display = canScrollRight ? "flex" : "none";
    }

    // Rola suavemente
    function smoothScroll(direction) {
      const scrollAmount = bookGrid.clientWidth * 0.8;
      bookGrid.scrollBy({
        left: direction === "right" ? scrollAmount : -scrollAmount,
        behavior: "smooth",
      });
    }

    // Adiciona os eventos
    scrollLeftBtn.addEventListener("click", () => smoothScroll("left"));
    scrollRightBtn.addEventListener("click", () => smoothScroll("right"));

    bookGrid.addEventListener("scroll", updateButtons);

    function checkScroll() {
      void bookGrid.offsetWidth;
      updateButtons();
    }

    window.addEventListener("resize", checkScroll);

    setTimeout(checkScroll, 150);
  });
});
