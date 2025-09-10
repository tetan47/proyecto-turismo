<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administradores - Validar Eventos</title>
    <link rel="stylesheet" href="estiloadmin.css">
</head>
<body>
    <h1>Validar Eventos</h1>
    <div class="grid-eventos" id="lista-eventos">
        <!-- Los eventos se generan aca -->
    </div>

    <script>
        // Ejemplo de eventos a validar
        const eventos = [
            {
                id: 1,
                nombre: "Festival de Música",
                descripcion: "Un festival con bandas locales y comida.",
                creador: "Juan Pérez",
                perfil: "perfil.html?usuario=juanperez"
            },
            {
                id: 2,
                nombre: "Carrera 5K",
                descripcion: "Evento deportivo para toda la familia.",
                creador: "Ana Gómez",
                perfil: "perfil.html?usuario=anagomez"
            },
            {
                id: 3,
                nombre: "Feria de Artesanías",
                descripcion: "Exposición y venta de artesanías regionales.",
                creador: "Carlos Ruiz",
                perfil: "perfil.html?usuario=carlosruiz"
            }
        ];

        const lista = document.getElementById('lista-eventos');

        eventos.forEach((evento, idx) => {
            // Crear contenedor de evento
            const eventoDiv = document.createElement('div');
            eventoDiv.className = 'evento';

            // Header con flecha y nombre
            const header = document.createElement('div');
            header.className = 'evento-header';
            header.innerHTML = `<span class="flecha">&#9654;</span> <strong>${evento.nombre}</strong>`;
            eventoDiv.appendChild(header);

            // Info desplegable
            const info = document.createElement('div');
            info.className = 'evento-info';
            info.innerHTML = `
                <p>${evento.descripcion}</p>
                <p>Creador: <a href="${evento.perfil}" target="_blank">${evento.creador}</a></p>
            `;
            eventoDiv.appendChild(info);

            // Botones y razón
            const accionesDiv = document.createElement('div');
            accionesDiv.className = 'botones';
            accionesDiv.innerHTML = `
                <button class="validar">Validar y Publicar</button>
                <button class="descartar">Descartar Evento</button>
                <input class="razon" type="text" placeholder="Razón si se descarta">
                <div class="mensaje"></div>
            `;

            // Evento para mostrar/ocultar info
            header.onclick = function() {
                const flecha = header.querySelector('.flecha');
                if (info.style.display === 'block') {
                    info.style.display = 'none';
                    flecha.style.transform = 'rotate(0deg)';
                } else {
                    info.style.display = 'block';
                    flecha.style.transform = 'rotate(90deg)';
                }
            };

            // Botón validar
            accionesDiv.querySelector('.validar').onclick = function() {
                fetch('validar_evento.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        id: evento.id,
                        accion: 'validar'
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert(`Evento "${evento.nombre}" validado y publicado en el catálogo.`);
                    eventoDiv.style.display = 'none';
                    accionesDiv.style.display = 'none'; // Oculta también los botones
                })
                .catch(() => {
                    alert('Error al validar el evento.');
                });
            };

            // Botón descartar
            accionesDiv.querySelector('.descartar').onclick = function() {
                const razon = accionesDiv.querySelector('.razon').value.trim();
                const mensaje = accionesDiv.querySelector('.mensaje');
                if (!razon) {
                    mensaje.textContent = 'Por favor, escribe la razón para descartar el evento.';
                } else {
                    mensaje.textContent = '';
                    fetch('validar_evento.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({
                            id: evento.id,
                            accion: 'descartar',
                            razon: razon
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert(`Evento "${evento.nombre}" descartado. Razón: ${razon}`);
                        eventoDiv.style.display = 'none';
                        accionesDiv.style.display = 'none'; // Oculta también los botones
                    })
                    .catch(() => {
                        alert('Error al descartar el evento.');
                    });
                }
            };

            // Añadir al grid
            lista.appendChild(eventoDiv);
            lista.appendChild(accionesDiv);
        });
    </script>
</body>
</html>