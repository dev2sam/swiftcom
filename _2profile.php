<?php

require '_0path.php';
require ROOTPATH.'/includes/permanent.php';
require ROOTPATH.'/includes/functions.php';


?>


<?php include 'includes/1tagsnlinks.php'; ?>
<link rel="stylesheet" href="styles/profile.css?<?php echo time(); ?>">
<title>SwfitCom | <?php echo $logged_fullname; ?></title>

</head>

<body>


    <section class="myprofile">


        <?php include 'includes/2swiftcom.php'; ?>

        <div class="main_tab">

            <div class="main">

                <div class="jnj"></div>

                <div class="top">
                    <h1>Your Profile</h1>
                </div>
                <div class="mid">
                    <div class="clip"></div>
                    <img class="profilepic" src="user_images/profiles/<?php echo $userdetails['profile_pic'];?>" alt="">
                    <div class="overlay_icon">
                        <img src="images/icons/edit.svg" alt="">
                    </div>
                </div>
                <div class="bottom">
                    <div>
                        <h1>Full Name :</h1>
                        <h2><?php echo $logged_fullname; ?></h2>
                    </div>
                    <div>
                        <h1>Username :</h1>
                        <h2><?php echo $logged_username; ?></h2>
                    </div>
                    <div>
                        <h1>Email :</h1>
                        <h2><?php echo $logged_email; ?></h2>
                    </div>
                    <div>
                        <button class="blocked_btn">Blocked Contacts →</button>
                    </div>
                </div>
                <div class="blocked_list">

                    <i class="fas fa-long-arrow-alt-left cross_btn"></i>

                    <?php 
                        foreach($array_blocked as $blocked):
                        
                        $sqll = "SELECT * FROM `users` WHERE `user_id`=$blocked";
                        $resultt = mysqli_query($conn, $sqll);

                        if ($resultt):
                        if (mysqli_num_rows($resultt) > 0):
                            $resultt = mysqli_fetch_assoc($resultt);
                        
                    ?>
                    <div class="blocked_contact">
                        <div class="left">
                            <img src="user_images/profiles/<?php echo $resultt['profile_pic'];?>">
                        </div>
                        <div class="right">
                            <div class="info">
                                <div class="inner-info">
                                    <h1><?php echo $resultt['user_fullname']; ?></h1>
                                    <h2>@<?php echo $resultt['user_username']; ?></h2>
                                    <input class="contact_id" type="hidden" value="<?php echo $resultt['user_id']; ?>">
                                </div>
                                <button class="unblock" value="<?php echo $resultt['user_id']; ?>">Unblock</button>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="very_bottom bottombar">
                <?php include 'includes/3bottombar.php'; ?>
            </div>
        </div>

    </section>


    <?php include 'includes/4scripts.php'; ?>



    <script>
    // tell php to make user offline when it closes tab
    $(window).bind('unload', function() {
        $.post("index.php", {
            end: "yes"
        });
    });
    $(window).bind('load', function() {
        $.post("index.php", {
            started: "yes"
        });
    });


    // show blocked contacts toggle
    $(".blocked_btn").click(function() {
        $(".bottom").slideUp(200);
        $(".blocked_list").slideDown(200);
    })

    // hide blocked contacts toggle
    $(".cross_btn").click(function() {
        $(".bottom").slideDown(200);
        $(".blocked_list").slideUp(200);
    })


    // to unlock a contact
    $(".unblock").click(function() {

        var confrim_unblock = confirm("Are you sure, this contact will be unblocked?");
        if (confrim_unblock == true) {

            $.post("_2profile.php", {
                unblock: $(this).val()
            })

            $(this).text("Unblocked!");
            $(this).css("background", "var(--success)");
        }
    })


    // animations
    document.addEventListener("DOMContentLoaded", function() {
        gsap.from(".main", {
            scale: 1.2,
            duration: 0.3
        })
    });
    </script>
</body>

</html>