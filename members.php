<?php 
    require_once ("db_connection/conn.php");
    include ("includes/header.php");

    // DELETE A MEMBER PERMANENTLY
    if (isset($_GET['permanent_delete']) && !empty($_GET['permanent_delete'])) {
        $permanent_delete = (int)$_GET['permanent_delete'];
        $permanent_delete = sanitize($permanent_delete);

        $uploaded_passport_location = BASEURL . $_GET['uploaded_passport'];
        $DEL = unlink($uploaded_passport_location);

        if ($DEL) {
            $query = "
                DELETE FROM tein_membership 
                WHERE id = ?
            ";
            $statement = $conn->prepare($query);
            $statement->execute([$permanent_delete]);
            $_SESSION['flash_success'] = 'Member permanently <span class="bg-info">DELETED</span>';
            redirect(PROOT . 'members');
        }
    }

    $query = "
        SELECT * FROM tein_membership 
        WHERE membership_trash = ?
        ORDER BY id DESC 
    ";
    $statement = $conn->prepare($query);
    $statement->execute([0]);
    $result = $statement->fetchAll();
?> 

    <?= $flash; ?>
    <div class="container-fluid">
        <main style="background-color: rgb(51, 51, 51);">
            <div class="row justify-content-center">
                <div class="col-md-4">

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3" style="margin-top: 34px;">
                        <h2 class="text-white" style="font-weight: 600; font-size: 20px; line-height: 28px;">TEIN . Members</h2>
                        <a href="add.member" class="btn btn-sm btn-outline-secondary" style="background: #333333;"> + Add Member</a>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm text-white user-banner">
                        <div class="btn-group me-2">

                            <img class="me-3" src="dist/media/logo/logo.png" alt="" width="48" height="38">
                            <div class="lh-1">
                                <h1 class="h6 mb-0 text-white lh-1" style="font-size: 16px; white-space: nowrap; text-overflow: ellipsis; font-weight: 700;">INUWA MOHAMMED UMAR</h1>
                                <span style="font-size: 12px; line-height: 16px;">inuwamohammedumar@tein.cktutas.org</span><br>   
                                <span style="align-items: center; flex-direction: row;">😎 singed in.</span>
                            </div>
                        </div>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <button type="button" class="text-white" style="background-color: transparent; border: none;">...</button>
                            </div>
                            <a href="index" class="btn btn-sm btn-outline-secondary">
                                Home
                            </a>
                        </div>
                    </div>

                </div>
            </div>
           

            <div class="text-white w-100 h-100" style="z-index: 5; padding: 4px 0px; margin-bottom: 20px; transition: all 0.2s ease-in-out; background: #3B3B3B; border-radius: 4px; box-shadow: 0px 1.6px 3.6px rgb(0 0 0 / 25%), 0px 0px 2.9px rgb(0 0 0 / 22%);">
                <div class="container-fluid mt-4">
                    <div class="table-responsive">
                         <table class="table table-sm text-white table-bordered">
                            <thead>
                                <tr style="color: #A7A7A7; font-weight: 700;">
                                    <th></th>
                                    <th>Membership Id</th>
                                    <th>Student Id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Sex</th>
                                    <th>School</th>
                                    <th>Department</th>
                                    <th>Programme</th>
                                    <th>Level</th>
                                    <th>Year of Admission</th>
                                    <th>Year of Completion</th>
                                    <th>Name of Hostel</th>
                                    <th>Region</th>
                                    <th>Constituency</th>
                                    <th>Branch (Polling Station)</th>
                                    <th>WhatsApp Contact</th>
                                    <th>Telephone Number</th>
                                    <th>Card Type</th>
                                    <th>Passport</th>
                                    <th>Registered Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($result as $row): ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td>
                                        <?= $row['membership_identity']; ?>
                                        <?= ($row['membership_paid'] == 1) ? '<span class="badge bg-success">Paid</span>' : ''; ?>        
                                        <?= ($row['membership_executive'] == 'Yes') ? '<span class="badge bg-info">' . ucwords($row["membership_position"]) . '</span>' : ''; ?>        
                                    </td>
                                    <td><?= $row['membership_student_id']; ?></td>
                                    <td><?= ucwords($row['membership_fname']); ?></td>
                                    <td><?= ucwords($row['membership_lname']); ?></td>
                                    <td><?= $row['membership_email']; ?></td>
                                    <td><?= ucwords($row['membership_sex']); ?></td>
                                    <td><?= ucwords($row['membership_school']); ?></td>
                                    <td><?= ucwords($row['membership_department']); ?></td>
                                    <td><?= ucwords($row['membership_programme']); ?></td>
                                    <td><?= ucwords($row['membership_level']); ?></td>
                                    <td><?= $row['membership_yoa']; ?></td>
                                    <td><?= $row['membership_yoc']; ?></td>
                                    <td><?= ucwords($row['membership_name_of_hostel']); ?></td>
                                    <td><?= ucwords($row['membership_region']); ?></td>
                                    <td><?= ucwords($row['membership_constituency']); ?></td>
                                    <td><?= ucwords($row['membership_branch']); ?></td>
                                    <td><?= $row['membership_whatsapp_contact']; ?></td>
                                    <td><?= $row['membership_telephone_number']; ?></td>
                                    <td><?= ucwords($row['membership_card_type']); ?></td>
                                    <td>
                                        <a href="<?= $row['membership_passport']; ?>" target="_blank">
                                            <img src="<?= $row['membership_passport']; ?>" width="100" height="100" class="img-thumbnail">  
                                        </a>
                                    </td>
                                    <td><?= pretty_date_notime($row['membership_registered_date']); ?></td>
                                    <td>
                                        <a class="badge bg-secondary text-decoration-none" href="<?= PROOT; ?>add.member?edit=1&id=<?= $row['id']; ?>">Edit</a>
                                        <!-- <a class="badge bg-danger text-decoration-none" href="<?= PROOT; ?>members?delete=1&id=<?= $row['id']; ?>">Delete</a> -->
                                        <a class="badge bg-danger text-decoration-none" href="<?= PROOT; ?>members?permanent_delete=<?= $row['id']; ?>&uploaded_passport=<?= $row['membership_passport']; ?>">Delete</a>
                                    </td>
                                <?php $i++; endforeach; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
               
        </main>
    </div>
<?php include ("includes/footer.php"); ?>
