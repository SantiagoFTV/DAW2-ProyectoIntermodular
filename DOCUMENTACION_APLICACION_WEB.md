# Documentación Completa de la Aplicación Web - src/www

**Fecha:** Enero 2026  
**Versión:** 1.0  

---

## Tabla de Contenidos

1. [Introducción](#introducción)
2. [Estructura General](#estructura-general)
3. [Controladores](#controladores)
4. [Modelos](#modelos)
5. [Vistas](#vistas)
6. [CSS](#css)
7. [JavaScript](#javascript)
8. [Flujo de la Aplicación](#flujo-de-la-aplicación)
9. [Sistema de Autenticación](#sistema-de-autenticación)

---

## Introducción

Esta aplicación web está diseñada usando el patrón MVC (Modelo-Vista-Controlador) con PHP. Su propósito es gestionar un sistema de donaciones, beneficiarios, puntos de distribución, alertas de caducidad y voluntarios.

**Ubicación principal:** `src/www/`

**Estructura:**
- **controladores/** - Lógica de negocio y enrutamiento
- **modelos/** - Acceso a datos y reglas de negocio
- **vistas/** - Interfaces HTML
- **css/** - Estilos
- **js/** - Funcionalidades de cliente

---

## Estructura General

```
src/www/
├── controladores/
│   ├── ControladorAuth.php
│   ├── controladorHome.php
│   ├── controladorDonacion.php
│   ├── controladorBeneficiario.php
│   ├── controladorPuntoDistribucion.php
│   ├── controladorAlertaCaducidad.php
│   └── controladorVoluntario.php
├── modelos/
│   ├── Sesion.php
│   ├── bd.php
│   ├── donacion.php
│   ├── beneficiario.php
│   ├── puntoDistribucion.php
│   ├── alertaCaducidad.php
│   └── voluntario.php
├── vistas/
│   ├── login.html
│   └── html/
│       ├── home.html
│       ├── gestion_donaciones.html
│       ├── gestion_beneficiarios.html
│       ├── detalles_beneficiario.html
│       ├── gestion_puntos_distribucion.html
│       ├── gestion_voluntarios.html
│       └── gestion_alertas_caducidad.html
├── css/
│   ├── home.css
│   ├── gestion_donaciones.css
│   ├── gestion_beneficiarios.css
│   ├── gestion_puntos_distribucion.css
│   ├── gestion_voluntarios.css
│   └── gestion_alertas_caducidad.css
└── js/
    ├── gestion_donaciones.js
    ├── gestion_beneficiarios.js
    ├── gestion_puntos_distribucion.js
    ├── gestion_voluntarios.js
    └── gestion_alertas_caducidad.js
```

---

## Controladores

### ControladorAuth.php

**Propósito:** Gestiona la autenticación de usuarios (login/logout)

**Métodos:**

#### `login()`
- Muestra el formulario de login
- Procesa credenciales POST
- Valida usuario y contraseña contra la clase `Sesion`
- Redirige al home si es exitoso
- Muestra error si las credenciales son inválidas

**Flujo:**
1. GET: Muestra formulario
2. POST: Procesa login
3. Redirige a `index.php?controlador=Home&metodo=listar`

#### `logout()`
- Destruye la sesión actual
- Redirige al formulario de login

---

### controladorHome.php

**Propósito:** Renderiza la página principal de la aplicación

**Métodos:**

#### `index()`
- Carga la vista `home.html`
- Disponible para todos los usuarios autenticados

#### `listar()`
- Alias de `index()` para compatibilidad

**Variables de vista:**
- `$config` - Configuración global

---

### controladorDonacion.php

**Propósito:** Gestiona donaciones entrantes (HU-01)  
**Restricción:** Solo administradores

**Métodos:**

#### `listar()`
- Lista todas las donaciones
- Carga estadísticas y puntos de distribución
- Variables vista:
  - `$donaciones_vista` - Array de donaciones
  - `$estadisticas_vista` - Contadores y datos agregados
  - `$puntos_distribucion_vista` - Puntos disponibles

#### `buscar()`
- POST: Busca donaciones por término
- Busca en: nombre_donante, tipo_producto, observaciones
- Retorna resultados filtrados

#### `filtrar()`
- POST: Filtro avanzado por criterios
- Parámetros:
  - `fecha_desde` - Fecha mínima
  - `fecha_hasta` - Fecha máxima
  - `donante` - Nombre del donante
  - `tipo_producto` - Tipo de producto

#### `crear()`
- POST: Crea nueva donación
- Validaciones:
  - Nombre donante (obligatorio)
  - Tipo producto (obligatorio)
  - Cantidad (número > 0)
  - Fecha caducidad (formato válido si aplica)
- Crea alerta automáticamente si tiene fecha de caducidad

#### `mostrarError()`
- Muestra errores de forma legible
- En debug: muestra mensaje, archivo y línea
- En producción: mensaje genérico

---

### controladorBeneficiario.php

**Propósito:** Gestiona beneficiarios y asignaciones (HU-03)  
**Restricción:** Lectura para todos; creación/edición solo admin

**Métodos:**

#### `listar()`
- Lista todos los beneficiarios
- Ordenados alfabéticamente por nombre
- Variables: `$beneficiarios_vista`, `$puntos_distribucion_vista`

#### `buscar()`
- POST: Busca por nombre, apellidos o número de identificación

#### `detalles()`
- GET `id=N`: Muestra detalles completos de un beneficiario
- Incluye historial de asignaciones

#### `crear()`
- POST: Crea nuevo beneficiario
- Campos: nombre, apellidos, número_identificación, teléfono, email, dirección, tamaño_familiar, necesidades
- Estado inicial: "pendiente"

#### `actualizar()`
- POST: Actualiza datos existentes
- Validaciones: mismo que crear()

#### `eliminar()`
- POST `id=N`: Elimina un beneficiario
- Solo admin

---

### controladorPuntoDistribucion.php

**Propósito:** Gestiona centros de distribución  
**Restricción:** Lectura para todos; creación/eliminación solo admin

**Métodos:**

#### `listar()`
- GET: Muestra todos los puntos

#### `crear()`
- POST: Crea nuevo punto de distribución
- Campos: nombre, dirección, responsable, teléfono, horario, descripción
- Sincroniza automáticamente con `sprint.sql`

#### `eliminar()`
- POST `id=N`: Elimina punto
- Solo admin

---

### controladorAlertaCaducidad.php

**Propósito:** Gestiona alertas de productos que se van a caducar (HU-02)  
**Restricción:** Solo administradores

**Métodos:**

#### `listar()`
- GET: Lista todas las alertas ordenadas por fecha

#### `crear()`
- POST: Crea nueva alerta
- Campos: nombre_producto, punto_distribucion_id, cantidad, fecha_caducidad, ubicación
- Valida: cantidad > 0, fecha válida

#### `eliminar()`
- POST `id=N`: Elimina alerta

#### `filtrar()`
- GET `filtro=valor`: Filtra por estado
- Opciones: todas, criticas (≤3 días), caducadas (< 0 días), proximas (3-15 días)

---

### controladorVoluntario.php

**Propósito:** Gestiona voluntarios (HU-09)  
**Restricción:** Solo administradores

**Métodos:**

#### `listar()`
- GET: Lista todos los voluntarios

#### `crear()`
- POST: Crea nuevo voluntario
- Campos: nombre, teléfono, horas_disponibles, habilidades (opcional)

#### `eliminar()`
- POST `id=N`: Elimina voluntario

---

## Modelos

### Sesion.php

**Propósito:** Manejo de autenticación y sesiones

**Constantes:**
```php
USUARIO_ADMIN = 'admin'
USUARIO_NORMAL = 'usuario'
```

**Usuarios Hardcodeados:**
- Admin: `admin` / `admin123`
- Usuario: `user` / `user123`

**Métodos Estáticos:**

#### `iniciarSesion()`
- Inicia la sesión PHP si no está activa

#### `login($usuario, $password)`
- Autentica usuario
- Retorna `true` si es exitoso
- Establece `$_SESSION['usuario']`, `$_SESSION['rol']`, `$_SESSION['autenticado']`

#### `logout()`
- Destruye la sesión

#### `estaAutenticado()`
- Verifica si hay usuario autenticado

#### `obtenerUsuario()`
- Retorna nombre de usuario actual

#### `obtenerRol()`
- Retorna rol del usuario (admin/usuario)

#### `esAdmin()`
- Retorna `true` si es administrador

#### `esUsuarioNormal()`
- Retorna `true` si es usuario normal

#### `requiereAdmin()`
- Valida que sea admin
- Muestra error y redirige si no lo es

#### `requiereAutenticacion()`
- Valida que esté autenticado
- Redirige al login si no lo está

---

### bd.php

**Propósito:** Abstracción de acceso a base de datos con PDO

**Configuración:**
- Host: `localhost`
- BD: `sprint`
- Usuario: `root`
- Contraseña: (vacía)

**Métodos:**

#### `insertar($sql, $parametros = [])`
- Ejecuta INSERT
- Retorna ID insertado

#### `seleccionar($sql, $parametros = [])`
- Ejecuta SELECT
- Retorna array asociativo

#### `ejecutar($sql, $parametros = [])`
- Ejecuta cualquier SQL
- Retorna número de filas afectadas

#### `actualizar($sql, $parametros = [])`
- Ejecuta UPDATE
- Retorna número de filas actualizadas

#### `eliminar($sql, $parametros = [])`
- Ejecuta DELETE
- Retorna número de filas eliminadas

---

### donacion.php

**Propósito:** Modelo de Donaciones (HU-01)

**Atributos:**
```php
id, nombre_donante, tipo_producto, cantidad, unidad_medida,
fecha_recepcion, fecha_caducidad, punto_distribucion_id,
observaciones, estado, created_at, updated_at
```

**Métodos Instancia:**

#### `guardar()`
- Inserta nueva donación
- Crea alerta automáticamente si tiene fecha de caducidad
- Retorna ID de la donación

#### `actualizar()`
- Actualiza donación existente
- Sincroniza alerta de caducidad

**Métodos Estáticos:**

#### `listar()`
- Retorna todas las donaciones ordenadas por fecha DESC
- Incluye nombre del punto de distribución

#### `buscar($termino)`
- Busca por nombre_donante, tipo_producto, observaciones

#### `filtrar($fecha_desde, $fecha_hasta, $donante, $tipo_producto)`
- Filtrado avanzado

#### `obtenerPorId($id)`
- Retorna una donación o `null`

#### `obtenerEstadisticas()`
- Retorna:
  - total_donaciones
  - total_cantidad
  - donantes_unicos
  - productos_diferentes

---

### beneficiario.php

**Propósito:** Modelo de Beneficiarios (HU-03, HU-04)

**Atributos:**
```php
id, nombre, apellidos, numero_identificacion, telefono, email,
direccion, tamaño_familiar, necesidades, estado_validacion,
fecha_ultima_asignacion, frecuencia_maxima_dias, created_at, updated_at
```

**Estado de validación:** pendiente, validado, rechazado

**Métodos Instancia:**

#### `guardar()`
- Inserta nuevo beneficiario
- Estado inicial: "pendiente"

#### `actualizar()`
- Actualiza datos del beneficiario

#### `obtenerHistorialAsignaciones()`
- Retorna array de asignaciones anteriores

#### `puedeRecibirAsignacion()`
- Verifica si puede recibir nueva asignación
- Respeta `frecuencia_maxima_dias`

#### `asignarProducto($nombre_producto, $cantidad, $punto_distribucion_id, $coordinador, $notas)`
- Registra una asignación

**Métodos Estáticos:**

#### `listar()`
- Todos los beneficiarios ordenados por nombre

#### `obtenerPorId($id)`

#### `buscar($termino)`
- Por nombre, apellidos o número_identificación

#### `buscarPorEstado($estado)`
- Filtra por estado de validación

---

### puntoDistribucion.php

**Propósito:** Modelo de Puntos de Distribución (HU-06)

**Atributos:**
```php
id, nombre, direccion, responsable, telefono, latitud, longitud,
horario, descripcion, created_at
```

**Métodos Instancia:**

#### `guardar()`
- Inserta punto y lo sincroniza con `sprint.sql`

**Métodos Estáticos:**

#### `listar()`
- Todos los puntos
- Fallback: carga desde `sprint.sql` si BD falla

#### `eliminar($id)`

---

### alertaCaducidad.php

**Propósito:** Modelo de Alertas de Caducidad (HU-02)

**Atributos:**
```php
id, nombre_producto, punto_distribucion_id, cantidad,
fecha_caducidad, dias_restantes, ubicacion, estado, created_at
```

**Estados:**
- `caducado`: días < 0
- `critico`: 0 a 3 días
- `urgente`: 4 a 7 días
- `proximo`: 8 a 15 días
- `ok`: más de 15 días

**Métodos Instancia:**

#### `guardar()`
- Inserta alerta
- Calcula automáticamente estado

**Métodos Estáticos:**

#### `listar()`
- Todas las alertas ordenadas por fecha

#### `obtenerPorId($id)`

#### `eliminar($id)`

#### `obtenerAlertas($filtro)`
- Filtro: `'todas'`, `'criticas'`, `'caducadas'`, `'proximas'`

---

### voluntario.php

**Propósito:** Modelo de Voluntarios (HU-09)

**Atributos:**
```php
id, nombre, telefono, horas_disponibles, habilidades, fecha_creacion
```

**Métodos Instancia:**

#### `guardar()`
- Inserta voluntario
- Convierte teléfono a int

**Métodos Estáticos:**

#### `listar()`
- Todos los voluntarios
- Carga desde BD y desde `sprint.sql` (sin duplicados)

#### `eliminar($id)`

---

## Vistas

Todas las vistas son HTML5 con estructura semántica. Comparten:
- Navbar con usuario y logout
- Menú dinámico según rol
- Mensajes de éxito/error
- Responsividad

### login.html
- Formulario de acceso
- Campos: usuario, contraseña
- Muestra credenciales por defecto (propósitos de demostración)

### home.html
- Página principal
- Menú con módulos disponibles según rol
- Componentes visuales decorativos
- Tarjetas de acceso rápido

### gestion_donaciones.html
- Tabla con todas las donaciones
- Filtros: fecha, donante, tipo_producto
- Búsqueda por término
- Modal para crear nueva donación
- Estadísticas (total, cantidad, donantes únicos)

### gestion_beneficiarios.html
- Tabla de beneficiarios
- Búsqueda por nombre/identificación
- Botón "Detalles" que va a `detalles_beneficiario.html`
- Opción crear/editar (solo admin)
- Opción eliminar (solo admin)

### detalles_beneficiario.html
- Información completa del beneficiario
- Historial de asignaciones
- Edición de datos
- Botones de acción

### gestion_puntos_distribucion.html
- Lista de centros de distribución
- Crear nuevo punto (solo admin)
- Eliminar punto (solo admin)
- Información: nombre, dirección, responsable, teléfono, horario

### gestion_voluntarios.html
- Lista de voluntarios
- Crear voluntario (solo admin)
- Eliminar voluntario (solo admin)
- Información: nombre, teléfono, horas disponibles, habilidades

### gestion_alertas_caducidad.html
- Lista de alertas
- Filtros: todas, críticas, caducadas, próximas
- Crear alerta (solo admin)
- Eliminar alerta (solo admin)
- Indicadores visuales por estado

---

## CSS

Se usa un sistema de variables CSS con diseño moderno (Glassmorphism + Gradientes).

### Paleta de Colores

```css
--bg: #0b1a13;              /* Fondo principal oscuro */
--panel: #0f2818;           /* Fondo de paneles */
--card: #0a1f14;            /* Fondo de tarjetas */
--text: #f3faf7;            /* Texto principal */
--muted: #9eb8ae;           /* Texto secundario */
--primary: #2F855A;         /* Color primario verde */
--accent: #68D391;          /* Color acento */
--border: rgba(..., 0.09);  /* Bordes sutiles */
--shadow: ...               /* Sombras suaves */
```

### home.css
- Diseño heroico con gradientes
- Grid responsivo
- Animaciones suaves
- Componentes reutilizables (.btn, .card, .badge)

### gestion_*.css
- Tablas estilizadas
- Formularios con validación visual
- Modales/overlays
- Alertas y mensajes
- Botones contextuales

---

## JavaScript

### gestion_donaciones.js

**Funciones:**

#### `toggleFiltros()`
- Muestra/oculta panel de filtros

#### `abrirFormularioNuevo()`
- Abre modal para crear donación
- Resetea formulario
- Establece fecha actual por defecto

#### Auto-ocultamiento de mensajes
- Oculta mensajes de éxito/error después de 5 segundos

### gestion_beneficiarios.js
- Similar a gestion_donaciones.js
- Manejo de modal de beneficiarios

### gestion_puntos_distribucion.js
- Toggle de filtros
- Validación de formularios

### gestion_voluntarios.js
- Confirmación de eliminación
- Validación de teléfono

### gestion_alertas_caducidad.js
- Filtrado dinámico
- Indicadores visuales de estado
- Validación de fechas

---

## Flujo de la Aplicación

### Flujo de Autenticación

```
Usuario accede a index.php
    ↓
index.php valida sesión (requiereAutenticacion())
    ↓
Si no autenticado → Redirige a ?controlador=Auth&metodo=login
    ↓
ControladorAuth::login() muestra formulario
    ↓
Usuario ingresa credenciales y POST
    ↓
Sesion::login() valida credenciales
    ↓
Si válido → Sesión iniciada, redirige a Home
Si inválido → Muestra error, vuelve al login
```

### Flujo de Control de Acceso

```
Usuario autenticado accede a módulo
    ↓
index.php verifica rol (requiereAdmin() si aplica)
    ↓
Si no tiene permiso → Muestra "Acceso denegado"
Si tiene permiso → Ejecuta controlador
    ↓
Controlador carga modelo y vista
```

### Flujo CRUD Típico

#### CREATE (Crear)
```
GET: Vista → Muestra formulario
POST: Datos → Controlador → Modelo → BD → Mensaje éxito
```

#### READ (Leer)
```
GET: Controlador → Modelo → BD → Vista con datos
```

#### UPDATE (Actualizar)
```
GET: ID → Controlador → Modelo → BD → Cargar en formulario
POST: Datos → Controlador → Modelo → BD → Mensaje éxito
```

#### DELETE (Eliminar)
```
POST: ID → Controlador → Modelo → BD → Mensaje éxito/error
```

---

## Sistema de Autenticación

### Usuarios Disponibles

| Usuario | Contraseña | Rol | Acceso |
|---------|------------|-----|--------|
| admin | admin123 | Admin | Todos los módulos + CRUD completo |
| user | user123 | Usuario | Solo lectura en Beneficiarios y Puntos |

### Permisos por Rol

#### Admin (👑)
- ✅ Crear/editar/eliminar donaciones
- ✅ Crear/editar/eliminar beneficiarios
- ✅ Crear/editar/eliminar puntos de distribución
- ✅ Crear/editar/eliminar alertas de caducidad
- ✅ Crear/editar/eliminar voluntarios
- ✅ Acceso a reportes y estadísticas

#### Usuario Normal (👤)
- ✅ Ver beneficiarios (solo lectura)
- ✅ Ver puntos de distribución (solo lectura)
- ❌ No puede crear/editar/eliminar nada
- ❌ Sin acceso a donaciones, voluntarios, alertas

### Notas de Seguridad

⚠️ **Actual (Desarrollo):**
- Credenciales hardcodeadas en `Sesion.php`
- Sin cifrado de contraseñas
- Sin HTTPS
- Sin rate limiting

✅ **Recomendaciones para Producción:**
- Almacenar usuarios en BD
- Usar bcrypt/Argon2 para contraseñas
- Implementar JWT o tokens seguros
- HTTPS obligatorio
- Rate limiting en login
- 2FA (autenticación de dos factores)
- Validación CSRF tokens

---

## Integración Base de Datos

La BD `sprint` contiene las siguientes tablas principales:

- **donaciones** - Registros de donaciones entrantes
- **beneficiarios** - Datos de personas beneficiarias
- **puntos_distribucion** - Centros de distribución
- **voluntarios_db** - Registro de voluntarios
- **alertas_caducidad** - Alertas de productos con vencimiento próximo
- **asignaciones_productos** - Historial de entregas

**Sincronización:** Los puntos de distribución y voluntarios se sincronizan automáticamente con `src/sql/sprint.sql` para backup.

---

## Resumen Técnico

| Concepto | Detalle |
|----------|---------|
| **Patrón MVC** | Implementado con PHP nativo |
| **BD** | MySQL con PDO |
| **Frontend** | HTML5, CSS3, JavaScript vanilla |
| **Autenticación** | Sesiones PHP + roles |
| **API** | POST/GET a través de index.php |
| **Validación** | Server-side (PHP) + Client-side (JS) |
| **Estilos** | CSS variables, Glassmorphism, Responsive |
| **Versionado** | Sincronización con SQL dump |

---

**Documento generado el 26/01/2026**
