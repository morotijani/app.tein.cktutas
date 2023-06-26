<?php 
	require_once ("../db_connection/conn.php");

	// check if email exist or not
	if (isset($_POST['email'])) {
		$email = sanitize($_POST['email']);

		$query = "
            SELECT * FROM tein_membership 
            WHERE membership_email = ?
        ";
        $statement = $conn->prepare($query);
        $statement->execute([$email]);
        if ($statement->rowCount() > 0) {
            echo 'Email already exist.';
        } else {
        	echo '';
        }
	} else {
		// check if student id exist
		if (isset($_POST['studentId'])) {
			$studentid = sanitize($_POST['studentId']);

			$query = "
	            SELECT * FROM tein_membership 
	            WHERE membership_student_id = ?
	        ";
	        $statement = $conn->prepare($query);
	        $statement->execute([$studentid]);
	        if ($statement->rowCount() > 0) {
	            echo 'student ID already exist.';
	        } else {
	        	echo '';
	        }
	    }
	}



