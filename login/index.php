<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> SPS | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
    .fa-lock,
    .fa-unlock {
        cursor: pointer;
    }

    .incorrect {
        box-shadow: 0px 0px 0px 3px rgb(255, 0, 0, 0.5) !important;
        border: 1px solid red !important;
    }
</style>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>SPS</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form id="login-form">
                    <div class="input-group mb-3">
                        <input type="text" maxlength="50" name="user_login" class="form-control"
                            placeholder="Email or username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="user_pass" class="form-control" maxlength="15"
                            placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock password-toggler"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" id="btn-submit" class="btn btn-primary btn-block">Log In</button>
                        </div>
			<div class="col-12 mt-2">
                            Not registered? <a href="../register">Register</a>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p> -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

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

     <?php
        // if the session blocked variable is set the display the blocked message
        session_start();
        if(isset($_SESSION['blocked']) && $_SESSION['blocked']['cause'] == 'awaiting'){
            echo '
            <script>
                toastr.warning("'.$_SESSION['blocked']['message'].'");
            </script>';
            unset($_SESSION['blocked']);
        }elseif(isset($_SESSION['blocked']) && $_SESSION['blocked']['cause'] == 'rejected'){
            echo '
            <script>
                toastr.error("'.$_SESSION['blocked']['message'].'");
            </script>';
            unset($_SESSION['blocked']);
        }
     ?>

    <script>
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

        // submit login form on through ajax

        let form = document.querySelector('#login-form');
        let btnSubmit = form.querySelector('#btn-submit');

        form.addEventListener('submit', e => {
            e.preventDefault();

            btnSubmit.textContent = "Logging in....";
            btnSubmit.disabled = true;

            let url = "process_login.php";
            let formData = new FormData(form);

            fetch(url, {
                method: "POST",
                body: formData,
            })
                .then(response => {
                    return response.json();
                },
                    (err) => {
                        toastr.error("No Internet Connection");
                    }).then(jsonData => {

                        if (jsonData.error) {
                            if (jsonData.incorrect_field && jsonData.incorrect_field != "") {
                                form.querySelector(`input[name=${jsonData.incorrect_field}]`).classList.add('incorrect');
                            }
                            toastr.error(jsonData.error_message);
                        } else {
                            form.reset();
                            toastr.success("Login successfull");

                            setTimeout(() => {
                                // get the previous url path to redirect the user to after a succesfull login
                                let completeURL = new URL(location.href);
                                if (completeURL.searchParams.get("previousURL")) {
                                    let origin = completeURL.origin;
                                    let previousURL = origin + completeURL.searchParams.get("previousURL");
                                    location.replace(previousURL);
                                } else {
                                    location.replace("../index.php");
                                }
                            }, 1000);

                        }
                    }).catch(err => {
                        toastr.error("Login Failed! Please try again later");
                    }).finally(() => {
                        btnSubmit.disabled = false;
                        btnSubmit.textContent = "Log In";
                    })
        })

        // remove invalid class styling from form input fields if they are set due to invalid data
        let inputs = form.querySelectorAll('input');
        Array.from(inputs).forEach(input => {
            input.addEventListener('input', () => {
                input.classList.remove('incorrect');
            })
        })
    </script>

</body>

</html>