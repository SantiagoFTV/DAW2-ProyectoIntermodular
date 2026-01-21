/**
 * JavaScript para Gestión de Donaciones
 * HU-01: Registro de Donaciones Entrantes
 */

// Auto-ocultar mensajes después de 5 segundos
document.addEventListener('DOMContentLoaded', function() {
    const mensaje = document.getElementById('mensaje');
    if (mensaje) {
        setTimeout(() => {
            mensaje.style.opacity = '0';
            mensaje.style.transition = 'opacity 0.5s';
            setTimeout(() => mensaje.remove(), 500);
        }, 5000);
    }
    
    // Establecer fecha actual por defecto en el campo de fecha de recepción
    const fechaRecepcionInput = document.getElementById('fecha_recepcion');
    if (fechaRecepcionInput) {
        const hoy = new Date();
        const año = hoy.getFullYear();
        const mes = String(hoy.getMonth() + 1).padStart(2, '0');
        const dia = String(hoy.getDate()).padStart(2, '0');
        fechaRecepcionInput.value = `${año}-${mes}-${dia}`;
    }
});

/**
 * Toggle del panel de filtros
 */
function toggleFiltros() {
    const panel = document.getElementById('filtrosPanel');
    if (panel.style.display === 'none' || panel.style.display === '') {
        panel.style.display = 'block';
    } else {
        panel.style.display = 'none';
    }
}

/**
 * Abre el modal para crear una nueva donación
 */
function abrirFormularioNuevo() {
    console.log('abrirFormularioNuevo() llamada');
    
    const modal = document.getElementById('modalDonacion');
    const form = document.getElementById('formDonacion');
    const titulo = document.getElementById('modalTitulo');
    
    console.log('Modal:', modal);
    console.log('Form:', form);
    console.log('Titulo:', titulo);
    
    if (!modal || !form || !titulo) {
        console.error('No se encontraron elementos del modal');
        alert('Error: No se encontraron elementos del modal. Verifica la consola.');
        return;
    }
    
    // Resetear formulario
    form.reset();
    form.action = 'index.php?controlador=Donacion&metodo=crear';
    titulo.textContent = 'Registrar Nueva Donación';
    
    console.log('Formulario reseteado');
    
    // Ocultar campo de estado (solo para edición)
    const estadoGroup = document.getElementById('estadoGroup');
    if (estadoGroup) {
        estadoGroup.style.display = 'none';
    }
    
    // Establecer fecha actual por defecto
    const fechaRecepcionInput = document.getElementById('fecha_recepcion');
    if (fechaRecepcionInput) {
        const hoy = new Date();
        const año = hoy.getFullYear();
        const mes = String(hoy.getMonth() + 1).padStart(2, '0');
        const dia = String(hoy.getDate()).padStart(2, '0');
        fechaRecepcionInput.value = `${año}-${mes}-${dia}`;
        console.log('Fecha establecida:', fechaRecepcionInput.value);
    }
    
    // Mostrar modal
    modal.style.display = 'flex';
    modal.classList.add('active');
    console.log('Modal mostrado, display:', modal.style.display);
}

/**
 * Edita una donación existente
 */
function editarDonacion(id) {
    const donacion = donacionesData.find(d => d.id === id);
    if (!donacion) {
        alert('Donación no encontrada');
        return;
    }
    
    const modal = document.getElementById('modalDonacion');
    const form = document.getElementById('formDonacion');
    const titulo = document.getElementById('modalTitulo');
    
    // Cambiar a modo edición
    form.action = 'index.php?controlador=Donacion&metodo=actualizar';
    titulo.textContent = 'Editar Donación';
    
    // Rellenar formulario
    document.getElementById('donacion_id').value = donacion.id;
    document.getElementById('nombre_donante').value = donacion.nombre_donante;
    document.getElementById('tipo_producto').value = donacion.tipo_producto;
    document.getElementById('cantidad').value = donacion.cantidad;
    document.getElementById('unidad_medida').value = donacion.unidad_medida;
    document.getElementById('fecha_recepcion').value = donacion.fecha_recepcion;
    document.getElementById('fecha_caducidad').value = donacion.fecha_caducidad || '';
    document.getElementById('punto_distribucion_id').value = donacion.punto_distribucion_id || '';
    document.getElementById('observaciones').value = donacion.observaciones || '';
    document.getElementById('estado').value = donacion.estado;
    
    // Mostrar campo de estado
    document.getElementById('estadoGroup').style.display = 'flex';
    
    // Mostrar modal
    modal.classList.add('active');
}

