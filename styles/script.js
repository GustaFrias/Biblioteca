const toggle = document.getElementById("menu-toggle");
const navList = document.getElementById("nav-list");

// Toggle do menu hamburguer
toggle.addEventListener("click", (e) => {
    e.stopPropagation();
    navList.classList.toggle("active");
    toggle.classList.toggle("active");
});

// Fechar menu ao clicar em um link (mobile)
document.querySelectorAll("#nav-list a").forEach(link => {
    link.addEventListener("click", () => {
        if (window.innerWidth <= 768) {
            navList.classList.remove("active");
            toggle.classList.remove("active");
        }
        // Adiciona classe ativa ao link clicado
        document.querySelectorAll("#nav-list a").forEach(item => {
            item.classList.remove("active");
        });
        link.classList.add("active");
    });
});

// Fechar menu ao clicar fora (mobile)
document.addEventListener("click", (e) => {
    if (window.innerWidth <= 768 && 
        !e.target.closest("nav") && 
        !e.target.closest(".menu-toggle") &&
        navList.classList.contains("active")) {
        navList.classList.remove("active");
        toggle.classList.remove("active");
    }
});

// Marcar link ativo baseado na página atual
function setActiveLink() {
    const currentPage = window.location.pathname.split("/").pop() || "index.html";
    document.querySelectorAll("#nav-list a").forEach(link => {
        const linkPage = link.getAttribute("href").split("/").pop();
        if (linkPage === currentPage) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });
}

// Chamar a função quando o DOM estiver carregado
document.addEventListener("DOMContentLoaded", setActiveLink);