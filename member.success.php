<?php 
	require_once('db_connection/conn.php');

	if (isset($_SESSION['member'])) {
		$reference  = sanitize($_SESSION['member']);
		$query = "
			SELECT * FROM tein_membership 
			WHERE membership_reference_id = ? 
			LIMIT 1
		";
		$statement = $conn->prepare($query);
		$statement->execute([$reference]);
		if ($statement->rowCount() > 0) {
			
		} else {
			session_unset($_SESSION['member']);
			redirect(POOT . 'get-membership-card');
		}
	} else {
		session_unset($_SESSION['member']);
		redirect(POOT . 'get-membership-card');
	}

?>