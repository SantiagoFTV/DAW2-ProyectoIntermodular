## HU-01: Registro de Donaciones Entrantes

**Como** coordinador de donaciones  
**Quiero** registrar nuevas donaciones recibidas  
**Para** mantener un control preciso del inventario, ver las donaciones que se han realizado hasta ahora y poder realizar reportes.

### Criterios de Aceptación

1. El sistema debe permitir registrar una donación con los siguientes campos obligatorios:
   - Nombre del donante
   - Tipo de producto
   - Cantidad
   - Fecha de recepción
   - Fecha de caducidad (si aplica)

2. El sistema debe generar un identificador único para cada donación registrada.

3. Debe ser posible visualizar un historial de todas las donaciones registradas con opciones de filtrado por fecha, donante y tipo de producto.

4. El sistema debe actualizar automáticamente el inventario al registrar una nueva donación.

5. Debe mostrarse un mensaje de confirmación después de registrar exitosamente una donación.

6. El sistema debe validar que las cantidades ingresadas sean números positivos.

---