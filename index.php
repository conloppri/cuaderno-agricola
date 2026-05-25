<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Descripción de la página">
    <meta name="keywords" content="palabras, clave, para, SEO">

    <title>Cuaderno de campo</title>
    <link rel="stylesheet" type="text/css" href="css/global.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">

</head>
<body>
    <header>
        <div class="cabecera-index">
            <div style="display: flex; align-items: center;">
                <img src="assets/logo.png" alt="Logo" style="width: 50px; height: 50px;">
                <h3>Cuaderno de Campo</h3>
            </div>
            <nav class="main_navbar">
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Contacto</a></li>
            </nav>
            <div>
                <button id="btnSesion" class="boton-nav"type="button">Iniciar sesión</button>
            </div>
        </div>
    </header>

    <main>
        <div class="contenido-index">
            <h1>Bienvenido a Cuaderno de Campo</h1>
            <p>Tu herramienta para gestionar tus explotaciones agrícolas de manera eficiente.</p>
        </div>
    </main>

    <!-- Ventana modal de login -->
    <dialog id="login-modal" class="ventana-modal">
        <div class="modal-content">
            <h2>Iniciar sesión</h2>
            <form id="login-form">
                <div class="grupo-form">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" placeholder="Usuario" required>
                </div>
                <div class="grupo-form">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" placeholder="Contraseña" required>
                </div>
                    <button type="submit" id="btn-form-sesion">Iniciar sesión</button>
                    <button type="button" id="btn-form-cerrar">Cerrar</button>
                <!-- Mensaje de errores -->
                <div id="mensaje" class="error-msg"></div>
            </form>
            
        </div>
    </dialog>

    <script>

        // JavaScript para controlar la ventana modal de login
        const btnAbrirModal = document.getElementById('btnSesion');
        const btnCerrarModal = document.getElementById('btn-form-cerrar');
        const modal = document.getElementById('login-modal');
        const formulario = document.getElementById('login-form');

        btnAbrirModal.addEventListener('click', () => {
            formulario.reset(); // Limpiar el formulario cada vez que se abre
            document.getElementById('mensaje').textContent = '';
            modal.showModal();
        });

        btnCerrarModal.addEventListener('click', () => {
            modal.close();
        });

        document.getElementById('login-form').addEventListener('submit', async(event) => {
            event.preventDefault(); // Evitar el envío tradicional del formulario

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch('/controllers/login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ username, password })
                });

                const result = await response.json();

                //console.log("Contenido de resultado:", result);
                //console.log("Tipo de success:", typeof result.success);
                //console.log("Contenido de resultado:", username, password);

                if (response.ok) {
                    if(result.success === true){
                        // Redirigir a la página de inicio o mostrar un mensaje de éxito
                        window.location.href = '../views/explotacionesView.php'; // Cambia esto a tu página de inicio
                    }else{
                        document.getElementById('mensaje').textContent = result.message;
                        event.target.reset(); // Limpiar el formulario después de un error
                    }
                } else {
                    // Mostrar mensaje de error
                    document.getElementById('mensaje').textContent = result.error || 'Error desconocido';
                    event.target.reset(); // Limpiar el formulario después de un error
                }
                    
            } catch (error) {
                console.error('Error en la solicitud:', error);
                document.getElementById('mensaje').textContent = 'Error en la conexión. Inténtalo de nuevo.';
            }
        });


    </script>

    <!-- Pie de página -->
    <?php include "templates/footer.php"; ?>