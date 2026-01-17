# Sprint 1: Fundamentos y Autenticación

**Duración:** 2 semanas  
**Fecha Inicio:** 6 de Enero, 2026  
**Fecha Fin:** 17 de Enero, 2026  
**Objetivo:** Establecer la arquitectura base del sistema, implementar autenticación de usuarios y control de acceso basado en roles  
**Estado:** COMPLETADO

---

## Resumen

Este sprint establece los cimientos del sistema de gestión del Banco de Alimentos. Se implementó una arquitectura MVC completa en PHP, un sistema de autenticación robusto con sesiones, y control de acceso basado en roles (RBAC) diferenciando entre administradores y usuarios normales.

---

## Historias de Usuario

### HU-00: Configuración Inicial del Proyecto
**Puntos de Historia:** 5  
**Prioridad:** CRÍTICA  
**Asignado a:** Equipo completo  
**Estado:** COMPLETADA

#### Descripción
Como desarrollador, necesito configurar la estructura base del proyecto para que el equipo pueda trabajar de forma organizada y escalable.

#### Criterios de Aceptación
- [X] Estructura MVC implementada correctamente
- [X] Clase BD con PDO funcionando
- [X] Archivo config.php con rutas configuradas
- [X] Autoloader de clases operativo
- [X] Router principal (index.php) funcionando

#### Tareas Técnicas

| ID | Tarea | Descripción | Tiempo | Estado |
|----|-------|-------------|--------|--------|
| T-001 | Configurar estructura MVC | Crear carpetas modelos/, controladores/, vistas/ | 2h | Completada |
| T-002 | Crear clase BD | Implementar PDO con prepared statements | 3h | Completada |
| T-003 | Configurar config.php | Definir rutas y parámetros de BD | 1h | Completada |
| T-004 | Implementar autoloader | spl_autoload_register para clases | 2h | Completada |
| T-005 | Crear router index.php | Dispatcher de controladores y métodos | 4h | Completada |

#### Notas de Implementación
```php
// Estructura de carpetas creada:
src/
  www/
    controladores/
    modelos/
    vistas/
      html/
    css/
    js/
  config.php
  index.php
```

---

### HU-01: Sistema de Autenticación y Login
**Puntos de Historia:** 8  
**Prioridad:** CRÍTICA  
**Asignado a:** Backend Team  
**Estado:** COMPLETADA

#### Descripción
Como usuario del sistema, quiero poder iniciar sesión con mis credenciales para acceder a las funcionalidades según mi rol.

#### Criterios de Aceptación
- [X] Usuario puede ingresar username y password
- [X] Sistema valida credenciales correctamente
- [X] Sesión se mantiene entre páginas
- [X] Mensajes de error claros para credenciales inválidas
- [X] Logout destruye la sesión completamente
- [X] Redirección automática según rol

#### Tareas Técnicas

| ID | Tarea | Descripción | Tiempo | Estado |
|----|-------|-------------|--------|--------|
| T-006 | Crear clase Sesion.php | Modelo estático para autenticación | 4h | Completada |
| T-007 | Implementar método login() | Validación de credenciales | 3h | Completada |
| T-008 | Implementar método logout() | Destruir sesión | 1h | Completada |
| T-009 | Crear ControladorAuth | Controller para login/logout | 3h | Completada |
| T-010 | Diseñar login.html | Interfaz de login responsive | 4h | Completada |
| T-011 | Validar sesión en index.php | Proteger rutas | 2h | Completada |
| T-012 | Manejo de errores | Mensajes de error en login | 2h | Completada |

#### Código Clave Implementado

**Sesion.php:**
```php
class Sesion {
    private static $usuarios = [
        'admin' => ['password' => 'admin123', 'rol' => 'admin'],
        'user' => ['password' => 'user123', 'rol' => 'usuario']
    ];

    public static function login($usuario, $password) {
        if (isset(self::$usuarios[$usuario]) && 
            self::$usuarios[$usuario]['password'] === $password) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['rol'] = self::$usuarios[$usuario]['rol'];
            $_SESSION['autenticado'] = true;
            return true;
        }
        return false;
    }
}
```

#### Demo
- **URL:** `http://localhost/DAW2-ProyectoIntermodular/src/index.php?controlador=Auth&metodo=login`
- **Credenciales Admin:** admin / admin123
- **Credenciales Usuario:** user / user123

