# Manual de Usuario - Gestión de Voluntarios

## Introducción

Este manual describe cómo usar el módulo de Gestión de Voluntarios del Sistema de Banco de Alimentos.

---

## Acceso al Sistema

1. Abre tu navegador web
2. Ingresa la URL: `http://localhost/Sprint1%20-%202/src/www/vistas/html/gestion_voluntarios.html`
3. Verás la interfaz de gestión de voluntarios

---

## Interfaz Principal

La pantalla principal contiene:
- **Título:** "Gestión de Voluntarios"
- **Botón "Agregar Voluntario":** Verde, en la parte superior
- **Tabla:** Listado de todos los voluntarios registrados
- **Controles:** Editar (amarillo) y Eliminar (rojo) para cada voluntario

---

## Operaciones Principales

### 1. Agregar Nuevo Voluntario

1. Haz clic en el botón **"Agregar Voluntario"** (verde)
2. Se abrirá un formulario modal con los campos:
   - **Nombre:** Nombre completo del voluntario (obligatorio)
   - **Teléfono:** Número de contacto (obligatorio, solo números)
   - **Horas Disponibles:** Cantidad de horas que puede trabajar (obligatorio)
   - **Habilidades:** Descripción de sus capacidades (opcional)

3. Completa los campos requeridos
4. Haz clic en **"Guardar"**
5. Verás un mensaje de confirmación
6. El voluntario aparecerá en la tabla automáticamente

**Ejemplo:**
- Nombre: Juan Pérez García
- Teléfono: 654456789
- Horas: 20
- Habilidades: Cocina, Organización

---

### 2. Editar Voluntario

1. En la tabla, encuentra el voluntario que deseas editar
2. Haz clic en el botón **"Editar"** (amarillo) en la fila correspondiente
3. Se abrirá el formulario con los datos actuales
4. Modifica los campos que necesites
5. Haz clic en **"Guardar"**
6. Los cambios se aplicarán automáticamente

---

### 3. Eliminar Voluntario

1. En la tabla, encuentra el voluntario a eliminar
2. Haz clic en el botón **"Eliminar"** (rojo) en la fila correspondiente
3. Aparecerá un mensaje de confirmación: "¿Estás seguro?"
4. Haz clic en **"Sí"** para confirmar o **"No"** para cancelar
5. El voluntario se eliminará de la base de datos

---

### 4. Buscar Voluntario

1. En la parte superior, existe un campo de búsqueda
2. Escribe el nombre del voluntario que buscas
3. La tabla se filtrará automáticamente mostrando coincidencias
4. Escribe "Todas" o borra el campo para ver todos nuevamente

---

## Validaciones

El sistema valida automáticamente:

✓ **Nombre:** No puede estar vacío  
✓ **Teléfono:** Solo acepta números (9-15 dígitos)  
✓ **Horas:** Solo acepta números positivos  
✓ **Duplicados:** No permite registrar el mismo DNI dos veces (si aplica)

Si hay error, aparecerá un mensaje rojo indicando el problema.

---

## Tabla de Voluntarios

La tabla muestra:
| Columna | Descripción |
|---------|-------------|
| ID | Identificador único |
| Nombre | Nombre completo |
| Teléfono | Número de contacto |
| Horas Disponibles | Total de horas |
| Habilidades | Competencias |
| Acciones | Botones Editar/Eliminar |

---

## Paginación

Si hay muchos voluntarios:
- La tabla se divide en páginas de 10 registros
- En la parte inferior aparecerán números de página
- Haz clic en el número para cambiar de página

---

## Mensajes del Sistema

| Tipo | Significado |
|------|-------------|
| ✅ Verde | Operación exitosa |
| ⚠️ Amarillo | Advertencia o confirmación |
| ❌ Rojo | Error, revisa los datos |

---

## Consejos Útiles

💡 **Habilidades:** Usa comas para separar múltiples habilidades  
💡 **Teléfono:** Incluye el código de país si es internacional  
💡 **Horas:** Registra horas por semana o disponibilidad mensual  
💡 **Búsqueda:** Funciona con partes del nombre también

---

## Solución de Problemas

### "El formulario no se abre"
- Actualiza la página (F5 o Ctrl+R)
- Verifica que JavaScript esté habilitado en tu navegador

### "No puedo guardar datos"
- Revisa que todos los campos obligatorios estén completos
- Verifica que el teléfono contenga solo números
- Asegúrate que la conexión a la base de datos sea correcta

### "La tabla no se actualiza"
- Actualiza la página manualmente
- Borra el caché del navegador

---

## Contacto y Soporte

Para reportar problemas o sugerencias:
- Email: soporte@bancoalimentos.org
- Teléfono: +34 XXX XXX XXX
- Horario: Lunes a Viernes, 9:00 - 17:00

---

**Versión:** 1.0  
**Última actualización:** 16/12/2025
