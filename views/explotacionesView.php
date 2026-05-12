<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Si el usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("Location: ../index.php");
    exit();
}

$usuarioID = $_SESSION['usuario_id'];

include '../templates/cabecera_explotacion.php';
?>
    <main>
        <div class="contenido">
            <h1>Bienvenido, <?php echo $_SESSION['username']; ?>!</h1>
            <p>Gestiona tus explotaciones agrícolas de manera eficiente.</p>
        </div>
    </main>
    
<?php include '../templates/footer.php';?>