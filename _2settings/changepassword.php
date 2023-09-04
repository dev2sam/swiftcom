<?php 

require '../_0path.php';
require ROOTPATH.'/includes/permanent.php';
require ROOTPATH.'/includes/functions.php';

?>


<title>SwfitCom | Change Password</title>
<?php include '../includes/1tagsnlinks2.php'; ?>

</head>

<body>



    <section class="settings_tab">

        <?php include '../includes/2swiftcom.php'; ?>

        <div class="main_tab">
            <div class="top">
                <a href="profile.php"><i class="fas fa-chevron-left"></i></a>
                <h1>Change Password</h1>
            </div>
            <div class="mid change_pass">

                <form action="changepassword.php" method="POST" class="change_pass_form">

                    <p>Old Password</p>
                    <input type="password" name="old_pass" required>

                    <p>New Password</p>
                    <input type="password" name="new_pass" required>
                    <p>Confrim Password</p>
                    <input type="password" name="conf_pass" required>

                    <button type="submit" name="sub_change_pass">Change Password</button>

                </form>

            </div>
            <div class="bottom"></div>
        </div>
    </section>





    <?php include '../includes/4scripts2.php'; ?>

    <script>


    </script>
</body>

</html>