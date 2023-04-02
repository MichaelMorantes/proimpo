<?php
// Inicia una sesión existente.
session_start();
// Destruye la sesión actual, eliminando cualquier dato asociado con ella.
session_destroy();
// Redirige al usuario a la página de inicio de sesión del sitio web en cuestión.
header('Location: https://localhost/proimpo/index.html');

