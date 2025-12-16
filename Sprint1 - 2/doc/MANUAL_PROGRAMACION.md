# Manual de Programación - Gestión de Voluntarios

## Introducción

Guía técnica para desarrolladores que necesitan mantener o extender el módulo de Gestión de Voluntarios.

---

## Arquitectura del Sistema

```
Gestión de Voluntarios
├── Frontend (HTML/CSS/JS)
│   ├── gestion_voluntarios.html
│   ├── gestion_voluntarios.css
│   └── gestion_voluntarios.js
├── Backend (PHP)
│   ├── controladorVoluntario.php
│   └── modelos/voluntario.php
└── Base de Datos (MySQL)
    └── tabla voluntarios_db
```

---

## Estructura de Carpetas

```
src/
├── config.php                    # Configuración de conexión BD
├── index.php                     # Página principal
└── www/
    ├── controladores/
    │   └── controladorVoluntario.php
    ├── css/
    │   └── gestion_voluntarios.css
    ├── js/
    │   └── gestion_voluntarios.js
    ├── modelos/
    │   ├── bd.php               # Clase de base de datos
    │   └── voluntario.php       # Modelo Voluntario
    └── vistas/
        └── html/
            └── gestion_voluntarios.html
```

---

## Base de Datos

### Tabla: voluntarios_db

```sql
CREATE TABLE `voluntarios_db` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `telefono` int(11) NOT NULL,
  `horas_disponibles` varchar(255) NOT NULL,
  `habilidades` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;
```

### Campos

| Campo | Tipo | Requerido | Descripción |
|-------|------|-----------|-------------|
| id | INT | Sí | Identificador único (auto-incremento) |
| nombre | VARCHAR(255) | Sí | Nombre del voluntario |
| telefono | INT | Sí | Teléfono de contacto |
| horas_disponibles | VARCHAR(255) | Sí | Horas semanales disponibles |
| habilidades | VARCHAR(255) | No | Competencias o skills |

---

## Modelo: voluntario.php

```php
<?php
class Voluntario {
    private $id;
    private $nombre;
    private $telefono;
    private $horas_disponibles;
    private $habilidades;
    private $conexion;

    // Constructor
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Getters y Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    
    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    
    // ... más getters y setters
}
?>
```

### Métodos Principales

#### obtenerTodos()
```php
public function obtenerTodos() {
    $sql = "SELECT * FROM voluntarios_db";
    $resultado = $this->conexion->query($sql);
    $voluntarios = [];
    
    while($fila = $resultado->fetch_assoc()) {
        $voluntarios[] = $fila;
    }
    
    return $voluntarios;
}
```

#### crear()
```php
public function crear() {
    $sql = "INSERT INTO voluntarios_db 
            (nombre, telefono, horas_disponibles, habilidades) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("siss", 
        $this->nombre, 
        $this->telefono, 
        $this->horas_disponibles, 
        $this->habilidades
    );
    
    return $stmt->execute();
}
```

#### actualizar()
```php
public function actualizar() {
    $sql = "UPDATE voluntarios_db 
            SET nombre=?, telefono=?, 
                horas_disponibles=?, habilidades=? 
            WHERE id=?";
    
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("sissi", 
        $this->nombre, $this->telefono, 
        $this->horas_disponibles, 
        $this->habilidades, $this->id
    );
    
    return $stmt->execute();
}
```

#### eliminar()
```php
public function eliminar($id) {
    $sql = "DELETE FROM voluntarios_db WHERE id=?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}
```

---

## Controlador: controladorVoluntario.php

```php
<?php
require_once '../modelos/voluntario.php';
require_once '../config.php';

header('Content-Type: application/json');

$accion = $_POST['accion'] ?? '';
$voluntario = new Voluntario($conn);
$respuesta = [];

switch($accion) {
    case 'listar':
        $respuesta['voluntarios'] = $voluntario->obtenerTodos();
        break;
        
    case 'crear':
        $voluntario->setNombre($_POST['nombre']);
        $voluntario->setTelefono($_POST['telefono']);
        $voluntario->setHorasDisponibles($_POST['horas']);
        $voluntario->setHabilidades($_POST['habilidades']);
        
        if($voluntario->crear()) {
            $respuesta['exito'] = true;
            $respuesta['mensaje'] = "Voluntario creado exitosamente";
        }
        break;
        
    case 'actualizar':
        // Similar a crear pero con UPDATE
        break;
        
    case 'eliminar':
        if($voluntario->eliminar($_POST['id'])) {
            $respuesta['exito'] = true;
        }
        break;
}

echo json_encode($respuesta);
?>
```

---

## Frontend: JavaScript

### Función: cargarVoluntarios()

```javascript
function cargarVoluntarios() {
    $.ajax({
        url: '../../controladores/controladorVoluntario.php',
        type: 'POST',
        data: { accion: 'listar' },
        dataType: 'json',
        success: function(respuesta) {
            let html = '';
            respuesta.voluntarios.forEach(vol => {
                html += `<tr>
                    <td>${vol.id}</td>
                    <td>${vol.nombre}</td>
                    <td>${vol.telefono}</td>
                    <td>${vol.horas_disponibles}</td>
                    <td>${vol.habilidades}</td>
                    <td>
                        <button onclick="editarVoluntario(${vol.id})">Editar</button>
                        <button onclick="eliminarVoluntario(${vol.id})">Eliminar</button>
                    </td>
                </tr>`;
            });
            $('#tabla-voluntarios tbody').html(html);
        }
    });
}
```

