// Mostrar contraseña
function mostrar() {
    var tipo = document.getElementById("password");
    var boton = document.querySelector(".password");

    if (tipo.type === "password") {
        tipo.type = "text";
        boton.classList.toggle("azul");
        boton.classList.remove("negro");
    }
    else {
        tipo.type = "password";
        boton.classList.toggle("negro");
        boton.classList.remove("azul");
    }
}

// Variables
let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;
const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

// Selecciona todo el DOM de cita
document.addEventListener("DOMContentLoaded", function() {
    iniciarApp();
});

// Manda a llamar todas las funciones de citas
function iniciarApp() {
    mostrarSeccion(); // Muestra y oculta las secciones
    tabs(); // Cambia la seccion cuando se presionen los tabs
    botonesPaginador(); // Agrega o quita los botones del paginador
    paginaSiguiente(); // Cambia a la pagina siguiente
    paginaAnterior();  // Cambia a la pagina anterior
    consultarAPI(); // Consulta la API en el backend de PHP
    idCliente(); // Almacena en cita el id del cliente
    nombreCliente(); // Almacena en cita el nombre del cliente
    seleccionarFecha(); // Almacena en cita la fecha que eligio el usuario
    seleccionarHora(); // Almacena en cita la hora que eligio el usuario
    mostrarResumen(); // Muestra el resumen de la cita
}

// FUNCIONES DE CITAS //

// --- PAGINADOR --- //
// Hacen que funciones los cambios de secciones en cita
function tabs() {
    const botones = document.querySelectorAll(".tabs button");

    botones.forEach( boton => {
        boton.addEventListener("click", function(e) {
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
        });
    });
}
// Oculta o muestra los botones segun sea necesario
function botonesPaginador() {
    const paginaSiguiente = document.querySelector("#siguiente");
    const paginaAnterior = document.querySelector("#anterior");

    if (paso === 1) {
        paginaAnterior.classList.add("ocultar");
        paginaSiguiente.classList.remove("ocultar");
    }
    else if (paso === 3) {
        paginaAnterior.classList.remove("ocultar");
        paginaSiguiente.classList.add("ocultar");
        mostrarResumen();
    }
    else {
        paginaAnterior.classList.remove("ocultar");
        paginaSiguiente.classList.remove("ocultar");
    }

    mostrarSeccion();
}
// Cambia a la pagina siguente
function paginaSiguiente() {
    const paginaSiguiente = document.querySelector("#siguiente");
    paginaSiguiente.addEventListener("click", function () {
       // Si paso es mayor a 3 no sumes mas
       if (paso >= pasoFinal) return;
       // Le sumamos a paso
       paso++;
       // --- //
       botonesPaginador();
    });
}
// Cambia a la pagina anterior
function paginaAnterior() {
    const paginaAnterior = document.querySelector("#anterior");
    paginaAnterior.addEventListener("click", function() {
        // Si paso es menor a 1 no restes mas
        if (paso <= pasoInicial) return;
        // Le restamos a paso
        paso--;
        // --- //
        botonesPaginador();
    });
}
// --------------- //

// --- API --- //
// Consulta la API
async function consultarAPI() {
    try {
        // Hasta que no termine resultado no se ejecuta lo demas
        const url = "https://". $_SERVER["HTTP_HOST"] . "/api/servicios";
        const resultado = await fetch(url);
        const servicios = await resultado.json();

        mostrarServicios(servicios);
        
    } catch (error) {
        console.log(error);
    }
}
// --------------- //

// --- ALMACENAR --- //
// Almacena en el arreglo de cita el id del cliente
function idCliente() {
    cita.id = document.querySelector("#id").value;
}
// Almacena en el arreglo de cita el nombre del cliente
function nombreCliente() {
    cita.nombre = document.querySelector("#nombre").value;
}
// Almacena en el arreglo de cita la fecha seleccionada por el cliente
function seleccionarFecha() {
    const inputFecha = document.querySelector("#fecha");
    inputFecha.addEventListener("input", function (e) {
        const dia = new Date(e.target.value).getUTCDay();
        if ( [6, 0].includes(dia) ) {
            e.target.value = "";
            mostrarAlerta("Fines de semana no permitidos", "error", "#paso-2 .semana");
        }
        else {
            cita.fecha = e.target.value;
        }
    });
}
// Almacena en el arreglo de cita la hora seleccionada por el cliente
function seleccionarHora() {
    const inputHora = document.querySelector("#hora");
    inputHora.addEventListener("input", function (e) {
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];
        if (hora < 10 || hora >= 19) {
            e.target.value = "";
            mostrarAlerta("Hora no valida (10:00 hasta 18:59)", "error", "#paso-2 .semana");
        }
        else {
            cita.hora = e.target.value;
        }
    });
}
// Selecciona un servicio de los que tengo en cita
function seleccionarServicio(servicio) {
    // Guardamos el id de los servicios
    const { id } = servicio;
    // Guardamos el arreglo de servicios
    const { servicios } = cita;

    // Identificar al elemento al que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobar si un servicio ya fue seleccionado
    if ( servicios.some( agregado => agregado.id === id ) ) {
        // Deseleccionar un servicio
        cita.servicios = servicios.filter( agregado => agregado.id !== id );
        divServicio.classList.remove("seleccionado");
    }
    else {
        // Seleccionar un servicio
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add("seleccionado");
    }
}
// --------------- //

