document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.nav');
    const userActions = document.querySelector('.user-actions');
    const explorarBtn = document.getElementById('explorarBtn');
    const crearBtn = document.getElementById('crearBtn');
    
    // Menú móvil
    menuToggle.addEventListener('click', function() {
        nav.style.display = nav.style.display === 'flex' ? 'none' : 'flex';
        userActions.style.display = userActions.style.display === 'flex' ? 'none' : 'flex';
        
        if (window.innerWidth <= 768) {
            if (nav.style.display === 'flex') {
                nav.classList.add('mobile-menu');
                userActions.classList.add('mobile-menu');
            } else {
                nav.classList.remove('mobile-menu');
                userActions.classList.remove('mobile-menu');
            }
        }
    });
    
    // Funcionalidad de los botones principales
    explorarBtn.addEventListener('click', function() {
        window.location.href = '#eventos'; // Cambiar por tu URL real
        console.log('Explorar eventos clickeado');
    });
    
    crearBtn.addEventListener('click', function() {
        window.location.href = '#crear-evento'; // Cambiar por tu URL real
        console.log('Crear evento clickeado');
    });
    
    // Ajustar menú al cambiar tamaño de pantalla
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            nav.style.display = 'flex';
            userActions.style.display = 'flex';
            nav.classList.remove('mobile-menu');
            userActions.classList.remove('mobile-menu');
        } else {
            nav.style.display = 'none';
            userActions.style.display = 'none';
        }
    });
    
    // Efectos hover mejorados
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Nav links active state
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
});