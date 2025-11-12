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
- Ver Sitios turísticos.
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

Para este proyecto hemos usado: GitHub, VScode,XAMPP,HTML5,CSS,js,phpMyAdmin y MySQL.

- GitHub: Plataforma para control de versiones y colaboración.
- VSCode: Editor de código para desarrollo y debugging
- XAMPP: Entorno de servidor local (Apache + MySQL + PHP)
- HTML5: Estructura y contenido de las páginas para formularios y visor de contenedores
- CSS: Diseño visual y responsive de la interfaz
- JavaScript: Interactividad dinámica y comunicación con el backend (AJAX)
- PHP: Lógica del servidor, autenticación y procesamiento de datos
- Python: Lenguaje utilizado para implementar la moderación de comentarios con IA.
- Flask: Framework en Python para crear la API de moderación.
- Flask-CORS: Extensión que permite la comunicación entre el servidor Flask y la web.
- MySQL: Base de datos relacional para almacenar usuarios, eventos y comentarios
- phpMyAdmin: Administración visual de la base de datos


Requisitos previos

Para ejecutar este proyecto se necesita:  
- XAMPP (Apache, MySQL, phpMyAdmin).
- Python (para ejecutar el sistema de moderación IA).  
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

## Sistema de moderación de comentarios (IA)

El proyecto incluye un módulo adicional llamado moderacion.py, desarrollado en Python con Flask, que se encarga de moderar los comentarios enviados por los usuarios.
Este sistema revisa automáticamente el texto antes de guardarlo y bloquea comentarios ofensivos, vacíos o escritos en mayúsculas.
Funciona como un servidor local que recibe el comentario desde la página web y devuelve si fue aprobado o no.

Instalación del servicio Flask

Para que la moderación funcione, es necesario tener instaladas las dependencias Flask y Flask-CORS, que permiten crear y conectar el servicio en Python con la página web.

Abrir una terminal dentro de la carpeta del proyecto.
Ejecutar los siguientes comandos:
pip install flask flask-cors

Una vez instaladas, iniciar el servicio ejecutando:
python moderacion.py

Si todo está correcto, se mostrará el mensaje:
IA Moderadora activa en http://localhost:5000

A partir de ese momento, el sistema web puede comunicarse con el moderador y validar los comentarios automáticamente.

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
   