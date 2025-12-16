## HU-04: Registro y Validación de Beneficiarios

**Como** administrador del sistema  
**Quiero** registrar y validar nuevos beneficiarios  
**Para** mantener integridad en la ayuda. Los beneficiarios pueden subir archivos con sus documentos para tener su información, además se mostrará datos acerca de la entrevista que tuvieron para poder acceder a las ayudas.

### Criterios de Aceptación

1. El formulario de registro debe incluir campos para:
   - Datos personales (nombre, apellidos, DNI, fecha de nacimiento)
   - Datos de contacto (teléfono, email, dirección)
   - Composición familiar
   - Situación socioeconómica

2. El sistema debe permitir subir documentos en formatos PDF, JPG o PNG con un tamaño máximo de 5MB por archivo.

3. Debe existir un apartado para registrar información de la entrevista inicial:
   - Fecha de entrevista
   - Entrevistador
   - Notas relevantes
   - Estado de validación

4. Los beneficiarios deben tener tres estados posibles: "Pendiente", "Validado" y "Rechazado".

5. Solo administradores autorizados pueden cambiar el estado de validación.

6. El sistema debe enviar una notificación al beneficiario cuando su solicitud sea procesada.

---