<?php
	require_once ("../db_connection/conn.php");

	if (isset($_POST['reference'])) {
		
		$reference = sanitize($_POST['reference']);
		$id = sanitize((int)$_POST['id']);
		$level = sanitize($_POST['level']);

		if (!empty($reference) || $reference != '') {
			if ($level == 'L100') {
                $sql = "
                    UPDATE `tein_dues` SET `member_id` = ?, `level_100` = ? 
                ";
            } elseif ($level == 'L200') {
                $sql = "
                    UPDATE `tein_dues` SET `member_id` = ?, `level_200` = ? 
                ";
            } elseif ($level == 'L300') {
                $sql = "
                    UPDATE `tein_dues` SET `member_id` = ?, `level_300` = ? 
                ";
            } elseif ($level == 'L400') {
                $sql = "
                    UPDATE `tein_dues` SET `member_id` = ?, `level_400` = ? 
                ";
            }
            $statement = $conn->prepare($sql);
            $result = $statement->execute([$id, $reference]);
            if (isset($result)) {
            	$_SESSION['member.paid'] = $reference;
            	echo '';
            }
		}
	}