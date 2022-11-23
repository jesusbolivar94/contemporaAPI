# Contempora API

API Laravel que funciona como API Gateway de la API de GoREST.
https://gorest.co.in

## Instalación

Crea el archivo de configuración .env en la raíz del proyecto duplicando el archivo .env.example

Debes agregar los siguientes parametros de configuración:

```dotenv
GO_REST_API_URL=https://gorest.co.in/public/v2
GO_REST_API_TOKEN="token de gorest"

DB_CONNECTION=sqlite
DB_DATABASE= ruta absoluta al archivo "database\sqlite\contemporaAPI.db"
DB_FOREIGN_KEYS=true
```

Ejecuta los siguientes comandos:

Instala las dependencias:
```bash
composer install
```

Migrar las tablas y datos
```bash
php artisan migrate
```

Inicia el proyecto
```bash
php artisan serve
```
