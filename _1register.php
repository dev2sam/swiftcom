<?php

    include 'php/connect.php';

    $userfullname = '';
    $username = '';
    $useremail = '';
    $userpassword = '';
    $usercpassword = '';
    $userstatus = '';
    $otp = '';

    
if (isset($_POST['submit-register'])){

    unset($_POST['submit-register']);

    $userfullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $useremail = trim($_POST['email']);
    $userpassword = trim($_POST['password']);
    $usercpassword = trim($_POST['cpassword']);
    $userfpassword = password_hash($userpassword, PASSWORD_DEFAULT);
    $userstatus = 'online';
    // $otp = trim($_POST['otp']);

    echo $userpassword;

    $sqlforusername = "SELECT * FROM `users` WHERE user_username = '$username'";
    $resultforusername = mysqli_query($conn, $sqlforusername);
    $sqlforuseremail = "SELECT * FROM `users` WHERE user_email = '$useremail'";
    $resultforuseremail = mysqli_query($conn, $sqlforuseremail);


    if (strlen($userfullname) > 20){
        echo '<script>alert("Name must be less that 20 chars")</script>';
    } 
    else if (strlen($userfullname) < 1){
        echo '<script>alert("name is reqired")</script>';
    }
    else if (strlen($username) > 20){
        echo '<script>alert("username is reqired")</script>';
    }
    else if (strlen($username) < 1){
        echo '<script>alert("username is reqired")</script>';
    }
    else if (strlen($useremail) < 1){
        echo '<script>alert("email is reqired")</script>';
    }
    else if (strlen($userpassword) < 1){
        echo '<script>alert("password is reqired")</script>';
    }
    else if (mysqli_num_rows($resultforusername) > 0){
        echo '<script>alert("this username is already in use")</script>';
    }
    else if (mysqli_num_rows($resultforuseremail) > 0){
        echo '<script>alert("this email is already in use")</script>';
    }
    else if ($userpassword !== $usercpassword){
        echo '<script>alert("passwords do not match")</script>';
    }
    else {

        // generating random
        // $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        // $number = array();
        // $datalen = strlen($data) - 1;
        // for ($i = 0; $i < 5; $i++) {
        //     $n = rand(0, $datalen);
        //     $pass[] = $data[$n];
        // }
        // $randomnumber = implode($pass);

        // sending email
        // $message = wordwrap("This is your confirmation OTP: " . $randomnumber);
        // $message = wordwrap($message,70);
        // mail($useremail,"SwiftCom - Email Confrimation",$message);

        // echo '<script>alert("jani tumhe main ne email send kiya hai. usko check kr zara")</script>';
 
        // if ($otp === $randomnumber){
            $sql = "INSERT INTO `users` (`user_fullname`, `user_password`, `user_email`, `user_created_at`, `user_status`, `user_username`, `user_contacts`, `blocked_contacts`, `profile_pic`, `password_reset`) VALUES ('$userfullname', '$userfpassword', '$useremail', current_timestamp(), '$userstatus', '$username', '', '', 'user.png', '');";
            if (mysqli_query($conn, $sql)){
    
                session_set_cookie_params(3600,"/");
                session_start();
                $_SESSION['username'] = $username;
                
                $status_sql = "UPDATE `users` SET user_status='online' WHERE `user_username`='$username'";
                mysqli_query($conn, $status_sql);

                ob_start();
                header('Location: ' . 'index.php');
                ob_end_flush();
                exit();
            }
        // }
        // else {
        //     echo '<script>alert("Jani otp galt hai")</script>';
        // }
        
    }

}



?>



<?php include 'includes/1tagsnlinks.php'; ?>
<title>SwfitCom | Sign Up</title>
<link rel="stylesheet" href="styles/register.css?<?php echo time(); ?>">

</head>

