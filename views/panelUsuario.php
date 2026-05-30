<?php
include '../templates/cabecera_panelUsuario.php';
?>
    <main>
        <div class="contenido">
            <h1>Panel de Usuario</h1>
            <p>Bienvenido <?php echo $_SESSION['username']; ?>. Aquí puedes gestionar tu cuenta y tus datos.</p>
        </div>
        <div class="contenido">
            <h2>Información de la cuenta</h2>
            <p><strong>Nombre de usuario:</strong> <?php echo $_SESSION['username']; ?></p>
            <p><strong>Correo electrónico:</strong> <?php echo $_SESSION['email']; ?></p>
        </div>
        <div class="contenido">
            <h2>Opciones</h2>
            <button id="btnEditarPerfil" class="user_button">Editar perfil</button>
            <button id="btnCambiarContraseña" class="user_button">Cambiar contraseña</button>
            <button id='btnEliminarCuenta' class="user_button">Eliminar cuenta</button>
        </div>
    </main>

    <script>
        
    </script>

    <!-- Pie de página -->
<?php include "../templates/footer.php"; ?>