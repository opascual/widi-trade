## Implementa una API con un solo endpoint siguiendo la siguiente definición

`POST /api/v1/short-urls`

Recibe un body con los siguiente requisitos:

`url: string, required`

Devuelve un objeto JSON con la siguiente estructura:

```
{
    "url": "<https://example.com/12345>"
}
```

url deberá apuntar a un acortador de urls, y al acceder deberá redireccionar a la url original recibida en el body de la petición.
Utiliza una API pública a tu elección, recomendamos tinyurl con su API: GET [https://tinyurl.com/api-create.php?url=http://www.example.com](https://tinyurl.com/api-create.php?url=http://www.example.com)

## Autorización

La autorización será tipo "Bearer Token", por ejemplo: `Authorization: Bearer my-token`.
Cualquier token que cumpla con el problema de los paréntesis (descrito a continuación) es un token válido, por ejemplo: `Authorization: Bearer []{}`

## Problema de los paréntesis

Dada una cadena que contiene tan solo los caracteres `{`, `}`, `[`, `]`, `(` y `)` determina si la entrada es válida.

La entrada es válida si cumple las siguientes condiciones:

-   Los paréntesis/llaves/corchetes abiertos se deben cerrar con el mismo tipo.
-   Los paréntesis/llaves/corchetes abiertos se deben cerrar en el orden correcto.

Nota: una cadena vacía es considerada válida.

Ejemplos:

```
{} - true
{}[]() - true
{) - false
[{]} - false
{([])} - true
(((((((() - false
```

## Desarrollo

He desarrollado un Middleware `CustomToken` que gestiona la validación del Bearer token para las peticiones al endpoint `/api/v1/short-urls`.

El controlador `ShortenUrlsController` se encarga de gestionar la llamada a Tinyurl y devolver una respuesta Json con los datos.

He implementado 3 tests para comprobar las respuestas de los caso siguientes:

-   Llamada al endpoint con un Bearer token válido devuelve `Status:200`.
-   LLamada al endpoint con un Bearer token válido pero sin el parámetro `url` en el BODY devuelve `Status:422`.
-   Llamada al endpoint con un Bearer token no válido devuelve `Status:403`.

He utilizado:

-   Laravel Framework 8.83.27
-   PHP 7.4
