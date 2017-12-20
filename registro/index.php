<?php 
	require_once('../recursos/conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Registro</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Wifft">
		<meta name="robots" content="noindex, nofollow">
		<meta name="googlebot" content="noindex, nofollow">
	</head>
	<body>
		<main>
			<section>
				<form action="<?php echo(filter_input(INPUT_SERVER, 'PHP_SELF')); ?>" method="post" onsubmit="return confirmarContra();">
					<label>Nombre de usuario:</label>
					<br>
					<input type="text" name="usuario" minlength="3" maxlength="15" required autocomplete="off">
					<br>
					<label>Correo elctr&oacute;nico:</label>
					<br>
					<input type="email" name="correo" maxlength="63" required autocomplete="off">
					<br>
					<label>Contrase&ntilde;a:</label>
					<br>
					<input id="c1" type="password" name="contra" minlength="8" maxlength="63" required autocomplete="off">
					<br>
					<label>Confirmar contrase&ntilde;a:</label>
					<br>
					<input id="c2" type="password" minlength="8" maxlength="63" required autocomplete="off">
					<script type="text/javascript">
						function confirmarContra(){
							var c1 = document.getElementById('c1').value;
							var c2 = document.getElementById('c2').value;
							if(c1 !== c2){
								alert('Las contraseñas no coinciden');
								return false;
							} else {
								return true;
							}
						}
					</script>
					<br>
					<br>
					<input type="submit" name="registrarse" value="Registrarse">
					<?php 
						if(NULL != filter_input(INPUT_POST, 'registrarse')){
							$usuario = mysqli_real_escape_string($con, strip_tags(filter_input(INPUT_POST, 'usuario')));
							$correo = mysqli_real_escape_string($con, strip_tags(filter_input(INPUT_POST, 'correo')));
							$contra = mysqli_real_escape_string($con, strip_tags(filter_input(INPUT_POST, 'contra')));
							$contra_encriptada = password_hash($contra, PASSWORD_DEFAULT);

							$sql_c_u = "SELECT usuario FROM usuarios WHERE usuario='$usuario'";
							$resultado_c_u = mysqli_query($con, $sql_c_u);
							$contar_c_u = (mysqli_num_rows($resultado_c_u) > 0);

							$sql_c_c = "SELECT correo FROM usuarios WHERE correo='$correo'";
							$resultado_c_c = mysqli_query($con, $sql_c_c);
							$contar_c_c = (mysqli_num_rows($resultado_c_c) > 0);

							if($contar_c_u || $contar_c_c){
								if($contar_c_u){
									echo('<p style="color:red">Este nombre de usuario ya est&aacute; registrado.</p>');
								}
								if($contar_c_c){
									echo('<p style="color:red">Esta direcci&oacute;n de correo electr&oacute;nico ya est&aacute; registrada.</p>');
								}
							} else {
								if((strlen($usuario) < 3 || strlen($usuario) > 15) || (strlen($correo) > 63) || (strlen($contra) < 8 || strlen($contra) > 63)){
									if((strlen($usuario) < 3 || strlen($usuario) > 15)){
										echo('<p style="color:red">El nombre de usuario debe tener al menos tres caracteres y no puede tener m&aacute;s de 63 caracteres.</p>');
									}
									if((strlen($correo) > 63)){
										echo('<p style="color:red">la direcci&oacute;n de correo elctr&oacute;nico no pude tener m&aacute;s de 63 caracteres.</p>');
									}
									if((strlen($correo) > 63) || (strlen($contra) < 8 || strlen($contra) > 63)){
										echo('<p style="color:red">La contrase&ntilde;a debe tener al menos ocho caracteres y no puede tener m&aacute;s de 63 caracteres.</p>');
									}
								} else {
									$sql_r = "INSERT INTO usuarios(id, usuario, correo, contra) VALUES('', '$usuario', '$correo', '$contra_encriptada')";
									$resultado_r = mysqli_query($con, $sql_r);

									$sql_u = "SELECT * FROM usuarios WHERE usuario='$usuario' AND correo='$correo'";
									$resultado_u = mysqli_query($con, $sql_u);
									if(mysqli_num_rows($resultado_u) == 1){
										$row_u = mysqli_fetch_assoc($resultado_u);

										$_SESSION['inicio_sesion'] = 'dog';
										$_SESSION['id'] = $row_u['id'];
										$_SESSION['usuario'] == $row_u['usuario'];

										header('location:../admin/');
									} else {
										('<p style="color:red">Ha ocurrido un error al realizar el registro. Vuelva a intentarlo.</p>');
									}
								}
								
							}
						}
					?>
				</form>
			</section>
		</main>
	</body>
</html>
	