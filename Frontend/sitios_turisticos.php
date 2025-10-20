<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/catalogo.css">
    <link rel="stylesheet" href="css/estructura_fundamental.css">
    <title>Catálogo - Sitios Turísticos</title>
</head>

<body>
    <?php
    include('header.php');
    ?>

    <div class="contenedor_nav">
        <nav>
            <form id="form-filtros" class="busqueda-eventos" autocomplete="off">
                <input type="text" name="Busqueda" placeholder="Buscar sitios..." minlength="3">

                <div id="filtros" style="display:none;">
                    <select name="categoria">
                        <option value="">Todas</option>
                        <option value="Naturaleza">Naturaleza</option>
                        <option value="Termas">Termas</option>
                        <option value="Recreativo">Recreativo</option>
                        <option value="Gastronomico">Gastronómico</option>
                        <option value="Historico">Histórico</option>
                        <option value="Cultural">Cultural</option>
                        <option value="Alojamiento">Alojamiento</option>
                        <option value="RutasMiradores">Rutas y Miradores</option>
                        <option value="Deporte">Deporte</option>
                        <option value="Otros">Otros</option>
                    </select>
                </div>

                <button type="button" id="mostrar-filtros">&#9660; Filtros</button>
                <button type="submit">Buscar</button>
            </form>
        </nav>
    </div>

    <section class="catalogo" id="catalogo-eventos">
        <!-- Aquí se cargarán los sitios filtrados -->
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('form-filtros');
            const catalogo = document.getElementById('catalogo-eventos');
            const mostrarFiltros = document.getElementById('mostrar-filtros');
            const filtros = document.getElementById('filtros');

            // Toggle para mostrar/ocultar filtros
            mostrarFiltros.addEventListener('click', function (e) {
                e.preventDefault();
                if (filtros.style.display === 'none') {
                    filtros.style.display = 'block';
                    mostrarFiltros.innerHTML = '&#9650; Filtros';
                } else {
                    filtros.style.display = 'none';
                    mostrarFiltros.innerHTML = '&#9660; Filtros';
                }
            });

            // Función para cargar sitios turísticos
            function cargarSitios() {
                const datos = new FormData(form);

                fetch("../backend/sitios/FiltrarS.php", {
                    method: 'POST',
                    body: datos
                })
                    .then(res => res.text())
                    .then(html => {
                        catalogo.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error al cargar sitios:', error);
                        catalogo.innerHTML = '<p style="padding:2em;text-align:center;color:#ff0000;">Error al cargar los sitios. Por favor, intenta nuevamente.</p>';
                    });
            }

            // Cargar todos los sitios al inicio
            cargarSitios();

            // Al enviar el formulario, filtra sin recargar la página
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                cargarSitios();
            });
        });

        function toggleMapa(btn) {
            const mapa = btn.nextElementSibling;
            if (mapa.style.display === "none" || mapa.style.display === "") {
                mapa.style.display = "block";
                btn.textContent = "Ocultar mapa";
            } else {
                mapa.style.display = "none";
                btn.textContent = "Ver mapa";
            }
        }


    </script>

    <?php
    include('footer.html');
    ?>

</body>

</html>