<?php 

// Make Date Readable
function pretty_date($date){
	return date("M d, Y h:i A", strtotime($date));
}

// Make Date Readable
function pretty_date_notime($date){
	return date("M d, Y", strtotime($date));
}

// Display money in a readable way
function money($number) {
	return '$ '.number_format($number, 2);
}

// Check For Incorrect Input Of Data
function sanitize($dirty) {
    $clean = htmlentities($dirty, ENT_QUOTES, "UTF-8");
    return trim($clean);
}

function cleanPost($post) {
    $clean = [];
    foreach ($post as $key => $value) {
      	if (is_array($value)) {
        	$ary = [];
        	foreach($value as $val) {
          		$ary[] = sanitize($val);
        	}
        	$clean[$key] = $ary;
      	} else {
        	$clean[$key] = sanitize($value);
      	}
    }
    return $clean;
}


// REDIRECT PAGE
function redirect($url) {
    if(!headers_sent()) {
      	header("Location: {$url}");
    } else {
      	echo '<script>window.location.href="' . $url . '"</script>';
    }
    exit;
}

function issetElse($array, $key, $default = "") {
    if(!isset($array[$key]) || empty($array[$key])) {
      return $default;
    }
    return $array[$key];
}






////////////////////////////////////////////////////////////////////////////////////////////////////////


function get_header_information() {
	global $conn;
	$siteQuery = "
	    SELECT * FROM asteelu_about 
	    LIMIT 1
	";
	$statement = $conn->prepare($siteQuery);
	$statement->execute();
	$site_result = $statement->fetchAll();

	foreach ($site_result as $site_row) {
	    $phone_1 = $site_row["about_phone"];
	}
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$actual_linkBreakDown = explode('/', $actual_link);
	$actual_linkLast = end($actual_linkBreakDown);

	$output = '';
	if ($actual_linkLast != 'signin' && $actual_linkLast != 'signin.php') {

		$output .= '
		<div class="header-eyebrow bg-dark">
		<div class="container">
		<div class="navbar navbar-dark row">
		<div class="col">
		<ul class="navbar-nav mr-auto">
		<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="javascript:;" id="curency" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		USD
		</a>
		<ul class="dropdown-menu" aria-labelledby="curency">
		<li><a class="dropdown-item" href="javascript:;">EUR</a></li>
		<li><a class="dropdown-item" href="javascript:;">RUB</a></li>
		</ul>
		</li>
		<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#!" id="language" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		EN
		</a>
		<ul class="dropdown-menu" aria-labelledby="language">
		<li><a class="dropdown-item" href="#!">Deutsch</a></li>
		<li><a class="dropdown-item" href="#!">Russian</a></li>
		<li><a class="dropdown-item" href="#!">French</a></li>
		</ul>
		</li>
		</ul>
		</div>
		<div class="col text-right">
		<span class="phone text-white">'.$phone_1.'</span>
		</div>
		</div>
		</div>
		</div>
		';

	} else {
		$output = '';
	}
	return $output;
}

function getTitle() {
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$actual_linkBreakDown = explode('/', $actual_link);
	$actual_linkLast = end($actual_linkBreakDown);

	$output = '';
	if ($actual_linkLast == 'signin' || $actual_linkLast == 'signin.php') {
		$output = 'Sigin · ';
	} elseif ($actual_linkLast == 'index.php' || $actual_linkLast == 'index' || $actual_linkLast == '') {
		$output = 'Welcome · ';
	} elseif ($actual_linkLast == 'products' || $actual_linkLast == 'products.php') {
		$output = 'Products · ';
	} elseif ($actual_linkLast == 'profile' || $actual_linkLast == 'profile.php') {
		$output = 'Profile · ';
	} elseif ($actual_linkLast == 'yourpassword' || $actual_linkLast == 'yourpassword.php') {
		$output = 'My Password · ';
	} elseif ($actual_linkLast == 'youraddress' || $actual_linkLast == 'youraddress.php') {
		$output = 'My Address · ';
	} elseif ($actual_linkLast == 'yourorders' || $actual_linkLast == 'yourorders.php') {
		$output = 'My Orders · ';
	} elseif ($actual_linkLast == 'cart' || $actual_linkLast == 'cart.php') {
		$output = 'My Cart · ';
	} elseif ($actual_linkLast == 'forgotPassword' || $actual_linkLast == 'forgotPassword.php') {
		$output = 'Forgot Password · ';
	} elseif ($actual_linkLast == 'verify' || $actual_linkLast == 'verify.php') {
		$output = 'Verify Account · ';
	} elseif ($actual_linkLast == 'verified' || $actual_linkLast == 'verified.php') {
		$output = 'Account on Verification · ';
	} elseif ($actual_linkLast == 'contact-us' || $actual_linkLast == 'contact-us.php') {
		$output = 'Contact Us · ';
	} elseif ($actual_linkLast == 'resendVericode' || $actual_linkLast == 'resendVericode.php') {
		$output = 'Resend Verification Code · ';
	} elseif ($actual_linkLast == 'resetPassword' || $actual_linkLast == 'resetPassword.php') {
		$output = 'Reset Password · ';
	} elseif ($actual_linkLast == 'thankYou' || $actual_linkLast == 'thankYou.php') {
		$output = 'Thank You · ';
	}
	return $output;
}








