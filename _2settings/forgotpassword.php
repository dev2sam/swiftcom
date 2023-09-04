<?php 

require '../_0path.php';
require ROOTPATH.'/includes/functions.php';

?>


<title>SwfitCom | Change Password</title>
<?php include ROOTPATH.'/includes/1tagsnlinks2.php'; ?>

</head>

<body>



    <section class="settings_tab">

        <?php include ROOTPATH.'/includes/2swiftcom.php'; ?>

        <div class="main_tab">
            <div class="top">
                <a href="profile.php"><i class="fas fa-chevron-left"></i></a>
                <h1>Change Password</h1>
            </div>
            <div class="mid forget_pass">

                <form action="forgotpassword.php" method="POST" class="forgot_pass_form forgot1">

                    <p>Please enter <b>email</b>, associated with your account :</p>
                    <input type="email" name="email_forgot" required>
                    <h6 class="no_email"><u>I dont remember email !</u></h6>

                    <button type="submit" name="sub_forgot_pass1" class="sub_forgot_pass1">Submit</button>
                </form>

                <form action="forgotpassword.php" method="POST" class="forgot_pass_form forgot2">

                    <p>Please enter <b>username</b>, associated with your account :</p>
                    <input type="text" name="username_forgot" required>
                    <h6 class="no_username"><u>I dont remember username !</u></h6>

                    <button type="submit" name="sub_forgot_pass2" class="sub_forgot_pass2">Submit</button>
                </form>

            </div>
            <div class="bottom"></div>
        </div>
    </section>





    <?php include ROOTPATH.'/includes/4scripts2.php'; ?>

    <script>
    // to toggle between respected forms
    $(".no_email").click(function() {
        $(".forgot1").slideUp(200)
        $(".forgot2").slideDown(200)
    })
    $(".no_username").click(function() {
        $(".forgot2").slideUp(200)
        $(".forgot1").slideDown(200)
    })
    </script>
</body>

</html>