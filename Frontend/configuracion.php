<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <link rel="stylesheet" href="css/estructura_fundamental.css">
    <link rel="stylesheet" href="css/configuracion.css">
</head>
<body>
    <button class="back-button" onclick="window.history.back()">← Volver</button>

    <main>
        <h1>Configuración</h1>

        <div class="config-wrapper">
            <div class="tabs-container">
                <button class="tab-btn active" data-tab="perfil">Perfil</button>
                <button class="tab-btn" data-tab="cuenta">Cuenta</button>
            </div>

            <div class="content-wrapper">
                <!-- PERFIL -->
                <div id="perfil" class="tab-content active">
                    <h2 class="section-title">Mi Perfil</h2>
                    
                    <div class="profile-section">
                        <img id="fotoPerfil" class="profile-pic" src="https://cdn-icons-png.flaticon.com/512/6378/6378141.png" alt="Foto">
                        <div class="profile-info">
                            <p><strong>Usuario:</strong> <span id="nombreCompleto">Cargando...</span></p>
                            <p id="fotoActual">Cargando foto...</p>
                        </div>
                    </div>

                    <form id="formPerfil">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" id="nombre" placeholder="Tu nombre" maxlength="20" required>
                        </div>
                        <div class="form-group">
                            <label>Apellido</label>
                            <input type="text" id="apellido" placeholder="Tu apellido" maxlength="20" required>
                        </div>
                        <div class="form-group">
                            <label>URL de la foto de perfil</label>
                            <input type="url" id="fotoURL" placeholder="https://ejemplo.com/foto.jpg">
                            <small style="color: rgba(224, 224, 224, 0.6); display: block; margin-top: 5px;">Deja en blanco para mantener la foto actual</small>
                        </div>
                        <div class="button-group">
                            <button type="submit">Guardar cambios</button>
                            <button type="button" class="secondary" onclick="cargarDatosUsuario()">Cancelar</button>
                        </div>
                    </form>
                </div>

                <!-- CUENTA -->
                <div id="cuenta" class="tab-content">
                    <h2 class="section-title">Configuración de Cuenta</h2>
                    
                    <!-- Verificación de contraseña -->
                    <div id="verificacionPassword" class="verificacion-container">
                        <div class="verificacion-box">
                            <h3>Verificación de Seguridad</h3>
                            <p>Por seguridad, debes ingresar tu contraseña actual para acceder a esta sección</p>
                            <form id="formVerificar">
                                <div class="form-group">
                                    <label>Contraseña Actual</label>
                                    <input type="password" id="passwordActualVerificar" placeholder="Ingresa tu contraseña actual" required>
                                </div>
                                <button type="submit">Verificar</button>
                            </form>
                        </div>
                    </div>

                    <!-- Formulario de cambio de contraseña (oculto hasta verificar) -->
                    <div id="formularioCuenta" class="formulario-bloqueado">
                        <form id="formCuenta">
                            <div class="form-group">
                                <label>Correo Electrónico</label>
                                <input type="email" id="correo" placeholder="tu@correo.com" readonly>
                                <small style="color: rgba(224, 224, 224, 0.6); display: block; margin-top: 5px;">El correo electrónico no puede ser modificado</small>
                            </div>
                            <div class="form-group">
                                <label>Nueva Contraseña</label>
                                <input type="password" id="passwordNueva" placeholder="Ingresa tu nueva contraseña" minlength="8">
                            </div>
                            <div class="form-group">
                                <label>Confirmar Contraseña</label>
                                <input type="password" id="passwordConfirm" placeholder="Confirmar contraseña">
                            </div>
                            <div class="button-group">
                                <button type="submit">Cambiar contraseña</button>
                                <button type="button" class="secondary" onclick="cargarDatosUsuario()">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Variables globales
        let datosUsuarioActuales = {};

        const BACKEND_PATH = '../backend/configuracion/procesos_configuracion.php';

        // Cargar datos del usuario al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            cargarDatosUsuario();
            
            // Detectar parámetro en URL para abrir pestaña específica
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');
            
            if (tab) {
                const tabBtn = document.querySelector(`[data-tab="${tab}"]`);
                if (tabBtn) {
                    tabBtn.click();
                }
            }
        });

        // Cambiar tabs
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const tab = this.getAttribute('data-tab');
                
                document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
                document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
                
                document.getElementById(tab).classList.add('active');
                this.classList.add('active');

                if (tab === 'cuenta') {
                    resetearVerificacion();
                }
            });
        });

        function resetearVerificacion() {
            document.getElementById('verificacionPassword').classList.remove('verificacion-oculto');
            document.getElementById('formularioCuenta').classList.remove('formulario-desbloqueado');
            document.getElementById('formularioCuenta').classList.add('formulario-bloqueado');
            document.getElementById('passwordActualVerificar').value = '';
        }

        document.getElementById('formVerificar').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const passwordActual = document.getElementById('passwordActualVerificar').value;

            if (!passwordActual) {
                mostrarMensaje('Debes ingresar tu contraseña actual', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('accion', 'verificar_password');
            formData.append('password_actual', passwordActual);

            fetch(BACKEND_PATH, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('verificacionPassword').classList.add('verificacion-oculto');
                    document.getElementById('formularioCuenta').classList.remove('formulario-bloqueado');
                    document.getElementById('formularioCuenta').classList.add('formulario-desbloqueado');
                    mostrarMensaje('Verificación exitosa', 'success');
                } else {
                    mostrarMensaje(data.message, 'error');
                }
            })
            .catch(error => {
                mostrarMensaje('Error de conexión', 'error');
            });
        });

        // Función para cargar datos del usuario
        function cargarDatosUsuario() {
            fetch(BACKEND_PATH, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'accion=obtener_datos'
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor: ' + response.status);
                }
                return response.text();
            })
            .then(text => {
                console.log('Response text:', text);
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        datosUsuarioActuales = data.data;
                        
                        // Actualizar campos del formulario de perfil
                        document.getElementById('nombre').value = data.data.Nombre || '';
                        document.getElementById('apellido').value = data.data.Apellido || '';
                        document.getElementById('fotoURL').value = '';
                        
                        // Actualizar foto de perfil
                        const fotoURL = data.data.imag_perfil || 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png';
                        document.getElementById('fotoPerfil').src = fotoURL;
                        document.getElementById('fotoActual').textContent = fotoURL;
                        
                        // Actualizar nombre completo
                        document.getElementById('nombreCompleto').textContent = `${data.data.Nombre} ${data.data.Apellido}`;
                        
                        // Actualizar campo de correo
                        document.getElementById('correo').value = data.data.Correo || '';
                        
                        // Limpiar campos de contraseña
                        document.getElementById('passwordNueva').value = '';
                        document.getElementById('passwordConfirm').value = '';
                    } else {
                        mostrarMensaje('Error al cargar datos: ' + data.message, 'error');
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    console.error('Response was:', text);
                    mostrarMensaje('Error: La respuesta del servidor no es válida', 'error');
                }
            })
            .catch(error => {
                console.error('Error completo:', error);
                mostrarMensaje('Error de conexión: ' + error.message, 'error');
            });
        }

        // Preview de imagen cuando se escribe URL
        document.getElementById('fotoURL').addEventListener('input', function(e) {
            const url = e.target.value;
            if (url) {
                const img = document.getElementById('fotoPerfil');
                img.onerror = function() {
                    this.src = 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png';
                };
                img.src = url;
            } else {
                document.getElementById('fotoPerfil').src = datosUsuarioActuales.imag_perfil || 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png';
            }
        });

        // Prevenir errores de selección en inputs
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                try {
                    // Asegurar que no haya problemas con la selección
                    if (window.getSelection) {
                        window.getSelection().removeAllRanges();
                    }
                } catch (e) {
                    // Ignorar errores de selección
                }
            });
        });

        // Guardar perfil
        document.getElementById('formPerfil').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nombre = document.getElementById('nombre').value.trim();
            const apellido = document.getElementById('apellido').value.trim();
            const fotoURL = document.getElementById('fotoURL').value.trim();

            if (!nombre || !apellido) {
                mostrarMensaje('Nombre y apellido son obligatorios', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('accion', 'actualizar_perfil');
            formData.append('nombre', nombre);
            formData.append('apellido', apellido);
            formData.append('foto_url', fotoURL);

            fetch(BACKEND_PATH, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarMensaje('Perfil actualizado correctamente', 'success');
                    cargarDatosUsuario();
                } else {
                    mostrarMensaje(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarMensaje('Error de conexión', 'error');
            });
        });

        // Guardar cuenta
        document.getElementById('formCuenta').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const correo = document.getElementById('correo').value.trim();
            const passwordNueva = document.getElementById('passwordNueva').value;
            const passwordConfirm = document.getElementById('passwordConfirm').value;

            if (!correo) {
                mostrarMensaje('El correo es obligatorio', 'error');
                return;
            }

            if (passwordNueva && passwordNueva !== passwordConfirm) {
                mostrarMensaje('Las contraseñas no coinciden', 'error');
                return;
            }

            if (passwordNueva && passwordNueva.length < 6) {
                mostrarMensaje('La contraseña debe tener al menos 6 caracteres', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('accion', 'actualizar_cuenta');
            formData.append('correo', correo);
            formData.append('password_nueva', passwordNueva);
            formData.append('password_confirm', passwordConfirm);

            fetch('../backend/configuracion/procesos_configuracion.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarMensaje('Cuenta actualizada correctamente', 'success');
                    document.getElementById('passwordNueva').value = '';
                    document.getElementById('passwordConfirm').value = '';
                } else {
                    mostrarMensaje(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarMensaje('Error de conexión', 'error');
            });
        });

        // Función para mostrar mensajes
        function mostrarMensaje(mensaje, tipo) {
            // Eliminar mensaje anterior si existe
            const mensajeAnterior = document.querySelector('.mensaje-notificacion');
            if (mensajeAnterior) {
                mensajeAnterior.remove();
            }

            // Crear nuevo mensaje
            const div = document.createElement('div');
            div.className = 'mensaje-notificacion mensaje-' + tipo;
            div.textContent = mensaje;

            document.body.appendChild(div);

            // Eliminar después de 3 segundos
            setTimeout(() => {
                div.classList.add('mensaje-salir');
                setTimeout(() => div.remove(), 300);
            }, 3000);
        }
    </script>
</body>
</html>