/////////////////////////////////////////////////////////////////////////////////////////////////




// Sessions For login
function adminLogin($admin_id) {
	$_SESSION['TNAdmin'] = $admin_id;
	global $conn;
	$data = array(
		':admin_last_login' => date("Y-m-d H:i:s"),
		':admin_id' => (int)$admin_id
	);
	$query = "
		UPDATE tein_admin 
		SET admin_last_login = :admin_last_login 
		WHERE admin_id = :admin_id";
	$statement = $conn->prepare($query);
	$result = $statement->execute($data);
	if (isset($result)) {
		$_SESSION['flash_success'] = '<div class="text-center" id="temporary">You are now logged in!</div>';
		redirect(PROOT . 'index');
	}
}

function admin_is_logged_in(){
	if (isset($_SESSION['TNAdmin']) && $_SESSION['TNAdmin'] > 0) {
		return true;
	}
	return false;
}

// Redirect admin if !logged in
function admn_login_redirect($url = 'signin') {
	$_SESSION['flash_error'] = '<div class="text-center" id="temporary" style="margin-top: 60px;">You must be logged in to access that page.</div>';
	redirect(PROOT . 'auth/' . $url);
}

// Redirect admin if do not have permission
function admin_permission_redirect($url = 'signin') {
	$_SESSION['flash_error'] = '<div class="text-center" id="temporary" style="margin-top: 60px;">You do not have permission in to access that page.</div>';
	redirec(PROOT . 'auth/' . $url);
}

function admin_has_permission($permission = 'admin') {
	global $admin_data;
	$permissions = explode(',', $admin_data['admin_permissions']);
	if (in_array($permission, $permissions, true)) {
		return true;
	}
	return false;
}







/////////////////////////////////////////////////////////////////////////////////////////////////////////



// GET PRODUCT CATEGORY
function get_product_category($product_category) {
	global $conn;
	$output = '';

	$query = "
		SELECT * FROM asteelu_category 
		WHERE category_trash = :category_trash
	";
	$statement = $conn->prepare($query);
	$statement->execute(
		[
			':category_trash' 	=> 0
		]
	);
	$result = $statement->fetchAll();
	$count_category = $statement->rowCount();
	if ($count_category > 0) {
		foreach ($result as $row) {
			$output .= '
				<option value="'.$row['category_id']. '" '.(($product_category == $row['category_id'])? "selected" : "").'>'.ucwords($row['category_name']).'</option>
			';
		}
	} else {
		$output = '<option value="">No category found.</option>';
	}
	return $output;
}

