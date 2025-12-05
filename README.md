# 📚 Bibliotech

**Bibliotech** es una plataforma web diseñada para la gestión y distribución de recursos de papers de IA.

## Características Principales

La plataforma cuenta con dos tipos de usuarios: **Clientes** y **Administradores**.

### Para los Clientes
*   **Exploración de Recursos**: Visualiza una lista completa de los papers disponibles con su portada, título, autores y una breve explicación.
*   **Búsqueda Inteligente**: Encuentra lo que buscas filtrando por nombre, autor, fecha o tipo de documento.
*   **Descarga de PDFs**: Descarga los documentos completos directamente a tu dispositivo.
*   **Acceso Seguro**: Sistema de registro e inicio de sesión.

### Para los Administradores
*   **Subir Recursos**: Formulario para añadir nuevos papers al sistema, incluyendo la carga del archivo PDF y una imagen de portada.
*   **Gestión de Contenido**: Posibilidad de eliminar papers que ya no sean necesarios.
*   **Panel de Estadísticas**: Visualiza gráficas interactivas para entender el comportamiento de los usuarios:
    *   Descargas por tipo de documento.
    *   Horas con más actividad.
    *   Papers más populares.
    *   Usuarios más activos.

---

## Estructura de la Base de Datos

La información se organiza en 4 tablas principales:

### 1. `logindb` (Usuarios)
Almacena la información de las cuentas de usuario.
*   `id`: Identificador único del usuario.
*   `nombre`: Nombre completo.
*   `email`: Correo electrónico.
*   `password_hash`: Contraseña encriptada.
*   `role`: Rol del usuario (`admin` o `cliente`).

### 2. `papers` (Recursos)
Contiene la información de los documentos académicos.
*   `ID`: Identificador único del paper.
*   `Nombre`: Título del documento.
*   `Autores`: Lista de autores.
*   `Fecha`: Fecha de publicación.
*   `Explicacion`: Breve descripción o resumen.
*   `Imagen`: Ruta de la imagen de portada.
*   `Archivo`: Ruta del archivo PDF.
*   `Tipo`: Categoría del documento (ej. Artículo, Tesis, Libro).
*   `Borrado`: Indicador de estado (0 = Activo, 1 = Eliminado).

### 3. `acceso` (Bitácora de Sesiones)
Registra cuándo entran y salen los usuarios.
*   `id`: Identificador del registro.
*   `usuario_id`: ID del usuario que realizó la acción.
*   `fecha`: Fecha y hora del evento.
*   `login`: Tipo de evento (`1` = Inicio de sesión, `0` = Cierre de sesión).

### 4. `descargas` (Bitácora de Descargas)
Registra cada vez que se descarga un documento.
*   `id`: Identificador del registro.
*   `paper_id`: ID del paper descargado.
*   `usuario_id`: ID del usuario que lo descargó.
*   `fecha`: Fecha y hora de la descarga.
