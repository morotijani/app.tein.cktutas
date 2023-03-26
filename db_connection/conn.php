<?php

	// Connection To Database
	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$conn = new PDO("mysql:host=$servername;dbname=tein", $username, $password);
	session_start();

	require_once($_SERVER['DOCUMENT_ROOT'].'/app.tein.cktutas/config.php');
 	require_once(BASEURL.'helpers/helpers.php');


////////////////////////////////////////////////////////////////////////////////////////////////////////
 	// ADMIN LOGIN
 	if (isset($_SESSION['ATAdmin'])) {
 		$admin_id = $_SESSION['ATAdmin'];
 		$data = array(
 			':admin_id' => $admin_id
 		);
 		$sql = "
 			SELECT * FROM asteelu_admin 
 			WHERE admin_id = :admin_id 
 			LIMIT 1
 		";
 		$statement = $conn->prepare($sql);
 		$statement->execute($data);

 		foreach ($statement->fetchAll() as $admin_data) {
 			$fn = explode(' ', $admin_data['admin_fullname']);
 			$admin_data['first'] = ucwords($fn[0]);
 				$admin_data['last'] = '';
 			if (count($fn) > 1) {
 				$admin_data['last'] = ucwords($fn[1]);
 			}
 		}
 	}

 	// Display on Messages on Errors And Success
 	$flash = '';
 	if (isset($_SESSION['flash_success'])) {
 	 	$flash = '<div class="bg-success" id="temporary"><p class="text-center text-white">'.$_SESSION['flash_success'].'</p></div>';
 	 	unset($_SESSION['flash_success']);
 	}

 	if (isset($_SESSION['flash_error'])) {
 	 	$flash = '<div class="bg-danger" id="temporary"><p class="text-center text-white">'.$_SESSION['flash_error'].'</p></div>';
 	 	unset($_SESSION['flash_error']);
 	}




?>
