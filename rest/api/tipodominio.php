<?php
	header('Content-Type: application/json');
	include('db.php');

	echo json_encode(executeSql("SELECT * FROM \"T00_TipoDominio\"; "));
?>