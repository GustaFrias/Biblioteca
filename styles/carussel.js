document.addEventListener('DOMContentLoaded', function() {
    const bookGrid = document.querySelector('.book-grid');
    const scrollLeftBtn = document.querySelector('.scroll-btn.left');
    const scrollRightBtn = document.querySelector('.scroll-btn.right');
    
    if (!bookGrid || !scrollLeftBtn || !scrollRightBtn) return;
    
    // Mostra/oculta botões conforme necessidade
    function updateButtons() {
        const canScrollLeft = bookGrid.scrollLeft > 10;
        const canScrollRight = bookGrid.scrollLeft < (bookGrid.scrollWidth - bookGrid.clientWidth - 10);
        
        scrollLeftBtn.style.display = canScrollLeft ? 'flex' : 'none';
        scrollRightBtn.style.display = canScrollRight ? 'flex' : 'none';
    }
    
    // Rola suavemente
    function smoothScroll(direction) {
        const scrollAmount = bookGrid.clientWidth * 0.8;
        bookGrid.scrollBy({
            left: direction === 'right' ? scrollAmount : -scrollAmount,
            behavior: 'smooth'
        });
    }
    
    // Event listeners
    scrollLeftBtn.addEventListener('click', () => smoothScroll('left'));
    scrollRightBtn.addEventListener('click', () => smoothScroll('right'));
    
    bookGrid.addEventListener('scroll', updateButtons);
    
    // Verifica ao carregar e redimensionar
    function checkScroll() {
        // Força recálculo do layout
        void bookGrid.offsetWidth;
        updateButtons();
    }
    
    window.addEventListener('resize', checkScroll);
    
    // Inicialização
    setTimeout(checkScroll, 100); // Pequeno delay para garantir cálculo correto
});