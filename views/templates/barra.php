<div class="barra">
    <p>Hola:<span><?php echo $nombre ?? null ?></span></p>

    <a class="boton" href="/logout">Cerrar Sesion</a>
</div>

<?php if (isset($_SESSION['admin'])): ?>
    <div class="barra-servicios">
        <a href="/admin" class="boton">Ver Citas</a>
        <a href="/servicios" class="boton">Ver Servicios</a>
        <a href="/servicios/crear" class="boton">Nuevos Servicios</a>
    </div>
<?php endif; ?>