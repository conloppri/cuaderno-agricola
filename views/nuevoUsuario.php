<?php
// Código para la vista de nuevo usuario
include '../templates/cabecera_explotacion_SinSesion.php';
?>
    <main>
        <div class="contenido">
            <h1>Crear nuevo usuario</h1>
            <form id="registro-form" class="grupo-form" method="POST" action="../controllers/registro.php">
                <label for="name">Nombre de usuario:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <select id="role" name="role" required>
                    <option value="">Selecciona un rol</option>
                    <option value="admin">Administrador</option>
                    <option value="user">Usuario</option>
                </select>

                <button type="submit">Registrar</button>
            </form>
            <div id="mensaje"></div>
        </div>
    </main>
<?php include '../templates/footer.php'; ?>