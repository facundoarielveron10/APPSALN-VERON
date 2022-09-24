<!-- Titulo de Seccion-->
<h1 class="nombre-pagina">Actualizar Servicios</h1>
<!-- Descripcion de la Seccion-->
<p class="descripcion-pagina">Edita el nombre o el precio del servicio</p>
<!-- Perfil -->
<?php include_once __DIR__ . "/../templates/barra.php"; ?>
<!-- Formulario -->
<form class="formulario" method="POST">
    <?php include_once __DIR__ . "/formulario.php"; ?>
    <input class="boton" type="submit" value="Actualizar">
</form>