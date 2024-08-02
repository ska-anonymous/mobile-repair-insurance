<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AthleteConnect | Agent Register</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../common/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../common/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../common/dist/css/adminlte.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../common/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../common/plugins/toastr/toastr.min.css">
</head>

<style>
    .invalid {
        box-shadow: 0px 0px 0px 2px rgb(255, 0, 0, 0.4);
    }

    .fa-lock,
    .fa-unlock {
        cursor: pointer;
    }
</style>

<body class="hold-transition register-page">
    <div class="container">
        <div class="register-logo">
            <a href="../common/"><b>Register</b></a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new business</p>
                <h3>Business Details</h3>
                <form id="register_form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" maxlength="20" class="form-control" name="b_name" placeholder="Name" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" maxlength="200" class="form-control" name="b_address" placeholder="Address" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-address-card"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" maxlength="20" name="b_country" class="form-control" placeholder="Country" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa fa-globe"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" maxlength="50" name="b_city" class="form-control" placeholder="City" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa fa-map-marker"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" maxlength="20" class="form-control" name="b_postal_code" placeholder="Area Postal Code" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" maxlength="50" class="form-control" name="b_email" placeholder="Email" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" maxlength="100" class="form-control" name="b_phone" placeholder="Phone" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa fa-phone"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="file" accept="image/*" class="form-control" name="b_logo" placeholder="Business Logo">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        Business Logo
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <select class="form-control" name="b_type" id="" required>
                                    <option value="" selected disabled>Select A Business Type</option>
                                    <option value="insurance">Insurance Company</option>
                                    <option value="workshop">Workshop</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h3>User Details</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" maxlength="20" class="form-control" name="name" placeholder="Name" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" maxlength="50" class="form-control" name="email" placeholder="Email" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" maxlength="20" class="form-control" name="username" placeholder="username" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-key"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" maxlength="20" minlength="8" class="form-control" name="password" placeholder="Password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <input type="text" maxlength="20" class="form-control" name="phone" placeholder="Phone" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa fa-phone"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-primary btn-block">Register</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                    </div>
                </form>

                <a href="../login" class="text-center">Already have a membership? <strong>Login</strong></a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="../common/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../common/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../common/dist/js/adminlte.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="../common/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../common/plugins/toastr/toastr.min.js"></script>

    <script>
        // submit Registration form through ajax to process Registration
        let form = document.querySelector('#register_form');
        let btnSubmit = form.querySelector('#btn_submit');

        form.addEventListener('submit', (e) => {
            e.preventDefault();

            let formData = new FormData(form);

            btnSubmit.disabled = true;
            btnSubmit.textContent = "Registering.....";

            // make post request using fetch
            let url = "process_register.php";

            fetch(url, {
                    method: "POST",
                    body: formData,
                })
                .then(response => {
                        return response.json();
                    },
                    (err) => {
                        toastr.error("No Internet Connection");
                    })
                .then(jsonData => {
                    if (jsonData.error) {
                        toastr.error(jsonData.error_message);
                    } else {
                        form.reset();
                        toastr.success("Registration Successfull");
                        toastr.warning("Please wait for admin to approve your account. Then you will be able to login");
                        setTimeout(() => {
                            location.replace("../login");
                        }, 4000)
                    }

                })
                .catch(err => {
                    toastr.error("Registration Failed! Please try again later");
                })
                .finally(() => {
                    btnSubmit.disabled = false;
                    btnSubmit.textContent = "Register";
                })

        })

        // remove invalid class styling from form input fields if they are set due to invalid data
        let inputs = form.querySelectorAll('input');
        Array.from(inputs).forEach(input => {
            input.addEventListener('input', () => {
                input.classList.remove('invalid');
            })
        })

        // toggle show/hide password in password fields
        let toggleButtons = document.querySelectorAll('.password-toggler');
        toggleButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                let inputElement = e.target.closest('.input-group.mb-3').querySelector('input');
                if (inputElement.type === "password") {
                    inputElement.type = "text";
                    button.classList.remove('fa-lock');
                    button.classList.add('fa-unlock');
                } else {
                    inputElement.type = "password";
                    button.classList.remove('fa-unlock');
                    button.classList.add('fa-lock');
                }
            })
        })
    </script>
</body>

</html>