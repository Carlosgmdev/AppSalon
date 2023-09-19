let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const d = document;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

d.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion();
    tabs();
    botonesPaginador();
    paginaSiguiente();
    paginaAnterior();

    consultarAPI();
    idCliente();
    nombreCliente();
    seleccionarFecha();
    seleccionarHora();
    mostrarResumen();
}

function tabs() {
    const botones = d.querySelectorAll('.tabs button');
    botones.forEach(e => {
        e.addEventListener('click', (e) => {
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
            if (paso = 3) {
                mostrarResumen();
            }
        })
    })
}

function mostrarSeccion() {

    const seccionAnterior = d.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    const seccion = d.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');

    const tabAnterior = d.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    const tab = d.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function botonesPaginador() {
    const paginaSiguiente = d.querySelector('#siguiente');
    const paginaAnterior = d.querySelector('#anterior');

    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar')
    }

    if (paso === 2) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    if (paso === 3) {
        paginaSiguiente.classList.add('ocultar');
        paginaAnterior.classList.remove('ocultar');
        mostrarResumen();
    }

    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = d.querySelector('#anterior');
    paginaAnterior.addEventListener('click', () => {
        if (paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    })
}

function paginaSiguiente() {
    const paginaSiguiente = d.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', () => {
        if (paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    })
}

async function consultarAPI() {

    try {
        const url = 'http://localhost:8080/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {

        const { id, nombre, precio } = servicio;

        nombreServicio = d.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        precioServicio = d.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        servicioDiv = d.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function () {
            seleccionarServicio(servicio);
        };

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        d.querySelector('#servicios').appendChild(servicioDiv);
    })
}

function seleccionarServicio(servicio) {

    const { id } = servicio;
    const { servicios } = cita;
    const servicioDiv = d.querySelector(`[data-id-servicio="${id}"]`);

    if (servicios.some(agregado => agregado.id === id)) {
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        servicioDiv.classList.remove('seleccionado');

    } else {
        cita.servicios = [...servicios, servicio];
        servicioDiv.classList.add('seleccionado');
    }
}

function idCliente() {
    cita.id = d.querySelector('#id').value;
}

function nombreCliente() {
    cita.nombre = d.querySelector('#nombre').value;
}

function seleccionarFecha() {
    const inputFecha = d.querySelector('#fecha');
    inputFecha.addEventListener('input', (e) => {
        const dia = new Date(e.target.value).getUTCDay();
        if ([0, 6].includes(dia)) {
            e.target.value = '';
            mostrarAlerta('.formulario', 'error', 'SABADOS Y DOMINGOS NO ABRIMOS');
        } else {
            cita.fecha = e.target.value;
        }
    })
}

function seleccionarHora() {
    const inputHora = d.querySelector('#hora');
    inputHora.addEventListener('input', (e) => {
        const horaCita = e.target.value;
        const hora = parseInt(horaCita.split(':')[0]);
        if (hora < 8 || hora > 19) {
            e.target.value = '';
            mostrarAlerta('.formulario', 'error', 'EL HORARIO DE ATENCION ES DE 08:00 A 19:00 HRS');
        } else {
            cita.hora = e.target.value;
        }
    })
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {

    // Previene que se generen más de 1 alerta
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) {
        alertaPrevia.remove();
    }

    // Scripting para crear la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if (desaparece) {
        // Eliminar la alerta
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }

}


function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    // Limpiar el Contenido de Resumen
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan datos de Servicios, Fecha u Hora', 'error', '.contenido-resumen', false);

        return;
    }

    // Formatear el div de resumen
    const { nombre, fecha, hora, servicios } = cita;



    // Heading para Servicios en Resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    // Iterando y mostrando los servicios
    servicios.forEach(servicio => {
        const { id, precio, nombre } = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });

    // Heading para Cita en Resumen
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    // Formatear la fecha en español
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    // Boton para Crear una cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(botonReservar);
}

async function reservarCita() {
    
    const {fecha, hora, servicios, id } = cita;

    const idServicios = servicios.map( servicio => servicio.id );
    // console.log(idServicios);

    const datos = new FormData();
    
    datos.append('fecha', fecha);
    datos.append('hora', hora );
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);

    // console.log([...datos]);

    try {
        // Petición hacia la api
        const url = 'http://localhost:8080/api/citas'
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();
        console.log(resultado);
        
        if(resultado.resultado) {
            Swal.fire({
                icon: 'success',
                title: 'Cita Creada',
                text: 'Tu cita fue creada correctamente',
                button: 'OK'
            }).then( () => {
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            })
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al guardar la cita'
        })
    }

    
    // console.log([...datos]);

}











