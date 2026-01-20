/**
 * Script para Gestión de Beneficiarios
 * Maneja la lógica del cliente para HU-03
 */

document.addEventListener('DOMContentLoaded', function() {
    // Ocultar mensaje después de 5 segundos
    const mensaje = document.getElementById('mensaje');
    if (mensaje) {
        setTimeout(function() {
            mensaje.style.opacity = '0';
            mensaje.style.transition = 'opacity 0.5s ease';
            setTimeout(function() {
                mensaje.style.display = 'none';
            }, 500);
        }, 5000);
    }

    // Inicializar eventos
    inicializarEventos();
});

/**
 * Inicializa los eventos del formulario
 */
function inicializarEventos() {
    // Validación de formularios en tiempo real
    const formInputs = document.querySelectorAll('.form-input');
    formInputs.forEach(input => {
        input.addEventListener('change', function() {
            validarCampo(this);
        });
    });

    // Buscar beneficiarios con delay
    const inputBusqueda = document.querySelector('input[name="termino_busqueda"]');
    if (inputBusqueda) {
        let timeout;
        inputBusqueda.addEventListener('keyup', function(e) {
            clearTimeout(timeout);
            if (this.value.length >= 2) {
                // Mostrar indicador de búsqueda
                mostrarIndicadorBusqueda();
            }
        });
    }
}

/**
 * Valida un campo del formulario
 */
function validarCampo(campo) {
    const tipo = campo.type;
    const valor = campo.value.trim();

    switch (tipo) {
        case 'text':
            if (campo.name === 'nombre' || campo.name === 'apellidos') {
                if (valor.length < 2) {
                    campo.classList.add('error');
                    mostrarError(campo, 'Mínimo 2 caracteres');
                    return false;
                } else {
                    campo.classList.remove('error');
                    limpiarError(campo);
                }
            }
            break;

        case 'email':
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (valor && !emailRegex.test(valor)) {
                campo.classList.add('error');
                mostrarError(campo, 'Email no válido');
                return false;
            } else {
                campo.classList.remove('error');
                limpiarError(campo);
            }
            break;

        case 'tel':
            if (valor && valor.length < 7) {
                campo.classList.add('error');
                mostrarError(campo, 'Teléfono no válido');
                return false;
            } else {
                campo.classList.remove('error');
                limpiarError(campo);
            }
            break;

        case 'number':
            if (campo.name === 'tamaño_familiar' || campo.name === 'cantidad') {
                if (isNaN(valor) || parseInt(valor) < 1) {
                    campo.classList.add('error');
                    mostrarError(campo, 'Valor debe ser mayor a 0');
                    return false;
                } else {
                    campo.classList.remove('error');
                    limpiarError(campo);
                }
            }
            break;
    }

    return true;
}

/**
 * Muestra un mensaje de error bajo un campo
 */
function mostrarError(campo, mensaje) {
    let errorDiv = campo.nextElementSibling;
    if (!errorDiv || !errorDiv.classList.contains('error-message')) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        campo.parentNode.insertBefore(errorDiv, campo.nextSibling);
    }
    errorDiv.textContent = mensaje;
    errorDiv.style.display = 'block';
}

/**
 * Limpia el mensaje de error de un campo
 */
function limpiarError(campo) {
    let errorDiv = campo.nextElementSibling;
    if (errorDiv && errorDiv.classList.contains('error-message')) {
        errorDiv.style.display = 'none';
    }
}

/**
 * Muestra indicador de búsqueda
 */
function mostrarIndicadorBusqueda() {
    const container = document.querySelector('.search-input-group');
    let spinner = container.querySelector('.search-spinner');
    
    if (!spinner) {
        spinner = document.createElement('div');
        spinner.className = 'search-spinner';
        spinner.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        container.appendChild(spinner);
    }
}

/**
 * Agrega un nuevo producto al formulario de asignación
 */
function agregarProducto() {
    const container = document.getElementById('productos-container');
    const index = container.children.length;

    const productoDiv = document.createElement('div');
    productoDiv.className = 'producto-item';
    productoDiv.innerHTML = `
        <input type="text" name="productos[${index}][nombre]" class="form-input" placeholder="Nombre del producto" required>
        <input type="number" name="productos[${index}][cantidad]" class="form-input" placeholder="Cantidad" min="1" required>
        <button type="button" class="btn btn-danger" onclick="removerProducto(this)">
            <i class="fas fa-trash"></i>
        </button>
    `;

    container.appendChild(productoDiv);

    // Agregar validación al nuevo input
    const inputs = productoDiv.querySelectorAll('.form-input');
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            validarCampo(this);
        });
    });

    // Scroll al nuevo producto
    productoDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