/**
 * Cierra el modal
 */
function cerrarModal() {
    const modal = document.getElementById('modalDonacion');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.remove('active');
    }
}

/**
 * Confirma la eliminación de una donación
 */
function confirmarEliminar(id) {
    const donacion = donacionesData.find(d => d.id === id);
    if (!donacion) {
        alert('Donación no encontrada');
        return;
    }
    
    const mensaje = `¿Está seguro que desea eliminar esta donación?\n\nDonante: ${donacion.nombre_donante}\nProducto: ${donacion.tipo_producto}\nCantidad: ${donacion.cantidad} ${donacion.unidad_medida}`;
    
    if (confirm(mensaje)) {
        window.location.href = `index.php?controlador=Donacion&metodo=eliminar&id=${id}`;
    }
}

/**
 * Validación del formulario antes de enviar
 */
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formDonacion');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Validar cantidad
            const cantidad = parseFloat(document.getElementById('cantidad').value);
            if (cantidad <= 0) {
                e.preventDefault();
                alert('La cantidad debe ser un número positivo mayor que 0');
                document.getElementById('cantidad').focus();
                return false;
            }
            
            // Validar fecha de caducidad si existe
            const fechaRecepcion = document.getElementById('fecha_recepcion').value;
            const fechaCaducidad = document.getElementById('fecha_caducidad').value;
            
            if (fechaCaducidad && fechaRecepcion) {
                const recepcion = new Date(fechaRecepcion);
                const caducidad = new Date(fechaCaducidad);
                
                if (caducidad < recepcion) {
                    e.preventDefault();
                    alert('La fecha de caducidad no puede ser anterior a la fecha de recepción');
                    document.getElementById('fecha_caducidad').focus();
                    return false;
                }
            }
            
            return true;
        });
    }
});

/**
 * Cerrar modal al hacer clic fuera de él
 */
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalDonacion');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                cerrarModal();
            }
        });
    }
});

/**
 * Cerrar modal con tecla ESC
 */
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModal();
    }
});

/**
 * Función auxiliar para formatear fechas
 */
function formatearFecha(fecha) {
    if (!fecha) return '';
    const d = new Date(fecha);
    const dia = String(d.getDate()).padStart(2, '0');
    const mes = String(d.getMonth() + 1).padStart(2, '0');
    const año = d.getFullYear();
    return `${dia}/${mes}/${año}`;
}

/**
 * Función auxiliar para calcular días hasta la caducidad
 */
function diasHastaCaducidad(fechaCaducidad) {
    if (!fechaCaducidad) return null;
    
    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0);
    
    const caducidad = new Date(fechaCaducidad);
    caducidad.setHours(0, 0, 0, 0);
    
    const diferencia = caducidad - hoy;
    const dias = Math.ceil(diferencia / (1000 * 60 * 60 * 24));
    
    return dias;
}

/**
 * Validación en tiempo real de cantidad
 */
document.addEventListener('DOMContentLoaded', function() {
    const cantidadInput = document.getElementById('cantidad');
    if (cantidadInput) {
        cantidadInput.addEventListener('input', function() {
            const valor = parseFloat(this.value);
            if (valor <= 0 && this.value !== '') {
                this.setCustomValidity('La cantidad debe ser mayor que 0');
            } else {
                this.setCustomValidity('');
            }
        });
    }
});
