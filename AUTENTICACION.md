# Sistema de Autenticación y Roles

## Credenciales de Acceso

Se ha implementado un sistema de login con dos tipos de usuarios:

### 👑 Administrador
- **Usuario:** `admin`
- **Contraseña:** `admin123`
- **Permisos:**
  - ✅ Acceso a todos los módulos
  - ✅ Gestión de Beneficiarios (crear, editar, eliminar)
  - ✅ Gestión de Voluntarios (crear, editar, eliminar)
  - ✅ Gestión de Puntos de Distribución (crear, editar, eliminar)
  - ✅ Gestión de Alertas de Caducidad (crear, editar, eliminar)

### 👤 Usuario Normal
- **Usuario:** `user`
- **Contraseña:** `user123`
- **Permisos:**
  - ✅ Acceso a Beneficiarios (solo lectura, sin crear/editar/eliminar)
  - ✅ Acceso a Puntos de Distribución (solo lectura, sin crear/editar/eliminar)
  - ❌ NO acceso a Voluntarios
  - ❌ NO acceso a Alertas de Caducidad
  - ❌ NO acceso a otras funciones de administración

## Características Implementadas

### 1. Página de Login
- Formulario seguro con validación
- Credenciales mostradas para fines de demostración
- Diseño consistente con el resto de la aplicación
- Interfaz responsiva y amigable

### 2. Gestión de Sesiones
- Clase `Sesion` para manejar login/logout
- Validación de autenticación en todas las páginas
- Protección de rutas basada en roles
- Logout seguro que destruye la sesión

### 3. Interfaz de Usuario
- Navbar en todas las vistas con información del usuario
- Indicador visual del rol (👑 Admin / 👤 Usuario)
- Botón de logout en la esquina superior derecha
- Menú principal que muestra solo los módulos disponibles según el rol

### 4. Control de Acceso
- El archivo `index.php` valida permisos antes de ejecutar controladores
- Usuarios normales reciben mensajes de "Acceso denegado" al intentar acceder a módulos restringidos
- Redirección automática al login si la sesión ha expirado

## Archivos Modificados/Creados

### Nuevos archivos:
- `src/www/modelos/Sesion.php` - Clase de gestión de sesiones y autenticación
- `src/www/controladores/ControladorAuth.php` - Controlador de autenticación
- `src/www/vistas/login.html` - Página de login

### Archivos modificados:
- `src/index.php` - Agregado validación de sesión y control de permisos
- `src/www/vistas/html/home.html` - Agregado navbar, logout y menú dinámico según rol
- `src/www/vistas/html/gestion_beneficiarios.html` - Agregado navbar y protección de acciones (delete solo para admin)
- `src/www/vistas/html/gestion_puntos_distribucion.html` - Agregado navbar
- `src/www/vistas/html/gestion_voluntarios.html` - Agregado navbar
- `src/www/vistas/html/gestion_alertas_caducidad.html` - Agregado navbar

## Cómo Probar

1. Accede a `http://localhost/DAW2-ProyectoIntermodular/src/index.php`
2. Serás redirigido automáticamente a la página de login
3. Ingresa con una de las credenciales proporcionadas arriba
4. Verás el panel principal con los módulos disponibles según tu rol
5. Haz clic en "Cerrar Sesión" en la esquina superior derecha para salir

## Notas de Seguridad

⚠️ **Importante para desarrollo:**
- Las credenciales están hardcodeadas en la clase `Sesion.php`
- Para producción, se recomienda:
  - Guardar usuarios y contraseñas en la base de datos
  - Usar hashing de contraseñas (bcrypt/Argon2)
  - Implementar JWT o tokens de sesión seguros
  - Usar HTTPS
  - Agregar rate limiting en el login
  - Implementar 2FA (autenticación de dos factores)
