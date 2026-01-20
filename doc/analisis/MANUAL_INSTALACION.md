# Manual de Instalación - Sistema de Gestión del Banco de Alimentos

**Versión:** 1.0  
**Fecha:** 17 de Enero, 2026  
**Dirigido a:** Administradores de sistemas y técnicos de TI

---

## Tabla de Contenidos

1. [Requisitos del Sistema](#requisitos-del-sistema)
2. [Instalación en Windows (XAMPP)](#instalación-en-windows-xampp)
3. [Instalación en Linux](#instalación-en-linux)
4. [Configuración de la Base de Datos](#configuración-de-la-base-de-datos)
5. [Configuración del Sistema](#configuración-del-sistema)
6. [Verificación de la Instalación](#verificación-de-la-instalación)
7. [Configuración Avanzada](#configuración-avanzada)
8. [Solución de Problemas](#solución-de-problemas)
9. [Desinstalación](#desinstalación)

---

## Requisitos del Sistema

### Requisitos de Hardware

**Servidor Mínimo:**
- Procesador: Intel Core i3 o equivalente
- RAM: 4 GB
- Disco Duro: 10 GB disponibles
- Red: Tarjeta de red 100 Mbps

**Servidor Recomendado:**
- Procesador: Intel Core i5 o superior
- RAM: 8 GB o más
- Disco Duro: 20 GB SSD
- Red: Tarjeta de red 1 Gbps

### Requisitos de Software

**Servidor Web:**
- Apache 2.4 o superior
- Nginx 1.18 o superior (alternativa)

**PHP:**
- Versión: PHP 8.0 o superior
- Extensiones requeridas:
  - php-pdo
  - php-mysqli
  - php-mbstring
  - php-json
  - php-xml
  - php-curl

**Base de Datos:**
- MySQL 8.0 o superior
- MariaDB 10.4 o superior

**Sistema Operativo:**
- Windows Server 2016 o superior
- Windows 10/11 (para desarrollo)
- Ubuntu 20.04 LTS o superior
- CentOS 8 o superior
- Debian 10 o superior

---

## Instalación en Windows (XAMPP)

### Paso 1: Descargar XAMPP

1. Visite: https://www.apachefriends.org/
2. Descargue XAMPP para Windows (versión con PHP 8.2)
3. Archivo: `xampp-windows-x64-8.2.X-installer.exe`

### Paso 2: Instalar XAMPP

1. Ejecute el instalador como Administrador
2. Seleccione componentes:
   ```
   [X] Apache
   [X] MySQL
   [X] PHP
   [X] phpMyAdmin
   [ ] FileZilla (opcional)
   [ ] Mercury (opcional)
   ```

3. Ruta de instalación: `C:\xampp`
4. Click en "Next" → "Next" → "Install"
5. Espere a que finalice la instalación
6. Click en "Finish"

### Paso 3: Iniciar Servicios

1. Abra XAMPP Control Panel
2. Click en "Start" para Apache
3. Click en "Start" para MySQL
4. Verifique que ambos estén en verde (Running)

```
Apache: Running (PID: 1234)
MySQL:  Running (PID: 5678)
```

### Paso 4: Descargar el Sistema

**Opción A: Desde Git**
```bash
cd C:\xampp\htdocs
git clone https://github.com/SantiagoFTV/DAW2-ProyectoIntermodular.git
```

**Opción B: Descarga Manual**
1. Descargue el archivo ZIP del sistema
2. Extraiga en `C:\xampp\htdocs\`
3. Renombre la carpeta a `DAW2-ProyectoIntermodular`

### Paso 5: Configurar Base de Datos

1. Abra el navegador
2. Visite: `http://localhost/phpmyadmin`
3. Click en "New" (Nueva base de datos)
4. Nombre: `banco_alimentos`
5. Cotejamiento: `utf8mb4_general_ci`
6. Click en "Create"

### Paso 6: Importar Estructura SQL

1. Seleccione la base de datos `banco_alimentos`
2. Click en la pestaña "Import"
3. Click en "Choose File"
4. Seleccione: `C:\xampp\htdocs\DAW2-ProyectoIntermodular\src\sql\sprint.sql`
5. Click en "Go"
6. Espere el mensaje: "Import has been successfully finished"

### Paso 7: Configurar Conexión

1. Abra el archivo: `C:\xampp\htdocs\DAW2-ProyectoIntermodular\src\config.php`
2. Edite las credenciales de conexión:

```php
<?php
// Configuración de Base de Datos
$config['db'] = [
    'host' => 'localhost',
    'puerto' => '3306',
    'base_datos' => 'banco_alimentos',
    'usuario' => 'root',
    'password' => '',  // Vacío en XAMPP por defecto
    'charset' => 'utf8mb4'
];
?>
```

3. Guarde el archivo

### Paso 8: Verificar Instalación

1. Abra el navegador
2. Visite: `http://localhost/DAW2-ProyectoIntermodular/src/index.php`
3. Debe ver la pantalla de login
4. Credenciales de prueba:
   - Usuario: `admin`
   - Contraseña: `admin123`

### Paso 9: Configurar Virtual Host (Opcional)

Para acceder con una URL más amigable:

1. Edite: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
2. Agregue al final:

```apache
<VirtualHost *:80>
    ServerName banco-alimentos.local
    DocumentRoot "C:/xampp/htdocs/DAW2-ProyectoIntermodular/src"
    <Directory "C:/xampp/htdocs/DAW2-ProyectoIntermodular/src">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

3. Edite: `C:\Windows\System32\drivers\etc\hosts` (como Administrador)
4. Agregue:
```
127.0.0.1    banco-alimentos.local
```

5. Reinicie Apache desde XAMPP Control Panel
6. Acceda a: `http://banco-alimentos.local`

---

## Instalación en Linux

### Ubuntu/Debian

#### Paso 1: Actualizar Sistema

```bash
sudo apt update
sudo apt upgrade -y
```

#### Paso 2: Instalar Apache

```bash
sudo apt install apache2 -y
sudo systemctl start apache2
sudo systemctl enable apache2
```

Verificar:
```bash
sudo systemctl status apache2
```

#### Paso 3: Instalar MySQL/MariaDB

```bash
sudo apt install mariadb-server -y
sudo systemctl start mariadb
sudo systemctl enable mariadb
```

Configurar seguridad:
```bash
sudo mysql_secure_installation
```

Respuestas recomendadas:
```
Enter current password: [Enter]
Set root password? Y
New password: [tu_contraseña_segura]
Remove anonymous users? Y
Disallow root login remotely? Y
Remove test database? Y
Reload privilege tables? Y
```

#### Paso 4: Instalar PHP 8.2

```bash
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.2 php8.2-cli php8.2-common php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl -y
```

Verificar versión:
```bash
php -v
```

#### Paso 5: Instalar Módulos PHP para Apache

```bash
sudo apt install libapache2-mod-php8.2 -y
sudo systemctl restart apache2
```

#### Paso 6: Descargar el Sistema

```bash
cd /var/www/html
sudo git clone https://github.com/SantiagoFTV/DAW2-ProyectoIntermodular.git
sudo chown -R www-data:www-data DAW2-ProyectoIntermodular
sudo chmod -R 755 DAW2-ProyectoIntermodular
```

#### Paso 7: Crear Base de Datos

```bash
sudo mysql -u root -p
```

En MySQL:
```sql
CREATE DATABASE banco_alimentos CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
CREATE USER 'banco_user'@'localhost' IDENTIFIED BY 'password_seguro';
GRANT ALL PRIVILEGES ON banco_alimentos.* TO 'banco_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Paso 8: Importar SQL

```bash
sudo mysql -u root -p banco_alimentos < /var/www/html/DAW2-ProyectoIntermodular/src/sql/sprint.sql
```

#### Paso 9: Configurar config.php

```bash
sudo nano /var/www/html/DAW2-ProyectoIntermodular/src/config.php
```

Editar:
```php
$config['db'] = [
    'host' => 'localhost',
    'puerto' => '3306',
    'base_datos' => 'banco_alimentos',
    'usuario' => 'banco_user',
    'password' => 'password_seguro',
    'charset' => 'utf8mb4'
];
```

Guardar: `Ctrl+O`, `Enter`, `Ctrl+X`

#### Paso 10: Configurar Virtual Host

```bash
sudo nano /etc/apache2/sites-available/banco-alimentos.conf
```

Contenido:
```apache
<VirtualHost *:80>
    ServerName banco-alimentos.local
    ServerAdmin admin@banco-alimentos.local
    DocumentRoot /var/www/html/DAW2-ProyectoIntermodular/src

    <Directory /var/www/html/DAW2-ProyectoIntermodular/src>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/banco-alimentos-error.log
    CustomLog ${APACHE_LOG_DIR}/banco-alimentos-access.log combined
</VirtualHost>
```

Habilitar sitio:
```bash
sudo a2ensite banco-alimentos.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Paso 11: Configurar Firewall

```bash
sudo ufw allow 'Apache Full'
sudo ufw enable
sudo ufw status
```

#### Paso 12: Verificar

Abra navegador:
```
http://localhost/DAW2-ProyectoIntermodular/src/
```

---

## Configuración de la Base de Datos

### Estructura de Tablas

El script `sprint.sql` crea las siguientes tablas:

1. **beneficiarios**
   - Almacena información de beneficiarios
   - Campos: id, nombre, apellidos, dni, teléfono, email, etc.

2. **voluntarios_db**
   - Información de voluntarios
   - Campos: id, nombre, telefono, horas_disponibles, habilidades

3. **puntos_distribucion**
   - Puntos de distribución físicos
   - Campos: id, nombre, direccion, responsable, latitud, longitud

4. **alertas_caducidad**
   - Alertas de productos próximos a caducar
   - Campos: id, nombre_producto, fecha_expiracion, estado

5. **asignaciones_productos**
   - Historial de asignaciones a beneficiarios
   - Campos: id, beneficiario_id, producto, cantidad, fecha

### Cargar Datos de Prueba

**Opción 1: Desde phpMyAdmin**
1. Acceda a phpMyAdmin
2. Seleccione la base de datos
3. Click en "SQL"
4. Copie y pegue el contenido de `alertas_caducidad.csv`
5. Click en "Go"

**Opción 2: Desde línea de comandos**
```bash
# Windows (XAMPP)
cd C:\xampp\htdocs\DAW2-ProyectoIntermodular\src\sql
C:\xampp\mysql\bin\mysql -u root -p banco_alimentos < datos_prueba.sql

# Linux
mysql -u banco_user -p banco_alimentos < /var/www/html/DAW2-ProyectoIntermodular/src/sql/datos_prueba.sql
```

### Backup de Base de Datos

**Crear Backup:**
```bash
# Windows
C:\xampp\mysql\bin\mysqldump -u root -p banco_alimentos > backup_$(date +%Y%m%d).sql

# Linux
mysqldump -u banco_user -p banco_alimentos > backup_$(date +%Y%m%d).sql
```

**Restaurar Backup:**
```bash
# Windows
C:\xampp\mysql\bin\mysql -u root -p banco_alimentos < backup_20260117.sql

# Linux
mysql -u banco_user -p banco_alimentos < backup_20260117.sql
```

---

## Configuración del Sistema

### Archivo config.php

Ubicación: `src/config.php`

**Parámetros Configurables:**

```php
<?php
// Configuración de Base de Datos
$config['db'] = [
    'host' => 'localhost',          // Host de MySQL
    'puerto' => '3306',             // Puerto de MySQL
    'base_datos' => 'banco_alimentos',
    'usuario' => 'root',            // Usuario de BD
    'password' => '',               // Contraseña de BD
    'charset' => 'utf8mb4'          // Charset
];

// Directorios del Proyecto
$config['dir_base'] = __DIR__ . '/';
$config['dir_controladores'] = __DIR__ . '/www/controladores/';
$config['dir_modelos'] = __DIR__ . '/www/modelos/';
$config['dir_vistas'] = __DIR__ . '/www/vistas/';

// Configuración de Sesión
$config['sesion'] = [
    'timeout' => 3600,              // Timeout en segundos (1 hora)
    'cookie_lifetime' => 0,         // 0 = hasta cerrar navegador
    'cookie_httponly' => true,      // Solo HTTP, no JavaScript
    'cookie_secure' => false        // true para HTTPS
];

// Configuración de Errores
$config['debug'] = true;            // true en desarrollo, false en producción
$config['error_reporting'] = E_ALL; // Nivel de reporte de errores

// Zona Horaria
date_default_timezone_set('Europe/Madrid');
?>
```

### Configuración de PHP

Editar `php.ini`:

**Windows XAMPP:** `C:\xampp\php\php.ini`  
**Linux:** `/etc/php/8.2/apache2/php.ini`

**Parámetros Recomendados:**
```ini
; Tiempo de ejecución máximo
max_execution_time = 300

; Memoria máxima
memory_limit = 256M

; Tamaño máximo de subida
upload_max_filesize = 20M
post_max_size = 25M

; Zona horaria
date.timezone = Europe/Madrid

; Mostrar errores (solo en desarrollo)
display_errors = On
error_reporting = E_ALL

; Extensiones requeridas
extension=pdo_mysql
extension=mysqli
extension=mbstring
extension=json
extension=xml
extension=curl
```

Reiniciar Apache después de cambios.

### Permisos de Archivos

**Linux:**
```bash
# Directorio principal
sudo chown -R www-data:www-data /var/www/html/DAW2-ProyectoIntermodular
sudo chmod -R 755 /var/www/html/DAW2-ProyectoIntermodular

# Archivos de configuración (solo lectura para web server)
sudo chmod 640 /var/www/html/DAW2-ProyectoIntermodular/src/config.php
```

**Windows:**
No requiere permisos especiales en XAMPP local.

---

## Verificación de la Instalación

### Checklist de Verificación

```
[ ] Apache está corriendo
[ ] MySQL/MariaDB está corriendo
[ ] PHP 8.0+ instalado correctamente
[ ] Base de datos 'banco_alimentos' creada
[ ] Tablas importadas correctamente
[ ] Datos de prueba cargados
[ ] config.php configurado correctamente
[ ] Conexión a BD funciona
[ ] Página de login se muestra
[ ] Login con credenciales funciona
[ ] Módulos principales accesibles
```

### Pruebas de Funcionamiento

#### 1. Test de PHP

Crear archivo: `test.php` en la raíz web:
```php
<?php
phpinfo();
?>
```

Acceder: `http://localhost/test.php`

Verificar:
- Versión PHP 8.0+
- Extensión PDO habilitada
- Extensión mysqli habilitada

**Eliminar el archivo después de verificar.**

#### 2. Test de Conexión a BD

Crear archivo: `test_db.php`:
```php
<?php
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=banco_alimentos;charset=utf8mb4',
        'root',
        ''
    );
    echo "Conexión exitosa a la base de datos";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
```

Acceder: `http://localhost/test_db.php`

Debe mostrar: "Conexión exitosa a la base de datos"

**Eliminar el archivo después de verificar.**

#### 3. Test de Sistema

1. Acceder a: `http://localhost/DAW2-ProyectoIntermodular/src/`
2. Verificar que aparece la pantalla de login
3. Login con: admin / admin123
4. Verificar que redirige al Home
5. Acceder a cada módulo:
   - Beneficiarios
   - Voluntarios
   - Puntos de Distribución
   - Alertas de Caducidad

6. Probar funcionalidades básicas:
   - Crear un beneficiario
   - Buscar beneficiarios
   - Ver alertas de caducidad
   - Logout

### Logs del Sistema

**Apache Access Log:**
- Windows: `C:\xampp\apache\logs\access.log`
- Linux: `/var/log/apache2/access.log`

**Apache Error Log:**
- Windows: `C:\xampp\apache\logs\error.log`
- Linux: `/var/log/apache2/error.log`

**MySQL Error Log:**
- Windows: `C:\xampp\mysql\data\mysql_error.log`
- Linux: `/var/log/mysql/error.log`

**PHP Error Log:**
Verificar configuración en `php.ini`:
```ini
error_log = /ruta/a/php_errors.log
```

---

## Configuración Avanzada

### HTTPS con SSL

#### Opción 1: XAMPP (Desarrollo)

1. Editar: `C:\xampp\apache\conf\extra\httpd-ssl.conf`
2. Verificar que el módulo SSL está habilitado
3. Reiniciar Apache

#### Opción 2: Linux con Let's Encrypt

```bash
# Instalar Certbot
sudo apt install certbot python3-certbot-apache -y

# Obtener certificado
sudo certbot --apache -d tudominio.com -d www.tudominio.com

# Renovación automática
sudo certbot renew --dry-run
```

### Optimización de Rendimiento

#### Habilitar Caché de OPcache

Editar `php.ini`:
```ini
[opcache]
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
```

#### Configurar mod_expires de Apache

Editar `.htaccess` en raíz del proyecto:
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

#### Habilitar Compresión GZIP

Editar `.htaccess`:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

### Configuración de Backups Automáticos

#### Script de Backup (Linux)

Crear archivo: `/usr/local/bin/backup_banco_alimentos.sh`

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/banco_alimentos"
DB_NAME="banco_alimentos"
DB_USER="banco_user"
DB_PASS="password_seguro"

# Crear directorio si no existe
mkdir -p $BACKUP_DIR

# Backup de base de datos
mysqldump -u$DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_$DATE.sql

# Comprimir
gzip $BACKUP_DIR/db_$DATE.sql

# Eliminar backups antiguos (más de 7 días)
find $BACKUP_DIR -name "*.sql.gz" -mtime +7 -delete

echo "Backup completado: db_$DATE.sql.gz"
```

Dar permisos:
```bash
sudo chmod +x /usr/local/bin/backup_banco_alimentos.sh
```

Programar con cron (diario a las 2 AM):
```bash
sudo crontab -e
```

Agregar:
```
0 2 * * * /usr/local/bin/backup_banco_alimentos.sh >> /var/log/backup_banco_alimentos.log 2>&1
```

---

## Solución de Problemas

### Error: "No se puede conectar a la base de datos"

**Causa:** Credenciales incorrectas o MySQL no está corriendo

**Solución:**
1. Verificar que MySQL está activo:
   ```bash
   # Windows (XAMPP)
   Verificar en XAMPP Control Panel
   
   # Linux
   sudo systemctl status mysql
   ```

2. Verificar credenciales en `config.php`
3. Probar conexión manual:
   ```bash
   mysql -u root -p
   ```

### Error: "Call to undefined function mysqli_connect()"

**Causa:** Extensión mysqli no está habilitada

**Solución:**
1. Editar `php.ini`
2. Descomentar o agregar:
   ```ini
   extension=mysqli
   extension=pdo_mysql
   ```
3. Reiniciar Apache

### Error: "404 Not Found"

**Causa:** Archivo no encontrado o configuración incorrecta

**Solución:**
1. Verificar ruta del proyecto
2. Verificar que el archivo `index.php` existe
3. Verificar configuración del Virtual Host
4. Verificar permisos de archivos (Linux)

### Error: "Permission denied"

**Causa:** Permisos incorrectos (Linux)

**Solución:**
```bash
sudo chown -R www-data:www-data /var/www/html/DAW2-ProyectoIntermodular
sudo chmod -R 755 /var/www/html/DAW2-ProyectoIntermodular
```

### Error: "Session failed to start"

**Causa:** Directorio de sesiones no tiene permisos

**Solución Linux:**
```bash
sudo chmod 1733 /var/lib/php/sessions
```

**Solución Windows:**
Verificar `php.ini`:
```ini
session.save_path = "C:\xampp\tmp"
```

### Página en Blanco

**Causa:** Error fatal de PHP no mostrado

**Solución:**
1. Habilitar errores en `php.ini`:
   ```ini
   display_errors = On
   error_reporting = E_ALL
   ```

2. Verificar logs de Apache
3. Verificar sintaxis PHP:
   ```bash
   php -l archivo.php
   ```

---

## Desinstalación

### Windows (XAMPP)

1. Detener servicios en XAMPP Control Panel
2. Eliminar carpeta del proyecto:
   ```
   C:\xampp\htdocs\DAW2-ProyectoIntermodular
   ```

3. Eliminar base de datos en phpMyAdmin:
   - Acceder a phpMyAdmin
   - Seleccionar `banco_alimentos`
   - Click en "Drop"

4. (Opcional) Desinstalar XAMPP:
   - Panel de Control → Programas → Desinstalar
   - Buscar "XAMPP"
   - Desinstalar

### Linux

1. Detener Apache y MySQL:
   ```bash
   sudo systemctl stop apache2
   sudo systemctl stop mysql
   ```

2. Eliminar archivos del proyecto:
   ```bash
   sudo rm -rf /var/www/html/DAW2-ProyectoIntermodular
   ```

3. Eliminar base de datos:
   ```bash
   sudo mysql -u root -p
   DROP DATABASE banco_alimentos;
   DROP USER 'banco_user'@'localhost';
   EXIT;
   ```

4. Eliminar configuración de Apache:
   ```bash
   sudo a2dissite banco-alimentos.conf
   sudo rm /etc/apache2/sites-available/banco-alimentos.conf
   sudo systemctl restart apache2
   ```

5. (Opcional) Desinstalar software:
   ```bash
   sudo apt remove apache2 mariadb-server php8.2 -y
   sudo apt autoremove -y
   ```

---

## Apéndices

### A. Comandos Útiles

**Reiniciar Servicios:**
```bash
# Apache
sudo systemctl restart apache2

# MySQL
sudo systemctl restart mysql

# PHP-FPM (si se usa)
sudo systemctl restart php8.2-fpm
```

**Ver Logs en Tiempo Real:**
```bash
# Apache
tail -f /var/log/apache2/error.log

# MySQL
tail -f /var/log/mysql/error.log
```

**Verificar Sintaxis de Configuración:**
```bash
# Apache
sudo apachectl configtest

# Nginx
sudo nginx -t
```

### B. Puertos Utilizados

- **80:** HTTP (Apache)
- **443:** HTTPS (Apache SSL)
- **3306:** MySQL/MariaDB

Verificar puertos en uso:
```bash
# Windows
netstat -ano | findstr :80
netstat -ano | findstr :3306

# Linux
sudo netstat -tlnp | grep :80
sudo netstat -tlnp | grep :3306
```

### C. Referencias

- Documentación de PHP: https://www.php.net/docs.php
- Documentación de MySQL: https://dev.mysql.com/doc/
- Documentación de Apache: https://httpd.apache.org/docs/
- XAMPP: https://www.apachefriends.org/

---

**Última actualización:** 17 de Enero, 2026  
**Versión del documento:** 1.0  
**Preparado por:** Equipo de Desarrollo
