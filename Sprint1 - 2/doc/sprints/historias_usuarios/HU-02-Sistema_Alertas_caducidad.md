## HU-02: Sistema de Alertas de Caducidad

**Como** almacenista  
**Quiero** recibir alertas de productos próximos a caducar  
**Para** priorizar su distribución y evitar pérdidas. Quiero saber cuántos días faltan para que caduque, en qué lugar se encuentran los productos y qué cantidad es.

### Criterios de Aceptación

1. El sistema debe generar alertas automáticas para productos que caduquen en menos de 7 días.

2. La alerta debe mostrar:
   - Nombre del producto
   - Días restantes hasta la caducidad
   - Ubicación exacta en el almacén
   - Cantidad disponible
   - Identificador de lote/donación

3. Las alertas deben estar visibles en un panel principal al iniciar sesión.

4. El sistema debe permitir ordenar las alertas por urgencia (días restantes).

5. Debe ser posible marcar productos como "en proceso de distribución" para actualizar el estado de la alerta.

6. Las alertas deben actualizarse diariamente de forma automática.

---