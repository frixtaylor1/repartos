# Repartos API

Este proyecto proporciona una API para la gestión de repartos, incluyendo la creación, asignación y seguimiento de órdenes. Está desarrollado en **Laravel** y sigue buenas prácticas de estructura y organización de código.

## Instalación

### 1. Configurar la base de datos
Antes de ejecutar la aplicación, se debe crear un usuario en la base de datos con los privilegios necesarios para gestionar la base de datos `repartos`.
Ejemplo de configuración en el archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=repartos
DB_USERNAME=<created_user>
DB_PASSWORD=<created_password>
```

### 2. Migraciones y seeds
Una vez configurada la base de datos, ejecutar los siguientes comandos para crear las tablas y cargar datos de prueba:

```bash
php artisan migrate:fresh --seed
```

### 3. Levantar el servidor
Para iniciar la aplicación en un entorno local:

```bash
php artisan serve
```

### Ejecución de Tests con PHPunit

Para ejecutar todos los tests del proyecto:
```bash
php artisan tests
```

Para ejecutar tests con cobertura de código:
```bash
php artisan tests --coverage
```

### Endpoints disponibles
Para consultar todos los endpoints disponibles en la API, utilizar el comando:

```bash
php artisan route:list
```

### Documentación adicional
El siguiente link presenta una documentacion autogenerada por la IA de Devin.
Hay que tomarla con "pinzas".
[DeepWiki - Repartos](https://deepwiki.com/frixtaylor1/repartos)