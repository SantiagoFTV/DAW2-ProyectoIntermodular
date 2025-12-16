# Manual de Instalación

## Requisitos del Sistema

### Hardware Mínimo
- Procesador: 2GHz dual-core
- RAM: 2GB
- Disco duro: 500MB libres

### Software Requerido
- **Servidor Web:** Apache 2.4+
- **Base de Datos:** MySQL 5.7+ o MariaDB 10.4+
- **PHP:** 7.4 o superior
- **Navegador:** Chrome, Firefox, Safari o Edge (última versión)

---

## Instalación Local (XAMPP)

### Paso 1: Descargar XAMPP

1. Visita: https://www.apachefriends.org/
2. Descarga XAMPP para Windows
3. Ejecuta el instalador

### Paso 2: Instalar XAMPP

1. Abre el archivo descargado
2. Sigue el asistente de instalación
3. Instala en: `C:\xampp`
4. Inicia el Control Panel de XAMPP

### Paso 3: Iniciar Servicios

En XAMPP Control Panel:
1. Haz clic en **"Start"** en Apache
2. Haz clic en **"Start"** en MySQL
3. Ambos deben mostrar estado "Running" (verde)

---

## Instalación del Proyecto

### Paso 1: Descargar Proyecto

```powershell
# Clona el repositorio
git clone https://github.com/usuario/DAW2-ProyectoIntermodular.git

# O descarga el ZIP y extrae en:
C:\xampp\htdocs\DAW2-ProyectoIntermodular
```

### Paso 2: Estructura de Carpetas

```
C:\xampp\htdocs\
└── DAW2-ProyectoIntermodular\
    └── Sprint1 - 2\
        ├── doc\
        ├── src\
        │   ├── config.php
        │   ├── index.php
        │   ├── sql\
        │   │   └── sprint.sql
        │   └── www\
        │       ├── controladores\
        │       ├── css\
        │       ├── js\
        │       ├── modelos\
        │       └── vistas\
```

### Paso 3: Configurar Base de Datos

1. Abre phpMyAdmin: `http://localhost/phpmyadmin`
2. Usuario: `root` / Contraseña: (vacío por defecto)
3. Crea nueva base de datos:
   - Click en "Nueva"
   - Nombre: `sprint`
   - Cotejamiento: `utf8mb4_general_ci`
   - Click "Crear"

---

## Importar Base de Datos

### Método 1: phpMyAdmin (Recomendado)

1. Abre phpMyAdmin: `http://localhost/phpmyadmin`
2. Selecciona la base de datos `sprint`
3. Click en pestaña **"Importar"**
4. Selecciona el archivo: `Sprint1 - 2/src/sql/sprint.sql`
5. Click en **"Ejecutar"**

### Método 2: Línea de Comando

```powershell
# Abre Command Prompt
cd C:\xampp\mysql\bin

# Importa el archivo SQL
mysql -u root sprint < "C:\xampp\htdocs\DAW2-ProyectoIntermodular\Sprint1 - 2\src\sql\sprint.sql"
```

---

## Configurar config.php

Abre: `Sprint1 - 2/src/config.php`

```php
<?php
// Configuración de Base de Datos

$servername = "localhost";
$username = "root";
$password = "";  // Contraseña (vacía por defecto en XAMPP)
$dbname = "sprint";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
```

**Nota:** Si tu MySQL tiene contraseña, reemplaza `$password = "";` con `$password = "tu_contraseña";`

---

## Verificar Instalación

1. Abre tu navegador
2. Ingresa: `http://localhost/DAW2-ProyectoIntermodular/Sprint1%20-%202/src/www/vistas/html/gestion_voluntarios.html`
3. Deberías ver la interfaz de Gestión de Voluntarios
4. Intenta agregar un voluntario para verificar que funciona

---

## Solución de Problemas

### "Conexión rechazada a la base de datos"
```
Solución:
1. Verifica que MySQL esté iniciado en XAMPP
2. Revisa config.php - usuario/contraseña correctos
3. Asegúrate que la base de datos "sprint" existe
```

### "Página en blanco"
```
Solución:
1. Habilita errores en PHP: config.php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
2. Revisa el archivo error.log de Apache
3. Verifica que los permisos de carpetas sean correctos
```

### "Archivo no encontrado (404)"
```
Solución:
1. Verifica la ruta completa en el navegador
2. Asegúrate que el archivo existe en la ubicación correcta
3. Las rutas son sensibles a mayúsculas/minúsculas
```

### "Permiso denegado"
```
Solución:
1. Click derecho en carpeta > Propiedades > Seguridad
2. Asigna permisos de lectura/escritura
3. O ejecuta como Administrador
```

---

## Desinstalación

Para desinstalar completamente:

```powershell
# 1. Detener servicios en XAMPP Control Panel
# 2. Eliminar carpeta del proyecto
Remove-Item -Recurse "C:\xampp\htdocs\DAW2-ProyectoIntermodular"

# 3. Eliminar base de datos (phpMyAdmin)
# 4. Desinstalar XAMPP si deseas
```

---

## Próximos Pasos

1. ✅ Verifica que la instalación funciona
2. ✅ Lee el Manual de Usuario
3. ✅ Consulta el Manual de Programación si necesitas modificar el código

---

**Versión:** 1.0  
**Última actualización:** 16/12/2025  
**Soporte:** soporte@bancoalimentos.org
