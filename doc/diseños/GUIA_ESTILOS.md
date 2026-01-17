# 🎨 Guía de Estilos - Sistema de Donaciones

## Tabla de Contenidos
1. [Paleta de Colores](#paleta-de-colores)
2. [Tipografía](#tipografía)
3. [Componentes](#componentes)
4. [Espaciados](#espaciados)
5. [Sombras](#sombras)
6. [Bordes y Radios](#bordes-y-radios)
7. [Estados](#estados)
8. [Ejemplos de Uso](#ejemplos-de-uso)

---

## Paleta de Colores

### Colores Principales

#### Verde Primario
```
Nombre: Verde Primario
Código HEX: #2F855A
RGB: 47, 133, 90
Uso: Botones principales, navbar, headers, enlaces activos
```

#### Verde Secundario
```
Nombre: Verde Claro (Accent)
Código HEX: #68D391
RGB: 104, 211, 145
Uso: Hover states, fondos suaves, accents
```

#### Verde Oscuro
```
Nombre: Verde Oscuro
Código HEX: #276749
RGB: 39, 103, 73
Uso: Gradientes, texto oscuro, borders
```

#### Blanco/Fondo Claro
```
Nombre: Blanco Verdoso
Código HEX: #F0FAF4
RGB: 240, 250, 244
Uso: Fondos, campos de formulario, tarjetas
```

#### Gris Oscuro
```
Nombre: Gris Oscuro
Código HEX: #1F2937
RGB: 31, 41, 55
Uso: Texto principal, headers, elementos oscuros
```

### Colores de Estado

#### Error / Peligro
```
Fondo: #f8d7da (rojo claro)
Texto: #721c24 (rojo oscuro)
Border: #f5c6cb (rojo intermedio)
Uso: Mensajes de error, botones de eliminar
```

#### Advertencia / Warning
```
Fondo: #fef3c7 (amarillo claro)
Texto: #d97706 (ámbar)
Border: #fcd34d (amarillo intermedio)
Uso: Alertas, información importante, estados críticos
```

#### Éxito / Success
```
Fondo: #d4edda (verde claro)
Texto: #155724 (verde oscuro)
Border: #c3e6cb (verde intermedio)
Uso: Mensajes de éxito, confirmaciones
```

#### Info
```
Fondo: #d1ecf1 (azul claro)
Texto: #0c5460 (azul oscuro)
Border: #bee5eb (azul intermedio)
Uso: Información, tips, notas
```

### Paleta Visual
```
┌─────────────────────────────────────────────────┐
│  #2F855A  │  #68D391  │  #276749  │  #F0FAF4   │
│  Primary  │ Secondary │   Dark    │   Light    │
└─────────────────────────────────────────────────┘

┌──────────┬──────────┬──────────┬──────────┐
│ #f8d7da  │ #fef3c7  │ #d4edda  │ #d1ecf1  │
│  Error   │ Warning  │ Success  │  Info    │
└──────────┴──────────┴──────────┴──────────┘
```

---

## Tipografía

### Fuente Principal
```
Familia: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif
Fallback: Arial, Helvetica, sans-serif
Tipo: Sans-serif (moderno y limpio)
```

### Pesos de Fuente

| Peso | Valor | Uso |
|------|-------|-----|
| Light | 300 | Textos secundarios, subtítulos |
| Regular | 400 | Texto de cuerpo, párrafos |
| Medium | 500 | Etiquetas, información relevante |
| Semi-Bold | 600 | Títulos de secciones, botones |
| Bold | 700 | Títulos principales, headers |

### Tamaños de Fuente

```
h1 (Títulos principales):     32px / 2rem
h2 (Subtítulos):              24px / 1.5rem
h3 (Encabezados):             20px / 1.25rem
h4 (Subencabezados):          18px / 1.125rem
p  (Párrafos):                16px / 1rem
label (Etiquetas):            14px / 0.875rem
small (Texto pequeño):        12px / 0.75rem
```

### Altura de Línea

```
Títulos:    1.2 (lineal)
Párrafos:   1.6 (generoso para legibilidad)
Etiquetas:  1.4 (normal)
```

### Ejemplo de Implementación

```css
h1 {
    font-size: 32px;
    font-weight: 700;
    line-height: 1.2;
    color: #2F855A;
}

p {
    font-size: 16px;
    font-weight: 400;
    line-height: 1.6;
    color: #1F2937;
}
```

---

## Componentes

### Botones

#### Botón Principal
```
Color de fondo: #2F855A
Color de texto: Blanco
Padding: 12px 20px
Border-radius: 5px
Font-weight: 600
Cursor: pointer
Hover: background-color: #276749, transform: translateY(-2px)
```

```html
<button class="btn btn-primary">Guardar</button>
```

#### Botón Secundario
```
Color de fondo: #F0FAF4
Color de texto: #2F855A
Border: 2px solid #2F855A
Padding: 12px 20px
Border-radius: 5px
Font-weight: 600
Hover: background-color: #68D391
```

```html
<button class="btn btn-secondary">Cancelar</button>
```

#### Botón Peligro (Delete)
```
Color de fondo: #f8d7da
Color de texto: #721c24
Border: 1px solid #f5c6cb
Padding: 8px 15px
Border-radius: 5px
Font-weight: 600
Font-size: 14px
Hover: background-color: #f5c6cb
```

```html
<button class="btn btn-danger">Eliminar</button>
```

#### Botón Pequeño
```
Padding: 6px 12px
Font-size: 13px
```

#### Botón Deshabilitado
```
Opacity: 0.5
Cursor: not-allowed
Pointer-events: none
```

### Formularios

#### Input Text / Email / Password
```
Width: 100% (en contenedor)
Padding: 12px
Border: 2px solid #e0e0e0
Border-radius: 5px
Font-size: 14px
Focus: border-color: #2F855A, outline: none
Background: white
Transition: all 0.3s
```

```html
<input type="text" class="form-input" placeholder="Nombre">
```

#### Textarea
```
Width: 100%
Padding: 12px
Border: 2px solid #e0e0e0
Border-radius: 5px
Font-size: 14px
Line-height: 1.5
Resize: vertical
Focus: border-color: #2F855A
```

#### Labels
```
Display: block
Font-weight: 600
Font-size: 14px
Color: #333
Margin-bottom: 8px
```

```html
<label class="form-label">Nombre *</label>
<input type="text" class="form-input">
```

### Tarjetas

```
Background: white
Border-radius: 10px
Padding: 30px
Box-shadow: 0 2px 8px rgba(0,0,0,0.1)
Hover: transform: translateY(-5px), box-shadow: 0 8px 20px rgba(47, 133, 90, 0.2)
Transition: all 0.3s
```

```html
<div class="card">
    <h3>Título</h3>
    <p>Descripción</p>
</div>
```

### Navbar / Header

```
Background: linear-gradient(135deg, #2F855A 0%, #276749 100%)
Padding: 15px 30px
Color: white
Box-shadow: 0 2px 8px rgba(0,0,0,0.1)
Display: flex
Justify-content: space-between
Align-items: center
```

### Mensajes / Alerts

#### Mensaje de Error
```
Background: #f8d7da
Color: #721c24
Border: 1px solid #f5c6cb
Padding: 12px
Border-radius: 5px
Font-size: 14px
```

#### Mensaje de Éxito
```
Background: #d4edda
Color: #155724
Border: 1px solid #c3e6cb
Padding: 12px
Border-radius: 5px
Font-size: 14px
```

### Tabla

```
Width: 100%
Border-collapse: collapse
Background: white
Box-shadow: 0 2px 8px rgba(0,0,0,0.1)

thead:
  Background: #F0FAF4
  Font-weight: 600
  Color: #2F855A

tbody tr:
  Border-bottom: 1px solid #eee
  Hover: background: #f9f9f9

td:
  Padding: 15px
  Font-size: 14px
```

---

## Espaciados

### Sistema de Espaciado Base: 8px

```
xs:  4px   (0.25rem)
sm:  8px   (0.5rem)
md: 16px   (1rem)
lg: 24px   (1.5rem)
xl: 32px   (2rem)
2xl: 40px  (2.5rem)
3xl: 48px  (3rem)
```

### Uso en Componentes

```
Padding botones:        12px (1.5x base)
Padding inputs:         12px (1.5x base)
Padding tarjetas:       30px (3.75x base)
Padding navbar:         15px (1.875x base)
Margin entre secciones: 40px (5x base)
Gap entre elementos:    20px (2.5x base)
```

### Margen Vertical Entre Elementos

```
Párrafos:           16px (1rem)
Secciones:          40px-60px
Elementos en grid:  20px
Elementos en lista: 10px
```

---

## Sombras

### Shadow 1 (Ligera)
```
box-shadow: 0 2px 8px rgba(0,0,0,0.1);
Uso: Tarjetas, botones, inputs
```

### Shadow 2 (Media)
```
box-shadow: 0 4px 12px rgba(0,0,0,0.15);
Uso: Modales, dropdowns
```

### Shadow 3 (Fuerte)
```
box-shadow: 0 8px 20px rgba(0,0,0,0.2);
Uso: Hover en tarjetas principales
```

### Shadow Específica para Verde
```
box-shadow: 0 4px 12px rgba(47, 133, 90, 0.2);
Uso: Hover en botones verdes
```

---

## Bordes y Radios

### Border Radius

```
Pequeño:    5px   (inputs, botones pequeños)
Medio:      8px   (tarjetas, modales)
Grande:     10px  (tarjetas principales)
Redondo:    50%   (avatares, badges)
```

### Border Width

```
Delgado:    1px (dividers, inputs sin focus)
Normal:     2px (inputs con focus, borders activos)
Grueso:     3px-4px (borders destacados)
```

### Estilos de Border

```
Color default:    #e0e0e0 (gris claro)
Color focus:      #2F855A (verde primario)
Color error:      #f5c6cb (rojo claro)
Color success:    #c3e6cb (verde claro)
```

---

## Estados

### Hover
```
Cambios comunes:
- Background más oscuro o claro
- Transform: translateY(-2px) para elevación
- Box-shadow más prominente
- Cursor: pointer
Duración: 0.3s (transition)
```

### Focus
```
Inputs:
- Border-color: #2F855A
- Box-shadow: 0 0 0 3px rgba(47, 133, 90, 0.1)
- Outline: none

Botones:
- Ring: 2px solid #2F855A
- Offset: 2px
```

### Active / Pressed
```
Background: más oscuro
Transform: translateY(0) (sin elevación)
Box-shadow: más ligera
```

### Disabled
```
Opacity: 0.5
Cursor: not-allowed
Pointer-events: none
```

### Loading
```
Opacity: 0.7
Pointer-events: none
Spinner animation: 360deg rotation
```

---

## Transiciones y Animaciones

### Duración Estándar
```
Rápida:   0.15s (hover cambios simples)
Normal:   0.3s  (cambios comunes)
Lenta:    0.5s  (animaciones complejas)
```

### Timing Function
```
Default: ease (suave)
UI: ease-in-out (botones, transforms)
Entrada: ease-in (elementos que entran)
Salida: ease-out (elementos que salen)
```

### Ejemplo
```css
button {
    transition: all 0.3s ease;
}

button:hover {
    background-color: #276749;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(47, 133, 90, 0.2);
}
```

---

## Ejemplos de Uso

### Header de Página
```html
<header style="background: linear-gradient(135deg, #2F855A 0%, #276749 100%); padding: 40px; color: white; border-radius: 10px;">
    <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 10px;">Título</h1>
    <p style="font-size: 16px; line-height: 1.6;">Descripción</p>
</header>
```

### Tarjeta de Módulo
```html
<a href="#" class="module-card" style="background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-decoration: none; transition: all 0.3s;">
    <div style="font-size: 48px; margin-bottom: 15px;">🍎</div>
    <h3 style="font-size: 20px; font-weight: 700; color: #2F855A; margin-bottom: 8px;">Módulo</h3>
    <p style="font-size: 14px; color: #666;">Descripción del módulo</p>
</a>
```

### Formulario Completo
```html
<form style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Email</label>
    <input type="email" style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 5px; font-size: 14px; margin-bottom: 20px;">
    
    <button style="background: #2F855A; color: white; padding: 12px 20px; border: none; border-radius: 5px; font-weight: 600; cursor: pointer; transition: all 0.3s;">Enviar</button>
</form>
```

### Mensaje de Éxito
```html
<div style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px; border-radius: 5px;">
    ✅ Acción completada exitosamente
</div>
```

---

## Breakpoints Responsivos

```
Mobile:     < 480px
Tablet:     480px - 768px
Desktop:    768px - 1024px
Large:      > 1024px
```

### Media Queries

```css
/* Mobile First */
@media (max-width: 768px) {
    /* Estilos para tablets y mobile */
}

@media (min-width: 1024px) {
    /* Estilos para desktop */
}
```

---

## Accesibilidad

### Contraste de Colores
- Texto oscuro (#1F2937) sobre fondo claro (#F0FAF4): ✅ Contraste alto
- Texto blanco sobre verde (#2F855A): ✅ Contraste alto
- Texto rojo (#721c24) sobre fondo rojo claro (#f8d7da): ✅ Contraste adecuado

### Focus Visible
```css
/* Siempre mantener visible el focus */
:focus-visible {
    outline: 2px solid #2F855A;
    outline-offset: 2px;
}

/* No ocultar outline */
/* outline: none; ❌ EVITAR */
```

### Tamaños Mínimos
```
Botones: mínimo 44px de altura (toque en móvil)
Inputs: mínimo 44px de altura
Links: mínimo 16px de fuente
```

---

## Recursos y Variables CSS

### Variables CSS Recomendadas

```css
:root {
    /* Colores */
    --primary: #2F855A;
    --primary-dark: #276749;
    --primary-light: #68D391;
    --primary-lighter: #F0FAF4;
    --dark: #1F2937;
    --error: #f8d7da;
    --error-text: #721c24;
    --success: #d4edda;
    --success-text: #155724;
    --warning: #fef3c7;
    --warning-text: #d97706;
    
    /* Tipografía */
    --font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto;
    --font-weight-regular: 400;
    --font-weight-semibold: 600;
    --font-weight-bold: 700;
    
    /* Espaciados */
    --spacing-xs: 4px;
    --spacing-sm: 8px;
    --spacing-md: 16px;
    --spacing-lg: 24px;
    --spacing-xl: 32px;
    
    /* Transiciones */
    --transition-fast: 0.15s ease;
    --transition-normal: 0.3s ease;
    --transition-slow: 0.5s ease;
}
```

---

## Checklist de Implementación

- ✅ Usar colores de la paleta definida
- ✅ Mantener consistencia en padding/margin
- ✅ Usar border-radius especificado
- ✅ Aplicar sombras apropiadas
- ✅ Mantener transiciones de 0.3s
- ✅ Asegurar contraste adecuado
- ✅ Responsive en todos los breakpoints
- ✅ Accesibilidad: focus visible, tamaños mínimos
- ✅ Consistencia en tipografía
- ✅ Usar pesos de fuente correctos

---

**Última actualización:** 17 de Enero, 2026  
**Versión:** 1.0