### Función: agregarVoluntario()

```javascript
function agregarVoluntario() {
    let nombre = $('#nombre').val();
    let telefono = $('#telefono').val();
    let horas = $('#horas').val();
    let habilidades = $('#habilidades').val();
    
    if(!nombre || !telefono || !horas) {
        alert('Completa todos los campos obligatorios');
        return;
    }
    
    $.ajax({
        url: '../../controladores/controladorVoluntario.php',
        type: 'POST',
        data: {
            accion: 'crear',
            nombre: nombre,
            telefono: telefono,
            horas: horas,
            habilidades: habilidades
        },
        success: function(respuesta) {
            if(respuesta.exito) {
                alert('Voluntario agregado exitosamente');
                cargarVoluntarios();
                limpiarFormulario();
            }
        }
    });
}
```

---

## Validaciones

### Backend (PHP)

```php
// Validar teléfono
if(!preg_match('/^\d{9,15}$/', $telefono)) {
    throw new Exception("Teléfono inválido");
}

// Validar nombre no vacío
if(empty($nombre) || strlen($nombre) < 3) {
    throw new Exception("Nombre debe tener mínimo 3 caracteres");
}

// Validar horas
if(!is_numeric($horas) || $horas < 0) {
    throw new Exception("Horas debe ser un número positivo");
}
```

### Frontend (JavaScript)

```javascript
function validarFormulario() {
    let nombre = $('#nombre').val().trim();
    let telefono = $('#telefono').val().trim();
    let horas = $('#horas').val().trim();
    
    if(nombre.length < 3) {
        mostrarError('Nombre muy corto');
        return false;
    }
    
    if(!/^\d{9,15}$/.test(telefono)) {
        mostrarError('Teléfono inválido (9-15 dígitos)');
        return false;
    }
    
    if(!/^\d+$/.test(horas) || parseInt(horas) <= 0) {
        mostrarError('Horas debe ser número positivo');
        return false;
    }
    
    return true;
}
```

---

## Flujo AJAX

```
Frontend (JS)
    ↓
$.ajax({...})
    ↓
controladorVoluntario.php
    ↓
voluntario.php (Modelo)
    ↓
Base de Datos
    ↓
Respuesta JSON
    ↓
success/error en Frontend
    ↓
Actualizar tabla HTML
```

---

## Extender Funcionalidad

### Agregar Campo Nuevo (Email)

**1. Base de Datos:**
```sql
ALTER TABLE voluntarios_db ADD COLUMN email VARCHAR(255) DEFAULT NULL;
```

**2. Modelo (voluntario.php):**
```php
private $email;

public function getEmail() { return $this->email; }
public function setEmail($email) { $this->email = $email; }

// Actualizar INSERT y UPDATE
```

**3. Controlador:**
```php
case 'crear':
    $voluntario->setEmail($_POST['email']);
    // resto del código...
```

**4. Frontend (gestion_voluntarios.html):**
```html
<input type="email" id="email" placeholder="Email" required>
```

**5. JavaScript:**
```javascript
let email = $('#email').val();
// Pasar en data: { email: email, ... }
```

---

## Testing

### Prueba Manual

1. Abre la aplicación en navegador
2. Abre Developer Tools (F12)
3. Ve a la pestaña "Network"
4. Realiza operaciones (crear, editar, eliminar)
5. Verifica peticiones y respuestas JSON

### Test Unit (PHPUnit)

```php
<?php
use PHPUnit\Framework\TestCase;

class VoluntarioTest extends TestCase {
    public function testCrearVoluntario() {
        $voluntario = new Voluntario($conexion);
        $voluntario->setNombre("Juan");
        $voluntario->setTelefono("654456789");
        $voluntario->setHorasDisponibles("20");
        
        $resultado = $voluntario->crear();
        $this->assertTrue($resultado);
    }
}
?>
```

---

## Buenas Prácticas

✅ **Usar prepared statements** para evitar SQL injection  
✅ **Validar entrada** tanto en frontend como en backend  
✅ **Codificar respuestas JSON** correctamente  
✅ **Comentar código** complejo o no obvio  
✅ **Usar nombres descriptivos** para variables y funciones  
✅ **Separar lógica** (modelos, controladores, vistas)  
✅ **Manejo de errores** con try-catch  
✅ **Logs** para debugging en producción  

---

## Debugging

### Habilitar Errores en config.php

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'errores.log');
```

### Ver Errores en Navegador

```javascript
$.ajax({
    // ... opciones
    error: function(xhr, status, error) {
        console.log('Error:', error);
        console.log('Status:', status);
        console.log('Response:', xhr.responseText);
    }
});
```

---

## Recursos Útiles

- 📚 [Documentación PHP](https://www.php.net/docs.php)
- 📚 [MySQL Reference](https://dev.mysql.com/doc/)
- 📚 [jQuery Documentation](https://api.jquery.com/)
- 📚 [Bootstrap Docs](https://getbootstrap.com/docs/)

---

**Versión:** 1.0  
**Última actualización:** 16/12/2025  
**Autor:** Equipo de Desarrollo
