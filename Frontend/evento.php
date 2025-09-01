<?php 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Evento</title>
    <link rel="stylesheet" href="evento.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="comentarios.css">
    
</head>
<body>

    <!--HEADER-->
    <header>
        <div class="logo">
            <img id="logo123" src="../Images/Logo-que-viaje.png">
        </div>    
        <h1>Visualizar Evento</h1>
        <div class="perfil">
            <img src="https://cdn-icons-png.flaticon.com/512/6378/6378141.png"> 
            <p>Usuario</p>
       
            <div>
                <button class="menu-btn">&#9776;</button>
                <div class="menu">
                    <a href="">Perfil</a>
                    <a href="Index.php">Inicio</a>   
                    <a href="">Configuración</a>
                    <a href="">Cerrar Sesión</a>
                    <a href="">Ayuda</a>
                </div>    
             </div>
        </div>
    </header>

    <!---INFO--->

    <section class="evento-detalles">
        <div class="imag-evento">
            <img class="imagen" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRBjM5XXfwZ3lgr1BfloIVi0n_eWBpXGY2QUQ&s">
            <p><strong>Creador:</strong> Ian Lubenko</p>
            <p><strong>Descripción:</strong> Este evento es una celebración especial con música en vivo, comida y actividades para toda la familia.</p>

        </div>
        <div class="detalles-evento">
        <h2>Gran Apertura</h2>
        <p><strong>Fecha Inicio:</strong> 25 de diciembre de 2025</p>
        <p><strong>Fecha Final</strong>27 de diciembre de 2025</p>
        <p><strong>Hora:</strong> 18:00 - 21:00</p>
        <p><strong>Lugar:</strong> Auditorio Principal, Ciudad</p>
        <p><strong>Categoría:</strong> Música</p>
        </div>
    </section>

    <!---COMENTARIOS--->
    <main>
    <h1>Comentarios</h5>
    <hr class="linea">
    <div class="container-comentarios">
        <div class="comentarios">

            <div class="foto-perfil">
                <img src="https://cdn-icons-png.flaticon.com/512/6378/6378141.png">
            </div>

            <div class="info-comentarios">
                <div class="header">
                    <h3>José Torres</h3>
                    <h4>18/08/25</h4>
                </div>

                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis iusto eligendi perspiciatis ratione. Laudantium consequuntur provident eveniet voluptatibus, voluptate sunt, obcaecati, non harum maiores nesciunt facere temporibus odio repellat cupiditate!</p>
                

                <div class="footer-comentarios">
                    <h4 class="responder">Responder</h4>
                    <label class="cora">
                        &#10084;
                        <div class="likes" value="0">0</div>
                    </label>
                </div>
            
            
            </div>
        </div>
    </div>

    <div class="container-comentarios-responder">
        <div class="comentarios-responder">

            <div class="foto-perfil">
                <img src="https://cdn-icons-png.flaticon.com/512/6378/6378141.png">
            </div>

            <div class="info-comentarios-responder">
                <div class="header">
                    <h3>José Torres</h3>
                    <h4>18/08/25</h4>
                </div>

                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis iusto eligendi perspiciatis ratione. Laudantium consequuntur provident eveniet voluptatibus, voluptate sunt, obcaecati, non harum maiores nesciunt facere temporibus odio repellat cupiditate!</p>
                

                <div class="footer-comentarios-responder">
                    <h4 class="responder">Responder</h4>
                    <label class="cora">
                        &#10084;
                        <div class="likes" value="0">0</div>
                    </label>
                </div>
            
            
            </div>
        </div>
    </div>

    <div class="container-comentarios">
        <div class="comentarios">

            <div class="foto-perfil">
                <img src="https://cdn-icons-png.flaticon.com/512/6378/6378141.png">
            </div>

            <div class="info-comentarios">
                <div class="header">
                    <h3>José Torres</h3>
                    <h4>18/08/25</h4>
                </div>

                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis iusto eligendi perspiciatis ratione. Laudantium consequuntur provident eveniet voluptatibus, voluptate sunt, obcaecati, non harum maiores nesciunt facere temporibus odio repellat cupiditate!</p>
                

                <div class="footer-comentarios">
                    <h4 class="responder">Responder</h4>
                    <label class="cora">
                        &#10084;
                        <div class="likes" value="0">0</div>
                    </label>
                </div>
            
            
            </div>
        </div>
    </div>
</main>

    <!--COMENTAR-->
<div class="container-data">
    <div class="foto-input">
        <div class="perfil-foto">
            <img id="img-perfil-usuario" src="https://cdn-icons-png.flaticon.com/512/6378/6378141.png" alt="Perfil">
        </div>
        <span id="nombre-usuario">Usuario</span>
    </div>

    <!-- Botones de formato -->
    <div class="formato-toolbar">
      <button type="button" class="formato-btn" data-comando="bold"><b>B</b></button>
      <button type="button" class="formato-btn" data-comando="italic"><i>I</i></button>
      <button type="button" class="formato-btn" data-comando="underline"><u>U</u></button>
    </div>

    <!-- Cambia tu textarea por un div editable -->
    <div class="mensaje" contenteditable="true" style="border:1px solid #ccc; min-height:60px; padding:10px; margin-top:10px;"></div>
    <button class="btn-comentar">Enviar</button>
</div>

<div class="comentarios-lista"></div>

    <script>    
        
     //LIKES
        document.querySelectorAll('.cora').forEach((btnCorazon, indice) => {
        const idComentario = 'comentario_' + indice;
        const claveLikes = 'likes_' + idComentario;
        const claveLikeado = 'likeado_' + idComentario;
        const divLikes = btnCorazon.querySelector('.likes');
        let cantidadLikes = parseInt(localStorage.getItem(claveLikes)) || 0;
        let likeado = localStorage.getItem(claveLikeado) === '1';

        divLikes.textContent = cantidadLikes;
        if (likeado) btnCorazon.classList.add('liked');

        btnCorazon.onclick = () => {
            likeado = !likeado;
            btnCorazon.classList.toggle('liked', likeado);
            cantidadLikes += likeado ? 1 : -1;
            divLikes.textContent = cantidadLikes;
            localStorage.setItem(claveLikes, cantidadLikes);
            localStorage.setItem(claveLikeado, likeado ? '1' : '');
        };
    });

    

        
        
    </script>
   
</body>
</html>