<?php

require '_0path.php';
require ROOTPATH.'/includes/permanent.php';
require ROOTPATH.'/includes/functions.php';

?>



<?php include 'includes/1tagsnlinks.php'; ?>
<title>SwfitCom | Settings</title>
<link rel="stylesheet" href="styles/settings.css?<?php echo time(); ?>">

</head>

<body>


    <section class="settings">

        <?php include 'includes/2swiftcom.php'; ?>

        <div class="main_tab">

            <div class="main">

                <div class="jnj"></div>

                <div class="top">
                    <h1>Settings</h1>
                </div>

                <div class="mid">
                    <div class="setting_options">
                        <img src="images/icons/profiles.svg" alt="">
                        <a href="_2settings/profile.php">
                            <h1>Profile</h1>
                        </a>
                    </div>
                    <div class="setting_options">
                        <img src="images/icons/themes.svg" alt="">
                        <a href="_2settings/theme.php">
                            <h1>Themes</h1>
                        </a>
                    </div>
                    <div class="setting_options">
                        <img src="images/icons/notification.svg" alt="">
                        <a href="_2settings/notifications.php">
                            <h1>Notifications</h1>
                        </a>
                    </div>
                    <div class="setting_options">
                        <img src="images/icons/invite.svg" alt="">
                        <a href="_2settings/invite.php">
                            <h1>Invite a friend</h1>
                        </a>
                    </div>
                    <div class="setting_options">
                        <img src="images/icons/help.svg" alt="">
                        <a href="_2settings/help.php">
                            <h1>Help & support</h1>
                        </a>
                    </div>
                </div>

                <div class="bottom">
                    <div class="logo">
                        <img src="images/logo.svg" alt="">
                        <h1>SwiftCom</h1>
                    </div>
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
    </script>


    <script>
    // animations while switching pages
    document.addEventListener("DOMContentLoaded", function() {

        gsap.from(".main", {
            scale: 1.2,
            duration: 0.3
        })
        gsap.from(".setting_options", {
            y: 100,
            stagger: 0.05,
            ease: "power2.inOut"
        })
    });
    // window.addEventListener("beforeunload", function(event) {
    //     event.returnValue = null;
    // });
    </script>
</body>

</html>