<body>

    <section class="login_screen">

        <div class="left">

            <svg class="main-svg" viewBox="0 0 160 677" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M111.229 0L122.352 28.2083C133.475 56.4167 155.72 112.833 159.428 169.25C163.136 225.667 148.305 282.083 129.767 338.5C111.229 394.917 88.9831 451.333 88.9831 507.75C88.9831 564.167 111.229 620.583 122.352 648.792L133.475 677H-5.54287e-06V648.792C-5.54287e-06 620.583 -5.54287e-06 564.167 -5.54287e-06 507.75C-5.54287e-06 451.333 -5.54287e-06 394.917 -5.54287e-06 338.5C-5.54287e-06 282.083 -5.54287e-06 225.667 -5.54287e-06 169.25C-5.54287e-06 112.833 -5.54287e-06 56.4167 -5.54287e-06 28.2083V0L111.229 0Z" />
            </svg>

            <div class="inner_left">
                <div class="top">
                    <i class="fas fa-chevron-left"></i>
                    <div class="icon">
                        <svg width="120" height="120" viewBox="0 0 120 120" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0 60V120H60H120V60V-1.78814e-06H60H0V60ZM58.6 36.5C60.6 38.6 61 39.6 60.5 42.4C59.5 47.5 61.3 50 66 50C68.1 50 70 50.5 70.2 51.1C70.4 51.7 73.6 52.2 77.7 52.3C83 52.5 85.3 53 86.8 54.3C92.2 59.2 89 67.9 81.7 68C77.3 68 73.9 63.9 74.2 59C74.3 56.8 74.1 54.8 73.8 54.4C73.4 54.1 70.8 54.2 67.8 54.7C61.1 55.7 60.6 57.6 65.5 62.7C68.7 66 69.1 67 68.6 69.9C67.8 74.8 63.4 80.6 57.1 85.1C54.1 87.2 51.5 88.9 51.3 88.7C51.2 88.5 52.6 85.2 54.5 81.4C59 72.5 59.1 68 55.1 63.9C53.5 62.3 51.2 61 50.1 61C48.9 61 43.5 63.3 38 66C26.5 71.8 24.6 72.3 31 67.9C35.2 65 35 64.8 29.3 66.5C24.3 67.9 27.5 66.1 36.3 62.5C47.6 57.7 51 54.7 51 49.1C51 42.1 49.5 40.2 43.3 39.4C37.4 38.7 37.4 37.8 43.5 35.6C50 33.2 55.7 33.6 58.6 36.5Z"
                                fill="#3B48FF" />
                            <path
                                d="M81.6 59.3C81.9 60.3 82.5 60.8 82.8 60.5C83.1 60.2 82.8 59.4 82.1 58.7C81.1 57.8 81 57.9 81.6 59.3Z"
                                fill="#3B48FF" />
                        </svg>
                        <h1>SwiftCom</h1>
                    </div>
                </div>

                <div class="heading">
                    <h1>Greetings !</h1>
                </div>

                <div class="image">
                    <img src="images/register.svg" alt="">
                </div>
            </div>

        </div>


        <div class="right">

            <div class="top">
                <div class="icon">
                    <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M0 60V120H60H120V60V-1.78814e-06H60H0V60ZM58.6 36.5C60.6 38.6 61 39.6 60.5 42.4C59.5 47.5 61.3 50 66 50C68.1 50 70 50.5 70.2 51.1C70.4 51.7 73.6 52.2 77.7 52.3C83 52.5 85.3 53 86.8 54.3C92.2 59.2 89 67.9 81.7 68C77.3 68 73.9 63.9 74.2 59C74.3 56.8 74.1 54.8 73.8 54.4C73.4 54.1 70.8 54.2 67.8 54.7C61.1 55.7 60.6 57.6 65.5 62.7C68.7 66 69.1 67 68.6 69.9C67.8 74.8 63.4 80.6 57.1 85.1C54.1 87.2 51.5 88.9 51.3 88.7C51.2 88.5 52.6 85.2 54.5 81.4C59 72.5 59.1 68 55.1 63.9C53.5 62.3 51.2 61 50.1 61C48.9 61 43.5 63.3 38 66C26.5 71.8 24.6 72.3 31 67.9C35.2 65 35 64.8 29.3 66.5C24.3 67.9 27.5 66.1 36.3 62.5C47.6 57.7 51 54.7 51 49.1C51 42.1 49.5 40.2 43.3 39.4C37.4 38.7 37.4 37.8 43.5 35.6C50 33.2 55.7 33.6 58.6 36.5Z"
                            fill="#3B48FF" />
                        <path
                            d="M81.6 59.3C81.9 60.3 82.5 60.8 82.8 60.5C83.1 60.2 82.8 59.4 82.1 58.7C81.1 57.8 81 57.9 81.6 59.3Z"
                            fill="#3B48FF" />
                    </svg>
                    <h1>SwiftCom</h1>
                </div>
            </div>

            <div class="form">
                <h3>Register</h3>
                <form action="_1register.php" method="POST">
                    <div class="input input1">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Name" class="fullname" name="fullname"
                            value="<?php echo $userfullname; ?>" required>
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div class="input input3">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Username" class="username" name="username"
                            value="<?php echo $username; ?>" required>
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div class="input input2">
                        <i class="fas fa-lock"></i>
                        <input type="email" placeholder="Email" class="email" name="email"
                            value="<?php echo $useremail; ?>" required>
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div class="input input4">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" class="password" name="password"
                            value="<?php echo $userpassword; ?>" required>
                        <i class="far fa-eye"></i>
                        <i class="far fa-eye-slash"></i>
                    </div>
                    <div class="input input5">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Confirm Password" class="password" name="cpassword"
                            value="<?php echo $usercpassword; ?>" required>
                        <i class="far fa-eye"></i>
                        <i class="far fa-eye-slash"></i>
                    </div>

                    <h2><input class="checkbox" name="privacy" type="checkbox"><a href="#">Privacy & Policy</a></h2>
                    <h2><input class="checkbox" name="terms" type="checkbox"><a href="#">Terms and conditions</a></h2>
                    <button class="login-btn" name="submit-register" type="submit">Sign up</button>
                </form>
                <p><span>or</span></p>
                <a href="_1login.php"><button class="sign-btn-promt">Log in</button></a>
            </div>


        </div>

    </section>


    <?php include 'includes/4scripts.php'; ?>


    <script>
    $(".fas.fa-chevron-left").click(function() {
        window.history.back();
    })

    $(".email")
        .focus(function() {
            $(this).parent().css("border-bottom", "2px solid var(--accent)")
        })
        .blur(function() {
            $(this).parent().css("border-bottom", "2px solid var(--text2)")
        })
    $(".fullname")
        .focus(function() {
            $(this).parent().css("border-bottom", "2px solid var(--accent)")
        })
        .blur(function() {
            $(this).parent().css("border-bottom", "2px solid var(--text2)")
        })
    $(".username")
        .focus(function() {
            $(this).parent().css("border-bottom", "2px solid var(--accent)")
        })
        .blur(function() {
            $(this).parent().css("border-bottom", "2px solid var(--text2)")
        })

    $(".password")
        .focus(function() {
            $(this).parent().css("border-bottom", "2px solid var(--accent)")
            $(".far.fa-eye").slideDown()
            $(".far.fa-eye-slash").slideUp()
        })
        .blur(function() {
            $(this).parent().css("border-bottom", "2px solid var(--text2)")
            $(".far.fa-eye").slideUp()
            $(".far.fa-eye-slash").slideUp()
        })
    $(".far.fa-eye").click(function() {
        $(".far.fa-eye").hide()
        $(".far.fa-eye-slash").show()
        $(".password").attr("type", "text")
    })
    $(".far.fa-eye-slash").click(function() {
        $(".far.fa-eye-slash").hide()
        $(".far.fa-eye").delay(500).show()
        $(".password").attr("type", "password")
    })
    </script>
</body>

</html>