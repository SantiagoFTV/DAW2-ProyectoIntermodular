# 📋 Casos de Uso - Sistema de Gestión del Banco de Alimentos

**Versión:** 1.0  
**Fecha:** 22 de Enero, 2026  
**Estado del Proyecto:** En Desarrollo

---

## Tabla de Contenidos

1. [Introducción](#introducción)
2. [Historias de Usuario](#historias-de-usuario)
3. [Casos de Uso Funcionales](#casos-de-uso-funcionales)
4. [Casos de Prueba por Sprint](#casos-de-prueba-por-sprint)
5. [Resumen de Cobertura](#resumen-de-cobertura)

---

## Introducción

Este documento describe todos los casos de uso del Sistema de Gestión del Banco de Alimentos. Se organizan en tres categorías:

- **Historias de Usuario (HU)**: Casos de uso principales del sistema desde la perspectiva del usuario
- **Casos de Uso Funcionales**: Funcionalidades específicas implementadas
- **Casos de Prueba (TC)**: Test cases ejecutados para validar el sistema

---

## Historias de Usuario

El proyecto cuenta con **10 Historias de Usuario** principales que representan los casos de uso fundamentales del sistema.

### HU-01: Registro de Donaciones Entrantes

**Estado:** Pendiente  
**Prioridad:** Alta  
**Descripción:** Como coordinador de donaciones, quiero registrar nuevas donaciones recibidas para mantener un control preciso del inventario y poder realizar reportes.

**Criterios de Aceptación:**
- Registrar donación con campos obligatorios (donante, tipo, cantidad, fechas)
- Generar identificador único para cada donación
- Visualizar historial con filtros por fecha, donante y tipo
- Actualizar inventario automáticamente
- Validar cantidades como números positivos

**Casos de Uso Derivados:**
- CU-01.1: Registrar nueva donación
- CU-01.2: Consultar historial de donaciones
- CU-01.3: Filtrar donaciones por criterios
- CU-01.4: Actualizar inventario

---

### HU-02: Sistema de Alertas de Caducidad

**Estado:** Completado ✓  
**Prioridad:** Alta  
**Descripción:** Como gestor de almacén, quiero recibir alertas automáticas de productos próximos a caducar para minimizar desperdicios.

**Criterios de Aceptación:**
- Alertas automáticas según días de antelación
- Clasificación por niveles de urgencia (crítico, urgente, normal)
- Vista de lista con productos próximos a vencer
- Sistema de notificaciones configurables
- Dashboard con estadísticas de caducidad

**Casos de Uso Derivados:**
- CU-02.1: Listar alertas de caducidad
- CU-02.2: Configurar umbrales de alerta
- CU-02.3: Ver detalles de alerta específica
- CU-02.4: Marcar alerta como gestionada

---

### HU-03: Asignación Inteligente a Beneficiarios

**Estado:** En Progreso (30%)  
**Prioridad:** Alta  
**Descripción:** Como sistema, quiero asignar productos a beneficiarios de forma inteligente basándome en necesidades y disponibilidad para optimizar la distribución.

**Criterios de Aceptación:**
- Algoritmo de asignación implementado
- Historial de asignaciones visible
- Validación de stock disponible
- Reportes de asignación generados
- Priorización por necesidad familiar
- Considerar fecha última asignación

**Casos de Uso Derivados:**
- CU-03.1: Ejecutar algoritmo de asignación
- CU-03.2: Ver historial de asignaciones
- CU-03.3: Validar disponibilidad de productos
- CU-03.4: Generar reporte de distribución

---

### HU-04: Registro y Validación de Beneficiarios

**Estado:** Completado ✓  
**Prioridad:** Alta  
**Descripción:** Como administrador del sistema, quiero registrar y validar nuevos beneficiarios para mantener integridad en la ayuda.

**Criterios de Aceptación:**
- Formulario con datos personales, contacto y situación socioeconómica
- Subir documentos (PDF, JPG, PNG, máx 5MB)
- Registrar información de entrevista inicial
- Estados: Pendiente, Validado, Rechazado
- Control de cambio de estado por admin
- Notificación al beneficiario

**Casos de Uso Derivados:**
- CU-04.1: Registrar nuevo beneficiario
- CU-04.2: Listar beneficiarios
- CU-04.3: Buscar beneficiario
- CU-04.4: Ver detalles de beneficiario
- CU-04.5: Actualizar información
- CU-04.6: Eliminar beneficiario
- CU-04.7: Cambiar estado de validación

---

### HU-05: Generación de Reportes Avanzados

**Estado:** Pendiente  
**Prioridad:** Media  
**Descripción:** Como director del banco de alimentos, quiero generar reportes avanzados con gráficos y análisis para tomar decisiones estratégicas.

**Criterios de Aceptación:**
- Reportes de donaciones recibidas
- Reportes de distribución a beneficiarios
- Análisis de productos más demandados
- Estadísticas de voluntarios activos
- Exportación en PDF y Excel
- Gráficos visuales interactivos

**Casos de Uso Derivados:**
- CU-05.1: Generar reporte de donaciones
- CU-05.2: Generar reporte de distribución
- CU-05.3: Analizar productos demandados
- CU-05.4: Exportar reportes

---

### HU-06: Gestión de Puntos de Distribución

**Estado:** Completado ✓  
**Prioridad:** Alta  
**Descripción:** Como coordinador logístico, quiero gestionar puntos de distribución físicos para optimizar la entrega de alimentos.

**Criterios de Aceptación:**
- Registrar puntos con ubicación GPS
- Mapa interactivo con marcadores
- Información de horarios y responsables
- Buscar y filtrar puntos
- CRUD completo para admin
- Vista de solo lectura para usuarios

**Casos de Uso Derivados:**
- CU-06.1: Crear punto de distribución
- CU-06.2: Listar puntos en mapa
- CU-06.3: Buscar punto por criterios
- CU-06.4: Actualizar información de punto
- CU-06.5: Eliminar punto de distribución

---

### HU-07: Sistema de Notificaciones Multi-canal

**Estado:** Pendiente  
**Prioridad:** Media  
**Descripción:** Como administrador, quiero enviar notificaciones a beneficiarios y voluntarios por múltiples canales para mejorar la comunicación.

**Criterios de Aceptación:**
- Notificaciones por email
- Notificaciones SMS
- Notificaciones push (app móvil)
- Plantillas personalizables
- Historial de notificaciones enviadas
- Programación de envíos

**Casos de Uso Derivados:**
- CU-07.1: Enviar notificación individual
- CU-07.2: Enviar notificación masiva
- CU-07.3: Crear plantilla de notificación
- CU-07.4: Ver historial de envíos

---

### HU-08: Control de Calidad de Productos

**Estado:** Pendiente  
**Prioridad:** Media  
**Descripción:** Como inspector de calidad, quiero registrar inspecciones de productos para garantizar la seguridad alimentaria.

**Criterios de Aceptación:**
- Formulario de inspección de calidad
- Registro fotográfico de productos
- Estados: Apto, Revisar, Rechazado
- Trazabilidad de inspecciones
- Alertas de productos rechazados
- Reportes de calidad

**Casos de Uso Derivados:**
- CU-08.1: Registrar inspección de calidad
- CU-08.2: Ver historial de inspecciones
- CU-08.3: Marcar producto como no apto
- CU-08.4: Generar reporte de calidad

---

### HU-09: Gestión de Voluntarios

**Estado:** Completado ✓  
**Prioridad:** Alta  
**Descripción:** Como coordinador de voluntarios, quiero gestionar el registro y asignación de voluntarios para optimizar los recursos humanos.

**Criterios de Aceptación:**
- Registrar voluntarios con datos personales y habilidades
- Vista de lista con todos los voluntarios
- Buscar y filtrar por habilidades y disponibilidad
- CRUD completo (crear, editar, eliminar)
- Validación de DNI único
- Solo acceso para admin

**Casos de Uso Derivados:**
- CU-09.1: Registrar nuevo voluntario
- CU-09.2: Listar voluntarios
- CU-09.3: Buscar voluntario
- CU-09.4: Actualizar información de voluntario
- CU-09.5: Eliminar voluntario

---

### HU-10: App Móvil para Beneficiarios

**Estado:** Pendiente  
**Prioridad:** Baja  
**Descripción:** Como beneficiario, quiero una aplicación móvil para consultar mis asignaciones y puntos de recogida.

**Criterios de Aceptación:**
- Login de beneficiarios
- Ver asignaciones actuales
- Ver historial de asignaciones
- Mapa de puntos de distribución
- Notificaciones push
- Actualizar datos de contacto

**Casos de Uso Derivados:**
- CU-10.1: Login en app móvil
- CU-10.2: Consultar asignaciones
- CU-10.3: Ver puntos cercanos
- CU-10.4: Recibir notificaciones

---

## Casos de Uso Funcionales

### Autenticación y Sesiones

#### CU-AUTH-01: Iniciar Sesión
**Actor:** Usuario (Admin/Usuario)  
**Precondiciones:** Usuario registrado en el sistema  
**Flujo Principal:**
1. Usuario accede a login.html
2. Ingresa credenciales (usuario/contraseña)
3. Sistema valida credenciales
4. Sistema crea sesión y redirige a home

**Flujo Alternativo:**
- Credenciales incorrectas: Mostrar mensaje de error

---

#### CU-AUTH-02: Cerrar Sesión
**Actor:** Usuario autenticado  
**Flujo Principal:**
1. Usuario hace clic en "Cerrar Sesión"
2. Sistema destruye sesión
3. Redirige a login.html

---

#### CU-AUTH-03: Verificar Permisos
**Actor:** Sistema  
**Precondiciones:** Usuario autenticado  
**Flujo Principal:**
1. Usuario intenta acceder a recurso
2. Sistema verifica rol del usuario
3. Si tiene permisos, permite acceso
4. Si no tiene permisos, muestra "Acceso Denegado"

---

### Gestión de Beneficiarios

#### CU-BEN-01: Crear Beneficiario
**Actor:** Administrador  
**Precondiciones:** Usuario autenticado como admin  
**Flujo Principal:**
1. Admin accede al módulo de beneficiarios
2. Completa formulario con datos requeridos
3. Envía formulario
4. Sistema valida datos
5. Sistema guarda beneficiario en BD
6. Muestra mensaje de éxito

**Validaciones:**
- Nombre y apellidos obligatorios
- Email con formato válido
- Número de identificación único
- Tamaño familiar > 0

---

#### CU-BEN-02: Listar Beneficiarios
**Actor:** Admin/Usuario  
**Precondiciones:** Usuario autenticado  
**Flujo Principal:**
1. Usuario accede al módulo
2. Sistema carga lista de beneficiarios
3. Muestra tabla con datos principales
4. Usuario puede ver acciones según su rol

---

#### CU-BEN-03: Buscar Beneficiario
**Actor:** Admin/Usuario  
**Flujo Principal:**
1. Usuario ingresa término de búsqueda
2. Sistema busca en nombre, apellidos o DNI
3. Muestra resultados filtrados

---

#### CU-BEN-04: Ver Detalles de Beneficiario
**Actor:** Administrador  
**Precondiciones:** Usuario es admin  
**Flujo Principal:**
1. Admin hace clic en "Ver Detalles"
2. Sistema carga página de detalles
3. Muestra información completa del beneficiario

---

#### CU-BEN-05: Eliminar Beneficiario
**Actor:** Administrador  
**Precondiciones:** Usuario es admin  
**Flujo Principal:**
1. Admin hace clic en "Eliminar"
2. Sistema solicita confirmación
3. Admin confirma eliminación
4. Sistema elimina beneficiario y asignaciones asociadas
5. Muestra mensaje de éxito

---

### Gestión de Voluntarios

#### CU-VOL-01: Registrar Voluntario
**Actor:** Administrador  
**Precondiciones:** Usuario es admin  
**Flujo Principal:**
1. Admin completa formulario de voluntario
2. Ingresa: nombre, teléfono, horas, habilidades
3. Sistema valida datos
4. Sistema convierte teléfono a INT
5. Guarda voluntario en BD
6. Muestra mensaje de éxito

**Validaciones:**
- Nombre obligatorio
- Teléfono numérico (convertido a INT)
- Horas disponibles obligatorias
- Habilidades obligatorias

---

#### CU-VOL-02: Listar Voluntarios
**Actor:** Administrador  
**Flujo Principal:**
1. Admin accede al módulo
2. Sistema carga lista de voluntarios
3. Muestra tabla con información

---

#### CU-VOL-03: Buscar Voluntario
**Actor:** Administrador  
**Flujo Principal:**
1. Admin ingresa término de búsqueda
2. Sistema busca por nombre
3. Muestra resultados filtrados

---

#### CU-VOL-04: Eliminar Voluntario
**Actor:** Administrador  
**Flujo Principal:**
1. Admin hace clic en eliminar
2. Sistema solicita confirmación
3. Admin confirma
4. Sistema elimina voluntario
5. Muestra mensaje de éxito

---

### Gestión de Alertas de Caducidad

#### CU-ALE-01: Listar Alertas
**Actor:** Admin/Usuario  
**Flujo Principal:**
1. Usuario accede al módulo
2. Sistema calcula alertas según fechas
3. Muestra lista ordenada por urgencia

---

#### CU-ALE-02: Filtrar Alertas por Urgencia
**Actor:** Admin/Usuario  
**Flujo Principal:**
1. Usuario selecciona nivel de urgencia
2. Sistema filtra alertas
3. Muestra resultados filtrados

---

### Gestión de Puntos de Distribución

#### CU-PUN-01: Crear Punto de Distribución
**Actor:** Administrador  
**Flujo Principal:**
1. Admin completa formulario
2. Ingresa nombre, dirección, coordenadas, etc.
3. Sistema valida datos
4. Guarda punto en BD
5. Actualiza mapa

---

#### CU-PUN-02: Ver Mapa de Puntos
**Actor:** Admin/Usuario  
**Flujo Principal:**
1. Usuario accede al módulo
2. Sistema carga mapa interactivo
3. Muestra marcadores de puntos
4. Usuario puede hacer clic para ver detalles

---

#### CU-PUN-03: Eliminar Punto
**Actor:** Administrador  
**Flujo Principal:**
1. Admin selecciona punto
2. Hace clic en eliminar
3. Sistema solicita confirmación
4. Admin confirma
5. Sistema elimina punto

---

## Casos de Prueba por Sprint

### Sprint 1: Fundamentos y Autenticación

**Fecha:** 6-13 Enero, 2026  
**Total Casos:** 6

| ID | Caso de Uso | Input | Resultado Esperado | Estado |
|----|-------------|-------|-------------------|--------|
| TC-S1-01 | Login exitoso (Admin) | admin / admin123 | Acceso concedido, redirige a home | ✅ PASS |
| TC-S1-02 | Login exitoso (Usuario) | user / user123 | Acceso concedido, redirige a home | ✅ PASS |
| TC-S1-03 | Login fallido | wrong / wrong | Mensaje de error | ✅ PASS |
| TC-S1-04 | Acceso sin sesión | Acceso a módulo sin login | Redirección a login | ✅ PASS |
| TC-S1-05 | Acceso no autorizado | Usuario accede a Voluntarios | "Acceso Denegado" | ✅ PASS |
| TC-S1-06 | Logout | Click en "Cerrar Sesión" | Sesión destruida, redirige | ✅ PASS |

---

### Sprint 2: Gestión de Beneficiarios

**Fecha:** 13-27 Enero, 2026  
**Total Casos:** 10

| ID | Caso de Prueba | Input | Resultado Esperado | Estado |
|----|----------------|-------|-------------------|--------|
| TC-S2-01 | Crear beneficiario válido | Todos los campos completos | Éxito, beneficiario creado | ✅ PASS |
| TC-S2-02 | Crear sin nombre | Nombre vacío | Error de validación | ✅ PASS |
| TC-S2-03 | DNI duplicado | DNI existente | Error: "DNI ya existe" | ✅ PASS |
| TC-S2-04 | Email inválido | "correo@invalido" | Error de formato | ✅ PASS |
| TC-S2-05 | Buscar por nombre | "Juan" | Lista filtrada con "Juan" | ✅ PASS |
| TC-S2-06 | Eliminar (admin) | ID válido | Beneficiario eliminado | ✅ PASS |
| TC-S2-07 | Eliminar (usuario) | ID válido | Acceso denegado | ✅ PASS |
| TC-S2-08 | Ver detalles (admin) | ID válido | Página de detalles | ✅ PASS |
| TC-S2-09 | Ver detalles (usuario) | ID válido | Botón oculto | ✅ PASS |
| TC-S2-10 | Listar todos | - | Tabla con todos | ✅ PASS |

---

### Sprint 3: Gestión de Voluntarios

**Fecha:** 3-14 Febrero, 2026  
**Total Casos:** 8

| ID | Caso de Prueba | Input | Resultado Esperado | Estado |
|----|----------------|-------|-------------------|--------|
| TC-S3-01 | Crear voluntario válido | Todos los campos | Éxito, voluntario creado | ✅ PASS |
| TC-S3-02 | Crear sin nombre | Nombre vacío | Error validación | ✅ PASS |
| TC-S3-03 | Crear sin teléfono | Teléfono vacío | Error validación | ✅ PASS |
| TC-S3-04 | Teléfono no numérico | "abc123" | Error al guardar | ✅ PASS (post-fix) |
| TC-S3-05 | Buscar por nombre | "Ana" | Lista filtrada | ✅ PASS |
| TC-S3-06 | Eliminar voluntario | ID válido | Voluntario eliminado | ✅ PASS |
| TC-S3-07 | Acceso usuario normal | URL directa | Acceso denegado | ✅ PASS |
| TC-S3-08 | Listar todos | - | Tabla completa | ✅ PASS |

---

## Resumen de Cobertura

### Por Estado de Implementación

| Estado | Cantidad | Historias |
|--------|----------|-----------|
| ✅ Completado | 4 | HU-02, HU-04, HU-06, HU-09 |
| 🔄 En Progreso | 1 | HU-03 |
| ⏳ Pendiente | 5 | HU-01, HU-05, HU-07, HU-08, HU-10 |
| **TOTAL** | **10** | **Historias de Usuario** |

### Por Prioridad

| Prioridad | Cantidad |
|-----------|----------|
| Alta | 7 |
| Media | 3 |
| Baja | 0 |

### Casos de Prueba Ejecutados

| Sprint | Casos Ejecutados | Tasa de Éxito |
|--------|------------------|---------------|
| Sprint 1 | 6 | 100% (6/6) |
| Sprint 2 | 10 | 100% (10/10) |
| Sprint 3 | 8 | 100% (8/8) |
| **TOTAL** | **24** | **100%** |

---

## Matriz de Trazabilidad

| Historia | Casos de Uso Funcionales | Casos de Prueba | Estado |
|----------|-------------------------|-----------------|--------|
| HU-01 | CU-01.1 a CU-01.4 | Pendiente | ⏳ |
| HU-02 | CU-02.1 a CU-02.4 | Pendiente | ✅ |
| HU-03 | CU-03.1 a CU-03.4 | Pendiente | 🔄 |
| HU-04 | CU-04.1 a CU-04.7 | TC-S2-01 a TC-S2-10 | ✅ |
| HU-05 | CU-05.1 a CU-05.4 | Pendiente | ⏳ |
| HU-06 | CU-06.1 a CU-06.5 | Pendiente | ✅ |
| HU-07 | CU-07.1 a CU-07.4 | Pendiente | ⏳ |
| HU-08 | CU-08.1 a CU-08.4 | Pendiente | ⏳ |
| HU-09 | CU-09.1 a CU-09.5 | TC-S3-01 a TC-S3-08 | ✅ |
| HU-10 | CU-10.1 a CU-10.4 | Pendiente | ⏳ |
| Autenticación | CU-AUTH-01 a CU-AUTH-03 | TC-S1-01 a TC-S1-06 | ✅ |

---

## Roles y Permisos por Caso de Uso

| Caso de Uso | Admin | Usuario |
|-------------|-------|---------|
| CU-AUTH-01: Login | ✅ | ✅ |
| CU-AUTH-02: Logout | ✅ | ✅ |
| CU-BEN-01: Crear Beneficiario | ✅ | ❌ |
| CU-BEN-02: Listar Beneficiarios | ✅ | ✅ (solo lectura) |
| CU-BEN-03: Buscar Beneficiario | ✅ | ✅ |
| CU-BEN-04: Ver Detalles | ✅ | ❌ |
| CU-BEN-05: Eliminar Beneficiario | ✅ | ❌ |
| CU-VOL-01 a CU-VOL-04 | ✅ | ❌ |
| CU-ALE-01: Listar Alertas | ✅ | ✅ (solo lectura) |
| CU-PUN-01: Crear Punto | ✅ | ❌ |
| CU-PUN-02: Ver Mapa | ✅ | ✅ |
| CU-PUN-03: Eliminar Punto | ✅ | ❌ |

---

## Diagrama de Casos de Uso (UML)

```
                    ┌─────────────────────────┐
                    │  Sistema Banco          │
                    │  de Alimentos           │
                    └─────────────────────────┘
                              │
         ┌────────────────────┼────────────────────┐
         │                    │                    │
    ┌────▼────┐         ┌────▼────┐        ┌─────▼─────┐
    │  Admin  │         │ Usuario │        │  Sistema  │
    └─────────┘         └─────────┘        └───────────┘
         │                    │                    │
         ├─ Login            ├─ Login             │
         ├─ Logout           ├─ Logout            │
         ├─ Gestionar        ├─ Ver               ├─ Alertas Auto
         │  Beneficiarios    │  Beneficiarios     │
         ├─ Gestionar        ├─ Ver Alertas       ├─ Asignación
         │  Voluntarios      │                    │  Inteligente
         ├─ Gestionar        ├─ Ver Mapa          │
         │  Puntos           │  Puntos            │
         ├─ Registrar        │                    │
         │  Donaciones       │                    │
         ├─ Generar          │                    │
         │  Reportes         │                    │
         └─ Control          │                    │
            Calidad          │                    │
```

---

## Próximos Casos de Uso a Implementar

### Sprint 4 (Planificado)
1. **CU-DON-01**: Registrar Donación Entrante
2. **CU-DON-02**: Listar Historial de Donaciones
3. **CU-DON-03**: Filtrar Donaciones
4. **CU-INV-01**: Consultar Inventario

### Sprint 5 (Planificado)
1. **CU-ASG-01**: Ejecutar Asignación Automática
2. **CU-ASG-02**: Ver Historial de Asignaciones
3. **CU-ASG-03**: Validar Stock

### Sprint 6 (Planificado)
1. **CU-REP-01**: Generar Reporte de Donaciones
2. **CU-REP-02**: Generar Reporte de Distribución
3. **CU-REP-03**: Exportar a PDF/Excel

---

## Notas de Implementación

### Convenciones de Nomenclatura
- **HU-XX**: Historia de Usuario
- **CU-XXX-XX**: Caso de Uso Funcional
- **TC-SX-XX**: Test Case del Sprint X

### Criterios de Aceptación
Todos los casos de uso deben cumplir:
- Validación de entrada en cliente y servidor
- Manejo de errores con mensajes claros
- Control de acceso según rol
- Logging de operaciones críticas
- Respuestas HTTP apropiadas

### Trazabilidad
Cada caso de uso debe tener:
- Historia de usuario asociada
- Casos de prueba definidos
- Código implementado
- Documentación actualizada

---

**Documento generado:** 22 de Enero, 2026  
**Última revisión:** Sprint 3  
**Próxima actualización:** Sprint 4
