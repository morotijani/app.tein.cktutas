<?php
require_once ("db_connection/conn.php");

    $message = '';
    $membership = new AllFunctions;
    $membership_identity = $membership->generate_identity_number(1);
    $student_id = ((isset($_POST['student_id']) && !empty($_POST['student_id'])) ? sanitize($_POST['student_id']) : '');
    $fname = ((isset($_POST['fname']) && !empty($_POST['fname'])) ? sanitize($_POST['fname']) : '');
    $lname = ((isset($_POST['lname']) && !empty($_POST['lname'])) ? sanitize($_POST['lname']) : '');
    $email = ((isset($_POST['email']) && !empty($_POST['email'])) ? sanitize($_POST['email']) : '');
    $sex = ((isset($_POST['sex']) && !empty($_POST['sex'])) ? sanitize($_POST['sex']) : '');
    $school = ((isset($_POST['school']) && !empty($_POST['school'])) ? sanitize($_POST['school']) : '');
    $department = ((isset($_POST['department']) && !empty($_POST['department'])) ? sanitize($_POST['department']) : '');
    $programme = ((isset($_POST['programme']) && !empty($_POST['programme'])) ? sanitize($_POST['programme']) : '');
    $level = ((isset($_POST['level']) && !empty($_POST['level'])) ? sanitize($_POST['level']) : '');
    $yoa = ((isset($_POST['yoa']) && !empty($_POST['yoa'])) ? sanitize($_POST['yoa']) : '');
    $yoc = ((isset($_POST['yoc']) && !empty($_POST['yoc'])) ? sanitize($_POST['yoc']) : '');
    $hostel = ((isset($_POST['hostel']) && !empty($_POST['hostel'])) ? sanitize($_POST['hostel']) : '');
    $region = ((isset($_POST['region']) && !empty($_POST['region'])) ? sanitize($_POST['region']) : '');
    $constituency = ((isset($_POST['constituency']) && !empty($_POST['constituency'])) ? sanitize($_POST['constituency']) : '');
    $branch = ((isset($_POST['branch']) && !empty($_POST['branch'])) ? sanitize($_POST['branch']) : '');
    $whatsapp = ((isset($_POST['whatsapp']) && !empty($_POST['whatsapp'])) ? sanitize($_POST['whatsapp']) : '');
    $telephone = ((isset($_POST['telephone']) && !empty($_POST['telephone'])) ? sanitize($_POST['telephone']) : '');
    $card_type = ((isset($_POST['card_type']) && !empty($_POST['card_type'])) ? sanitize($_POST['card_type']) : '');
    $executive = ((isset($_POST['executive']) && !empty($_POST['executive'])) ? sanitize($_POST['executive']) : '');
    $position = ((isset($_POST['position']) && !empty($_POST['position'])) ? sanitize($_POST['position']) : '');
    $registered_date = date("Y-m-d H:i:s A");
    $passport = '';


     if (isset($_POST['submit'])) {
        $memberQuery = "
            SELECT * FROM tein_membership 
            WHERE membership_email = ?
        ";
        $statement = $conn->prepare($memberQuery);
        $statement->execute([$email]);
        if ($statement->rowCount() > 0) {
            $message = '<div class="alert alert-danger">'.$email.' already exists.</div>';
        } else {

            // UPLOAD PASSPORT PICTURE TO uploadedprofile IF FIELD IS NOT EMPTY
            

        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Get membership card . TEIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    
    <div class="container py-4">
        <div class="p-5 mb-4 bg-body-tertiary rounded-3" style="background-image: url(<?= PROOT; ?>dist/media/bg-1.jpg); background-position: center; background-repeat: no-repeat; background-size: cover;">
          <div class="container-fluid py-5">
            <h1 class="display-2 fw-bold py-5"></h1>
          </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="display-5 fw-bold">Get membership card</h1>
                        <p class="small text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis beatae pariatur ad voluptatum cum voluptates molestiae consequuntur sunt debitis voluptas omnis ipsam quod harum quos, nesciunt, tempora tempore sapiente ducimus.</p>
                        <a href="news/">go back</a>
                    </div>
                </div>

                 <form method="POST" id="membershipForm" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="student_id" id="student_id" placeholder="Student Id" value="<?= $student_id; ?>">
                                <label for="student_id">Student Id</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name" value="<?= $fname; ?>">
                                <label for="fname">First Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" value="<?= $lname; ?>">
                                <label for="lname">Last Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?= $email; ?>">
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select type="text" class="form-select" name="sex" id="sex">
                                    <option value="">...</option>
                                    <option <?= ($sex == 'Male')? "selected" : ""; ?>>Male</option>
                                    <option <?= ($sex == 'Female')? "selected" : ""; ?>>Female</option>
                                    <option <?= ($sex == 'Other')? "selected" : ""; ?>>Other</option>
                                </select>
                                <label for="sex">Sex</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="school" id="school" placeholder="School" value="<?= $school ?>">
                                <label for="school">School</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="department" id="department" placeholder="Department" value="<?= $department ?>">
                                <label for="department">Department</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="programme" id="programme" placeholder="Programme" value="<?= $programme ?>">
                                <label for="programme">Programme</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select type="text" class="form-select" name="level" id="level">
                                    <option value="">...</option>
                                    <option <?= ($level == 'L100')? "selected" : ""; ?>>L100</option>
                                    <option <?= ($level == 'L200')? "selected" : ""; ?>>L200</option>
                                    <option <?= ($level == 'L300')? "selected" : ""; ?>>L300</option>
                                    <option <?= ($level == 'L400')? "selected" : ""; ?>>L400</option>
                                </select>
                                <label for="level">Level</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating mb-3">
                                <input type="number" min="1900" max="<?= date('Y');?>" step="1" class="form-control form-control-sm" name="yoa" placeholder="Year of Admission" id="yoa" value="<?= $yoa; ?>">
                                <label for="yoa">Year of Admission</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" min="1900" max="<?= date('Y') - 1;?>" step="1" class="form-control form-control-sm" name="yoc" id="yoc" placeholder="Year of Completion" value="<?= $yoc; ?>">
                                <label for="yoc">Year of Completion</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form-control-sm" name="hostel" id="hostel" placeholder="Name of Hostel" value="<?= $hostel; ?>">
                                <label for="hostel">Name of Hostel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="region" id="region" placeholder="Region" value="<?= $region; ?>">
                                <label for="region">Region</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="constituency" id="constituency" placeholder="Constituency" value="<?= $constituency; ?>">
                                <label for="constituency">Constituency</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="branch" id="branch"  placeholder="Branch (Polling Station)" value="<?= $branch; ?>">
                                <label for="branch">Branch (Polling Station)</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="whatsapp" id="whatsapp" placeholder="WhatsApp Contact" value="<?= $whatsapp; ?>">
                                <label for="whatsapp">WhatsApp Contact</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Telephone" value="<?= $telephone; ?>">
                                <label for="telephone">Telephone Number</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select type="text" class="form-select" name="card_type" id="card_type" value="<?= $card_type; ?>">
                                    <option value="">...</option>
                                    <option <?= ($card_type == 'Plastic')? "selected" : ""; ?>>Plastic</option>
                                    <option <?= ($card_type == 'Booklet')? "selected" : ""; ?>>Booklet</option>
                                </select>
                                <label for="card_type">Card Type</label>
                            </div>
                        </div>

                        <?php if ($passport != ''): ?>
                        <div class="mb-3">
                            <label>Product Image</label><br>
                            <img src="<?= $passport; ?>" class="img-fluid img-thumbnail" style="width: 200px; height: 200px; object-fit: cover;">
                            <a href="<?= PROOT; ?>add.member?dpp=1&mid=<?= $edit_id; ?>&pp=<?= $passport; ?>" class="badge bg-danger">Change Image</a>
                        </div>
                        <?php else: ?>
                        <div class="mb-3">
                            <div>
                                <label for="passport" class="form-label">Passpot size Image</label>
                                <input type="file" class="form-control" id="passport" name="passport" required>
                                <span id="upload_file"></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <input type="hidden" name="uploaded_passport" id="uploaded_passport" value="<?= $passport; ?>">

                        <div class="col-md-12 mb-4">
                            <label for="executive">Executive/Committee Member</label>
                            <select name="executive" id="executive">
                                <option value=""></option>
                                <option value="No" <?= ($executive == 'No')? "selected" : ""; ?>>No</option>
                                <option value="Yes" <?= ($executive == 'Yes')? "selected" : ""; ?>>Yes</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 position" style="display: <?= ((isset($_GET['edit']) && $executive == 'Yes') ? 'block' : 'none'); ?>">
                            <label for="position">Position</label>
                            <select name="position" id="position" class="form-control form-control-sm">
                                <option value="">...</option>
                                <?php foreach ($conn->query("SELECT * FROM tein_position ORDER BY position_name ASC")->fetchAll() as $row): ?>
                                <option <?= (($position == ucwords($row['position_name'])) ? 'selected' : ''); ?>><?= ucwords($row['position_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mt-2 mb-2">
                            <input type="hidden" id="ref" name="ref">
                            <button onclick="payWithPaystack()" class="btn btn-outline-success" name="submit" id="submit">Register</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <footer class="pt-3 mt-4 text-body-secondary border-top">
            &copy; <?= date('Y'); ?>
        </footer>
    </div>
    <?php include ("includes/footer.php"); ?>
    <script src="https://js.paystack.co/v1/inline.js"></script> 
    <script>
        const paymentForm = document.getElementById('membershipForm');
        paymentForm.addEventListener("submit", payWithPaystack, false);

        function payWithPaystack() {
            //e.preventDefault();

            let handler = PaystackPop.setup({
                key: '<?php echo PAYSTACK_PUBLIC_KEY; ?>', // Replace with your public key
                email: document.getElementById("email").value,
                // amount: document.getElementById("amount").value * 100,
                amount: 20 * 100,
                ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                // label: "Optional string that replaces customer email"
                currency: 'GHS',
                channels: ['card', 'bank', 'ussd', 'qr', 'mobile_money', 'bank_transfer'], 
                onClose: function() {
                  alert('Window closed.');
                },
                callback: function(response) {
                    $('#ref').val(response.reference);
                    var $this = $('#membershipForm');
                    $.ajax({
                        url : 'controller/add.member.verify.payment.php',
                        method : 'POST',
                        data : $(this).serialize(),
                        success : function(data) {}
                    });
                    let message = 'Payment complete! Reference: ' + response.reference;
                    alert(message);
                }
            });

            handler.openIframe();
        }
    </script>

</body>
</html>