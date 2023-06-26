<?php 
	require_once ("../db_connection/conn.php");
    $membership = new AllFunctions;

	if ($_SERVER['SERVER_REQUEST'] == 'POST') {
		if (isset($_POST['ref']) {
		 	$reference = sanitize($_POST['ref']);
            $membership_identity = $membership->generate_identity_number(1);
            $student_id = sanitize($_POST['student_id']);
            $fname = sanitize($_POST['fname']);
            $lname = sanitize($_POST['lname']);
            $email = sanitize($_POST['email']);
            $sex =  sanitize($_POST['sex']);
            $school = sanitize($_POST['school']);
            $department = sanitize($_POST['department']);
            $programme = sanitize($_POST['programme']);
            $level = sanitize($_POST['level']);
            $yoa =  sanitize($_POST['yoa']);
            $yoc =  sanitize($_POST['yoc']);
            $hostel = sanitize($_POST['hostel']);
            $region = sanitize($_POST['region']);
            $constituency = sanitize($_POST['constituency']);
            $branch = sanitize($_POST['branch']);
            $whatsapp = sanitize($_POST['whatsapp']);
            $telephone = sanitize($_POST['telephone']);
            $card_type = sanitize($_POST['card_type']);
            $executive = sanitize($_POST['executive']);
            $position = sanitize($_POST['position']);
            $paid = 1;
            $registered_date = date("Y-m-d H:i:s A");

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
                    $student_id, $fname, $lname, $email, $sex, $school, $department, $programme, $level, $yoa, $yoc, $hostel, $region, $constituency, $branch, $location, $whatsapp, $telephone, $card_type, $executive, $position, $paid, $registered_date
                );
                $query = "
                    INSERT INTO `tein_membership`(`membership_student_id`, `membership_fname`, `membership_lname`, `membership_email`, `membership_sex`, `membership_school`, `membership_department`, `membership_programme`, `membership_level`, `membership_yoa`, `membership_yoc`, `membership_name_of_hostel`, `membership_region`, `membership_constituency`, `membership_branch`, `membership_passport`, `membership_whatsapp_contact`, `membership_telephone_number`, `membership_card_type`, `membership_executive`, `membership_position`, `membership_paid`, `membership_registered_date`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";
                $statement = $conn->prepare($query);
                $result = $statement->execute($data);
                
                $inserted_id = $conn->lastInsertId();
                $identity = $Allfunctions->generate_identity_number($inserted_id);
                if (isset($result)) {
                    $conn->query("UPDATE tein_membership SET membership_identity = '" . $identity . "' WHERE id = $inserted_id")->execute();

                    $_SESSION['flash_success'] = 'New Member successfully <span class="bg-info">Added</span>';
                    $_SESSION['member'] = $reference;
                    redirect(PROOT . 'member.success');
                }
                
            } else {
                $message;
            }
            
		}
	}






