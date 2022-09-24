<!-- Titulo de Seccion-->
<h1 class="nombre-pagina">Servicios</h1>
<!-- Descripcion de la Seccion-->
<p class="descripcion-pagina">Administracion de Servicios</p>
<!-- Perfil -->
<?php include_once __DIR__ . "/../templates/barra.php"; ?>
<!-- Servicios -->
<ul class="servicios">
    <?php foreach($servicios as $servicio): ?>
        <li>
            <p>Nombre: <span>$<?php echo $servicio->nombre; ?></span></p>
            <p>Precio: <span>$<?php echo $servicio->precio; ?></span></p>
            <!-- Actualizar, Borrar -->
            <div class="acciones">
                <!-- Actualizar -->
                <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id; ?>">Actualizar</a>
                <!-- Borrar -->
                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
                    <input type="submit" value="Borrar" class="boton-eliminar">
                </form>
            </div>
        </li>
    <?php endforeach; ?>
</ul>