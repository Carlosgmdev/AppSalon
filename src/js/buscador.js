const d = document;

d.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
})

function iniciarApp() {
    buscarPorFecha();
}

function buscarPorFecha() {

    const fechaInput = d.querySelector('#fecha');

    fechaInput.addEventListener('input', (e) => {
        const fechaSeleccionada = e.target.value;
        window.location = `?fecha=${fechaSeleccionada}`;
    })
}