// GET ALL PRODUCTS WHERE TRASH = 0
function get_all_product($product_trash = '') {
	global $conn;
	$output = '';

	$query = "
		SELECT * FROM asteelu_product 
		INNER JOIN asteelu_category
		ON asteelu_category.category_id = asteelu_product.product_category
		LEFT JOIN asteelu_admin
		ON asteelu_admin.admin_id = asteelu_product.product_added_by
		WHERE asteelu_product.product_trash = :product_trash
		AND asteelu_category.category_trash = :category_trash
		ORDER BY asteelu_product.product_id DESC
	";
	$statement = $conn->prepare($query);
	$statement->execute([
		':product_trash' 	=> $product_trash,
		':category_trash' 	=> 0
	]);
	$count_products = $statement->rowCount();
	$result = $statement->fetchAll();

	if ($count_products > 0) {
		$i = 1;
		foreach ($result as $key => $row) {
			$output .= '
				<tr>
					<td>'.$i.'</td>
					<td>'.ucwords($row["product_name"]).'</td>
					<td>'.ucwords($row["category_name"]).'</td>
					<td>'.money($row["product_price"]).'</td>
					<td>'.$row["product_quantity"].'</td>
					<td>'.ucwords($row["admin_fullname"]).'</td>
					<td>'.pretty_date($row["product_added_date"]).'</td>
				';
				if ($product_trash == 0) {
					$output .= '
						<td>
							<a href="'.PROOT.'admin/products?featured='.(($row['product_featured'] == 0)?"1":"0").'&id='.$row["product_id"].'" class="btn btn-sm btn-light">
								<span data-feather="'.(($row['product_featured'] == 0)?"plus":"minus").'"></span> '.(($row['product_featured'] == 0)?"":"Featured product").'
							</a>
						</td>
						<td>
					';
				} else {
					$output .= '
						<td>
						</td>
						<td>
					';
				}
				if ($product_trash == 1) {
					$output .= '
						<a href="'.PROOT.'admin/products?permanent_delete='.$row["product_id"].'&upload_product_image_name='.$row["product_image"].'" class="btn btn-sm btn-outline-primary"><span data-feather="trash"></span></a>&nbsp;
                          <a href="'.PROOT.'admin/products?restore='.$row["product_id"].'" class="btn btn-sm btn-outline-danger"><span data-feather="refresh-cw"></span></a>&nbsp;
					';
				} else {
					$output .= '
							<a href="'.PROOT.'admin/products?edit='.$row["product_id"].'" class="btn btn-sm btn-info"><span data-feather="edit-2"></span></a>
							<a href="'.PROOT.'admin/products?delete='.$row["product_id"].'" class="btn btn-sm btn-secondary"><span data-feather="trash-2"></span></a>
						';
				}
				$output .= '
						</td>
					</tr>
				';
			$i++;
		}
	} else {
		$output = '
			<tr>
				<td colspan="9">No products found in the database...</h3></td>
			</tr>
		';
	}
	return $output;
}



////////////////////////////////////////////////////////////////////////////////////////////////////

// GET ALL ADMINS
function get_all_admins() {
	global $conn;
	global $admin_data;
	$output = '';

	$query = "
		SELECT * FROM asteelu_admin 
		WHERE admin_trash = :admin_trash
	";
	$statement = $conn->prepare($query);
	$statement->execute([':admin_trash' => 0]);
	$result = $statement->fetchAll();

	foreach ($result as $row) {
		$admin_last_login = $row["admin_last_login"];
		if ($admin_last_login == NULL) {
			$admin_last_login = '<span class="text-secondary">Never</span>';
		} else {
			$admin_last_login = pretty_date($admin_last_login);
		}
		$output .= '
			<tr>
				<td>
		';
					
		if ($row['admin_id'] != $admin_data['admin_id']) {
			$output .= '
				<a href="'.PROOT.'admin/admins?delete='.$row["admin_id"].'" class="btn btn-sm btn-light"><span data-feather="trash-2"></span></a>
			';
		}

		$output .= '
				</td>
				<td>'.ucwords($row["admin_fullname"]).'</td>
				<td>'.$row["admin_email"].'</td>
				<td>'.pretty_date($row["admin_joined_date"]).'</td>
				<td>'.$admin_last_login.'</td>
				<td>'.$row["admin_permissions"].'</td>
			</tr>
		';
	}
	return $output;
}

// GET ADMIN PROFILE DETAILS
function get_admin_profile() {
	global $conn;
	global $admin_data;
	$output = '';

	$query = "
		SELECT * FROM asteelu_admin 
		WHERE admin_trash = :admin_trash 
		LIMIT 1
	";
	$statement = $conn->prepare($query);
	$statement->execute([':admin_trash' => 0]);
	$result = $statement->fetchAll();

	foreach ($result as $row) {
		if ($row['admin_id'] == $admin_data['admin_id']) {
			$output = '
				<h3>Name</h3>
			    <p class="lead">'.ucwords($row["admin_fullname"]).'</p>
			    <br>
			    <h3>Email</h3>
			    <p class="lead">'.$row["admin_email"].'</p>
			    <br>
			    <h3>Joined Date</h3>
			    <p class="lead">'.pretty_date($row["admin_joined_date"]).'</p>
			    <br>
			    <h3>Last Login</h3>
			    <p class="lead">'.pretty_date($row["admin_last_login"]).'</p>
			';
		}
	}
	return $output;
}

