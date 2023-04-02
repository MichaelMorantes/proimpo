<a name="readme-top"></a>
<br />

<div align="center">
  <h3 align="center">Prueba Proimpo</h3>
</div>

### Construido con

- [![php][php.com]][php-url]
- [![javascript][javascript.com]][javascript-url]
- [![Bootstrap][bootstrap.com]][bootstrap-url]
- [![JQuery][jquery.com]][jquery-url]

## Datos importantes

Para acceder al login los datos son:

    usuario: cliente
    contraseña: cliente

La contraseña se encuentra cifrada con md5 en la base de datos.

Comisión = (Ventas del mes \* Tasa de comisión) + (Clientes nuevos \* valor comisión por cliente)

## Requisitos previos

Antes de comenzar, debes asegurarte de tener instalado lo siguiente:

    -Servidor web: Apache
    -PHP 7.0 o superior
    -MySQL 5.7 o superior
    -Un editor de texto para editar los -archivos del proyecto

Yo utilice la herramienta XAMPP

### Pasos

    Clonar o descargar el repositorio del proyecto.

    Crea la base de datos MySQL con el archivo proimpo.sql con usuario: "root" y contraseña vacia

    Copia todos los archivos del proyecto en el directorio htdocs

    Inicia el servidor web y accede al proyecto desde tu navegador web. Por ejemplo, si estás utilizando Apache y tu proyecto está en htdocs/proimpo, puedes acceder a él escribiendo http://localhost/proimpo en tu navegador.

    Si todo está configurado correctamente, deberías ver el proyecto funcionando en tu navegador.

## Estructura del Proyecto

    /proimpo
    ├── public
    │   ├── img
    │   ├── css
    │   │   └── style.css
    │   └── js
    │       └── functions.js
    ├── src
    │   ├── Controller
    |   |   ├── controller.php
    |   |   └── data_handler.php
    │   ├── Database
    |   |   ├── Calculate.sql
    |   |   ├── Delete.sql
    |   |   ├── Insert.sql
    |   |   ├── Login.sql
    |   |   └── Select.sql
    │   ├── Model
    |   |   └── model.php
    │   └── Utils
    |       ├── login.php
    |       ├── logout.php
    |       └── verifylogin.php
    ├── template
    │   ├── base
    |   |   ├── footer.html
    |   |   └── header.html
    │   └── cliente
    |       └── index.php
    ├─── index.html
    ├─── proimpo.sql
    └─── readme.md

<p align="right">(<a href="#readme-top">Subir</a>)</p>

[javascript.com]: https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E
[javascript-url]: https://www.javascript.com/
[php.com]: https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white
[php-url]: https://www.php.net/
[bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[bootstrap-url]: https://getbootstrap.com
[jquery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[jquery-url]: https://jquery.com
