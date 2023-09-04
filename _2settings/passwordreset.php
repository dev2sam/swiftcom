<?php 

require '../_0path.php';
require ROOTPATH.'/includes/functions.php';

if (!isset($_GET['pass_key'])){
    header('location: '.BASE.'/_1login.php');
    exit(0);
    
} else{
    $pass_keyy = $_GET['pass_key'];
}

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
            <div class="mid reset_pass">

                <form action="passwordreset.php" method="POST" class="reset_pass_form">

                    <p>Enter your new password</p>
                    <input type="password" name="reset_password" required>
                    <p>Confirm your new password</p>
                    <input type="password" name="conf_reset_password" required>
                    <input type="hidden" value="<?php echo $pass_keyy; ?>" name="pass_keyy">

                    <button type="submit" name="reset_pass_btn">Reset</button>
                </form>

            </div>
            <div class="bottom"></div>
        </div>
    </section>





    <?php include ROOTPATH.'/includes/4scripts2.php'; ?>

    <script>

    </script>
</body>

</html>