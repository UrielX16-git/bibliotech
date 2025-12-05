# Despliegue de Bibliotech con Docker

Este proyecto ha sido adaptado para funcionar con Docker. Sigue estos pasos para desplegarlo.

## Requisitos

- Docker instalado.
- Docker Compose.

## Pasos para Desplegar

1.  **Construir e Iniciar los Contenedores:**

    Abre una terminal en la carpeta del proyecto y ejecuta:

    ```bash
    docker-compose up -d --build
    ```

    Esto descargará las imágenes necesarias, construirá el contenedor de la aplicación web e iniciará la base de datos (MariaDB) y phpMyAdmin.

2.  **Crear Usuario Administrador:**

    Una vez que los contenedores estén corriendo, abre tu navegador y visita la siguiente dirección para crear el usuario administrador por defecto (`admin@bibliotech.com` / `admin123`):

    [http://localhost/setup_admin.php](http://localhost/setup_admin.php)

    Deberías ver un mensaje indicando que el usuario ha sido creado.

3.  **Usar la Aplicación:**

    Ahora puedes acceder a la aplicación principal en:

    [http://localhost](http://localhost)

    Inicia sesión con:
    - **Email:** admin@bibliotech.com
    - **Contraseña:** admin123

4.  **Gestión de Base de Datos (Opcional):**

    Si necesitas inspeccionar la base de datos, puedes usar phpMyAdmin en:

    [http://localhost:8080](http://localhost:8080)
    (Servidor: `db`, Usuario: `root`, Contraseña: `root`)

## Archivos Importantes

- `docker-compose.yml`: Definición de los servicios (web, db, phpmyadmin).
- `Dockerfile`: Configuración de la imagen de PHP con Apache.
- `init.sql`: Script para crear las tablas de la base de datos automáticamente.
- `setup_admin.php`: Script auxiliar para crear el usuario administrador con la contraseña encriptada correctamente.
- `database.php`: Archivo de conexión adaptado para leer variables de entorno.
