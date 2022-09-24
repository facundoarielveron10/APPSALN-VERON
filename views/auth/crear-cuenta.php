<!-- Titulo del Formulario -->
<h1 class="nombre-pagina">Registrarse</h1>
<!-- Descripcion del Formulario -->
<p class="descripcion-pagina">LLena el siguiente formulario para registrarte</p>
<!-- Alertas -->
<?php
    include_once __DIR__ . "/../templates/alertas.php";
?>
<!-- Formulario -->
<form class="formulario" method="POST" action="/crear-cuenta">
    <!-- Nombre -->
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input 
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Tu Nombre"
            value="<?php echo s($usuario->getNombre()) ?>"
        />
    </div>
    <!-- Apellido -->
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input 
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Tu Apellido"
            value="<?php echo s($usuario->getApellido()) ?>"  
        />
    </div>
    <!-- Telefono -->
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input 
            type="tel"
            id="telefono"
            name="telefono"
            placeholder="Tu Telefono"
            value="<?php echo s($usuario->getTelefono()) ?>"
        />
    </div>
    <!-- Email -->
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            placeholder="Tu Email"
            name="email"
            value="<?php echo s($usuario->getEmail()) ?>"
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
    <input type="submit" class="boton" value="Registrarse">
</form>
<!-- Boton Volver -->
<div class="acciones">
    <a class="boton" href="/"><< Volver</a>
</div>

<?php 
    $script = '<script src="build/js/app.js"></script>';
?>