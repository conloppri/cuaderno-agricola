<?php include "../controllers/parcelaController.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo</title>
</head>
<body>
    <h1>Lista de Parcelas</h1>
    <?php if(empty($infoParcelas)) {
        echo "<p>No hay parcelas registradas.</p>";
    } else {
        echo "<ul>";
        foreach ($infoParcelas as $parcela) {
            echo "<li>";
            echo "ID: " . $parcela['parcela_id'] . "<br>";
            echo "Nombre: " . $parcela['nombre'] . "<br>";
            echo "Tamaño: " . $parcela['superficie'] . " ha <br>";
            echo "</li>";
        }
        echo "</ul>";
    }
    ?>
</body>
</html>