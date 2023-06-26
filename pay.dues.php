<?php
    require_once ("db_connection/conn.php");

    session_destroy();
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
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="text-center">
                    <img src="<?= PROOT; ?>dist/media/logo/logo.png" class="img-fluid" alt="TEIN's LOGO">
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="display-5 fw-bold">Pay your dues</h1>
                        <p class="small text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis beatae pariatur ad voluptatum cum voluptates molestiae consequuntur sunt debitis voluptas omnis ipsam quod harum quos, nesciunt, tempora tempore sapiente ducimus.</p>
                        <a href="news/"><< go back</a>
                    </div>
                </div>

                 <form id="membershipForm" enctype="multipart/form-data" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="student_id" id="student_id" placeholder="Student Id">
                                <label for="student_id">Student Id</label>
                                <div class="form-text text-danger student_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                <label for="email">Email</label>
                                <div class="form-text text-danger email_msg"></div>
                            </div>
                        </div>

                        <div class="mt-2 mb-2">
                            <input type="hidden" id="ref" name="ref">
                            <button onclick="payWithPaystack()" class="btn btn-outline-success" name="submit" id="submit">Pay dues</button>
                            <br>
                            <br>
                            <a href="<?= PROOT; ?>news" class="text-secondary"><< go back.</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <?php include ("includes/footer.php"); ?>
    <script src="https://js.paystack.co/v1/inline.js"></script> 
    <script>

        $('#email').on('keyup', function(e) {
            e.preventDefault();
            var  email = $('#email').val()

            $.ajax ({
                url: '<?= PROOT; ?>controller/check.exist.php',
                method : 'POST',
                data: {email : email},
                success : function(data) {
                    if (data == '') {
                        $('.email_msg').html();
                        return true
                    } else {
                        $('.email_msg').html(data);
                        return false;
                    }
                }
            })
        })
        
        $('#student_id').on('keyup', function(e) {
            e.preventDefault();
            var  studentId = $('#student_id').val()

            $.ajax ({
                url: '<?= PROOT; ?>controller/check.exist.php',
                method : 'POST',
                data: {studentId : studentId},
                success : function(data) {
                    if (data == '') {
                        $('.student_msg').html();
                        return true
                    } else {
                        $('.student_msg').html(data);
                        return false;
                    }
                }
            })
        })

        const paymentForm = document.getElementById('membershipForm');
        paymentForm.addEventListener("submit", payWithPaystack, false);

        function payWithPaystack(e) {
            e.preventDefault();
            
            var  student_id = $('#student_id').val()
            var  fname = $('#fname').val()
            var  lname = $('#lname').val()
            var  email = $('#email').val()
            var  sex = $('#sex').val()
            var  school = $('#school').val()
            var  department = $('#department').val()
            var  programme = $('#programme').val()
            var  yoa = $('#yoa').val()
            var  region = $('#region').val()
            var  telephone = $('#telephone').val()
            var  card_type = $('#card_type').val()
            var  passport = $('#passport').val()

            if (student_id == '') {
                $('#student_id').focus();
                $('.student_msg').html('Student id is required!');
                return false;
            } else {
                
                $('.student_msg').html('');
                if (fname == '') {
                    $('#fname').focus();
                    $('.fname_msg').html('First name required!');
                    return false;
                } else {
                    $('.student_msg').html('');
                    $('.fname_msg').html('');
                    if (lname == '') {
                        $('#lname').focus();
                        $('.lname_msg').html('Last name required!');
                        return false;
                    } else {
                        $('.student_msg').html('');
                        $('.fname_msg').html('');
                        $('.lname_msg').html('');
                        if (email == '') {
                            $('#email').focus();
                            $('.email_msg').html('Email required!');
                            return false;
                        } else {
                       
                            $('.student_msg').html('');
                            $('.fname_msg').html('');
                            $('.lname_msg').html('');
                            $('.email_msg').html('');
                            if (sex == '') {
                                $('#sex').focus();
                                $('.sex_msg').html('Sex is required!');
                                return false;
                            } else {
                                $('.student_msg').html('');
                                $('.fname_msg').html('');
                                $('.lname_msg').html('');
                                $('.email_msg').html('');
                                $('.sex_msg').html('');
                                if (school == '') {
                                    $('#school').focus();
                                    $('.school_msg').html('School is required!');
                                    return false;
                                } else {
                                    $('.student_msg').html('');
                                    $('.fname_msg').html('');
                                    $('.lname_msg').html('');
                                    $('.email_msg').html('');
                                    $('.sex_msg').html('');
                                    $('.school_msg').html('');
                                    if (department == '') {
                                        $('#department').focus();
                                        $('.department_msg').html('Department is required!');
                                        return false;
                                    } else {
                                        $('.student_msg').html('');
                                        $('.fname_msg').html('');
                                        $('.lname_msg').html('');
                                        $('.email_msg').html('');
                                        $('.sex_msg').html('');
                                        $('.school_msg').html('');
                                        $('.department_msg').html('');
                                        if (programme == '') {
                                            $('#programme').focus();
                                            $('.programme_msg').html('Programme is required!');
                                            return false;
                                        } else {
                                            $('.student_msg').html('');
                                            $('.fname_msg').html('');
                                            $('.lname_msg').html('');
                                            $('.email_msg').html('');
                                            $('.sex_msg').html('');
                                            $('.school_msg').html('');
                                            $('.department_msg').html('');
                                            $('.programme_msg').html('');
                                            if (yoa == '') {
                                                $('#yoa').focus();
                                                $('.yoa_msg').html('Year of admission required!');
                                                return false;
                                            } else {
                                                $('.student_msg').html('');
                                                $('.fname_msg').html('');
                                                $('.lname_msg').html('');
                                                $('.email_msg').html('');
                                                $('.sex_msg').html('');
                                                $('.school_msg').html('');
                                                $('.department_msg').html('');
                                                $('.programme_msg').html('');
                                                $('.yoa_msg').html('');
                                                if (region == '') {
                                                    $('#region').focus();
                                                    $('.region_msg').html('Region is required!');
                                                    return false;
                                                } else {
                                                    $('.student_msg').html('');
                                                    $('.fname_msg').html('');
                                                    $('.lname_msg').html('');
                                                    $('.email_msg').html('');
                                                    $('.sex_msg').html('');
                                                    $('.school_msg').html('');
                                                    $('.department_msg').html('');
                                                    $('.programme_msg').html('');
                                                    $('.yoa_msg').html('');
                                                    $('.region_msg').html('');
                                                    if (telephone == '') {
                                                        $('#telephone').focus();
                                                        $('.telephone_msg').html('Telephone number is required!');
                                                        return false;
                                                    } else {
                                                        $('.student_msg').html('');
                                                        $('.fname_msg').html('');
                                                        $('.lname_msg').html('');
                                                        $('.email_msg').html('');
                                                        $('.sex_msg').html('');
                                                        $('.school_msg').html('');
                                                        $('.department_msg').html('');
                                                        $('.programme_msg').html('');
                                                        $('.yoa_msg').html('');
                                                        $('.region_msg').html('');
                                                        $('.telephone_msg').html('');
                                                        if (card_type == '') {
                                                            $('#card_type').focus();
                                                            $('.card_type_msg').html('Card Type required!');
                                                            return false;
                                                        } else {
                                                            $('.student_msg').html('');
                                                            $('.fname_msg').html('');
                                                            $('.lname_msg').html('');
                                                            $('.email_msg').html('');
                                                            $('.sex_msg').html('');
                                                            $('.school_msg').html('');
                                                            $('.department_msg').html('');
                                                            $('.programme_msg').html('');
                                                            $('.yoa_msg').html('');
                                                            $('.region_msg').html('');
                                                            $('.telephone_msg').html('');
                                                            $('.card_type_msg').html('');
                                                            if (passport == '') {
                                                                $('#passport').focus();
                                                                $('.passport_msg').html('Passport size photo is required!');
                                                                return false;
                                                            } else {
                                                                $('.student_msg').html('');
                                                                $('.fname_msg').html('');
                                                                $('.lname_msg').html('');
                                                                $('.email_msg').html('');
                                                                $('.sex_msg').html('');
                                                                $('.school_msg').html('');
                                                                $('.department_msg').html('');
                                                                $('.programme_msg').html('');
                                                                $('.yoa_msg').html('');
                                                                $('.region_msg').html('');
                                                                $('.telephone_msg').html('');
                                                                $('.card_type_msg').html('');
                                                                $('.passport_msg').html('');

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

                                                                        var data = new FormData();

                                                                        // Form data
                                                                        var form_data = $('#membershipForm').serializeArray();
                                                                        $.each(form_data, function (key, input) {
                                                                            data.append(input.name, input.value);
                                                                        });

                                                                        // File data
                                                                        var property = document.getElementById("passport").files[0];
                                                                        data.append("passport", property);

                                                                        // Custom data
                                                                        data.append('key', 'value');                                                                        
                                                                        $.ajax({
                                                                            url : 'controller/add.member.verify.payment.php',
                                                                            method : 'POST',
                                                                            data: data,
                                                                            contentType: false,
                                                                            cache: false,
                                                                            processData: false,
                                                                            success : function(data) {
                                                                                if (data == '') {
                                                                                    window.location = '<?= PROOT; ?>member.success';
                                                                                } else {
                                                                                    console.log(data);
                                                                                }
                                                                            }
                                                                        });
                                                                        // let message = 'Payment complete! Reference: ' + response.reference;
                                                                        // alert(message);
                                                                    }
                                                                });

                                                                $.ajax ({
                                                                    url: '<?= PROOT; ?>controller/check.exist.php',
                                                                    method : 'POST',
                                                                    data: {studentId : student_id},
                                                                    success : function(data) {
                                                                        if (data == '') {

                                                                            $('.student_msg').html();

                                                                            $.ajax ({
                                                                                url: '<?= PROOT; ?>controller/check.exist.php',
                                                                                method : 'POST',
                                                                                data: {email : email},
                                                                                success : function(data) {
                                                                                    if (data == '') {
                                                                                        $('.email_msg').html();

                                                                                        handler.openIframe();

                                                                                    } else {
                                                                                        $('.email_msg').html(data);
                                                                                        $('#email').focus()
                                                                                        return false;
                                                                                    }
                                                                                }
                                                                            })
                                                                        } else {
                                                                            $('.student_msg').html(data);
                                                                            $('#student_id').focus()
                                                                            return false;
                                                                        }
                                                                    }
                                                                })
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    </script>

</body>
</html>