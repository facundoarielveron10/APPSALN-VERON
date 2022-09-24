<!-- Titulo de Seccion-->
<h1 class="nombre-pagina">Nuevos Servicios</h1>
<!-- Descripcion de la Seccion-->
<p class="descripcion-pagina">Llena todos los campos para añadir un nuevo servicio</p>
<!-- Alertas -->
<?php include_once __DIR__ . "/../templates/alertas.php"; ?>
<!-- Perfil -->
<?php include_once __DIR__ . "/../templates/barra.php"; ?>
<!-- Formulario -->
<form class="formulario" action="/servicios/crear" method="POST">
    <?php include_once __DIR__ . "/formulario.php"; ?>
    <input class="boton" type="submit" value="Guardar Servicio">
</form>