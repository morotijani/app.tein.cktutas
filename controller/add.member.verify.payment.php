<?php 
	 require_once ("../db_connection/conn.php");

	if ($_SERVER['SERVER_REQUEST'] == 'POST') {
		// code...
		if (isset($_POST['ref']) {
		 	// code...
		 	echo $_POST['ref'];



		 	if ($_POST['uploaded_passport'] == '') {
                if (!empty($_FILES)) {

                    $image_test = explode(".", $_FILES["passport"]["name"]);
                    $image_extension = end($image_test);
                    $image_name = md5(microtime()). '.' . $image_extension;

                    $location = 'dist/media/membership/'.$image_name;
                    move_uploaded_file($_FILES["passport"]["tmp_name"], BASEURL . $location);
                    
                    if ($_POST['uploaded_image'] != '') {
                        unlink($_POST['uploaded_image']);
                    }
                } else {
                    $message = '<div class="alert alert-danger">Passport Picture Can not be Empty</div>';
                }
            } else {
                $location = $_POST['uploaded_passport'];
            }

            if (empty($message)) {
                $data = array(
                    $membership_identity, $student_id, $fname, $lname, $email, $sex, $school, $department, $programme, $level, $yoa, $yoc, $hostel, $region, $constituency, $branch, $location, $whatsapp, $telephone, $card_type, $executive, $position, '$paid', $registered_date
                );
                $query = "
                    INSERT INTO `tein_membership`(`membership_identity`, `membership_student_id`, `membership_fname`, `membership_lname`, `membership_email`, `membership_sex`, `membership_school`, `membership_department`, `membership_programme`, `membership_level`, `membership_yoa`, `membership_yoc`, `membership_name_of_hostel`, `membership_region`, `membership_constituency`, `membership_branch`, `membership_passport`, `membership_whatsapp_contact`, `membership_telephone_number`, `membership_card_type`, `membership_executive`, `membership_position`, `membership_paid`, `membership_registered_date`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";
                $statement = $conn->prepare($query);
                $result = $statement->execute($data);
                if (isset($result)) {
                    $_SESSION['flash_success'] = 'New Member successfully <span class="bg-info">Added</span>';
                    redirect(PROOT . 'members');
                }
                
            } else {
                $message;
            }
            
		}
	}






