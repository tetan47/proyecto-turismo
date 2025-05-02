document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar contraseña
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('password');
    
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
    
    // Validación del formulario
    const formLogin = document.querySelector('.formulario-login');
    
    formLogin.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        // Validación básica
        if (!email || !password) {
            alert('Por favor completa todos los campos');
            return;
        }
        
        // Aquí iría la lógica de autenticación real
        console.log('Email:', email);
        console.log('Password:', password);
        
        // Simulación de login exitoso
        alert('¡Inicio de sesión exitoso! Redirigiendo...');
        // window.location.href = 'dashboard.html'; // Redirigir al dashboard
    });
    
    // Efectos hover para botones
    const buttons = document.querySelectorAll('button, .red-social');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Efecto de carga inicial
    setTimeout(() => {
        document.querySelector('.contenedor-login').style.opacity = '1';
        document.querySelector('.contenedor-login').style.transform = 'translateY(0)';
    }, 100);
});