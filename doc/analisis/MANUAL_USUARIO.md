# Manual de Usuario - Sistema de Gestión del Banco de Alimentos

**Versión:** 1.0  
**Fecha:** 17 de Enero, 2026  
**Dirigido a:** Usuarios finales del sistema

---

## Tabla de Contenidos

1. [Introducción](#introducción)
2. [Requisitos del Sistema](#requisitos-del-sistema)
3. [Acceso al Sistema](#acceso-al-sistema)
4. [Roles y Permisos](#roles-y-permisos)
5. [Módulo de Inicio (Home)](#módulo-de-inicio-home)
6. [Gestión de Beneficiarios](#gestión-de-beneficiarios)
7. [Gestión de Voluntarios](#gestión-de-voluntarios)
8. [Puntos de Distribución](#puntos-de-distribución)
9. [Alertas de Caducidad](#alertas-de-caducidad)
10. [Preguntas Frecuentes](#preguntas-frecuentes)
11. [Solución de Problemas](#solución-de-problemas)
12. [Contacto y Soporte](#contacto-y-soporte)

---

## Introducción

### ¿Qué es este sistema?

El Sistema de Gestión del Banco de Alimentos es una aplicación web diseñada para facilitar la administración de donaciones, beneficiarios, voluntarios y puntos de distribución de un banco de alimentos.

### Objetivo

Optimizar la gestión de recursos, mejorar el seguimiento de beneficiarios, coordinar voluntarios y garantizar la distribución eficiente de alimentos a personas en situación de vulnerabilidad.

### Funcionalidades Principales

- Registro y seguimiento de beneficiarios
- Gestión de voluntarios y sus habilidades
- Control de puntos de distribución con mapas
- Sistema de alertas de productos próximos a caducar
- Reportes y estadísticas
- Control de acceso basado en roles

---

## Requisitos del Sistema

### Requisitos Técnicos

**Navegador Web:**
- Google Chrome 90 o superior (recomendado)
- Mozilla Firefox 88 o superior
- Microsoft Edge 90 o superior
- Safari 14 o superior

**Conexión a Internet:**
- Velocidad mínima: 1 Mbps
- Recomendada: 5 Mbps o superior

**Resolución de Pantalla:**
- Mínima: 1024x768 píxeles
- Recomendada: 1920x1080 píxeles

**Dispositivos Compatibles:**
- Ordenadores de escritorio
- Portátiles
- Tablets (modo landscape)

### Conocimientos Previos

- Navegación básica en internet
- Uso de formularios web
- Comprensión de conceptos básicos de gestión

---

## Acceso al Sistema

### Paso 1: Abrir el Navegador

Abra su navegador web preferido (Chrome, Firefox, Edge, Safari).

### Paso 2: Ingresar la URL

En la barra de direcciones, escriba la URL del sistema:

```
http://localhost/DAW2-ProyectoIntermodular/src/index.php
```

O si está en un servidor:

```
https://banco-alimentos.tudominio.com
```

### Paso 3: Pantalla de Inicio de Sesión

Verá la pantalla de inicio de sesión con los siguientes campos:

```
┌─────────────────────────────────────┐
│   BANCO DE ALIMENTOS                │
│                                     │
│   Usuario:    [_______________]     │
│                                     │
│   Contraseña: [_______________]     │
│                                     │
│   [Iniciar Sesión]                  │
│                                     │
│   Credenciales de prueba:           │
│   Admin: admin / admin123           │
│   Usuario: user / user123           │
└─────────────────────────────────────┘
```

### Paso 4: Introducir Credenciales

**Para Administrador:**
- Usuario: `admin`
- Contraseña: `admin123`

**Para Usuario Normal:**
- Usuario: `user`
- Contraseña: `user123`

### Paso 5: Click en "Iniciar Sesión"

Haga clic en el botón "Iniciar Sesión" o presione Enter.

### Paso 6: Acceso Exitoso

Si las credenciales son correctas, será redirigido al panel principal (Home).

### Errores Comunes en el Login

**Error: "Usuario o contraseña incorrectos"**
- Verifique que está escribiendo correctamente
- Asegúrese de que no tiene el Caps Lock activado
- Compruebe que no hay espacios antes o después del texto

**Error: "Sesión expirada"**
- Vuelva a iniciar sesión
- Si persiste, limpie las cookies del navegador

---

## Roles y Permisos

### Tipos de Usuarios

El sistema tiene dos niveles de acceso:

#### 1. Administrador (Admin)

**Permisos:**
- Acceso COMPLETO a todos los módulos
- Crear, editar y eliminar beneficiarios
- Gestionar voluntarios
- Administrar puntos de distribución
- Ver y gestionar alertas de caducidad
- Generar reportes
- Acceso a configuración del sistema

**Identificación Visual:**
- Badge en navbar: "Admin" (fondo verde)
- Acceso a todos los módulos en el Home

#### 2. Usuario Normal (Usuario)

**Permisos:**
- Ver lista de beneficiarios (solo lectura)
- Ver puntos de distribución (solo lectura)
- Buscar información
- Sin acceso a Voluntarios
- Sin acceso a Alertas de Caducidad
- No puede crear, editar ni eliminar

**Identificación Visual:**
- Badge en navbar: "Usuario" (fondo azul)
- Módulos restringidos aparecen deshabilitados en Home

### Comparativa de Permisos

| Módulo | Administrador | Usuario Normal |
|--------|---------------|----------------|
| Beneficiarios | CRUD completo | Solo lectura |
| Voluntarios | CRUD completo | Sin acceso |
| Puntos Distribución | CRUD completo | Solo lectura |
| Alertas Caducidad | CRUD completo | Sin acceso |
| Reportes | Completo | Sin acceso |
| Configuración | Acceso total | Sin acceso |

---

## Módulo de Inicio (Home)

### Descripción

El panel principal muestra un resumen de los módulos disponibles según su rol de usuario.

### Elementos de la Interfaz

**1. Barra de Navegación (Navbar)**
```
┌───────────────────────────────────────────────────┐
│ 🍎 Banco de Alimentos | Usuario: admin (Admin) ❌│
└───────────────────────────────────────────────────┘
```

- **Logo:** Identifica la aplicación
- **Usuario:** Muestra el nombre de usuario actual
- **Rol:** Badge con el nivel de acceso
- **Cerrar Sesión (❌):** Click para salir del sistema

**2. Título Principal**
```
BANCO DE ALIMENTOS
Panel de Gestión
```

**3. Grid de Módulos**

Muestra tarjetas con cada módulo disponible:

```
┌─────────────────┐  ┌─────────────────┐
│ 👥 BENEFICIARIOS│  │ 📍 PUNTOS       │
│                 │  │ DISTRIBUCIÓN    │
│ Lectura/Escrit. │  │ Lectura/Escrit. │
│ [Acceder]       │  │ [Acceder]       │
└─────────────────┘  └─────────────────┘

┌─────────────────┐  ┌─────────────────┐
│ ⚠️ ALERTAS      │  │ 🤝 VOLUNTARIOS  │
│ CADUCIDAD       │  │                 │
│ Lectura/Escrit. │  │ Lectura/Escrit. │
│ [Acceder]       │  │ [Acceder]       │
└─────────────────┘  └─────────────────┘
```

### Cómo Usar el Home

1. **Ver Módulos Disponibles:** Observe las tarjetas de módulos
2. **Identificar Acceso:** Vea el tipo de acceso en cada tarjeta
3. **Acceder a Módulo:** Click en el botón "Acceder"
4. **Cerrar Sesión:** Click en el botón rojo (❌) en la navbar

---

## Gestión de Beneficiarios

### Descripción

Módulo para registrar y gestionar personas que reciben ayuda del banco de alimentos.

### Acceso

**Ruta:** Home → Beneficiarios  
**Permisos:** Admin (completo), Usuario (solo lectura)

### Interfaz del Módulo

```
┌──────────────────────────────────────────────┐
│ Gestión de Beneficiarios                     │
├──────────────────────────────────────────────┤
│ Buscar: [____________] [Buscar]              │
├──────────────────────────────────────────────┤
│ REGISTRAR NUEVO BENEFICIARIO (Solo Admin)    │
│ Nombre: [________] Apellidos: [________]     │
│ DNI: [________] Teléfono: [________]         │
│ Email: [________________]                    │
│ Tamaño Familiar: [__] Dirección: [_______]  │
│ [Guardar]                                    │
├──────────────────────────────────────────────┤
│ BENEFICIARIOS REGISTRADOS                    │
│ ID | Nombre      | DNI       | Estado | Acc │
│ 1  | Juan Pérez  | 12345678A | Valid. | 👁️ │
│ 2  | Ana López   | 87654321B | Pend.  | 👁️ │
└──────────────────────────────────────────────┘
```

### Funciones Disponibles

#### 1. Ver Lista de Beneficiarios

**Todos los Usuarios:**

1. Acceda al módulo "Beneficiarios"
2. Verá una tabla con todos los beneficiarios registrados
3. Columnas mostradas:
   - ID
   - Nombre completo
   - Número de identificación (DNI)
   - Estado de validación
   - Acciones

#### 2. Buscar Beneficiario

**Todos los Usuarios:**

1. Escriba el nombre, apellido o DNI en el campo "Buscar"
2. Click en el botón "Buscar"
3. El sistema mostrará los resultados que coincidan
4. Para ver todos nuevamente, borre el campo y busque vacío

**Ejemplo:**
```
Buscar: [Juan___] [Buscar]

Resultado: Mostrará todos los beneficiarios que contengan "Juan"
en nombre, apellidos o DNI
```

#### 3. Registrar Nuevo Beneficiario

**Solo Administrador:**

1. Complete el formulario "Registrar Nuevo Beneficiario"
2. Campos obligatorios (marcados con *):
   - **Nombre:** Nombre del beneficiario
   - **Apellidos:** Apellidos completos
   - **DNI:** Número de identificación único
   - **Teléfono:** Número de contacto
   - **Email:** Correo electrónico
   - **Tamaño Familiar:** Número de personas en el hogar
   - **Dirección:** Dirección completa
   - **Necesidades:** Necesidades especiales (opcional)
   - **Estado:** Validado o Pendiente

3. Click en "Guardar"
4. Verá un mensaje de confirmación

**Validaciones:**
- Nombre y apellidos obligatorios
- DNI único (no puede repetirse)
- Email en formato válido
- Tamaño familiar debe ser mayor a 0

#### 4. Ver Detalles de Beneficiario

**Solo Administrador:**

1. En la tabla, localice el beneficiario
2. Click en el icono 👁️ (ojo) en la columna "Acciones"
3. Se abrirá una página con información completa:
   - Datos personales
   - Información de contacto
   - Composición familiar
   - Necesidades especiales
   - Historial de asignaciones
   - Última fecha de entrega

#### 5. Editar Beneficiario

**Solo Administrador:**

1. Acceda a los detalles del beneficiario
2. Modifique los campos necesarios
3. Click en "Guardar cambios"
4. Confirmación de actualización

#### 6. Eliminar Beneficiario

**Solo Administrador:**

1. En la tabla, localice el beneficiario
2. Click en el botón "Eliminar" (🗑️)
3. Confirme la eliminación en el diálogo
4. El beneficiario será eliminado permanentemente

**⚠️ Advertencia:** Esta acción no se puede deshacer. Se eliminarán también todos los registros relacionados.

### Estados de Beneficiarios

- **Validado (Verde):** Beneficiario verificado, puede recibir asignaciones
- **Pendiente (Amarillo):** Esperando validación de documentación

### Mensajes del Sistema

**Éxito:**
- "Beneficiario creado con éxito"
- "Beneficiario actualizado correctamente"
- "Beneficiario eliminado"

**Error:**
- "El DNI ya existe en el sistema"
- "Debe completar todos los campos obligatorios"
- "Email inválido"

---

## Gestión de Voluntarios

### Descripción

Módulo para administrar el equipo de voluntarios del banco de alimentos.

### Acceso

**Ruta:** Home → Voluntarios  
**Permisos:** Solo Administrador

### Interfaz del Módulo

```
┌──────────────────────────────────────────────┐
│ Gestión de Voluntarios                       │
├──────────────────────────────────────────────┤
│ Buscar: [____________] [Buscar]              │
├──────────────────────────────────────────────┤
│ REGISTRAR NUEVO VOLUNTARIO                   │
│ Nombre: [____________________]               │
│ Teléfono: [__________]                       │
│ Horas Disponibles: [_____________]           │
│ Habilidades: [___________________]           │
│ [Guardar Voluntario]                         │
├──────────────────────────────────────────────┤
│ VOLUNTARIOS REGISTRADOS                      │
│ ID | Nombre         | Teléfono  | Acciones  │
│ 1  | Ana López      | 600123456 | 🗑️       │
│ 2  | Carlos Ruiz    | 600987654 | 🗑️       │
└──────────────────────────────────────────────┘
```

### Funciones Disponibles

#### 1. Ver Lista de Voluntarios

1. Acceda al módulo "Voluntarios" (solo admin)
2. Verá la tabla con todos los voluntarios
3. Información mostrada:
   - ID
   - Nombre completo
   - Teléfono de contacto
   - Horas disponibles
   - Habilidades
   - Acciones

#### 2. Registrar Nuevo Voluntario

1. Complete el formulario de registro
2. Campos requeridos:
   - **Nombre Completo:** Nombre y apellidos del voluntario
   - **Teléfono:** Número de contacto (solo números)
   - **Horas Disponibles:** Ejemplo: "Lunes y Miércoles 9-13h"
   - **Habilidades:** Ejemplo: "Logística, Conducción, Almacén"

3. Click en "Guardar Voluntario"
4. Mensaje de confirmación

**Ejemplo de Registro:**
```
Nombre: María García Pérez
Teléfono: 666555444
Horas: Martes y Jueves 16-20h
Habilidades: Atención al público, Trabajo social
```

#### 3. Buscar Voluntario

1. Escriba el nombre en el campo de búsqueda
2. Click en "Buscar"
3. Ver resultados filtrados

#### 4. Eliminar Voluntario

1. Localice el voluntario en la tabla
2. Click en el icono 🗑️
3. Confirme la eliminación
4. El voluntario será eliminado

### Tipos de Habilidades Comunes

- **Logística:** Organización de almacén, inventario
- **Conducción:** Transporte de mercancía
- **Atención al Público:** Interacción con beneficiarios
- **Trabajo Social:** Entrevistas, valoración de necesidades
- **Informática:** Soporte técnico, gestión del sistema
- **Coordinación:** Organización de equipos y tareas

### Horarios Habituales

- Mañanas: 9:00 - 13:00
- Tardes: 16:00 - 20:00
- Fines de semana
- Días específicos de la semana

---

## Puntos de Distribución

### Descripción

Gestión de ubicaciones físicas donde se distribuyen los alimentos.

### Acceso

**Ruta:** Home → Puntos de Distribución  
**Permisos:** Admin (completo), Usuario (solo lectura)

### Interfaz del Módulo

```
┌──────────────────────────────────────────────┐
│ Gestión de Puntos de Distribución            │
├──────────────────────────────────────────────┤
│ Buscar: [____________] [Buscar]              │
├──────────────────────────────────────────────┤
│ CREAR NUEVO PUNTO (Solo Admin)               │
│ Nombre: [____________________]               │
│ Dirección: [_________________]               │
│ Responsable: [_______________]               │
│ Teléfono: [__________]                       │
│ Horario: [___________________]               │
│ [Guardar Punto]                              │
├──────────────────────────────────────────────┤
│ MAPA DE PUNTOS                               │
│ [Mapa interactivo con marcadores]            │
├──────────────────────────────────────────────┤
│ LISTA DE PUNTOS                              │
│ ID | Nombre      | Dirección   | Acciones   │
│ 1  | Centro Sur  | C/ Luna 15  | 👁️ 🗑️    │
└──────────────────────────────────────────────┘
```

### Funciones Disponibles

#### 1. Ver Puntos en el Mapa

**Todos los Usuarios:**

1. Acceda al módulo "Puntos de Distribución"
2. Verá un mapa interactivo con marcadores
3. Cada marcador representa un punto de distribución
4. Click en un marcador para ver información

**Información del Marcador:**
- Nombre del punto
- Dirección
- Responsable
- Horarios de atención

#### 2. Ver Lista de Puntos

**Todos los Usuarios:**

1. Debajo del mapa, vea la tabla con todos los puntos
2. Información mostrada:
   - Nombre del punto
   - Dirección completa
   - Responsable
   - Teléfono
   - Horarios

#### 3. Crear Nuevo Punto

**Solo Administrador:**

1. Complete el formulario "Crear Nuevo Punto"
2. Campos requeridos:
   - **Nombre:** Identificación del punto (ej: "Centro Norte")
   - **Dirección:** Dirección completa
   - **Responsable:** Nombre del encargado
   - **Teléfono:** Contacto del punto
   - **Latitud:** Coordenada GPS (ej: 40.4168)
   - **Longitud:** Coordenada GPS (ej: -3.7038)
   - **Horario:** Horarios de atención
   - **Descripción:** Información adicional

3. Click en "Guardar Punto"
4. El nuevo punto aparecerá en el mapa

**Obtener Coordenadas GPS:**
1. Abra Google Maps
2. Busque la dirección
3. Click derecho sobre la ubicación
4. Seleccione las coordenadas que aparecen
5. Cópielas al formulario

#### 4. Buscar Punto

**Todos los Usuarios:**

1. Escriba nombre o dirección en el campo de búsqueda
2. Click en "Buscar"
3. Resultados filtrados en tabla y mapa

#### 5. Eliminar Punto

**Solo Administrador:**

1. Localice el punto en la tabla
2. Click en el icono 🗑️
3. Confirme la eliminación
4. El punto desaparecerá del mapa y la tabla

### Ejemplo de Punto de Distribución

```
Nombre: Centro de Distribución Norte
Dirección: Calle de la Esperanza, 45, 28015 Madrid
Responsable: Laura Martínez
Teléfono: 915551234
Latitud: 40.4500
Longitud: -3.6833
Horario: Lunes a Viernes: 9:00-14:00, 16:00-19:00
Descripción: Centro principal con almacén de 200m², 
acceso para vehículos de carga
```

---

## Alertas de Caducidad

### Descripción

Sistema de alertas para productos próximos a caducar.

### Acceso

**Ruta:** Home → Alertas de Caducidad  
**Permisos:** Solo Administrador

### Interfaz del Módulo

```
┌──────────────────────────────────────────────┐
│ Sistema de Alertas de Caducidad              │
├──────────────────────────────────────────────┤
│ Filtros: [Todos] [Urgente] [Crítico] [OK]   │
├──────────────────────────────────────────────┤
│ PRODUCTOS CON ALERTA                         │
│ Producto    | Punto   | Días | Estado       │
│ Leche       | Centro1 | 3    | CRÍTICO (🔴) │
│ Pan integral| Centro2 | 8    | URGENTE (🟠) │
│ Conservas   | Centro1 | 20   | PRÓXIMO (🟡) │
│ Pasta       | Centro3 | 45   | OK (🟢)      │
└──────────────────────────────────────────────┘
```

### Estados de Alerta

| Estado | Color | Días Restantes | Acción Requerida |
|--------|-------|----------------|------------------|
| OK | 🟢 Verde | Más de 30 | Sin acción |
| PRÓXIMO | 🟡 Amarillo | 15-30 días | Planificar distribución |
| URGENTE | 🟠 Naranja | 7-15 días | Priorizar distribución |
| CRÍTICO | 🔴 Rojo oscuro | 1-7 días | Distribución inmediata |
| CADUCADO | 🔴 Rojo | 0 o negativo | Desechar producto |

### Funciones Disponibles

#### 1. Ver Todas las Alertas

1. Acceda al módulo "Alertas de Caducidad"
2. Verá la tabla con todos los productos
3. Columnas mostradas:
   - Nombre del producto
   - Punto de distribución
   - Fecha de expiración
   - Días restantes
   - Estado (con color)

#### 2. Filtrar por Estado

1. Click en los botones de filtro:
   - **Todos:** Muestra todas las alertas
   - **Crítico:** Solo alertas críticas (1-7 días)
   - **Urgente:** Solo alertas urgentes (7-15 días)
   - **Próximo:** Próximos a caducar (15-30 días)
   - **OK:** Productos con más de 30 días

2. La tabla se actualizará automáticamente

#### 3. Interpretar Alertas

**Producto en Estado CRÍTICO (🔴):**
```
Producto: Leche entera 1L
Punto: Centro Sur
Fecha Caducidad: 20/01/2026
Días Restantes: 3
Estado: CRÍTICO

Acción: Distribuir INMEDIATAMENTE. Contactar beneficiarios 
prioritarios hoy mismo.
```

**Producto en Estado URGENTE (🟠):**
```
Producto: Pan integral
Punto: Centro Norte
Fecha Caducidad: 27/01/2026
Días Restantes: 10
Estado: URGENTE

Acción: Incluir en la próxima distribución programada esta semana.
```

### Recomendaciones de Uso

1. **Revisión Diaria:** Acceda cada mañana para ver alertas críticas
2. **Planificación Semanal:** Use alertas urgentes para planificar distribuciones
3. **Rotación de Stock:** Priorice productos con menos días restantes
4. **Comunicación:** Informe a coordinadores sobre alertas críticas

---

## Preguntas Frecuentes

### General

**P: ¿Cómo puedo recuperar mi contraseña?**  
R: Contacte con el administrador del sistema para que restablezca su contraseña.

**P: ¿Por qué no veo ciertos módulos?**  
R: Depende de su rol. Los usuarios normales solo tienen acceso a Beneficiarios y Puntos de Distribución en modo lectura.

**P: ¿Puedo cambiar mi contraseña?**  
R: Actualmente no. Esta función estará disponible en futuras versiones.

### Beneficiarios

**P: ¿Puedo registrar un beneficiario sin DNI?**  
R: No, el DNI es obligatorio para evitar duplicados y garantizar la trazabilidad.

**P: ¿Qué significa "Estado: Pendiente"?**  
R: El beneficiario ha sido registrado pero falta validar su documentación.

**P: ¿Se puede recuperar un beneficiario eliminado?**  
R: No, la eliminación es permanente. Use con precaución.

### Voluntarios

**P: ¿Puedo asignar tareas a voluntarios desde el sistema?**  
R: Actualmente no. Esta función está en desarrollo para futuras versiones.

**P: ¿Cómo registro horarios flexibles?**  
R: En el campo "Horas Disponibles", escriba una descripción libre, por ejemplo: "Disponible tardes de lunes a jueves, horario flexible".

### Puntos de Distribución

**P: ¿Cómo obtengo las coordenadas GPS?**  
R: Use Google Maps, busque la dirección, click derecho y copie las coordenadas.

**P: ¿El mapa no se muestra?**  
R: Verifique su conexión a internet y que JavaScript esté habilitado en su navegador.

### Alertas

**P: ¿Con qué frecuencia se actualizan las alertas?**  
R: Los días restantes se calculan en tiempo real cada vez que accede al módulo.

**P: ¿Recibo notificaciones automáticas?**  
R: Actualmente no. Debe acceder al módulo manualmente. Las notificaciones automáticas están planificadas para versiones futuras.

---

## Solución de Problemas

### Problema: No Puedo Iniciar Sesión

**Síntomas:** Mensaje "Usuario o contraseña incorrectos"

**Soluciones:**
1. Verifique que escribe correctamente usuario y contraseña
2. Compruebe que no tiene Caps Lock activado
3. Intente copiar y pegar las credenciales
4. Limpie las cookies del navegador
5. Contacte al administrador

### Problema: La Página No Carga

**Síntomas:** Pantalla en blanco o error de carga

**Soluciones:**
1. Refresque la página (F5)
2. Limpie la caché del navegador (Ctrl+Shift+Del)
3. Verifique su conexión a internet
4. Pruebe con otro navegador
5. Contacte al soporte técnico

### Problema: No Veo el Botón "Guardar"

**Síntomas:** Botones de acción no visibles

**Soluciones:**
1. Verifique su rol de usuario (solo admin puede crear/editar/eliminar)
2. Desplace la página hacia abajo
3. Aumente el zoom del navegador (Ctrl + +)
4. Use un dispositivo con pantalla más grande

### Problema: El Mapa No Se Muestra

**Síntomas:** Espacio vacío donde debería estar el mapa

**Soluciones:**
1. Verifique conexión a internet
2. Compruebe que JavaScript está habilitado
3. Desactive bloqueadores de contenido/anuncios
4. Refresque la página
5. Pruebe con otro navegador

### Problema: Sesión Expirada Constantemente

**Síntomas:** Debe iniciar sesión cada pocos minutos

**Soluciones:**
1. Verifique que las cookies están habilitadas
2. No use modo incógnito/privado
3. Cierre otras pestañas del sistema
4. Contacte al administrador

---

## Contacto y Soporte

### Soporte Técnico

**Email:** soporte@bancoalimentos.org  
**Teléfono:** +34 900 123 456  
**Horario:** Lunes a Viernes, 9:00 - 18:00

### Reporte de Errores

Si encuentra un error en el sistema:

1. Anote el mensaje de error exacto
2. Describa qué estaba haciendo cuando ocurrió
3. Tome una captura de pantalla si es posible
4. Envíe la información a soporte@bancoalimentos.org

### Sugerencias de Mejora

Sus comentarios son importantes. Envíe sugerencias a:  
**Email:** mejoras@bancoalimentos.org

### Formación

¿Necesita formación adicional?  
Contacte con el departamento de capacitación:  
**Email:** formacion@bancoalimentos.org  
**Teléfono:** +34 900 123 457

---

## Glosario

- **Beneficiario:** Persona que recibe ayuda del banco de alimentos
- **Voluntario:** Persona que colabora de forma altruista
- **Punto de Distribución:** Ubicación física donde se entregan alimentos
- **CRUD:** Crear, Leer, Actualizar, Eliminar
- **Rol:** Nivel de permisos de un usuario
- **Admin:** Administrador con permisos completos
- **DNI:** Documento Nacional de Identidad
- **GPS:** Sistema de Posicionamiento Global
- **Alerta:** Notificación de producto próximo a caducar

---

**Última actualización:** 17 de Enero, 2026  
**Versión del documento:** 1.0  
**Sistema:** Banco de Alimentos v1.0
