# Repartos API

Este proyecto proporciona una API para la gestión de repartos, incluyendo la creación y asignación de órdenes. Está desarrollado en **Laravel**.
El proyecto usa **mariadb** como motor de base de datos.

## Instalación

### 1. Instalar dependencias
Primero instalar las dependencias del proyecto.
```bash
composer install
```

### 2. Configurar la base de datos
Antes de ejecutar la aplicación, se debe crear un usuario en la base de datos con los privilegios necesarios para gestionar la base de datos `repartos`.
Ejemplo de configuración en el archivo `.env`:

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=repartos
DB_USERNAME=<created_user>
DB_PASSWORD=<created_password>
```

Crear la base de datos:
```sql
CREATE DATABASE repartos;
CREATE USER 'repartos_user'@'%' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON repartos.* TO 'repartos_user'@'%';

-- Esto es sólo para crear la db de testing...
CREATE DATABASE repartos_test;
GRANT ALL PRIVILEGES ON repartos_test.* TO 'repartos_user'@'%';

FLUSH PRIVILEGES;
```

### 3. Migraciones y seeds
Una vez configurada la base de datos, ejecutar los siguientes comandos para crear las tablas y cargar datos de prueba:

```bash
php artisan migrate:fresh --seed
```

### 4. Levantar el servidor
Para iniciar la aplicación en un entorno local:

```bash
php artisan serve
```

### Ejecución de Tests con PHPunit
Antes de poder ejecutar todos los tests del proyecto hay que tener una base de datos de tests como se menciona en el punto n° 2.

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