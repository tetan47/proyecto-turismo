# proyecto-turismo
¡Qué Viaje!   
Plataforma Web Interactiva de Eventos Turísticos y Culturales – Ciudad de Salto

Desarrollado por
 Emmanuel Ezequiel Bennett Méndez  
 Ian Yevgeny Lubenko Martínez  
 Maicon Aaron Paulo De Los Santos  
 José Eduardo Torres Cattaneo  

 Descripción del Proyecto
¡Qué Viaje! es una plataforma web desarrollada por TIBAWARE que centraliza información sobre eventos culturales y turísticos en Salto Uruguay.  
El objetivo es resolver la falta de información en tiempo real sobre eventos, ofreciendo un espacio digital accesible y confiable tanto para ciudadanos como para turistas.  

La aplicación permite:  
- Publicar y consultar eventos.  
- Filtrar por categorías, ubicación o fecha.  
- Acceder a un mapa interactivo de lugares de interés.  
- Usar un buscador de información histórica de Salto.  
- Integrar IA para moderación de comentarios y sugerencias personalizadas.  

Nuestros objetivos son:
- Crear un software a medida que fomente la divulgación de eventos y fortalezca la economía local.  
- Centralizar la información de eventos sociales y culturales.  
- Implementar IA para moderación de comentarios.  
- Incluir geolocalización mediante API de mapas.  
- Diseñar un sistema accesible y fácil de usar.  

Para este proyecto hemos usado: VScode,XAMPP,HTML5,css,js,phpMyAdmin. y MySQL.

Requisitos previos

Para ejecutar este proyecto se necesita:  
- XAMPP (Apache, MySQL, phpMyAdmin).  
- GitHub (para descargar el repositorio).  
- Navegador web actualizado (Chrome, Edge, Firefox, etc.).  

Instalación

1. Descargar el proyecto  
   - Crear una cuenta en GitHub.  
   - Solicitar acceso al repositorio al administrador del proyecto.  
   - Descargar el contenido del repositorio en tu computadora.  

2. Instalar XAMPP  
   - Durante la instalación asegurarse de marcar: Apache y MySQL.

3. Ejecutar servicios  
   - Abrir el XAMPP Control Panel.  
   - Dar clic en Start en Apache y MySQL (deben quedar en verde).  

## Configuración de la base de datos

1. Abrir phpMyAdmin desde el botón Admin de MySQL en el panel de XAMPP.  
2. Crear una nueva base de datos llamada:  
turismo
3. Ir a la pestaña Importar.  
4. Seleccionar el archivo `turismo.sql` (incluido en este repositorio).  
5. Hacer clic en Aceptar para cargar las tablas.  

Dentro de esta base de datos se encuentra la tabla `evento`, donde se almacenarán los eventos creados por los usuarios.  

## Uso del sistema

1. Copiar la carpeta del proyecto en:  
C:\xampp\htdocs\

Ejemplo:  
C:\xampp\htdocsproyecto-turismo

2. Abrir el navegador y escribir en la barra de direcciones:  
http://localhost/proyecto-turismo

3. El sistema estará disponible para su uso.  

## Cómo probar el sistema

1. Ingresar al módulo de creación de eventos desde la página principal.  
2. Completar el formulario con un evento de ejemplo, por ejemplo:  
- Nombre del evento: Fiesta de la Primavera  
- Lugar: Plaza Artigas  
- Fecha: 21/09/2025  
- Descripción: Celebración con música en vivo y feria gastronómica.  

3. Guardar el evento.  
4. Verificar en phpMyAdmin, dentro de la tabla `evento`, que el registro se insertó correctamente.  
5. Visualizar el evento en la página principal del sistema.  
   