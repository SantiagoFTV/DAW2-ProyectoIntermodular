# 🏗️ Arquitectura Tecnológica - Sistema de Donaciones

## Tabla de Contenidos
1. [Stack Tecnológico](#stack-tecnológico)
2. [Arquitectura General](#arquitectura-general)
3. [Estructura del Proyecto](#estructura-del-proyecto)
4. [Flujo de Datos](#flujo-de-datos)
5. [Componentes Principales](#componentes-principales)
6. [Base de Datos](#base-de-datos)
7. [Patrones de Diseño](#patrones-de-diseño)
8. [Flujo de Autenticación](#flujo-de-autenticación)
9. [Seguridad](#seguridad)
10. [Escalabilidad](#escalabilidad)

---

## Stack Tecnológico

### Backend
```
├── PHP 8.2
│   ├── PDO (PHP Data Objects) - Acceso a BD
│   ├── Session Management - Manejo de sesiones
│   └── OOP (Programación Orientada a Objetos)
│
└── Servidor
    ├── Apache 2.4
    ├── XAMPP (Desarrollo local)
    └── MariaDB 10.4.32
```

### Frontend
```
├── HTML5
│   ├── Semántica correcta
│   └── Estructura responsiva
│
├── CSS3
│   ├── Flexbox & Grid
│   ├── Gradientes
│   ├── Transiciones
│   └── Media Queries
│
└── JavaScript (Vanilla)
    ├── DOM Manipulation
    ├── Event Handling
    └── Form Validation
```

### Base de Datos
```
MySQL / MariaDB
├── Versión: 10.4.32
├── Charset: utf8mb4
├── Collation: utf8mb4_general_ci
└── Storage Engine: InnoDB
```

### Entorno de Desarrollo
```
Sistema Operativo: Windows 10/11
Editor: Visual Studio Code
Navegador: Chrome, Firefox, Edge
Control de Versiones: Git (opcional)
```

---

## Arquitectura General

### Patrón MVC (Model-View-Controller)

```
┌────────────────────────────────────────────────────────────┐
│                    Usuario Solicita                        │
└────────────────┬─────────────────────────────────────────┘
                 │
                 ▼
         ┌───────────────┐
         │   index.php   │ (Router/Dispatcher)
         │   (Central)   │
         └───────┬───────┘
                 │
        ┌────────┴────────┐
        │                 │
        ▼                 ▼
   ┌────────────────┐ ┌─────────────────┐
   │  Controller    │ │  Controlador    │
   │  (Lógica de    │ │  Específico     │
   │   Negocio)     │ │  (Voluntario,   │
   └────────┬───────┘ │   Beneficiario) │
            │         └────────┬────────┘
            │                  │
            ▼                  ▼
   ┌────────────────┐ ┌─────────────────┐
   │  Model         │ │  Model (BD)     │
   │  (Datos &      │ │  (Consultas SQL)│
   │   Acceso BD)   │ │                 │
   └────────┬───────┘ └────────┬────────┘
            │                  │
            └────────┬─────────┘
                     │
                     ▼
            ┌────────────────────┐
            │   MySQL/MariaDB    │
            │   (Datos)          │
            └────────────────────┘
                     │
                     ▼
            ┌────────────────────┐
            │   Vista HTML/CSS   │
            │   (Presentación)   │
            └────────┬───────────┘
                     │
                     ▼
            ┌────────────────────┐
            │   Navegador        │
            │   (Cliente)        │
            └────────────────────┘
```

---

## Estructura del Proyecto

### Árbol de Carpetas

```
DAW2-ProyectoIntermodular/
│
├── README.md                           (Información principal)
├── AUTENTICACION.md                    (Credenciales y features)
├── FLUJO_AUTENTICACION.md              (Diagrama de flujos)
├── DIAGRAMAS_FLUJO.txt                 (Visualización de procesos)
├── DOCUMENTACION_CODIGO.md             (Explicación de código)
├── GUIA_ESTILOS.md                     (Colores, tipografía, componentes)
└── ARQUITECTURA_TECNOLOGICA.md         (Este documento)
│
└── src/                                (Código fuente)
    │
    ├── index.php                       (Entry point - Router principal)
    ├── config.php                      (Configuración de rutas y BD)
    │
    ├── www/
    │   ├── controladores/              (Capa de Control)
    │   │   ├── ControladorAuth.php     (Login/Logout)
    │   │   ├── ControladorHome.php     (Panel principal)
    │   │   ├── ControladorBeneficiario.php
    │   │   ├── ControladorVoluntario.php
    │   │   ├── ControladorPuntoDistribucion.php
    │   │   └── ControladorAlertaCaducidad.php
    │   │
    │   ├── modelos/                    (Capa de Modelo)
    │   │   ├── Sesion.php              (Autenticación)
    │   │   ├── BD.php                  (Acceso a BD)
    │   │   ├── beneficiario.php
    │   │   ├── voluntario.php
    │   │   ├── puntoDistribucion.php
    │   │   └── alertaCaducidad.php
    │   │
    │   ├── vistas/                     (Capa de Vista)
    │   │   ├── login.html              (Página de autenticación)
    │   │   └── html/
    │   │       ├── home.html           (Panel principal)
    │   │       ├── gestion_beneficiarios.html
    │   │       ├── gestion_voluntarios.html
    │   │       ├── gestion_puntos_distribucion.html
    │   │       ├── gestion_alertas_caducidad.html
    │   │       └── detalles_beneficiario.html
    │   │
    │   ├── css/                        (Estilos)
    │   │   ├── home.css
    │   │   ├── gestion_beneficiarios.css
    │   │   ├── gestion_voluntarios.css
    │   │   ├── gestion_puntos_distribucion.css
    │   │   └── gestion_alertas_caducidad.css
    │   │
    │   └── js/                         (JavaScript)
    │       ├── gestion_beneficiarios.js
    │       ├── gestion_voluntarios.js
    │       ├── gestion_puntos_distribucion.js
    │       └── gestion_alertas_caducidad.js
    │
    └── sql/                            (Base de datos)
        ├── sprint.sql                  (Script de inicialización)
        └── alertas_caducidad.csv       (Datos de ejemplo)

└── doc/                                (Documentación del proyecto)
    ├── analisis/
    ├── diseños/
    └── sprints/
        ├── product_backlog.md
        ├── sprint_backlog.md
        └── historias_usuarios/
```

---

## Flujo de Datos

### Ciclo de Vida de una Petición

```
1. USUARIO REALIZA ACCIÓN
   └─ Clic en enlace o envía formulario

2. PETICIÓN LLEGA A index.php
   └─ URL: index.php?controlador=Beneficiario&metodo=listar

3. index.php PROCESA PETICIÓN
   ├─ session_start()
   ├─ Carga autoloader
   ├─ Valida autenticación
   ├─ Valida permisos
   └─ Determina controlador

4. INSTANCIA CONTROLADOR
   └─ $controlador = new ControladorBeneficiario($config)

5. EJECUTA MÉTODO DEL CONTROLADOR
   └─ $controlador->listar()

6. CONTROLADOR CARGA MODELO
   ├─ require_once('beneficiario.php')
   └─ $beneficiarios = Beneficiario::listar()

7. MODELO CONSULTA BASE DE DATOS
   ├─ Crea instancia BD
   ├─ Ejecuta SQL preparado
   ├─ Procesa resultados
   └─ Retorna objetos

8. CONTROLADOR PREPARA DATOS PARA VISTA
   ├─ $beneficiarios_vista = $beneficiarios
   ├─ Asigna variables a $config
   └─ Carga vista HTML

9. VISTA RENDERIZA HTML
   ├─ Accede a variables
   ├─ Genera HTML dinámico
   ├── Incluye CSS y JS
   └─ Envía respuesta

10. NAVEGADOR RECIBE Y RENDERIZA
    ├─ Procesa HTML
    ├─ Aplica CSS
    ├─ Ejecuta JavaScript
    └─ Muestra página al usuario
```

### Ejemplo Real: Listar Beneficiarios

```
Usuario clic en "Beneficiarios"
    ↓
URL: index.php?controlador=Beneficiario&metodo=listar
    ↓
index.php:
  - Valida sesión ✓
  - Valida permiso a Beneficiario ✓
  - Instancia ControladorBeneficiario
    ↓
ControladorBeneficiario::listar():
  - require_once beneficiario.php
  - $beneficiarios = Beneficiario::listar()
    ↓
Beneficiario::listar():
  - $bd = new BD()
  - $sql = "SELECT * FROM beneficiarios"
  - $resultados = $bd->seleccionar($sql)
  - Crea objetos Beneficiario
  - Retorna array
    ↓
BD::seleccionar():
  - $sentencia = $this->conexion->prepare($sql)
  - $sentencia->execute($parametros)
  - return $sentencia->fetchAll()
    ↓
MariaDB:
  - Ejecuta consulta
  - Retorna resultados
    ↓
Controlador asigna:
  - $beneficiarios_vista = $beneficiarios
  - require_once gestion_beneficiarios.html
    ↓
Vista HTML:
  - Itera sobre $beneficiarios_vista
  - Renderiza tabla
  - Incluye CSS y JS
    ↓
Navegador:
  - Muestra página
```

---

## Componentes Principales

### 1. Router (index.php)

```php
Responsabilidades:
├─ Inicia sesiones
├─ Carga autoloader
├─ Extrae parámetros (controlador, metodo)
├─ Valida autenticación
├─ Valida permisos por rol
├─ Instancia controlador
└─ Ejecuta método
```

### 2. Capa de Control (Controllers)

```php
ControladorBeneficiario
├─ listar()        → Muestra todos los beneficiarios
├─ crear()         → Procesa formulario de creación
├─ eliminar()      → Elimina beneficiario
├─ buscar()        → Busca por término
├─ detalles()      → Muestra detalles
└─ mostrarError()  → Maneja errores
```

### 3. Capa de Modelo (Models)

```php
class Beneficiario
├─ Propiedades privadas (id, nombre, apellidos, etc)
├─ Constructor
├─ Getters/Setters
├─ static listar()         → SELECT *
├─ static obtenerPorId()   → SELECT por ID
├─ guardar()              → INSERT/UPDATE
├─ static eliminar()      → DELETE
└─ Métodos de negocio     → Lógica específica
```

### 4. BD Class (Abstracción de Base de Datos)

```php
class BD
├─ __construct()          → Conecta a BD
├─ insertar($sql, $params) → INSERT, retorna lastInsertId
├─ seleccionar($sql, $params) → SELECT, retorna array
└─ ejecutar($sql, $params)   → Ejecuta SQL genérico
```

### 5. Sesion Class (Autenticación)

```php
class Sesion
├─ iniciarSesion()        → session_start()
├─ login()                → Autentica usuario
├─ logout()               → Destruye sesión
├─ estaAutenticado()      → Verifica sesión
├─ obtenerUsuario()       → Retorna usuario actual
├─ esAdmin()              → Verifica si es admin
└─ requiereAdmin()        → Valida permisos
```

### 6. Capa de Vista (Views)

```html
home.html
├─ Navbar con usuario y logout
├─ Grid de módulos
├─ Acceso condicional por rol
└─ Footer

gestion_beneficiarios.html
├─ Navbar
├─ Formulario de búsqueda
├─ Formulario de creación (solo admin)
├─ Tabla de beneficiarios
├─ Botones de acciones
└─ Mensajes de estado
```

---

## Base de Datos

### Modelo de Datos

```sql
beneficiarios
├─ id (PK, INT AUTO_INCREMENT)
├─ nombre (VARCHAR 255)
├─ apellidos (VARCHAR 255)
├─ numero_identificacion (VARCHAR 50)
├─ telefono (VARCHAR 50)
├─ email (VARCHAR 100)
├─ tamaño_familiar (INT)
├─ direccion (TEXT)
├─ necesidades (TEXT)
├─ estado_validacion (ENUM: validado/pendiente)
├─ fecha_ultima_asignacion (DATETIME)
└─ created_at (TIMESTAMP)

voluntarios_db
├─ id (PK, INT AUTO_INCREMENT)
├─ nombre (VARCHAR 255)
├─ telefono (INT)
├─ horas_disponibles (VARCHAR 255)
└─ habilidades (VARCHAR 255)

puntos_distribucion
├─ id (PK, INT AUTO_INCREMENT)
├─ nombre (VARCHAR 255)
├─ direccion (TEXT)
├─ responsable (VARCHAR 255)
├─ telefono (VARCHAR 50)
├─ latitud (DECIMAL 10,6)
├─ longitud (DECIMAL 10,6)
├─ horario (VARCHAR 255)
├─ descripcion (TEXT)
└─ created_at (DATETIME)

alertas_caducidad
├─ id (PK, INT AUTO_INCREMENT)
├─ nombre_producto (VARCHAR 255)
├─ punto_distribucion_id (FK)
├─ fecha_expiracion (DATE)
├─ diasRestantes (COMPUTED)
├─ estado (ENUM: ok/proximo/urgente/critico/caducado)
└─ created_at (TIMESTAMP)

asignaciones_productos
├─ id (PK, INT AUTO_INCREMENT)
├─ beneficiario_id (FK)
├─ producto (VARCHAR 255)
├─ cantidad (INT)
├─ fecha_asignacion (DATETIME)
└─ observaciones (TEXT)
```

### Relaciones

```
beneficiarios 1:N asignaciones_productos
  beneficiario.id → asignaciones.beneficiario_id

puntos_distribucion 1:N alertas_caducidad
  punto.id → alerta.punto_distribucion_id

beneficiarios ←→ puntos_distribucion (N:N indirecta via asignaciones)
```

### Consultas Típicas

```sql
-- Listar todos
SELECT * FROM beneficiarios ORDER BY id DESC

-- Búsqueda
SELECT * FROM beneficiarios 
WHERE nombre LIKE ? OR apellidos LIKE ?

-- Crear
INSERT INTO beneficiarios (nombre, apellidos, ...) 
VALUES (?, ?, ...)

-- Actualizar
UPDATE beneficiarios 
SET estado_validacion = 'validado' 
WHERE id = ?

-- Eliminar (con cascada si está configurado)
DELETE FROM beneficiarios WHERE id = ?

-- Alertas por vencer
SELECT * FROM alertas_caducidad 
WHERE DATEDIFF(fecha_expiracion, CURDATE()) <= 15
ORDER BY fecha_expiracion ASC
```

---

## Patrones de Diseño

### 1. MVC (Model-View-Controller)
- **Separación de responsabilidades**
- Lógica de negocio en Modelos
- Presentación en Vistas
- Control en Controllers

### 2. Singleton (Sesión)
```php
class Sesion {
    private static $instancia;
    
    public static function iniciarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
// Uso: Sesion::iniciarSesion()
```

### 3. DAO (Data Access Object)
```php
class BD {
    private $conexion;
    
    public function insertar($sql, $params)
    public function seleccionar($sql, $params)
    public function ejecutar($sql, $params)
}
// Abstrae acceso a BD
```

### 4. Active Record (Parcial)
```php
class Beneficiario {
    public function guardar()      // Insert/Update
    public static function listar() // Select all
    public static function obtenerPorId($id) // Select by ID
    public static function eliminar($id)     // Delete
}
```

### 5. Factory Pattern (Autoloader)
```php
spl_autoload_register(function($clase) {
    // Busca automáticamente archivos de clases
    // Instancia automáticamente clases
});
```

### 6. Conditional Rendering
```php
<?php if ($esAdmin): ?>
    <!-- Contenido solo para admin -->
<?php endif; ?>
```

---

## Flujo de Autenticación

### Login Process

```
1. Usuario accede a index.php sin sesión
   └─ Redirige a login.html

2. Usuario ingresa credenciales
   └─ Envía POST a ControladorAuth::login()

3. ControladorAuth::login()
   ├─ Obtiene usuario y password del POST
   ├─ Llama a Sesion::login($usuario, $password)
   └─ Si es exitoso → redirige a home
     Si es error → muestra mensaje

4. Sesion::login()
   ├─ Verifica si usuario existe en array
   ├─ Valida contraseña
   ├─ Si es correcto:
   │  ├─ Crea $_SESSION['usuario']
   │  ├─ Crea $_SESSION['rol']
   │  └─ Crea $_SESSION['autenticado'] = true
   └─ Retorna true/false

5. Usuario accede a módulo
   ├─ index.php verifica:
   │  ├─ ¿Tiene sesión activa? (Sesion::estaAutenticado())
   │  └─ ¿Tiene permiso al módulo? (según rol)
   └─ Acceso concedido o denegado

6. Usuario cierra sesión
   ├─ Clic en "Cerrar Sesión"
   ├─ Llamada a ControladorAuth::logout()
   └─ Sesion::logout() destruye sesión
```

### Control de Acceso

```
Controladores Públicos:
└─ Auth (login, logout)

Controladores Protegidos (Admin):
├─ Voluntario (CRUD)
├─ AlertaCaducidad (CRUD)
└─ etc.

Controladores Semi-Protegidos (Admin + Usuario):
├─ Home (visualización)
├─ Beneficiario (vista limitada para usuario)
└─ PuntoDistribucion (vista limitada para usuario)
```

---

## Seguridad

### Medidas Implementadas

```
✅ Sesiones PHP nativas
   ├─ session_start()
   ├─ $_SESSION para almacenar datos
   └─ session_destroy() para logout

✅ Prepared Statements (PDO)
   ├─ Previene SQL injection
   ├─ Parámetros con :nombre
   └─ execute($params) seguro

✅ Control de Acceso Basado en Roles (RBAC)
   ├─ Validación en index.php
   ├─ Validación en vistas (hidden buttons)
   └─ Validación en controladores

✅ Validación de Entrada
   ├─ trim() para espacios
   ├─ htmlspecialchars() para output
   ├─ isset() para campos
   └─ Required en inputs HTML

✅ Restricción de Módulos
   ├─ Admin acceso total
   ├─ Usuario normal acceso limitado
   └─ Redirección automática si no autorizado

⚠️ Mejoras Futuras Recomendadas

├─ Hashing de contraseñas (bcrypt/Argon2)
├─ Tokens CSRF en formularios
├─ Rate limiting en login
├─ Logs de acceso y auditoría
├─ HTTPS forzado
├─ Headers de seguridad (CSP, X-Frame-Options)
├─ 2FA (autenticación de dos factores)
├─ Encriptación de datos sensibles
└─ Rotación de sesiones
```

### Funciones de Seguridad Utilizadas

```php
// Escapar output
echo htmlspecialchars($variable);

// Validar entrada
$variable = isset($_POST['campo']) ? trim($_POST['campo']) : '';

// Prepared statements
$sql = "SELECT * FROM usuarios WHERE id = ?";
$bd->seleccionar($sql, [$id]);

// Sesiones seguras
session_start();
$_SESSION['usuario'] = $usuario;

// Validación de rol
if (!Sesion::esAdmin()) {
    die('Acceso denegado');
}
```

---

## Escalabilidad

### Recomendaciones de Crecimiento

#### 1. Base de Datos
```
Actual:
├─ Base de datos única
├─ Todas las tablas en un servidor
└─ Conexión única

Mejorado:
├─ Conexión a pool de BD
├─ Índices en campos frecuentes
├─ Particionamiento de tablas grandes
├─ Replicación master-slave
└─ Caché (Redis/Memcached)
```

#### 2. Backend
```
Actual:
├─ Servidor único
├─ Procesamiento síncrono
└─ Ejecución en tiempo real

Mejorado:
├─ Múltiples servidores
├─ Load balancer
├─ Colas de trabajo (Beanstalkd/RabbitMQ)
├─ APIs REST
├─ Microservicios
└─ Caché de datos
```

#### 3. Frontend
```
Actual:
├─ Archivos CSS/JS directos
├─ Sin minificación
└─ Sin compresión

Mejorado:
├─ Bundler (Webpack/Vite)
├─ Minificación de assets
├─ Compresión GZIP
├─ CDN para static files
├─ Service Workers
└─ PWA (Progressive Web App)
```

#### 4. Infraestructura
```
Actual:
├─ XAMPP local
├─ Servidor único
└─ Sin redundancia

Mejorado:
├─ Cloud (AWS/Azure/GCP)
├─ Docker containerización
├─ Kubernetes orquestación
├─ CI/CD (GitHub Actions/Jenkins)
├─ Monitoring (Prometheus/Grafana)
└─ Alertas automáticas
```

#### 5. Código
```
Actual:
├─ Monolítico
├─ Métodos en controladores
└─ Lógica mixta

Mejorado:
├─ Separar en capas/servicios
├─ Inyección de dependencias
├─ Interfaces y abstracciones
├─ Testing automatizado
├─ Code standards (PSR)
└─ Documentation (API docs)
```

### Plan de Escalabilidad

```
Fase 1 (Actual): MVP
├─ Monolítico MVC
├─ BD única
└─ Servidor único

Fase 2 (6 meses):
├─ Optimización BD (índices)
├─ Caché de datos
├─ Compresión de assets
└─ Logs centralizados

Fase 3 (1 año):
├─ APIs REST
├─ Múltiples servidores
├─ Docker
└─ CI/CD

Fase 4 (2 años):
├─ Microservicios
├─ Kubernetes
├─ Analytics
└─ Machine Learning
```

---

## Tecnologías Complementarias

### Recomendadas para Producción

```
PHP Framework:
├─ Laravel
├─ Symfony
└─ Slim

Templating:
├─ Blade (Laravel)
├─ Twig (Symfony)
└─ Mustache

Frontend Framework:
├─ Vue.js
├─ React
└─ Angular

Base de Datos:
├─ PostgreSQL (producción)
├─ Redis (caché)
└─ MongoDB (datos no estructurados)

Testing:
├─ PHPUnit
├─ Jest
└─ Cypress

Tooling:
├─ Composer (PHP dependencies)
├─ NPM (JS dependencies)
├─ Docker (containerización)
└─ Git (versionado)
```

---

## Diagrama de Arquitectura Completa

```
                        ┌─────────────────────────────────┐
                        │      INTERNET / USUARIOS        │
                        └──────────────┬──────────────────┘
                                       │
                                       ▼
                        ┌─────────────────────────────────┐
                        │   CAPA DE PRESENTACIÓN          │
                        │  (HTML5 + CSS3 + JavaScript)    │
                        │   ├─ home.html                  │
                        │   ├─ login.html                 │
                        │   └─ gestion_*.html             │
                        └──────────────┬──────────────────┘
                                       │
                                       ▼
                        ┌─────────────────────────────────┐
                        │   CAPA DE APLICACIÓN            │
                        │      (PHP 8.2)                  │
                        │                                 │
                        │  ┌──────────────────────────┐   │
                        │  │  Router (index.php)      │   │
                        │  │  ├─ Session Mgmt         │   │
                        │  │  ├─ Autenticación        │   │
                        │  │  └─ Autorización         │   │
                        │  └──────────────────────────┘   │
                        │           ▲                     │
                        │           │ Carga              │
                        │   ┌───────┴────────┐           │
                        │   │                │           │
                        │   ▼                ▼           │
                        │  ┌──────────┐   ┌──────────┐  │
                        │  │Controller│   │  Model   │  │
                        │  │          │   │          │  │
                        │  │  Recibe  │   │  Lógica  │  │
                        │  │  Datos   │   │  de      │  │
                        │  │  Prepara │   │  Negocio │  │
                        │  │  Vistas  │   │  Acceso  │  │
                        │  │          │   │  a BD    │  │
                        │  └────┬─────┘   └────┬─────┘  │
                        │       │              │        │
                        │       │ Renderiza    │ Carga  │
                        │       │              │        │
                        │       └───────┬──────┘        │
                        │               ▼               │
                        │        ┌──────────────┐       │
                        │        │  Sesion.php  │       │
                        │        │  BD.php      │       │
                        │        └──────────────┘       │
                        └──────────────┬──────────────────┘
                                       │
                                       ▼
                        ┌─────────────────────────────────┐
                        │      CAPA DE DATOS              │
                        │    (MariaDB 10.4.32)            │
                        │                                 │
                        │  ┌─────────────────────────┐   │
                        │  │ Tablas SQL              │   │
                        │  │ ├─ beneficiarios        │   │
                        │  │ ├─ voluntarios_db       │   │
                        │  │ ├─ puntos_distribucion  │   │
                        │  │ ├─ alertas_caducidad    │   │
                        │  │ └─ asignaciones         │   │
                        │  └─────────────────────────┘   │
                        │                                 │
                        │  Índices, Constraints, Relaciones
                        └─────────────────────────────────┘
```

---

## Resumen Técnico

| Aspecto | Detalles |
|---------|----------|
| **Patrón Arquitectónico** | MVC (Model-View-Controller) |
| **Lenguaje Backend** | PHP 8.2 OOP |
| **Lenguaje Frontend** | HTML5 + CSS3 + JavaScript Vanilla |
| **Base de Datos** | MariaDB 10.4.32 |
| **Servidor Web** | Apache 2.4 (XAMPP) |
| **ORM/Query Builder** | PDO Nativo (Prepared Statements) |
| **Autenticación** | Sessions PHP + Clase Sesion |
| **Autorización** | RBAC (Role-Based Access Control) |
| **Gestión de Dependencias** | Autoloader nativo PHP |
| **Versionado** | Git |

---

**Última actualización:** 17 de Enero, 2026  
**Versión:** 1.0  
**Estado:** Producción (con mejoras recomendadas)
