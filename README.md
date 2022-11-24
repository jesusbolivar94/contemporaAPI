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

## Endpoints

Todas las solicitudes deben enviarse con la cabecera:

```http request
Accept: "application/json"
```

### Token

#### GET `/token`

Las peticiones PUT, POST y PATCH deben autorizarse con un token.

Basta con hacer una solicitud GET al endpoint /token.

Este endpoint regresa una respuesta HTTP 200 con el token de seguridad.

```JSON
{
    "access_token": "6wDQjxZGnXW7QQvYTVNpPGNSIj9RA6YMJQlAnwxK"
}
```

El token de acceso tiene un tiempo de vida de 1 hora desde su solicitud.

### Usuarios

#### GET `/usuarios`
#### GET `/usuarios/p/{page}`

Devuelve un listado de usuarios. 

Puedes cambiar de pagina añadiendo a la petición el parametro opcional `p` seguido del numero de pagina en el que quieres consultar usuarios.

Se puede filtrar el listado de usuarios pasando parametros de busqueda:

#### GET `/usuarios?nombre=varma`
#### GET `/usuarios?email=dhanesh`
#### GET `/usuarios?genero=mujer`
#### GET `/usuarios?activos=true`

Se puede usar más de un parametro de busqueda a la vez y tambien cambiar de pagina en esa busqueda

#### GET `/usuarios/p/2?nombre=varma&activos=false`

```JSON
[
    {
        "id": 3738,
        "nombre": "Dhanesh Varma",
        "email": "dhanesh_varma@murazik.com",
        "genero": "mujer",
        "activo": "true"
    },
    {
        "id": 3735,
        "nombre": "Deepesh Kocchar DC",
        "email": "kocchar_deepesh_dc@kirlin.io",
        "genero": "mujer",
        "activo": "false"
    },
    {
        "id": 3734,
        "nombre": "Dhanadeepa Menon Jr.",
        "email": "menon_dhanadeepa_jr@ankunding.io",
        "genero": "hombre",
        "activo": "false"
    },
    {
        "id": 3732,
        "nombre": "Anusuya Guneta",
        "email": "anusuya_guneta@moen.biz",
        "genero": "mujer",
        "activo": "false"
    },
    {
        "id": 3731,
        "nombre": "Somnath Mukhopadhyay",
        "email": "somnath_mukhopadhyay@considine.net",
        "genero": "hombre",
        "activo": "true"
    },
    {
        "id": 3730,
        "nombre": "Adikavi Dwivedi",
        "email": "dwivedi_adikavi@beatty-torp.com",
        "genero": "mujer",
        "activo": "false"
    },
    {
        "id": 3727,
        "nombre": "Amritambu Somayaji",
        "email": "amritambu_somayaji@mayert.name",
        "genero": "mujer",
        "activo": "false"
    },
    {
        "id": 3726,
        "nombre": "Ekdant Shah",
        "email": "shah_ekdant@ernser.biz",
        "genero": "hombre",
        "activo": "false"
    },
    {
        "id": 3724,
        "nombre": "Dharitri Mishra",
        "email": "dharitri_mishra@lesch-tillman.io",
        "genero": "hombre",
        "activo": "true"
    },
    {
        "id": 3723,
        "nombre": "Anshula Pandey",
        "email": "pandey_anshula@barton.name",
        "genero": "mujer",
        "activo": "false"
    }
]
```

#### GET `/usuarios/{id}`

Puedes consultar solamente un usuario pasando el id del usuario como parametro en la URL

```JSON
{
    "id": 3738,
    "nombre": "Dhanesh Varma",
    "email": "dhanesh_varma@murazik.com",
    "genero": "mujer",
    "activo": "true"
}
```

#### POST `/usuarios`

Para crear usuarios debes hacer una solicitud POST and endpoint `/usuarios` pasando un objeto JSON con los datos del nuevo usuario.

Esta solicitud debe ser autorizada con el Bearer Token que responde el endpoint `/token`

```JSON
{
    "nombre": "Jhon Doe Bol 2",
    "email": "pruebamail8@mail.com",
    "genero": "hombre",
    "activo": true
}
```

Crear un usuario devuelve un objeto con los datos ingresados y el ID del nuevo usuario

```JSON
{
    "id": 3881,
    "nombre": "Jhon Doe Bol 2",
    "email": "pruebamail8@mail.com",
    "genero": "hombre",
    "activo": "false"
}
```

#### PATCH `/usuarios/{id}`
#### PATCH `/usuarios/{id}?nombre=`
#### PATCH `/usuarios/{id}?email=`
#### PATCH `/usuarios/{id}?genero=`
#### PATCH `/usuarios/{id}?activo=`

Se pueden modificar datos de un usuario pasando el parametro id en el endpoint `/usuarios`
y como query en la url el campo - valor que deseas modificar.

Esta solicitud debe ser autorizada con el Bearer Token que responde el endpoint `/token`

Se puede modificar más de un dato a la vez. Por ejemplo:

#### PATCH `/usuarios/{id}?nombre=Jane&genero=mujer`

```JSON
{
    "id": 3881,
    "nombre": "Jane",
    "email": "pruebamail9@mail.com",
    "genero": "mujer",
    "activo": "true"
}
```

#### PUT `/usuarios/{id}`

Puedes modificar todos los datos del usuario a la vez, excepto el id, haciendo una solicitud `PUT` al endpoint `/usuarios`
y pasando el id del usuario a modificar como parametro.

Debes enviar en el cuerpo de la solicitud un objeto json con los datos.

A diferencia de la modificación con método `PATCH` el metodo `PUT` va a requerir especificar todos los datos en el cuerpo de la solicitud.

Esta solicitud debe ser autorizada con el Bearer Token que responde el endpoint `/token`

PUT `/usuarios/3881`
```JSON
{
    "nombre": "Jane",
    "email": "pruebamail9@mail.com",
    "genero": "mujer",
    "activo": true
}
```

La solicitud devolvera un objeto json con los datos del usuario modificado:

```JSON
{
    "id": 3881,
    "nombre": "Jane",
    "email": "pruebamail9@mail.com",
    "genero": "mujer",
    "activo": "true"
}
```
