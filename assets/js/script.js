document.addEventListener("DOMContentLoaded", () => {
    
    /* =========================================
       ANIMAÇÃO DE SCROLL (Home)
       ========================================= */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('mostrar');
                // Opcional: observer.unobserve(entry.target); se quiser que a animação aconteça só 1 vez
            }
        });
    });

    const elementosEscondidos = document.querySelectorAll('.escondido');
    if (elementosEscondidos.length > 0) {
        elementosEscondidos.forEach((el) => observer.observe(el));
    }

    /* =========================================
       ANIMAÇÃO DE ENTRADA (Login/Cadastro)
       ========================================= */
    const authBox = document.getElementById('authBox');
    if (authBox) {
        // Um pequeno delay de 100ms deixa a transição mais natural ao carregar a página
        setTimeout(() => {
            authBox.classList.add('mostrar-login');
        }, 100);
    }

});