// LIST * USERS
function subscriped_emails() {
	global $conn;

	$query = "
		SELECT * FROM asteelu_subscription
	";
	$statement = $conn->prepare($query);
	$statement->execute();
	$row_count = $statement->rowCount();
	$result = $statement->fetchAll();

	$output = '';
	$i = 1;
	if ($row_count > 0) {
		foreach ($result as $row) {
			$output .= '
				<tr>
					<td>'.$i.'</td>
					<td>'.$row["subscription_email"].'</td>
					<td>'.pretty_date($row["subscription_date"]).'</td>
				</tr>
			';
			$i++;
		}
	} else {
		$output = '
			<tr>
				<td colspan="3">No emails under subscription table.</td>
			</tr>
		';
	}
	return $output;
}














///////////////////////////////////////////////////////////////////////////////////////////////////////////

// FIND USER WITH EMAIL
 function findUserByEmail($email) {
 	global $conn;
    $sql = "
    	SELECT * FROM asteelu_user 
    	WHERE user_email = :user_email
    ";
    $statement = $conn->prepare($sql);
    $statement->execute([':user_email' => $email]);
    $result = $statement->fetchAll();
    foreach ($result as $row) {
    	return $row;
    }
}

// Sessions For login
function userLogin($user_id) {
	$_SESSION['ATUser'] = $user_id;
	global $conn;
	$data = array(
		':user_last_login' => date("Y-m-d H:i:s"),
		':user_id' => (int)$user_id
	);
	$query = "
		UPDATE asteelu_user 
		SET user_last_login = :user_last_login 
		WHERE user_id = :user_id";
	$statement = $conn->prepare($query);
	$result = $statement->execute($data);
	if (isset($result)) {
		//$_SESSION['flash_success'] = '<div class="text-center" id="temporary">You are now logged in!</div>';
		header('Location: index');
	}
}

function user_is_logged_in(){
	if (isset($_SESSION['ATUser']) && $_SESSION['ATUser'] > 0) {
		return true;
	}
	return false;
}

// Redirect admin if !logged in
function user_login_redirect($url = 'login') {
	$_SESSION['flash_error'] = '<div class="text-center" id="temporary" style="margin-top: 60px;">You must be logged in to access that page.</div>';
	header('Location: '.$url);
}


function send_vericode($email) {
	global $conn;
    $success = false;
    $user = findUserByEmail($email);

    if($user) {
      	$vericode = md5(time());
      	$sql = "
      		UPDATE asteelu_user 
      		SET user_vericode = :user_vericode 
      		WHERE user_id = :user_id
      	";
      	$statement = $conn->prepare($sql);
      	$result = $statement->execute([
      		':user_vericode' => $vericode,
      		':user_id' => $user['user_id']
      	]);
      	if ($result) {
        	$fn = ucwords($user['user_fullname']);
        	$to = $email;
			$from = 'castright@namibra.com';
			$from_name = 'Asteelu, Products';
         	$subject = "Please Verify Your Account";
			$body = "
				<h3>
					{$fn},</h3>
					<p>
						Thank you for regestering. Please verify your account by clicking 
          				<a href=\"http://localhost/asteelu/verify/{$vericode}\" target=\"_blank\">here</a>.
        		</p>
			";

      		//Create an instance; passing `true` enables exceptions
			$mail = new PHPMailer(true);

			$mail->IsSMTP();
			$mail->SMTPAuth = true;

			$mail->SMTPSecure = 'ssl'; 
			$mail->Host = 'smtp.namibra.com';
			$mail->Port = 465;  
			$mail->Username = 'castright@namibra.com';
			$mail->Password = 'Um9f985c2'; 

			$mail->IsHTML(true);
			$mail->WordWrap = 50;
			$mail->From = "castright@namibra.com";
			$mail->FromName = $from_name;
			$mail->Sender = $from;
			$mail->AddReplyTo($from, $from_name);
			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->AddAddress($to);
			$result = $mail->Send();
			if ($result) {
				echo 'Message has been sent';
			} else {
			    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}



      	}
    }
    return $success;
 }











////////////////////////////////////////////////////////////////////////////////////





?>