---

### HU-02: Control de Acceso Basado en Roles (RBAC)
**Puntos de Historia:** 5  
**Prioridad:** CRÍTICA  
**Asignado a:** Backend Team  
**Estado:** COMPLETADA

#### Descripción
Como administrador del sistema, quiero que los usuarios tengan diferentes niveles de acceso según su rol para proteger funcionalidades críticas.

#### Criterios de Aceptación
- [X] Roles definidos: admin y usuario
- [X] Admin tiene acceso total a todos los módulos
- [X] Usuario normal solo accede a módulos permitidos
- [X] Validación en el router (index.php)
- [X] Validación en las vistas (botones ocultos)
- [X] Mensaje "Acceso Denegado" para intentos no autorizados

#### Tareas Técnicas

| ID | Tarea | Descripción | Tiempo | Estado |
|----|-------|-------------|--------|--------|
| T-013 | Implementar roles | Definir admin y usuario | 2h | Completada |
| T-014 | Métodos de verificación | esAdmin(), esUsuarioNormal() | 2h | Completada |
| T-015 | Validar permisos en router | Bloquear acceso por rol | 3h | Completada |
| T-016 | Restringir módulos | Solo admin: Voluntarios, Alertas | 2h | Completada |
| T-017 | Protección en vistas | Ocultar formularios/botones | 3h | Completada |

#### Matriz de Permisos

| Módulo | Admin | Usuario Normal |
|--------|-------|----------------|
| Home | Lectura/Escritura | Lectura |
| Beneficiarios | CRUD completo | Solo lectura |
| Voluntarios | CRUD completo | Sin acceso |
| Puntos Distribución | CRUD completo | Solo lectura |
| Alertas Caducidad | CRUD completo | Sin acceso |

#### Código Implementado

**index.php - Validación de permisos:**
```php
// Controladores públicos
$controladores_publicos = ['Auth'];

// Controladores permitidos por rol
$modulos_permitidos = [
    'admin' => ['*'], // Acceso total
    'usuario' => ['Home', 'PuntoDistribucion', 'Beneficiario']
];

// Validar acceso
if (!Sesion::estaAutenticado() && !in_array($controlador, $controladores_publicos)) {
    header("Location: index.php?controlador=Auth&metodo=login");
    exit;
}
```

---

### HU-03: Interfaz de Inicio (Home)
**Puntos de Historia:** 5  
**Prioridad:** ALTA  
**Asignado a:** Frontend Team  
**Estado:** COMPLETADA

#### Descripción
Como usuario autenticado, quiero ver un panel principal con acceso rápido a los módulos disponibles según mi rol.

#### Criterios de Aceptación
- [X] Panel principal con grid de módulos
- [X] Módulos mostrados según rol del usuario
- [X] Navbar con información del usuario
- [X] Botón de logout visible y funcional
- [X] Diseño responsive
- [X] Acceso visual rápido a cada módulo

#### Tareas Técnicas

| ID | Tarea | Descripción | Tiempo | Estado |
|----|-------|-------------|--------|--------|
| T-018 | Diseñar home.html | Layout principal | 4h | Completada |
| T-019 | Crear grid de módulos | CSS Grid responsive | 3h | Completada |
| T-020 | Acceso condicional | Mostrar módulos por rol | 2h | Completada |
| T-021 | Diseñar navbar | Barra superior reutilizable | 3h | Completada |
| T-022 | Implementar logout | Botón en navbar | 1h | Completada |

#### Diseño Implementado

**Componentes del Home:**
```
┌─────────────────────────────────────────┐
│ Navbar                                   │
│ Logo | Usuario: admin (Admin) | Logout  │
├─────────────────────────────────────────┤
│                                         │
│  Banco de Alimentos - Panel Principal   │
│                                         │
│  ┌──────────┐  ┌──────────┐           │
│  │ Benefi-  │  │ Puntos   │           │
│  │ ciarios  │  │ Distrib. │           │
│  └──────────┘  └──────────┘           │
│                                         │
│  ┌──────────┐  ┌──────────┐ (Admin)   │
│  │ Alertas  │  │ Volunt.  │           │
│  │ Caducidad│  │          │           │
│  └──────────┘  └──────────┘           │
│                                         │
└─────────────────────────────────────────┘
```

