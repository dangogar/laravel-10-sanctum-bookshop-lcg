# Laravel 10 Book Library API

Una API RESTful completa para gestionar una biblioteca de libros usando Laravel 10 con autenticación Sanctum.


## Características propuestas por LCG

🔐 Autenticación (Laravel Sanctum)
- Registro de usuario
- Login
- Logout
- Acceso solo autenticado a rutas protegidas

📚 CRUD de Libros
- Crear un libro
- Ver listado de libros
- Ver detalle de un libro
- Actualizar libro
- Eliminar libro

🏷️ CRUD de Categorías
- Crear categoría
- Ver listado de categorías
- Actualizar categoría
- Eliminar categoría

🧰 Requisitos técnicos
- Laravel 10+
- Base de datos con migraciones
- Eloquent y relaciones (1:N entre categorías y libros)
- Validaciones usando FormRequest
- Middleware de autenticación
- Respuestas JSON claras
- Buen manejo de errores (404, 403, 422, etc.)


## Requisitos

- PHP 8.1+
- Composer
- SQLite o MySQL/MariaDB (si necesitas ésta, se habrá que configurar en .env y phpunit.xml)
- Laravel 10


## Estructura del Proyecto

```
app/
├── Http/
│   ├── Controllers/ <- Controlador para listar, guardar, modificar, mostrar y eliminar
│   │   ├── AuthController.php  <- Controlador de usuarios
│   │   ├── BookController.php  <- Controlador de libros
│   │   └── CategoryController.php <- Controlador de categorías
│   ├── Middleware/
│   ├── Requests/ <- Reglas y autorizaciones
│   │   ├── BookRequest.php 
│   │   └── CategoryRequest.php
│   └── Resources/ <- Transformar un elemento con datos en un array en formato JSON
│       ├── BookResource.php
│       └── CategoryResource.php
├── Models/ <- Clases y funciones
│   ├── Book.php
│   ├── Category.php
│   └── User.php
├── Policies/ <- Determinar si un usuario puede realizar el uso como listar, guardar, modificar y eliminar
│   ├── BookPolicy.php
│   └── CategoryPolicy.php
└── Providers/
    ├── AuthServiceProvider.php <- Autorizar las políticas BookPolicy y CategoryPolicy
    └── RouteServiceProvider.php <- Configurar las rutas de api
    
routes/
└── api.php  <- Rutas públicas y protegidas Sanctum (ver Rutas disponibles)
    
database/
├── migrations/  <- Tablas de categorías y libros (ver Estructura de la Base de Datos)
│   ├── create_categories_table.php
│   └── create_books_table.php
├── seeders/  <- Ejemplos de categorías y libros en castellano
│   ├── CategorySeeder.php
│   ├── BookSeeder.php
│   └── DatabaseSeeder.php
└── factories/ <- Fabricar categorías y libros al azar, opcional
    ├── CategoryFactory.php
    └── BookFactory.php
        
tests/
└── Feature/  <- Testear el funcionamiento
    ├── AuthTest.php
    ├── BookTest.php
    └── CategoryTest.php
    
Bookshop_API.postman_collection.json <- Colección de tests para Postman
```


## Estructura de la Base de Datos

### Tabla Categorías (categories)
- `id` - Identificador único
- `name` - Nombre de la categoría
- `created_at` - Fecha de creación
- `updated_at` - Fecha de actualización

### Tabla Libros (books)
- `id` - Identificador único
- `name` - Nombre del libro
- `category_id` - ID de la categoría (clave foránea)
- `author` - Autor del libro
- `created_at` - Fecha de creación
- `updated_at` - Fecha de actualización


## Rutas disponibles

### Autenticación (Públicos)

#### POST /api/register
Registra un nuevo usuario (AuthController@register).

#### POST /api/login
Inicia sesión de un usuario (AuthController@login).


### Rutas Protegidas (Requieren autenticación)

**Header requerido:** `Authorization: Bearer {token}`

#### GET /api/user
Obtiene el perfil del usuario autenticado (AuthController@user).

#### POST /api/logout
Cierra la sesión del usuario (AuthController@logout).


### Categorías

#### GET /api/categories
Lista todas las categorías (categories.index › CategoryController@index).

#### POST /api/categories
Crea una nueva categoría (categories.store › CategoryController@store).

#### GET /api/categories/{id}
Obtiene una categoría específica (categories.show › CategoryController@show).

#### PUT /api/categories/{id}
Actualiza una categoría (categories.update › CategoryController@update).

#### DELETE /api/categories/{id}
Elimina una categoría (categories.destroy › CategoryController@destroy). 


### Libros

#### GET /api/books
Lista todos los libros (books.index › BookController@index).

#### POST /api/books
Crea un nuevo libro (books.store › BookController@store).

#### GET /api/books/{id}
Obtiene un libro específico (books.show › BookController@show).

#### PUT /api/books/{id}
Actualiza un libro (books.update › BookController@update).

#### DELETE /api/books/{id}
Elimina un libro (books.destroy › BookController@destroy).



## Instalación

1. Clona el repositorio:
```bash
git clone <repository-url>
cd laravel-10-sanctum-bookshop-lcg
```

2. Instala las dependencias:
```bash
composer install
```

3. Copia el archivo de configuración:
```bash
cp .env.example .env
```

4. Si desea usar "mysql", configura tu base de datos en `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

5. Genera la clave de la aplicación:
```bash
php artisan key:generate
```

6. Ejecuta las migraciones:
```bash
php artisan migrate
```

7. Ejecuta los seeders para datos de ejemplo:
```bash
php artisan db:seed
```

8. Inicia el servidor:
```bash
php artisan serve
```


## Ejemplos de Uso mediante JSON

### 1. Registrar un usuario
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Usuario 1",
    "email": "usuario@ejemplo.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### 2. Iniciar sesión
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "usuario@ejemplo.com",
    "password": "password123"
  }'
```

### 3. Crear una categoría
```bash
curl -X POST http://localhost:8000/api/categories \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Tecnología"
  }'
```

### 4. Crear un libro
```bash
curl -X POST http://localhost:8000/api/books \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Laravel en Acción",
    "author": "Desarrollador Ejemplo",
    "category_id": 1
  }'
```

## Testing

### Ejecuta los tests con:

```bash
php artisan test
```
Los tests cubren:
- Autenticación (registro, login, logout)
- CRUD de categorías
- CRUD de libros
- Validaciones
- Autorización
- Manejo de errores


### Ejecuta el test de una clase con:

```bash
php artisan test --filter=AuthTest
```
Los tests de clases:
- AuthTest
- BookTest
- CategoryTest


### Ejecuta un test específico (función) de una clase con:

```bash
php artisan test --filter=test_user_can_register
```
Los tests específicos de una clase, p. ej. AuthTest:
- test_user_can_register
- test_user_can_login
- test_user_cannot_login_with_invalid_credentials
- test_user_can_logout
- test_user_can_get_profile
- test_unauthenticated_user_cannot_access_protected_routes


## Testing con Postman

1. Abre un espacio de trabajo
2. Pulsa el botón "Import"
3. Selecciona el archivo "Bookshop_API.postman_collection.json" que está en el proyecto


## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.
