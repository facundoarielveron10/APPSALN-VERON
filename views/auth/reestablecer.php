<!-- Titulo del Formulario -->
<h1 class="nombre-pagina">Reestablecer Contraseña</h1>
<!-- Descripcion del Formulario -->
<p class="descripcion-pagina">Coloca tu nueva contraseña a continuacion</p>
<!-- Alertas -->
<?php
    include_once __DIR__ . "/../templates/alertas.php";
?>
<!-- Error de Token -->
<?php if ($error) return; ?>
<!-- Contraseña reestablecida -->
<?php if ($reestablecer): ?>
    <!-- Boton Volver -->
    <div class="acciones">
        <a class="boton" href="/">Iniciar Sesion</a>
    </div>
<?php endif; ?>
<?php if (!$reestablecer): ?>
    <!-- Formulario -->
    <form class="formulario" method="POST">
        <!-- Contraseña -->
        <div class="campo">
            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                placeholder="Tu Contraseña"
                name="password"
            />
            <span class="password material-symbols-outlined" onclick="mostrar()">visibility</span>
        </div>
        <!-- Boton Enviar -->
        <input type="submit" class="boton" value="Guardar Nueva Contraseña">
    </form>
    <!-- Boton Volver -->
    <div class="acciones">
        <a class="boton" href="/"><< Volver</a>
    </div>
<?php endif; ?>

<?php 
    $script = '<script src="build/js/app.js"></script>';
?>