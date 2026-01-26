/**
 * Script de gestion de puntos de distribucion
 * Actualiza iframe de mapa y muestra detalles de cada punto
 */
document.addEventListener('DOMContentLoaded', function() {
    const mapFrame = document.getElementById('mapFrame');
    const mapDetails = document.getElementById('mapDetails');
    const actionButtons = document.querySelectorAll('button[data-nombre]');

    function setMap(direccion, nombre, responsable, telefono, horario, descripcion) {
        const query = encodeURIComponent(direccion || nombre || 'Spain');
        const src = `https://www.google.com/maps?q=${query}&output=embed`;
        mapFrame.setAttribute('src', src);

        const detailHtml = `
            <div class="detail-title">${nombre || 'Punto de distribución'}</div>
            <div class="detail-body">${direccion || 'Dirección no especificada'}</div>
            <div class="detail-body"><strong>Responsable:</strong> ${responsable || 'N/D'} · <strong>Tel:</strong> ${telefono || 'N/D'}</div>
            ${horario ? `<div class="detail-body"><strong>Horario:</strong> ${horario}</div>` : ''}
            ${descripcion ? `<div class="detail-body">${descripcion}</div>` : ''}
        `;
        mapDetails.innerHTML = detailHtml;
    }

    actionButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const nombre = btn.dataset.nombre;
            const direccion = btn.dataset.direccion;
            const responsable = btn.dataset.responsable;
            const telefono = btn.dataset.telefono;
            const horario = btn.dataset.horario;
            const descripcion = btn.dataset.descripcion;
            setMap(direccion, nombre, responsable, telefono, horario, descripcion);
        });
    });

    if (typeof window.puntosDistribucion !== 'undefined' && window.puntosDistribucion.length > 0) {
        const first = window.puntosDistribucion[0];
        setMap(first.direccion, first.nombre, first.responsable, first.telefono, first.horario, first.descripcion);
    }
});
