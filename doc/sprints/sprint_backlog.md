# Sprint Backlog - Desglose por Módulos

## Tabla de Contenidos
- [Sprint 1: Fundamentos y Autenticación](#sprint-1-fundamentos-y-autenticación)
- [Sprint 2: Gestión de Beneficiarios](#sprint-2-gestión-de-beneficiarios)
- [Sprint 3: Gestión de Voluntarios](#sprint-3-gestión-de-voluntarios)
- [Sprint 4: Puntos de Distribución](#sprint-4-puntos-de-distribución)
- [Sprint 5: Sistema de Alertas](#sprint-5-sistema-de-alertas)
- [Sprint 6: Reportes y Análisis](#sprint-6-reportes-y-análisis)
- [Sprint 7: Notificaciones Multi-canal](#sprint-7-notificaciones-multi-canal)
- [Sprint 8: App Móvil](#sprint-8-app-móvil)

---

## Sprint 1: Fundamentos y Autenticación

**Duración:** 2 semanas  
**Objetivo:** Establecer la arquitectura base, autenticación y autorización  
**Estado:** COMPLETADO

### Historias de Usuario

#### HU-00: Configuración Inicial del Proyecto
**Puntos:** 5  
**Prioridad:** CRÍTICA  

| Tarea | Descripción | Estado |
|-------|-------------|--------|
| T-001 | Configurar estructura MVC en PHP | Completada |
| T-002 | Crear clase BD con PDO | Completada |
| T-003 | Configurar config.php con rutas | Completada |
| T-004 | Implementar autoloader de clases | Completada |
| T-005 | Crear router (index.php) | Completada |

#### HU-01: Sistema de Autenticación y Login
**Puntos:** 8  
**Prioridad:** CRÍTICA  
**Descripción:** Como usuario, quiero poder acceder al sistema con mis credenciales

| Tarea | Descripción | Estado |
|-------|-------------|--------|
| T-006 | Crear clase Sesion.php | Completada |
| T-007 | Implementar método login() | Completada |
| T-008 | Implementar método logout() | Completada |
| T-009 | Crear ControladorAuth | Completada |
| T-010 | Diseñar login.html | Completada |
| T-011 | Validar sesión en index.php | Completada |
| T-012 | Crear manejo de errores de autenticación | Completada |

#### HU-02: Control de Acceso Basado en Roles (RBAC)
**Puntos:** 5  
**Prioridad:** CRÍTICA  
**Descripción:** Como administrador, quiero que los usuarios tengan diferentes niveles de acceso

| Tarea | Descripción | Estado |
|-------|-------------|--------|
| T-013 | Implementar roles (admin, usuario) | Completada |
| T-014 | Crear métodos esAdmin() y esUsuarioNormal() | Completada |
| T-015 | Validar permisos en index.php | Completada |
| T-016 | Restringir acceso a módulos por rol | Completada |
| T-017 | Implementar protección en vistas | Completada |

#### HU-03: Interfaz de Inicio (Home)
**Puntos:** 5  
**Prioridad:** ALTA  
**Descripción:** Como usuario, quiero ver un panel principal con acceso a los módulos

| Tarea | Descripción | Estado |
|-------|-------------|--------|
| T-018 | Diseñar home.html | Completada |
| T-019 | Crear grid de módulos | Completada |
| T-020 | Mostrar acceso condicional por rol | Completada |
| T-021 | Diseñar navbar reutilizable | Completada |
| T-022 | Implementar logout button | Completada |

**Criterios de Aceptación:**
- Usuario puede loguearse con credenciales válidas
- Sesión se mantiene entre páginas
- Logout destruye la sesión completamente
- Admin ve todos los módulos
- Usuario normal ve solo módulos permitidos
- Acceso no autorizado redirige a login

---

## Sprint 2: Gestión de Beneficiarios

**Duración:** 2 semanas  
**Objetivo:** Implementar CRUD completo para beneficiarios  
**Estado:** COMPLETADO

### HU-04: Registro y Validación de Beneficiarios
**Puntos:** 8  
**Prioridad:** CRÍTICA  
**Descripción:** Como operario, quiero registrar beneficiarios con validación de datos

#### Tareas

| ID | Tarea | Descripción | Subtareas | Estado |
|----|-------|-------------|-----------|--------|
| T-023 | Crear modelo Beneficiario | Clase con propiedades y métodos CRUD | 1. Crear clase<br>2. Propiedades privadas<br>3. Constructor<br>4. Getters/Setters | ✅ |
| T-024 | Crear BD Beneficiarios | Tabla con campos necesarios | 1. Script SQL<br>2. Ejecutar en MariaDB<br>3. Verificar estructura | ✅ |
| T-025 | Implementar método listar() | SELECT * FROM beneficiarios | 1. Query preparada<br>2. Fetchall objetos<br>3. Manejo de errores | ✅ |
| T-026 | Implementar método crear() | INSERT INTO beneficiarios | 1. Validar entrada<br>2. Preprar SQL<br>3. Ejecutar<br>4. Retornar ID | ✅ |
| T-027 | Crear ControladorBeneficiario | Controller para acciones | 1. listar()<br>2. crear()<br>3. guardar()<br>4. eliminar() | ✅ |
| T-028 | Diseñar gestion_beneficiarios.html | Interfaz con tabla y formulario | 1. Tabla con datos<br>2. Formulario de creación<br>3. Búsqueda<br>4. Botones de acción | ✅ |
| T-029 | Implementar búsqueda de beneficiarios | Búsqueda por nombre/ID | 1. Input de búsqueda<br>2. Query con LIKE<br>3. Resultados dinámicos | ✅ |
| T-030 | Validar campos requeridos | Validación en cliente y servidor | 1. HTML5 required<br>2. PHP isset() y trim()<br>3. Mensajes de error | ✅ |

#### Campos de Beneficiario

```sql
- id (PK)
- nombre (VARCHAR 255) - Requerido
- apellidos (VARCHAR 255) - Requerido
- numero_identificacion (VARCHAR 50) - Único
- telefono (VARCHAR 50) - Contacto
- email (VARCHAR 100) - Contacto
- tamaño_familiar (INT) - Núcleo familiar
- direccion (TEXT) - Ubicación
- necesidades (TEXT) - Necesidades especiales
- estado_validacion (ENUM: validado/pendiente) - Control de calidad
- fecha_ultima_asignacion (DATETIME) - Seguimiento
- created_at (TIMESTAMP) - Auditoría
```

**Criterios de Aceptación:**
- Crear beneficiario con validación de datos
- Listar todos los beneficiarios paginados
- Buscar beneficiario por nombre/ID
- Ver detalles de beneficiario
- Editar información de beneficiario (solo admin)
- Eliminar beneficiario (solo admin)
- Usuario normal solo ve lista

---

### HU-05: Asignación Inteligente de Productos
**Puntos:** 13  
**Prioridad:** ALTA  
**Descripción:** Como sistema, quiero asignar productos a beneficiarios inteligentemente

#### Tareas

| ID | Tarea | Descripción | Estado |
|----|-------|-------------|--------|
| T-031 | Crear tabla asignaciones_productos | Registro de asignaciones | Completada |
| T-032 | Implementar lógica de asignación | Algoritmo por necesidad | Pendiente |
| T-033 | Crear historial de asignaciones | Seguimiento de entregas | Pendiente |
| T-034 | Validar cantidad disponible | Stock de productos | Pendiente |
| T-035 | Generar reportes de asignación | Análisis de distribución | Pendiente |

**Algoritmo de Asignación:**
```
1. Obtener beneficiarios no asignados recientemente
2. Calcular necesidad: tamaño_familiar * días_sin_asignación
3. Ordenar por necesidad descendente
4. Asignar productos según disponibilidad
5. Registrar en asignaciones_productos
6. Actualizar fecha_ultima_asignacion
```

---

## Sprint 3: Gestión de Voluntarios

**Duración:** 1.5 semanas  
**Objetivo:** Implementar registro y gestión de voluntarios  
**Estado:** COMPLETADO

### HU-09: Gestión de Voluntarios
**Puntos:** 8  
**Prioridad:** ALTA  
**Descripción:** Como responsable, quiero gestionar el equipo de voluntarios

#### Tareas

| ID | Tarea | Descripción | Subtareas | Estado |
|----|-------|-------------|-----------|--------|
| T-036 | Crear modelo Voluntario | Clase de voluntario | 1. Constructor<br>2. Propiedades<br>3. Métodos CRUD | Completada |
| T-037 | Crear BD voluntarios_db | Tabla en MariaDB | 1. SQL script<br>2. Ejecutar<br>3. Verificar | Completada |
| T-038 | Implementar CRUD Voluntario | Operaciones básicas | 1. create()<br>2. read()<br>3. update()<br>4. delete() | Completada |
| T-039 | Crear ControladorVoluntario | Controller | 1. listar()<br>2. crear()<br>3. guardar()<br>4. eliminar() | Completada |
| T-040 | Diseñar gestion_voluntarios.html | Interfaz | 1. Tabla<br>2. Formulario<br>3. Búsqueda | Completada |
| T-041 | Validar datos de voluntario | Validación entrada | 1. Cliente<br>2. Servidor<br>3. Errores | Completada |
| T-042 | Corrección: tipo TELEFONO | Convertir a INT | 1. Alter table<br>2. Cast en insert | Completada |

#### Campos de Voluntario

```sql
- id (PK)
- nombre (VARCHAR 255) - Requerido
- telefono (INT) - Contacto
- horas_disponibles (VARCHAR 255) - Disponibilidad
- habilidades (VARCHAR 255) - Competencias
```

**Criterios de Aceptación:**
- Crear voluntario sin errores de tipo
- Listar voluntarios activos
- Buscar por nombre
- Editar datos de voluntario
- Eliminar voluntario

---

## Sprint 4: Puntos de Distribución

**Duración:** 1.5 semanas  
**Objetivo:** Gestionar ubicaciones de distribución con mapas  
**Estado:** COMPLETADO

### HU-06: Gestión de Puntos de Distribución
**Puntos:** 10  
**Prioridad:** ALTA  
**Descripción:** Como coordinador, quiero gestionar puntos de distribución con ubicación geográfica

#### Tareas

| ID | Tarea | Descripción | Subtareas | Estado |
|----|-------|-------------|-----------|--------|
| T-043 | Crear modelo PuntoDistribucion | Clase punto | 1. Constructor<br>2. Propiedades<br>3. CRUD | Completada |
| T-044 | Crear BD puntos_distribucion | Tabla con geolocalización | 1. Script SQL<br>2. Campos lat/lon<br>3. Indices | Completada |
| T-045 | Implementar CRUD punto | Operaciones | 1. Create<br>2. Read<br>3. Update<br>4. Delete | Completada |
| T-046 | Crear ControladorPuntoDistribucion | Controller | 1. listar()<br>2. crear()<br>3. eliminar() | Completada |
| T-047 | Diseñar vista con mapa | Interfaz HTML | 1. Tabla puntos<br>2. Mapa interactivo<br>3. Formulario | Completada |
| T-048 | Integrar API de mapas | Google Maps o similar | 1. API key<br>2. Mostrar puntos<br>3. Marcadores | Completada |
| T-049 | Búsqueda por ubicación | Búsqueda geográfica | 1. Input búsqueda<br>2. Query LIKE<br>3. Filtrar resultados | Completada |
| T-050 | Restringir creación a admin | Solo admin crea puntos | 1. if ($esAdmin)<br>2. Ocultar formulario<br>3. Validar en backend | Completada |

#### Campos de Punto de Distribución

```sql
- id (PK)
- nombre (VARCHAR 255) - Requerido
- direccion (TEXT) - Ubicación exacta
- responsable (VARCHAR 255) - Encargado
- telefono (VARCHAR 50) - Contacto
- latitud (DECIMAL 10,6) - Ubicación GPS
- longitud (DECIMAL 10,6) - Ubicación GPS
- horario (VARCHAR 255) - Horarios de atención
- descripcion (TEXT) - Información adicional
- created_at (DATETIME)
```

**Criterios de Aceptación:**
- Crear punto con validación de ubicación
- Listar puntos con tabla
- Mostrar mapa con marcadores
- Búsqueda por nombre/zona
- Ver horarios de atención
- Solo admin puede crear/editar/eliminar
- Usuario normal solo visualiza

---

## Sprint 5: Sistema de Alertas

**Duración:** 2 semanas  
**Objetivo:** Implementar alertas de caducidad y control de calidad  
**Estado:** EN PROGRESO

### HU-02: Sistema de Alertas de Caducidad
**Puntos:** 10  
**Prioridad:** CRÍTICA  
**Descripción:** Como gestor, quiero recibir alertas de productos próximos a caducar

#### Tareas

| ID | Tarea | Descripción | Subtareas | Estado |
|----|-------|-------------|-----------|--------|
| T-051 | Crear modelo AlertaCaducidad | Clase alerta | 1. Propiedades<br>2. Constructor<br>3. Métodos | Completada |
| T-052 | Crear BD alertas_caducidad | Tabla con fechas | 1. Script SQL<br>2. Relación con puntos<br>3. Índices en fecha | Completada |
| T-053 | Implementar cálculo de días restantes | DATEDIFF SQL | 1. Función en SQL<br>2. Lógica en PHP<br>3. Categorizar estado | Completada |
| T-054 | Categorizar alertas por urgencia | Estados: ok/proximo/urgente/critico/caducado | 1. Crear enums<br>2. Colores CSS<br>3. Iconos visuales | Completada |
| T-055 | Crear ControladorAlertaCaducidad | Controller | 1. listar()<br>2. listarPorEstado()<br>3. cambiarEstado() | Completada |
| T-056 | Diseñar gestion_alertas_caducidad.html | Vista con tabla coloreada | 1. Tabla dinámica<br>2. Colores por estado<br>3. Indicadores visuales | Completada |
| T-057 | Crear dashboard de alertas | Vista rápida de críticas | 1. Widget urgentes<br>2. Gráfico de estados<br>3. Últimas alertas | Pendiente |
| T-058 | Implementar filtros por estado | Filtrar alertas | 1. Botones estado<br>2. Query condicional<br>3. Resulados dinámicos | Completada |

#### Estados de Alerta

```
OK: Más de 30 días para expiración (Verde: #68D391)
PRÓXIMO: 15-30 días (Amarillo: #ECC94B)
URGENTE: 7-15 días (Naranja: #ED8936)
CRÍTICO: 1-7 días (Rojo oscuro: #C53030)
CADUCADO: Pasada la fecha (Rojo: #E53E3E)
```

#### Fórmula de Cálculo

```php
$diasRestantes = ceil((strtotime($fecha_expiracion) - time()) / 86400);

if ($diasRestantes < 0) {
    $estado = 'CADUCADO';
} elseif ($diasRestantes <= 7) {
    $estado = 'CRITICO';
} elseif ($diasRestantes <= 15) {
    $estado = 'URGENTE';
} elseif ($diasRestantes <= 30) {
    $estado = 'PROXIMO';
} else {
    $estado = 'OK';
}
```

**Criterios de Aceptación:**
- Listar todas las alertas
- Mostrar días restantes automáticamente
- Color de fondo según urgencia
- Filtrar por estado
- Solo admin puede gestionar
- Datos realistas desde CSV

---

### HU-08: Control de Calidad de Productos
**Puntos:** 8  
**Prioridad:** ALTA  
**Descripción:** Como supervisor, quiero validar la calidad de productos

#### Tareas

| ID | Tarea | Descripción | Estado |
|----|-------|-------------|--------|
| T-059 | Crear modelo ControlCalidad | Clase de control | Pendiente |
| T-060 | Crear BD control_calidad | Tabla de inspecciones | Pendiente |
| T-061 | Implementar formulario de inspección | Checklist de calidad | Pendiente |
| T-062 | Generar reportes de calidad | Análisis de rechazo | Pendiente |
| T-063 | Integrar con alertas de caducidad | Rechazar caducados | Pendiente |

---

## Sprint 6: Reportes y Análisis

**Duración:** 2 semanas  
**Objetivo:** Crear reportes avanzados y análisis de datos  
**Estado:** NO INICIADO

### HU-05: Generación de Reportes Avanzados
**Puntos:** 13  
**Prioridad:** MEDIA  
**Descripción:** Como gestor, quiero reportes detallados del sistema

#### Tareas

| ID | Tarea | Descripción | Estado |
|----|-------|-------------|--------|
| T-064 | Crear clase ReporteGenerador | Base para reportes | Pendiente |
| T-065 | Reporte de Distribución | Productos por punto | Pendiente |
| T-066 | Reporte de Beneficiarios | Análisis por zona | Pendiente |
| T-067 | Reporte de Voluntarios | Horas y asignaciones | Pendiente |
| T-068 | Exportar a Excel | CSV/XLSX | Pendiente |
| T-069 | Exportar a PDF | Reportes formalizados | Pendiente |
| T-070 | Crear dashboard visual | Gráficos con Chart.js | Pendiente |
| T-071 | Reportes por fecha | Rango personalizado | Pendiente |

#### Tipos de Reportes

```
1. Distribución de Productos
   ├─ Por punto de distribución
   ├─ Por beneficiario
   └─ Por período

2. Análisis de Beneficiarios
   ├─ Demográfico
   ├─ Geográfico
   └─ Necesidades

3. Actividad de Voluntarios
   ├─ Horas trabajadas
   ├─ Asignaciones
   └─ Productividad

4. Inventario
   ├─ Stock actual
   ├─ Caducidad próxima
   └─ Rotación
```

---

## Sprint 7: Notificaciones Multi-canal

**Duración:** 2 semanas  
**Objetivo:** Sistema de notificaciones por múltiples canales  
**Estado:** NO INICIADO

### HU-07: Sistema de Notificaciones Multi-canal
**Puntos:** 13  
**Prioridad:** MEDIA  
**Descripción:** Como usuario, quiero recibir notificaciones de eventos importantes

#### Tareas

| ID | Tarea | Descripción | Estado |
|----|-------|-------------|--------|
| T-072 | Crear modelo Notificacion | Clase base | Pendiente |
| T-073 | Implementar notificaciones por email | SMTP | Pendiente |
| T-074 | Implementar notificaciones por SMS | Twilio o similar | Pendiente |
| T-075 | Implementar notificaciones en app | Push notifications | Pendiente |
| T-076 | Crear tabla notificaciones | BD de historial | Pendiente |
| T-077 | Crear panel de preferencias | Usuario elige canales | Pendiente |
| T-078 | Implementar colas de notificación | Para envío asíncrono | Pendiente |

#### Eventos que Notifican

```
- Alerta de caducidad próxima
  └─ Email + SMS (admin)

- Nueva asignación de producto
  └─ Email (beneficiario)

- Voluntario registrado
  └─ Email (coordinador)

- Beneficiario validado
  └─ Email (beneficiario)

- Punto de distribución próximo
  └─ Email (usuarios cercanos)
```

---

## Sprint 8: App Móvil

**Duración:** 3 semanas  
**Objetivo:** Aplicación móvil para beneficiarios  
**Estado:** NO INICIADO

### HU-10: App Móvil para Beneficiarios
**Puntos:** 21  
**Prioridad:** BAJA  
**Descripción:** Como beneficiario, quiero acceder desde mi móvil

#### Tareas

| ID | Tarea | Descripción | Estado |
|----|-------|-------------|--------|
| T-079 | Crear API REST | Endpoints JSON | Pendiente |
| T-080 | Documentar API | OpenAPI/Swagger | Pendiente |
| T-081 | Implementar autenticación API | JWT tokens | Pendiente |
| T-082 | Crear app en React Native | Cross-platform | Pendiente |
| T-083 | Pantalla de login móvil | Autenticación | Pendiente |
| T-084 | Ver asignaciones pendientes | Historial personal | Pendiente |
| T-085 | Ubicar puntos de distribución | Mapa interactivo | Pendiente |
| T-086 | Ver horarios de atención | Filtrar por zona | Pendiente |
| T-087 | Notificaciones push | Recordatorios | Pendiente |
| T-088 | Testing en dispositivos | QA mobile | Pendiente |

#### Características Móviles

```
Beneficiario:
├─ Ver próxima asignación
├─ Historial de entregas
├─ Ubicar puntos cercanos
├─ Ver horarios
├─ Contactar coordinador
└─ Recibir notificaciones

Admin:
├─ Dashboard de alerts
├─ Registrar actividades
├─ Validar entrega
├─ Fotos de conformidad
└─ Reportes rápidos
```

---

## Resumen de Progreso

### Sprints Completados

```
Sprint 1: Fundamentos y Autenticación     100%
  5 tareas completadas
  23 subtareas completadas
  Puntos totales: 18

Sprint 2: Gestión de Beneficiarios        100%
  2 HUs completadas
  15 tareas completadas
  Puntos totales: 16

Sprint 3: Gestión de Voluntarios          100%
  1 HU completada
  7 tareas completadas
  Puntos totales: 8

Sprint 4: Puntos de Distribución          100%
  1 HU completada
  8 tareas completadas
  Puntos totales: 10

Sprint 5: Sistema de Alertas              85%
  2 HUs en progreso
  16 tareas: 14 completadas, 2 pendientes
  Puntos totales: 18
```

### Sprints Pendientes

```
Sprint 6: Reportes y Análisis             0%
  1 HU pendiente
  8 tareas por realizar
  Puntos totales: 13

Sprint 7: Notificaciones Multi-canal      0%
  1 HU pendiente
  7 tareas por realizar
  Puntos totales: 13

Sprint 8: App Móvil                       0%
  1 HU pendiente
  10 tareas por realizar
  Puntos totales: 21
```

### Velocidad del Equipo

```
Sprint 1: 18 puntos/semana
Sprint 2: 16 puntos/2 semanas = 8 puntos/semana
Sprint 3: 8 puntos/1.5 semanas = 5.3 puntos/semana
Sprint 4: 10 puntos/1.5 semanas = 6.7 puntos/semana
Sprint 5: 15.3 puntos/2 semanas (proyectado)

Promedio: ~8.8 puntos/semana
```

### Resumen Total

```
Completado:     70 puntos (66%)
En Progreso:    15 puntos (14%)
Pendiente:      47 puntos (20%)
────────────────────────────
Total:         132 puntos
```

---

## Próximos Pasos

### Inmediato (Sprint 5 - Completar)
- [ ] Crear dashboard de alertas
- [ ] Implementar notificaciones en sistema

### Corto Plazo (Sprint 6)
- [ ] Iniciar desarrollo de reportes
- [ ] Crear exportación a Excel/PDF

### Mediano Plazo (Sprint 7)
- [ ] Implementar sistema de notificaciones
- [ ] Integrar con SMTP/SMS

### Largo Plazo (Sprint 8)
- [ ] Desarrollar API REST
- [ ] Crear app móvil React Native

---

**Última actualización:** 17 de Enero, 2026  
**Versión:** 1.0  
**Estado:** En Progreso - Sprint 5 activo
