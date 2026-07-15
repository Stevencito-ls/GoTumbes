# Mejoras de Rendimiento y Experiencia de Usuario (UX)

Este documento detalla las optimizaciones implementadas para mejorar drásticamente la velocidad de carga entre páginas y proporcionar una experiencia de navegación fluida tipo "aplicación nativa" (SPA). También documenta las soluciones a los retos técnicos derivados de esta integración.

## 1. Navegación Ultrarrápida con Hotwired Turbo (`@hotwired/turbo`)
Se instaló e importó la librería **Turbo**. Esta herramienta cambia la forma en que la aplicación web funciona:
- Intercepta los clics en todos los enlaces de la aplicación.
- En lugar de realizar una recarga completa del navegador (lo cual obliga a volver a descargar y renderizar estilos y scripts), solicita el contenido de la nueva página por detrás (vía fetch/AJAX).
- Reemplaza únicamente el contenido del `<body>` de manera casi instantánea.
- **Beneficio:** Cero pantallas blancas o parpadeos al navegar entre secciones (Ej. pasar de Inicio a Destinos).

## 2. Transiciones de Vista Nativas (View Transitions API)
Para otorgarle una experiencia visual única y moderna al cliente, se activó el soporte para la nueva API de Transiciones de Vista del navegador.
- Se agregó la etiqueta `<meta name="view-transition" content="same-origin">` en los diseños (`app.blade.php`, `guest.blade.php`).
- Se añadieron estilos CSS (en `app.css`) haciendo uso de los pseudo-elementos `::view-transition-old` y `::view-transition-new`.
- **Beneficio:** Un elegante efecto de **desvanecimiento y escalado** (fade & scale) de 0.4 segundos que acompaña cada cambio de página.

## 3. Corrección de Carga Infinita en Destinos (Skeleton Loader)
Tras instalar Turbo, la página de destinos presentaba un error donde los recuadros grises de carga (Skeleton) se quedaban infinitamente.
- **Causa:** El código en JavaScript encargado de cargar los destinos esperaba el evento `DOMContentLoaded`. Turbo, al cambiar de página sin recargar, no dispara este evento.
- **Solución:** Se modificó la estructura del script en `index.blade.php` envolviendo el código en una Función Invocada Inmediatamente (IIFE). De esta manera, apenas Turbo inserta la página en la vista, el código se ejecuta automáticamente cargando los destinos.

## 4. Implementación de Caché para Firebase (Destinos)
Se detectó que el tiempo de espera hasta que los destinos dejaban de cargar era prolongado.
- **Causa:** El endpoint `/api/destinations` en el `PublicController` hacía una conexión en vivo y en directo a la base de datos de Firestore con cada visita a la página.
- **Solución:** Se envolvió la consulta a Firestore dentro de un bloque `Cache::remember('public_destinations', 300)`. 
- **Beneficio:** Los destinos ahora se almacenan en la memoria temporal del servidor por 5 minutos. La primera consulta toma un par de segundos, pero todas las siguientes se responden en milisegundos, haciendo que las tarjetas aparezcan de forma instantánea.

## 5. Reactivación del Video de Fondo (Autoplay Override)
Al navegar por la aplicación y regresar al Inicio, el video de fondo aparecía pausado.
- **Causa:** Por medidas de seguridad y políticas de los navegadores (Google Chrome, Safari), los videos insertados dinámicamente en la pantalla (como lo hace Turbo) ignoran el atributo `autoplay`.
- **Solución:** Se le asignó el identificador `id="hero-video"` a la etiqueta del video. En el archivo principal `app.js`, se creó un Event Listener que escucha el evento `turbo:load` (el cual se dispara cuando Turbo termina de cargar una página). Este listener busca el video y ejecuta de manera forzada y manual la instrucción de reproducir `video.play()`.
- **Beneficio:** El video ahora se reproduce ininterrumpidamente cada vez que el usuario vuelve a la pantalla de inicio, sin importar si llegó recargando el navegador o navegando rápidamente con Turbo.
