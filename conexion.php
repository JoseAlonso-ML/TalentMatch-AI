<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "talentmatch_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// Opcional: Descomenta la siguiente línea para probar si conecta
// echo "Conexión exitosa a la base de datos"; 
?>