<?php
// Este código inicia una sesión y verifica si las variables de sesión 'username' e 'id' existen y no están vacías. Si alguna de estas condiciones no se cumple, el usuario es redirigido a la página principal del sitio web utilizando la función header() de PHP. Es decir, este código se utiliza para asegurarse de que el usuario ha iniciado sesión antes de permitirles acceder a ciertas páginas o funcionalidades en el sitio web.
session_start();
if (
	!isset($_SESSION['username'])
	|| !isset($_SESSION['id'])
	|| empty($_SESSION['username'])
	|| empty($_SESSION['id'])
) {
	header('Location: https://localhost/proimpo/index.html');
}
