<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Salón</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    <!-- Contenedor de toda la app -->
    <div class="contenedor-app">
        <!-- Imagen de la izquierda -->
        <div class="imagen"></div>
        <!-- Aplicacion -->
        <div class="app">
            <?php echo $contenido; ?>
        </div>
    </div>
    <!-- Script -->
    <?php 
        echo $script ?? "";
    ?>
</body>
</html>