# 📘 Documentación Técnica y Funcional: Proyecto "GoTumbes"

Esta documentación detalla la arquitectura, tecnologías y funcionalidades del sistema **GoTumbes**, una plataforma web moderna diseñada para la gestión y reserva de experiencias turísticas en la región de Tumbes, Perú.

---

## 🚀 1. Stack Tecnológico (Tecnologías Utilizadas)

El proyecto ha sido desarrollado utilizando un stack moderno, priorizando la escalabilidad, la velocidad y la seguridad a través de tecnologías Serverless y frameworks de vanguardia.

- **Backend (Lógica de Servidor):** [Laravel 11](https://laravel.com/) (PHP)
- **Frontend (Diseño y UI):** [Tailwind CSS](https://tailwindcss.com/) compilado mediante Vite.js, complementado con Vanilla JavaScript para micro-interacciones (ej. Skeleton Loaders).
- **Base de Datos (NoSQL):** [Google Firebase - Firestore](https://firebase.google.com/docs/firestore), base de datos en tiempo real en la nube. **No se utilizan bases de datos locales tradicionales (MySQL/PostgreSQL)**.
- **Autenticación:** [Firebase Authentication](https://firebase.google.com/docs/auth), gestionando el login, registro y recuperación de contraseñas de forma segura.
- **Generación de Reportes:** `barryvdh/laravel-dompdf` para la creación instantánea de vouchers en formato PDF.

---

## 🎨 2. Diseño e Interfaz (UI/UX)

- **Modo Oscuro Elegante (Dark Theme):** Diseño centrado en fondos oscuros (`bg-slate-900`) con contrastes en color verde azulado (`teal-400` / `emerald-400`), transmitiendo una sensación premium, aventurera y confiable.
- **Efectos Glassmorphism:** Uso de paneles translúcidos con desenfoque (backdrop-blur) en barras de navegación y tarjetas de presentación.
- **Skeleton Loaders:** Para evitar pantallas blancas (congeladas) cuando el internet es lento, la sección del catálogo muestra animaciones de "carga fantasma" (esqueletos) mientras consulta los datos de Google Cloud, mejorando radicalmente la percepción de velocidad.
- **Prevención de Errores de Usuario (UX):** Los botones críticos (como "Confirmar Pago") cambian a un estado de carga y se bloquean al presionarse, previniendo que clientes impacientes envíen la misma reserva múltiples veces.
- **Comunicación Rápida:** Botón flotante persistente de WhatsApp configurado directamente con el número de la agencia.

---

## ⚙️ 3. Arquitectura del Sistema

- **Arquitectura MVC (Modelo-Vista-Controlador):** Patrón de diseño nativo de Laravel.
- **Inyección de Dependencias (Service Layer):** Toda la comunicación pesada con la base de datos de Google se ha abstraído en un `FirebaseService`, centralizando el código para hacerlo más limpio, profesional y fácil de escalar por cualquier ingeniero.
- **Gestión de Roles (Middleware):** Un sistema de seguridad personalizado (`is_admin`) intercepta las rutas y verifica en la nube si el usuario conectado posee privilegios administrativos antes de dejarlo pasar a los paneles de control.
- **Caché Optimizado:** Las métricas de administrador realizan peticiones pesadas a Firestore. Se implementó `Cache::remember()` de Laravel para guardar estos resultados por 60 segundos, ahorrando cientos de lecturas a la base de datos y reduciendo drásticamente los costos de Google Cloud.

---

## 🎯 4. Funcionalidades Principales

El sistema se divide en dos grandes áreas: **Área Pública (Turistas)** y **Área Administrativa (Agencia)**.

### 🙎‍♂️ A. Área Pública (Para Turistas y Clientes)

1. **Landing Page Interactiva:** 
   - Banner principal (Hero) con video de fondo en alta calidad.
   - Presentación de la marca, propuesta de valor y rutas principales.
2. **Catálogo Dinámico de Destinos:**
   - Consume en tiempo real los tours disponibles desde la base de datos Firestore a través de una API interna.
   - Muestra precios, fotos dinámicas y títulos amigables.
3. **Página de Detalles del Destino:**
   - Muestra información extensa (cupos, descripciones, recomendaciones).
   - **SEO Avanzado:** Cuenta con etiquetas *Open Graph* integradas, lo que permite que al compartir el enlace del tour por WhatsApp o Facebook, se genere una tarjeta visual con la foto y el título del viaje.
4. **Sistema de Checkout y Reservas (Modelo Yape/Plin):**
   - El turista elige cuántos tickets desea comprar, y el sistema calcula en tiempo real el monto total.
   - **Formulario adaptado:** En lugar de pasarelas de tarjeta de crédito, muestra instrucciones para transferir vía Yape o Plin.
   - El usuario selecciona la **Fecha del Tour**, su **Método de Pago** y registra el **Número de Operación**.
5. **Generador de Vouchers PDF:**
   - Una vez realizada la solicitud, el sistema emite automáticamente un comprobante PDF descargable, etiquetado en naranja como "PENDIENTE DE VALIDACIÓN", sirviendo como garantía para el cliente.
6. **Autenticación (Login/Registro):**
   - Sistema de cuentas personales. Los usuarios pueden crear su cuenta con su correo electrónico, gestionado por la seguridad de Firebase.

### 💼 B. Área Administrativa (Panel de Control de la Agencia)

Acceso restringido únicamente a dueños o empleados autorizados.

1. **Dashboard y Estadísticas Inteligentes:**
   - Gráficos y tarjetas que muestran el "Total de Reservas" y el "Total de Ingresos".
   - *Lógica de Contabilidad Exacta:* Los ingresos totales ignoran las reservas pendientes o rechazadas; **solo suman el dinero que la agencia ya validó como "Aprobado" (Pagado).**
2. **Gestor de Reservas (Validación de Pagos):**
   - Tabla completa con el historial de todos los clientes, números de operación, método de pago y fecha del tour.
   - **Flujo de Aprobación:** Botones rápidos de "Aprobar" (✅) o "Rechazar" (❌) que actualizan el estatus del cliente en tiempo real en la nube.
   - Acceso al Voucher PDF de cada reserva.
3. **Gestor de Catálogo (CRUD de Destinos):**
   - El administrador puede Crear, Editar y Eliminar los destinos turísticos, ajustar los precios y descripciones sin tocar el código fuente. Las modificaciones impactan inmediatamente la web pública.
4. **Gestor de Usuarios y Roles:**
   - Visualización de todas las personas registradas en la web.
   - Capacidad para ascender a cualquier turista o empleado al rol de "Administrador", otorgándole acceso a los paneles de control.

---

## 📈 5. Conclusión y Viabilidad del Proyecto

GoTumbes es un proyecto de software robusto, con un alto grado de pulido visual y arquitectónico. Al no depender de servidores SQL locales y utilizar la infraestructura de Firebase, posee alta disponibilidad y es invulnerable a caídas típicas de tráfico, convirtiéndolo en una solución corporativa "Nivel 10/10", lista para operar y recibir clientes masivos.