// --- MOSTRAR --- //
// Mostramos una alerta
function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
    // Previene que se genere mas de una alerta
    const alertaPrevia = document.querySelector(".alerta");
    if (alertaPrevia) {
        alertaPrevia.remove();
    }

    // Scripting para crear la alerta
    const alerta = document.createElement("DIV");
    alerta.textContent = mensaje;
    alerta.classList.add("alerta");
    alerta.classList.add(tipo);

    // Mostrar la alerta en pantalla
    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    // Tiempo antes de quitar la alerta
    if (desaparece) {
        setTimeout(() => {
            alerta.remove();
        }, 5000);   
    }
}
// Muestra los servicios de la Base de Datos
function mostrarServicios(servicios) {
    servicios.forEach( servicio => {
        // Variables con los datos
        const { id, nombre, precio } = servicio;
        
        // Creamos las etiquetas de los nombres de los servicios
        const nombreServicio = document.createElement("P");
        nombreServicio.classList.add("nombre-servicio");
        nombreServicio.textContent = nombre;
        // Creamos las etiquetas de los precios de los servicios
        const precioServicio = document.createElement("P");
        precioServicio.classList.add("precio-servicio");
        precioServicio.textContent = `$${precio}`;

        // Creamos el div para los servicios
        const servicioDiv = document.createElement("DIV");
        servicioDiv.classList.add("servicio");
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function () {
            seleccionarServicio(servicio);
        }

        // Unimos el div con las etiquetas
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        // Mostramos en pantalla los servicios
        document.querySelector("#servicios").appendChild(servicioDiv);
    });
}
// Muestra cada una de las secciones
function mostrarSeccion() {
    // Ocultar la session que tenga la clase de mostrar
    const seccionAnterior = document.querySelector(".mostrar");
    if (seccionAnterior) {
        seccionAnterior.classList.remove("mostrar");   
    }

    // Seleccionar la seccion con el paso...
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add("mostrar");

    // Ocultar la clase actual al tab anterior
    const tabAnterior = document.querySelector(".actual");
    if (tabAnterior) {
        tabAnterior.classList.remove("actual");
    }

    // Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add("actual");
}
// Muestra el resumen de lo que selecciono el usuario
function mostrarResumen() {
    // Seleccionamos la seccion de resumen
    const resumen = document.querySelector(".contenido-resumen");
    // Limpiar el contenido de resumen
    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }
    // Validamos que haya elegido una hora, fecha y servicio
    if ( Object.values(cita).includes("") || cita.servicios.length === 0) {
        mostrarAlerta("Faltan datos de Servicios, Fecha u Hora", "error", ".contenido-resumen", false);
        return;
    }

    // Mostramos los datos seleecionados por el usuario
    const { nombre, fecha, hora, servicios } = cita;
    
    
    // Headin para Servicios en Resumen
    const headingServicios = document.createElement("H3");
    headingServicios.textContent = "Resumen Servicios";
    resumen.appendChild(headingServicios);
    
    // Servicios seleccionados
    servicios.forEach(servicio => {
        // Contenedor del servicio
        const { id, precio, nombre } = servicio;
        const contenedorServicio = document.createElement("DIV");
        contenedorServicio.classList.add("contenedor-servicio");
        // Nombre del Servicio
        const textoServicio = document.createElement("P");
        textoServicio.textContent = nombre;
        // Precio del Servicio
        const precioServicio = document.createElement("P");
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`
        // Guardamos en el contenedor el nombre y el precio del servicio
        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);
        
        // Mostramos en pantalla los servicios
        resumen.appendChild(contenedorServicio);
    });

    
    // Headin para Datos en Resumen
    const headingDatos= document.createElement("H3");
    headingDatos.textContent = "Resumen Datos";
    resumen.appendChild(headingDatos);
    
    // Nombre del cliente
    const nombreCliente = document.createElement("P");
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;
   
    // Formatear la fecha en español
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();
    const fechaUTC = new Date(Date.UTC(year, mes, dia));
    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}
    const fechaFormateada = fechaUTC.toLocaleDateString("es-AR", opciones);
    const fechaMayuscula = fechaFormateada.toUpperCase();
    
    // Fecha seleccionada
    const fechaCita = document.createElement("P");
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaMayuscula}`;
    
    // Hora seleccionada
    const horaCita = document.createElement("P");
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    // Boton para Crear una Cita
    const botonReservar = document.createElement("BUTTON");
    botonReservar.classList.add("boton");
    botonReservar.textContent = "Reservar Cita";
    botonReservar.onclick = reservarCita;

    // Mostramos la informacion
    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);
}
// --------------- //


// --- RESERVACIONES --- //
// Reserva la cita con los datos seleccionados por el Usuario
async function reservarCita() {
    const { id, fecha, hora, servicios } = cita;
    const idServicio = servicios.map( servicio => servicio.id);
    const datos = new FormData();
    
    datos.append("fecha", fecha);
    datos.append("hora", hora);
    datos.append("usuarioId", id);
    datos.append("servicios", idServicio);

    try {
        // Peticion hacia la API
        const url = "https://". $_SERVER["HTTP_HOST"] . "/api/citas";
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        $resultado = await respuesta.json();
        console.log($resultado.resultado);

        if ($resultado.resultado) {
            Swal.fire({
                icon: 'success',
                title: 'CITA CREADA',
                text: 'Tu cita fue creada correctamente'
            }).then( () => {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error...',
            text: 'Hubo un error al guardar la cita',
        }).then( () => {
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });
    }
    
}
// --------------- //

// Mostrar el FormData()
//console.log([...datos]);