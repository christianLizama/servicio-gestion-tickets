# Gestión de Tickets

Este proyecto utiliza Laravel y MySQL junto con Docker y Docker-compose para su ejecución. A continuación se detallan los pasos necesarios para configurar y ejecutar el proyecto.

## Requisitos del Entorno

- PHP 8.3.10 (cli) (built: Jul 30 2024 15:15:59) (ZTS Visual C++ 2019 x64)
- Composer version 2.7.7 2024-06-10 22:11:12

## Requisitos Previos

- [Docker](https://www.docker.com/products/docker-desktop) instalado
- [Docker-compose](https://docs.docker.com/compose/install/) instalado

## Instalación

1. Clonar el repositorio del proyecto:
    ```
    git clone https://github.com/christianLizama/servicio-gestion-tickets.git
    ```

2. Navegar al directorio del proyecto:
    ```
    cd servicio-gestion-tickets
    ```

3. Copiar el archivo `.env.example` a `.env`:
    ```
    cp .env.example .env
    ```

4. Construir y levantar los contenedores de Docker:
    ```
    docker-compose up --build -d
    ```

## Configuración Adicional

Una vez que los contenedores estén en funcionamiento, es necesario ingresar al contenedor de la aplicación y ejecutar las migraciones y los seeders.

1. Ingresar al contenedor de la aplicación:
    ```
    docker-compose exec app bash
    ```

2. Generar la clave de la aplicación:
    ```
    php artisan key:generate
    ```

3. Ejecutar las migraciones:
    ```
    php artisan migrate
    ```

4. Ejecutar los seeders:
    ```
    php artisan db:seed --class=CustomerSeeder
    php artisan db:seed --class=EventSeeder
    ```

## Uso

Una vez completados los pasos anteriores, el proyecto estará disponible en http://localhost:8000.

## Consultando la API

El proyecto expone varias rutas de API que pueden ser utilizadas para interactuar con la aplicación. A continuación se muestran ejemplos de cómo consultar la API:

Además, puedes utilizar la colección de Postman incluida en el repositorio para facilitar la interacción con las rutas de la API. La colección se llama `Servicio Gestion Tickets.postman_collection.json` y está disponible en el directorio del repositorio. Para utilizarla, sigue estos pasos:

1. Descarga e instala Postman si aún no lo has hecho.
2. Abre Postman y selecciona la opción para importar una colección.
3. Selecciona el archivo `Servicio Gestion Tickets.postman_collection.json` desde el directorio del repositorio.
4. Una vez importada, podrás ver y utilizar todas las rutas de la API definidas en la colección, así como ejecutar las solicitudes y ver las respuestas directamente desde Postman.

### Obtener todos los eventos (ver imagen 1 en la carpeta images)

Ruta: `GET /events`

### Obtener detalles de un evento (ver imagen 2)

Ruta: `GET /event/{id}`

### Realizar una compra (ver imagen 3)

Ruta: `POST /purchase`

### Obtener órdenes por cliente (ver imagen 4)

Ruta: `GET /orders/customer`

## Comandos Útiles

- Ver los logs de los contenedores:
    ```
    docker-compose logs
    ```

- Detener los contenedores:
    ```
    docker-compose down
    ```

- Reiniciar los contenedores:
    ```
    docker-compose restart
    ```

## Ejecutar sin usar Docker

Si prefieres ejecutar el proyecto sin usar Docker, sigue estos pasos:

1. Asegúrate de tener PHP, Composer y MySQL instalados en tu máquina.
2. Instalar las dependencias del proyecto:
    ```
    composer install
    ```

3. Copiar el archivo `.env.example` a `.env` y configurar las variables de entorno necesarias.
4. Generar la clave de la aplicación:
    ```
    php artisan key:generate
    ```

5. Ejecutar las migraciones:
    ```
    php artisan migrate
    ```

6. Ejecutar los seeders:
    ```
    php artisan db:seed --class=CustomerSeeder
    php artisan db:seed --class=EventSeeder
    ```

7. Levantar el servidor de desarrollo de Laravel:
    ```
    php artisan serve
    ```

El proyecto estará disponible en http://localhost:8000.

## Suposiciones del Proyecto

- Cada cliente tiene un correo electrónico único que actúa como su identificador principal.
- Los eventos tienen un nombre, una descripción opcional, una fecha de inicio y una fecha de finalización.
- El precio de los eventos es un valor decimal con hasta 8 dígitos antes del punto decimal y 2 dígitos después.
- Cada ticket está asociado con un evento específico y un cliente específico. Los tickets se eliminan automáticamente si se elimina el evento o el cliente asociado.
- Cada orden está vinculada a un ticket específico. Las órdenes tienen un campo de estado para rastrear su progreso. Por defecto, todas las compras se consideran exitosas y se les asigna el estado de "completed". Sin embargo, es fácil editar el código para manejar otros estados en caso de errores u otras situaciones como compras por tarjeta de crédito, por ejemplo. Las órdenes se eliminan automáticamente si se elimina el ticket asociado.
- Las tablas `tickets` y `orders` tienen relaciones de clave foránea con las tablas `events`, `customers`, y `tickets` respectivamente. Se utiliza eliminación en cascada para mantener la integridad referencial.
- Todas las tablas incluyen campos de timestamps (`created_at` y `updated_at`) para rastrear cuándo se crean y actualizan los registros.
- No se ha implementado un sistema de inicio de sesión ni funcionalidades relacionadas, ya que el enfoque principal del proyecto es la lógica de la compra de tickets.
- Se asume que un usuario puede comprar varios tickets para el mismo evento.
- Para simplificar la ejecución de la solución, se han creado seeders para poblar la base de datos con datos mínimos necesarios para utilizar la aplicación. No se ha creado un sistema de inicio de sesión ni funcionalidades relacionadas, ya que se considera innecesario para los objetivos del proyecto.