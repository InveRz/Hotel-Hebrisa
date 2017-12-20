<?php
	$servidor = "localhost";
	$usuario = "root";
	$contra = "";
	$bd = "hebrisa";
	$con = mysqli_connect($servidor, $usuario, $contra, $bd);
	if(mysqli_connect_errno()){
		echo('<p style="color:red">Error al conectar con el host.</p>');
	}
	mysqli_set_charset($con, "utf8mb4");
	mysqli_select_db($con, $bd) or die('<p style="color:red">Error al conectar con la BD.</p>'); 