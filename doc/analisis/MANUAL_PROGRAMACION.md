# Manual de Programación - Sistema de Gestión del Banco de Alimentos

**Versión:** 1.0  
**Fecha:** 17 de Enero, 2026  
**Dirigido a:** Desarrolladores del proyecto

---

## Tabla de Contenidos

1. [Introducción](#introducción)
2. [Arquitectura General](#arquitectura-general)
3. [Estructura del Proyecto](#estructura-del-proyecto)
4. [Flujo de Ejecución](#flujo-de-ejecución)
5. [Convenciones de Código](#convenciones-de-código)
6. [Capas y Componentes](#capas-y-componentes)
7. [Base de Datos y Acceso](#base-de-datos-y-acceso)
8. [Autenticación y Sesión](#autenticación-y-sesión)
9. [Roles y Permisos (RBAC)](#roles-y-permisos-rbac)
10. [Creación de Nuevos Módulos](#creación-de-nuevos-módulos)
11. [Controladores: Guía y Referencia](#controladores-guía-y-referencia)
12. [Modelos: Guía y Referencia](#modelos-guía-y-referencia)
13. [Vistas: Guía y Referencia](#vistas-guía-y-referencia)
14. [Validaciones y Seguridad](#validaciones-y-seguridad)
15. [Front-End (CSS/JS)](#front-end-cssjs)
16. [Debugging y Logs](#debugging-y-logs)
17. [Pruebas](#pruebas)
18. [Despliegue](#despliegue)
19. [Roadmap Técnico](#roadmap-técnico)
20. [Apéndices](#apéndices)

---

## Introducción

Este manual describe cómo desarrollar y mantener el Sistema de Gestión del Banco de Alimentos, construido sobre PHP 8.2 con un patrón MVC ligero. Se documenta la estructura, flujos, estándares, y procedimientos para añadir funcionalidades con calidad y seguridad.

---

## Arquitectura General

- **Patrón:** MVC (Model-View-Controller)  
- **Backend:** PHP 8.2 (PDO, sesiones)  
- **Frontend:** HTML5, CSS3, JavaScript (vanilla)  
- **Base de Datos:** MariaDB 10.4.32 / MySQL 8  
- **Servidor:** Apache 2.4 (XAMPP en desarrollo)  
- **Sesiones:** Autenticación vía `Sesion.php` y rol `admin`/`usuario`

Diagrama simplificado:

```
Cliente (HTML/CSS/JS) → index.php → Controladores → Modelos (BD) → MariaDB
                                      ↓
                                  Vistas (HTML)
```

---

## Estructura del Proyecto

```
DAW2-ProyectoIntermodular/
├── README.md
├── doc/
│   ├── analisis/
│   ├── diseños/
│   └── sprints/
│       ├── product_backlog.md
│       ├── sprint_backlog.md
│       ├── sprint1.md
│       ├── historias_usuarios/
│       └── ...
├── src/
│   ├── config.php
│   ├── index.php
│   └── sql/
│       ├── alertas_caducidad.csv
│       └── sprint.sql
└── www/
    ├── controladores/
    │   ├── controladorAlertaCaducidad.php
    │   ├── controladorPuntoDistribucion.php
    │   └── controladorVoluntario.php
    ├── css/
    │   ├── gestion_alertas_caducidad.css
    │   ├── gestion_puntos_distribucion.css
    │   └── gestion_voluntarios.css
    ├── js/
    │   ├── gestion_alertas_caducidad.js
    │   ├── gestion_puntos_distribucion.js
    │   └── gestion_voluntarios.js
    ├── modelos/
    │   ├── alertaCaducidad.php
    │   ├── bd.php
    │   ├── puntoDistribucion.php
    │   └── voluntario.php
    └── vistas/
        └── html/
            ├── gestion_alertas_caducidad.html
            ├── gestion_puntos_distribucion.html
            └── gestion_voluntarios.html
```

---

## Flujo de Ejecución

1. El usuario accede a `src/index.php`
2. `index.php` inicia sesión y dirige al controlador según ruta/acción
3. El controlador valida permisos y procesa la petición
4. El modelo se comunica con BD mediante `BD` (PDO)
5. El controlador prepara datos y renderiza una vista HTML

---

## Convenciones de Código

- **Estilo PHP:**
  - PSR-12 (adaptado): nombres `CamelCase` para clases, `camelCase` para métodos/variables
  - Archivos de clases con nombre igual a la clase
  - Evitar variables de una letra; nombres descriptivos
- **Errores:** usar `try/catch` y registrar errores
- **BD:** consultas con `PDO::prepare()` y `bindParam`
- **Seguridad:** sanitizar entradas; `htmlspecialchars` en vistas
- **Rutas:** controladores reciben `action` por GET/POST, validada contra lista permitida

---

## Capas y Componentes

### `index.php`
- Punto de entrada. Determina el controlador a ejecutar, inicia sesión si aplica.

### Controladores (`www/controladores/`)
- Orquestan lógica de negocio y llamadas a modelos.
- Validan permisos en base a `Sesion` y rol.

### Modelos (`www/modelos/`)
- Encapsulan acceso a BD. No renderizan vistas.
- Usan `BD` para ejecutar consultas.

### Vistas (`www/vistas/html/`)
- Plantillas HTML. Consumidas por controladores.

### `BD` (`www/modelos/bd.php`)
- Singleton/conector PDO. Provee `query`, `fetch`, `execute`.

---

## Base de Datos y Acceso

### Conexión PDO

Ejemplo de uso:
```php
$pdo = BD::getConexion();
$stmt = $pdo->prepare('SELECT * FROM voluntarios_db WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$voluntario = $stmt->fetch(PDO::FETCH_ASSOC);
```

### Transacciones

```php
$pdo->beginTransaction();
try {
    // ... operaciones
    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
}
```

### Migraciones
- Se suministra `src/sql/sprint.sql`. Se recomienda añadir scripts incrementales para cambios futuros.

---

## Autenticación y Sesión

- Clase `Sesion` (referenciada en documentación) gestiona login/logout.
- Credenciales de ejemplo: `admin/admin123`, `user/user123` (solo desarrollo).
- Pautas: almacenar contraseñas con `password_hash` en producción.

Flujo:
```
login.html → ControladorAuth → Sesion::login() → redirección al Home
```

---

## Roles y Permisos (RBAC)

- Roles: `admin`, `usuario`
- `admin`: CRUD completo en todos los módulos.
- `usuario`: lectura en Beneficiarios y Alertas; limitado en Voluntarios y Puntos.

Validación típica en controlador:
```php
if (!Sesion::tieneRol('admin')) {
    http_response_code(403);
    echo 'Acceso denegado';
    exit;
}
```

---

## Creación de Nuevos Módulos

### 1. Modelo
- Ubicación: `www/modelos/NombreModulo.php`
- Responsabilidad: métodos para CRUD y consultas específicas.

### 2. Controlador
- Ubicación: `www/controladores/controladorNombreModulo.php`
- Responsabilidad: validar input/roles, coordinar modelo y renderizar vista.

### 3. Vista
- Ubicación: `www/vistas/html/gestion_nombre_modulo.html`
- Responsabilidad: estructura HTML + hooks para JS/CSS.

### 4. Frontend
- CSS: `www/css/gestion_nombre_modulo.css`
- JS: `www/js/gestion_nombre_modulo.js`

### 5. Rutas
- Definir `action` manejadas por el controlador: `listar`, `crear`, `actualizar`, `eliminar`.

### 6. Validación
- Sanitizar inputs y validar tipos (p. ej., `telefono` como numérico).

---

## Controladores: Guía y Referencia

### Estructura Base
```php
class ControladorEjemplo {
    public function listar() {}
    public function crear() {}
    public function actualizar() {}
    public function eliminar() {}
}
```

### Buenas Prácticas
- Validar `$_GET`/`$_POST` y usar filtros: `filter_input`
- Responder JSON para peticiones AJAX cuando proceda
- Manejar errores y devolver códigos HTTP apropiados

---

## Modelos: Guía y Referencia

### Estructura Base
```php
class Ejemplo {
    private PDO $pdo;
    public function __construct() { $this->pdo = BD::getConexion(); }

    public function obtenerPorId(int $id): ?array {}
    public function crear(array $data): int {}
    public function actualizar(int $id, array $data): bool {}
    public function eliminar(int $id): bool {}
}
```

### Buenas Prácticas
- Mapear columnas correctamente (tipos INT, VARCHAR, DATE)
- Usar `LIMIT` y paginación en listados
- Manejar excepciones `PDOException`

---

## Vistas: Guía y Referencia

- Plantillas HTML separadas, sin lógica de negocio
- Escapar variables con `htmlspecialchars($variable, ENT_QUOTES, 'UTF-8')`
- Incluir CSS/JS específicos del módulo

---

## Validaciones y Seguridad

- Usar `filter_var` para emails, URLs, enteros
- Prevenir XSS: escapar salida
- Prevenir CSRF: tokens por formulario (a implementar en roadmap)
- Prevenir SQL Injection: siempre consultas preparadas
- Gestión de errores: no mostrar detalles sensibles en producción

---

## Front-End (CSS/JS)

- **CSS:** seguir esquema de colores del proyecto (verde principal). Usar BEM si es posible.
- **JS:** modular, funciones claras, evitar variables globales. Manejar eventos de forma declarativa.

Ejemplo JS:
```js
document.getElementById('btnBuscar').addEventListener('click', () => {
  const q = document.getElementById('inputBusqueda').value.trim();
  if (!q) return;
  // fetch(...) y render
});
```

---

## Debugging y Logs

- Habilitar `error_reporting(E_ALL)` en desarrollo
- Revisar `apache error.log`
- Agregar registros con `error_log('mensaje')`
- Depurar SQL mostrando parámetros (solo en desarrollo)

---

## Pruebas

- **Unitarias:** pragmáticas para modelos (métodos puros)
- **Integración:** validar flujo controlador-modelo-vista con entorno local
- **Manual:** seguir checklist del Manual de Instalación

Herramientas sugeridas:
- `phpunit` (a integrar)

---

## Despliegue

- Entorno de producción con Apache/PHP 8.x
- Configuración de `config.php` con credenciales seguras
- `debug=false`, `display_errors=Off`
- Backups automáticos y monitoreo de logs

---

## Roadmap Técnico

- Añadir `ControladorAuth.php` y `Sesion.php` formalizados
- Implementar CSRF tokens
- Añadir `phpunit` y pruebas automáticas
- Paginación y filtros en listados grandes
- API REST para móvil (beneficiarios)

---

## Apéndices

### A. Snippets Útiles

- Sanitizar entrada:
```php
$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
```

- Escapar salida:
```php
echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
```

- Validar entero:
```php
$telefono = filter_input(INPUT_POST, 'telefono', FILTER_VALIDATE_INT);
```

### B. Errores Comunes

- `SQLSTATE[HY000]: 1366` por tipos incorrectos (ej.: `telefono` con texto). Solución: castear a `int` y validar.
- "Página en blanco": revisar `error.log` y activar `display_errors` en desarrollo.

---

**Última actualización:** 17 de Enero, 2026  
**Versión del documento:** 1.0  
**Preparado por:** Equipo de Desarrollo
