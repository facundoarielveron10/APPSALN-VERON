<!-- Titulo del Formulario -->
<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<!-- Descripcion del Formulario -->
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>
<!-- Perfil -->
<?php include_once __DIR__ . "/../templates/barra.php" ?>
<!-- Formulario -->
<div id="app">
    <!-- Navegacion -->
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Datos y Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <!-- Servicios -->
    <div id="paso-1" class="seccion">
        <!-- Titulo -->
        <h2>Servicios</h2>
        <!-- Descripcion -->
        <p class="text-center">Elique tus servicios a continuacion</p>
        <!-- Lista de Servicios -->
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <!-- Datos y Cita -->
    <div id="paso-2" class="seccion">
        <!-- Titulo -->
        <h2>Tus Datos y Cita</h2>
        <!-- Descripcion -->
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>
        <div class="semana"></div>
        <!-- Formulario para Datos y Cita -->
        <form class="formulario">
            <!-- Nombre -->
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    id="nombre"
                    type="text" 
                    name="nombre" 
                    placeholder="Tu Nombre"
                    value="<?php echo $nombre; ?>"
                    disabled
                />
            </div>
            <!-- Fecha -->
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                    id="fecha"
                    type="date" 
                    name="fecha"
                    min="<?php echo date("Y-m-d", strtotime("+1 day")) ?>"
                    max="2022-12-31"
                />
            </div>
            <!-- Hora -->
            <div class="campo">
                <label for="hora">Hora</label>
                <input 
                    id="hora"
                    type="time" 
                    name="hora"
                />
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
    </div>
    <!-- Resumen -->
    <div id="paso-3" class="seccion contenido-resumen">
        <!-- Titulo -->
        <h2>Resumen</h2>
        <!-- Descripcion -->
        <p class="text-center">Verifica que la informacion sea correcta</p>
    </div>
    <!-- Paginacion -->
    <div class="paginacion">
        <!-- Anterior -->
        <button
            id="anterior"
            class="boton"
        ><< Anterior</button>
        <!-- Siguiente -->
        <button
            id="siguiente"
            class="boton"
        >Siguiente >></button>
    </div>
</div>
<?php 
    $script = "
        <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>