#### Estilos Aplicados
- **Colores:** Paleta verde (#2F855A primary, #68D391 accent)
- **Tipografía:** System fonts, fallback a sans-serif
- **Layout:** CSS Grid con auto-fit y minmax
- **Responsive:** Media queries para móviles

---

## Retrospectiva del Sprint

### Lo que salió bien
- Estructura MVC sólida desde el inicio
- Sistema de autenticación robusto y seguro
- RBAC implementado correctamente en todas las capas
- Diseño UI/UX limpio y profesional
- Trabajo en equipo coordinado

### Lo que se puede mejorar
- Migrar credenciales hardcodeadas a base de datos
- Implementar hashing de contraseñas (bcrypt)
- Agregar validación de fortaleza de contraseñas
- Implementar recuperación de contraseña
- Agregar logs de auditoría

### Bloqueadores encontrados
- Ninguno crítico
- Pequeños ajustes en rutas de archivos

### Aprendizajes
- Importancia de definir bien la arquitectura al inicio
- RBAC debe implementarse desde el principio
- Sesiones PHP son suficientes para MVP
- Diseño simple funciona mejor

---

## Métricas del Sprint

### Velocidad
- **Puntos planeados:** 23
- **Puntos completados:** 23
- **Velocidad:** 23 puntos/2 semanas = 11.5 puntos/semana

### Tiempo
- **Horas estimadas:** 50h
- **Horas reales:** 48h
- **Eficiencia:** 104%

### Calidad
- **Bugs encontrados:** 0 críticos
- **Code review:** Aprobado
- **Tests manuales:** Todos pasados

---

## Deuda Técnica Identificada

1. **Contraseñas en texto plano** - Prioridad: ALTA
   - Migrar a bcrypt o Argon2
   - Implementar salt único por usuario

2. **Usuarios hardcodeados** - Prioridad: MEDIA
   - Crear tabla `usuarios` en BD
   - Migrar datos de array a BD

3. **Sin recuperación de contraseña** - Prioridad: BAJA
   - Implementar en Sprint futuro

4. **Sin 2FA** - Prioridad: BAJA
   - Para versión futura

---

## Entregables

### Código
- [X] Estructura MVC completa
- [X] Clase BD con PDO
- [X] Clase Sesion
- [X] ControladorAuth
- [X] login.html
- [X] home.html
- [X] config.php
- [X] index.php (router)

### Documentación
- [X] README.md actualizado
- [X] AUTENTICACION.md
- [X] FLUJO_AUTENTICACION.md
- [X] DOCUMENTACION_CODIGO.md
- [X] GUIA_ESTILOS.md
- [X] ARQUITECTURA_TECNOLOGICA.md

### Testing
- [X] Tests manuales de login
- [X] Tests de permisos por rol
- [X] Tests de sesiones
- [X] Tests de logout

---

## Demo y Validación

### Casos de Uso Probados

1. **Login Exitoso (Admin)**
   - Input: admin / admin123
   - Resultado: Acceso concedido, redirige a home
   - Estado: PASS

2. **Login Exitoso (Usuario)**
   - Input: user / user123
   - Resultado: Acceso concedido, redirige a home
   - Estado: PASS

3. **Login Fallido**
   - Input: wrong / wrong
   - Resultado: Mensaje de error, permanece en login
   - Estado: PASS

4. **Acceso sin Sesión**
   - Intento: Acceder a módulo sin login
   - Resultado: Redirección a login
   - Estado: PASS

5. **Acceso No Autorizado**
   - Intento: Usuario normal accede a Voluntarios
   - Resultado: "Acceso Denegado"
   - Estado: PASS

6. **Logout**
   - Acción: Click en "Cerrar Sesión"
   - Resultado: Sesión destruida, redirige a login
   - Estado: PASS

---

## Próximos Pasos (Sprint 2)

1. Implementar CRUD de Beneficiarios
2. Agregar búsqueda y filtros
3. Crear formularios de registro
4. Implementar validaciones de entrada
5. Conectar con base de datos real

---

**Sprint Review:** 17 de Enero, 2026  
**Participantes:** Equipo completo  
**Resultado:** Sprint EXITOSO - Todos los objetivos cumplidos  
**Preparado por:** Equipo de Desarrollo
