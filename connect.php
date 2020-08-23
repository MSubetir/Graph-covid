<?php 
    session_start();

	$servidor = 'localhost';
 	$usuario = 'root';
 	$senha = '';
 	$bd = 'gcovid';


 	$conecta = mysqli_connect($servidor, $usuario, $senha, $bd);

    mysqli_set_charset($conecta, "utf8");
 ?>