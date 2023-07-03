<?php
	require_once ("../db_connection/conn.php");

	if (isset($_POST['reference'])) {
		print_r($_POST);
		die;
		$reference = sanitize($_POST['reference']);
		$id = sanitize((int)$_POST['id']);
		$level = sanitize($_POST['level']);

		if (!empty($reference) || $reference != '') {
			$sql = "
				INSERT INTO `tein_dues`(`member_id`, `level_100`, `level_200`, `level_300`, `level_400`) 
				VALUES ()
			";
		} else {
			echo 'naa';
		}

	}