/**
 * Remueve un producto del formulario de asignación
 */
function removerProducto(boton) {
    const container = document.getElementById('productos-container');
    
    // No permitir eliminar el último producto
    if (container.children.length > 1) {
        boton.parentElement.remove();
        reindexarProductos();
    } else {
        alert('Debe haber al menos un producto');
    }
}

/**
 * Reindexar los productos después de eliminar uno
 */
function reindexarProductos() {
    const container = document.getElementById('productos-container');
    const items = container.querySelectorAll('.producto-item');

    items.forEach((item, index) => {
        const inputs = item.querySelectorAll('input');
        inputs[0].name = `productos[${index}][nombre]`;
        inputs[1].name = `productos[${index}][cantidad]`;
    });
}

/**
 * Validar formulario de asignación antes de enviar
 */
document.addEventListener('submit', function(e) {
    const form = e.target;

    // Validar formulario de asignación
    if (form.id === 'form-asignacion') {
        const puntoDistribucion = form.querySelector('#punto_distribucion_id');
        const productosContainer = document.getElementById('productos-container');

        if (!puntoDistribucion.value) {
            e.preventDefault();
            alert('Selecciona un punto de distribución');
            return;
        }

        const productos = productosContainer.querySelectorAll('.producto-item');
        let productosValidos = true;

        productos.forEach(producto => {
            const nombre = producto.querySelector('input[name*="[nombre]"]');
            const cantidad = producto.querySelector('input[name*="[cantidad]"]');

            if (!nombre.value.trim() || !cantidad.value) {
                productosValidos = false;
            }
        });

        if (!productosValidos) {
            e.preventDefault();
            alert('Todos los productos deben tener nombre y cantidad');
            return;
        }
    }

    // Validación general de formularios
    const inputs = form.querySelectorAll('.form-input[required]');
    let formularioValido = true;

    inputs.forEach(input => {
        if (input.style.display !== 'none') {
            if (!validarCampo(input)) {
                formularioValido = false;
            }
        }
    });

    if (!formularioValido) {
        e.preventDefault();
    }
});

/**
 * Función para generar comprobante en PDF (opcional)
 */
function generarComprobantePDF() {
    const beneficiarioNombre = document.querySelector('.details-header h2')?.textContent || 'Beneficiario';
    const fecha = new Date().toLocaleDateString('es-ES');
    
    const contenido = `
Comprobante de Asignación de Productos
======================================

Beneficiario: ${beneficiarioNombre}
Fecha: ${fecha}

Productos Asignados:
${obtenerDetallesProductos()}

Generado por el Sistema de Gestión de Beneficiarios
    `;

    // Crear blob y descargar
    const blob = new Blob([contenido], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `comprobante_${beneficiarioNombre}_${fecha}.txt`;
    a.click();
    window.URL.revokeObjectURL(url);
}

/**
 * Obtiene los detalles de los productos de la tabla
 */
function obtenerDetallesProductos() {
    const tabla = document.querySelector('.beneficiarios-table');
    if (!tabla) return '';

    const filas = tabla.querySelectorAll('tbody tr');
    let detalles = '';

    filas.forEach((fila, index) => {
        const celdas = fila.querySelectorAll('td');
        detalles += `${index + 1}. ${celdas[0]?.textContent} - Cantidad: ${celdas[1]?.textContent}\n`;
    });

    return detalles;
}

/**
 * Formato de números con separador de miles
 */
function formatearNumero(numero) {
    return new Intl.NumberFormat('es-ES').format(numero);
}

/**
 * Mostrar confirmación antes de acciones críticas
 */
function confirmarAccion(mensaje) {
    return confirm(mensaje);
}

/**
 * Exportar tabla a CSV
 */
function exportarTablaCSV(nombreArchivo = 'beneficiarios.csv') {
    const tabla = document.querySelector('.beneficiarios-table');
    if (!tabla) return;

    let csv = [];
    
    // Headers
    const headers = Array.from(tabla.querySelectorAll('thead th')).map(h => h.textContent);
    csv.push(headers.join(','));

    // Filas
    const filas = tabla.querySelectorAll('tbody tr');
    filas.forEach(fila => {
        const celdas = Array.from(fila.querySelectorAll('td')).map(c => c.textContent);
        csv.push(celdas.join(','));
    });

    // Descargar
    const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', nombreArchivo);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Exportar funciones globales
window.agregarProducto = agregarProducto;
window.removerProducto = removerProducto;
window.generarComprobantePDF = generarComprobantePDF;
window.exportarTablaCSV = exportarTablaCSV;
window.confirmarAccion = confirmarAccion;
