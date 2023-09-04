<?php 

require '../_0path.php';
require ROOTPATH.'/includes/permanent.php';
require ROOTPATH.'/includes/functions.php';

?>


<title>SwfitCom | Profile</title>
<?php include '../includes/1tagsnlinks2.php'; ?>

</head>

<body>



    <section class="settings_tab">

        <?php include '../includes/2swiftcom.php'; ?>

        <div class="main_tab">
            <div class="top">
                <a href="../_2settings.php"><i class="fas fa-chevron-left"></i></a>
                <h1>Profile settings</h1>
            </div>
            <div class="mid profile">
                <div class="change">
                    <img class="profilepic" src="../user_images/profiles/<?php echo $userdetails['profile_pic'];?>"
                        alt="">

                    <form method="POST" action="profile.php" enctype="multipart/form-data" class="image_form"
                        id="image_form">
                        <input type="hidden" name="profile_user" value="<?php echo $username_session; ?>">
                        <input type="file" id="profile_pic" name="profile_pic" class="profile_pic" accept="image/*">
                    </form>
                    <button class="change_btn">Change</button>
                </div>

                <div class="delete">
                    <a href="changepassword.php"><button class="change_password">Change Password</button></a>
                    <button class="del_profile">Delete Profile</button>
                </div>
            </div>
            <div class="bottom"></div>
        </div>
    </section>





    <?php include '../includes/4scripts2.php'; ?>

    <script>
    // to change profile pic
    $(".change_btn").click(function() {
        $(".profile_pic").trigger('click')
    })
    document.getElementById("profile_pic").onchange = function() {
        document.getElementById("image_form").submit();
    }


    // to delete profile
    $(".del_profile").click(function() {
        var confrimDelete = confirm("Delete account?");

        if (confrimDelete === true) {

            var del_password = prompt("Please enter your password");

            $.post("profile.php", {
                delete: del_password
            })
        }
    })
    </script>
</body>

</html>