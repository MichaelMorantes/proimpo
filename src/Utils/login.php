<?php
require_once __DIR__ . '/../Model/model.php'; // Se incluye el archivo que contiene el modelo.

session_start(); // Se inicia la sesión.

if (
	$_SERVER['REQUEST_METHOD'] !== 'POST' // Si el método de la petición no es POST
	|| !isset($_POST['username']) // Si no se ha enviado el campo de nombre de usuario.
	|| !isset($_POST['password']) // Si no se ha enviado el campo de contraseña.
	|| empty($_POST['username']) // Si el campo de nombre de usuario está vacío.
	|| empty($_POST['password']) // Si el campo de contraseña está vacío.
) {
	header('Location: https://localhost/proimpo/index.html'); // Se redirige al usuario a la página de inicio.
}

try {
	$model = new model(); // Se crea una nueva instancia del modelo.

	$_POST['password'] = md5($_POST['password']); // Se cifra la contraseña utilizando el algoritmo md5.

	$result = $model->executeQuery(file_get_contents(__DIR__."/../Database/Login.sql"), $_POST); // Se ejecuta una consulta SQL utilizando el modelo.

	if (count($result) > 0) { // Si se encontró al menos un resultado.
		$_SESSION['username'] = $result[0]['username']; // Se guarda el nombre de usuario en la sesión.
		$_SESSION['id'] = $result[0]['id']; // Se guarda el ID de usuario en la sesión.
		header('Location: https://localhost/proimpo/template/cliente/index.php'); // Se redirige al usuario a la página principal de la aplicación.
	} else { // Si no se encontraron resultados.
		header('Location: https://localhost/proimpo/index.html'); // Se redirige al usuario a la página de inicio.
	}
} catch (PDOException $e) { // Si ocurre un error al ejecutar la consulta SQL.
	print_r($e->getMessage()); // Se imprime el mensaje de error.
}
