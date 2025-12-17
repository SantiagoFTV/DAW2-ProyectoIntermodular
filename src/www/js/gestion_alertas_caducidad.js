/**
 * Script de gestión de alertas de caducidad
 */

document.addEventListener('DOMContentLoaded', function() {
    // Validar formulario
    const form = document.querySelector('.form-alertas');
    if (form) {
        form.addEventListener('submit', validarFormulario);
    }

    // Validar fecha mínima
    const fechaCaducidad = document.getElementById('fecha_caducidad');
    if (fechaCaducidad) {
        const hoy = new Date().toISOString().split('T')[0];
        fechaCaducidad.min = hoy;
        fechaCaducidad.addEventListener('change', actualizarPrediccion);
    }

    // Auto-actualizar predicción de caducidad
    const cantidadInput = document.getElementById('cantidad');
    if (cantidadInput) {
        cantidadInput.addEventListener('change', validarCantidad);
    }

    // Cerrar mensajes automáticamente
    const mensajes = document.querySelectorAll('.mensaje');
    mensajes.forEach(mensaje => {
        setTimeout(() => {
            mensaje.style.transition = 'opacity 0.3s ease-out';
            mensaje.style.opacity = '0';
            setTimeout(() => mensaje.remove(), 300);
        }, 5000);
    });
});

/**
 * Validar formulario antes de enviar
 */
function validarFormulario(e) {
    const nombre = document.getElementById('nombre_producto').value.trim();
    const punto = document.getElementById('punto_distribucion_id').value;
    const cantidad = document.getElementById('cantidad').value.trim();
    const fecha = document.getElementById('fecha_caducidad').value;
    const ubicacion = document.getElementById('ubicacion').value.trim();

    if (!nombre || !punto || !cantidad || !fecha || !ubicacion) {
        e.preventDefault();
        mostrarAlertaLocal('Por favor, completa todos los campos.', 'error');
        return false;
    }

    if (isNaN(cantidad) || parseInt(cantidad) <= 0) {
        e.preventDefault();
        mostrarAlertaLocal('La cantidad debe ser un número positivo.', 'error');
        return false;
    }

    return true;
}

/**
 * Validar cantidad
 */
function validarCantidad(e) {
    const valor = e.target.value.trim();
    if (valor !== '' && (isNaN(valor) || parseInt(valor) <= 0)) {
        e.target.value = '';
        mostrarAlertaLocal('La cantidad debe ser un número positivo.', 'error');
    }
}

/**
 * Actualizar predicción de caducidad
 */
function actualizarPrediccion(e) {
    const fecha = new Date(e.target.value);
    const hoy = new Date();
    const diferencia = fecha - hoy;
    const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));

    let estado = '';
    if (dias < 0) {
        estado = `⚠️ Producto caducado (${Math.abs(dias)} días)`;
    } else if (dias === 0) {
        estado = '🔴 CRÍTICO - Vence hoy';
    } else if (dias <= 3) {
        estado = `🔴 CRÍTICO - ${dias} días`;
    } else if (dias <= 7) {
        estado = `🟠 URGENTE - ${dias} días`;
    } else if (dias <= 15) {
        estado = `🟡 PRÓXIMO - ${dias} días`;
    } else {
        estado = `✅ OK - ${dias} días`;
    }

    // Mostrar tooltip
    e.target.title = estado;
}

/**
 * Mostrar alerta local (sin recargar página)
 */
function mostrarAlertaLocal(mensaje, tipo = 'error') {
    const container = document.querySelector('header');
    const alert = document.createElement('div');
    alert.className = `mensaje ${tipo}`;
    alert.innerHTML = mensaje;
    alert.style.position = 'fixed';
    alert.style.top = '20px';
    alert.style.right = '20px';
    alert.style.zIndex = '1000';
    alert.style.maxWidth = '400px';

    document.body.appendChild(alert);

    setTimeout(() => {
        alert.style.transition = 'opacity 0.3s ease-out';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
    }, 5000);
}

/**
 * Formatear fecha a formato legible
 */
function formatearFecha(fechaString) {
    const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(fechaString).toLocaleDateString('es-ES', opciones);
}

/**
 * Calcular estado según días restantes
 */
function calcularEstado(diasRestantes) {
    if (diasRestantes < 0) {
        return 'caducado';
    } else if (diasRestantes <= 3) {
        return 'critico';
    } else if (diasRestantes <= 7) {
        return 'urgente';
    } else if (diasRestantes <= 15) {
        return 'proximo';
    }
    return 'ok';
}
