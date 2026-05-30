<?php
// Código para la vista de nuevo usuario
include '../templates/cabecera_explotacion_SinSesion.php';
?>
    <main>
        <div class="contenido">
            <h1>Crear nuevo usuario</h1>
            <form id="registro-form" class="grupo-form" method="POST" action="../controllers/registro.php">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <label for="confirm_password">Confirmar contraseña:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <button type="submit">Registrar</button>
            </form>
            <div id="mensaje"></div>
        </div>
    </main>

    <script>
        // Validación del formulario de registro
        document.getElementById('registro-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío del formulario

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const mensajeDiv = document.getElementById('mensaje');

            // Validar que las contraseñas coincidan
            if (password !== confirmPassword) {
                mensajeDiv.textContent = 'Las contraseñas no coinciden.';
                mensajeDiv.style.color = 'red';
                return;
            }

            // Validar la fortaleza de la contraseña (mínimo 8 caracteres, al menos una letra y un número)
            const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
            if (!passwordRegex.test(password)) {
                mensajeDiv.textContent = 'La contraseña debe tener al menos 8 caracteres, incluyendo una letra y un número.';
                mensajeDiv.style.color = 'red';
                return;
            }

            // Si la validación es exitosa, enviar el formulario
            const formData = new FormData(this);

            fetch('../controllers/registroUsuario.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Usuario creado exitosamente');
                    window.location.href = '../index.php';
                } else {
                    mensajeDiv.textContent = data.message || 'Error al registrar. Inténtalo de nuevo.';
                    mensajeDiv.style.color = 'red';
                }
            })
            .catch(error => {
                console.error('Error al registrar:', error);
                mensajeDiv.textContent = 'Error al registrar. Inténtalo de nuevo.';
                mensajeDiv.style.color = 'red';
            });
        });
    </script>
<?php include '../templates/footer.php'; ?>