<?php

$host = "192.168.100.60";
$dbname = "SiteProjeto";
$user = "admin";
$pass = "admin123";

try {
	$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass,[
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	]);
}  catch (PDOException $e) {
	die("Erro de conexao: " . $e->getMessage());
}

?>
