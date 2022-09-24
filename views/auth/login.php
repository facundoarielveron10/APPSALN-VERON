<!-- Titulo del Formulario -->
<h1 class="nombre-pagina">Iniciar Sesión</h1>
<!-- Descripcion del Formulario -->
<p class="descripcion-pagina">Completa con tus datos</p>
<!-- Alertas -->
<?php
    include_once __DIR__ . "/../templates/alertas.php";
?>
<!-- Formulario -->
<form class="formulario" method="POST" action="/">
    <!-- Email -->
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            placeholder="Tu Email"
            name="email"
            value="<?php echo s($auth->getEmail()); ?>"
        />
    </div>
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
    <input type="submit" class="boton" value="Iniciar Sesion">
</form>
<!-- Acciones adicionales -->
<div class="acciones">
    <a class="hover" href="/crear-cuenta">¿Aun no tienes una cuenta? - Crear una</a>
    <a class="hover" href="/olvide">¿Olvidaste tu contraseña?</a>
</div>

<?php 
    $script = '<script src="build/js/app.js"></script>';
?>