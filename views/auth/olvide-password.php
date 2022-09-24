<!-- Titulo del Formulario -->
<h1 class="nombre-pagina">Olvide mi contraseña</h1>
<!-- Descripcion del Formulario -->
<p class="descripcion-pagina">Restablece tu contraseña escribiendo tu email a continuacion</p>
<!-- Alertas -->
<?php
    include_once __DIR__ . "/../templates/alertas.php";
?>
<!-- Formulario -->
<form class="formulario" action="/olvide" method="POST">
    <!-- Email -->
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu Email"
        />
    </div>
    <!-- Boton Enviar -->
    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>
<!-- Boton Volver -->
<div class="acciones">
    <a class="boton" href="/"><< Volver</a>
</div>