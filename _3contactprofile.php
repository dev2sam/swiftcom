<?php


require '_0path.php';
require ROOTPATH.'/includes/permanent.php';
require ROOTPATH.'/includes/functions.php';

    
if (isset($_GET['contact_profile'])){
    
    $contact_id = $_GET['contact_profile'];
    $sql_get_contact_info = "SELECT * FROM `users` WHERE user_id=$contact_id";
    $contact_details = mysqli_query($conn, $sql_get_contact_info);
    $contact_details = mysqli_fetch_assoc($contact_details);
}

// checking if contact is set
if (!isset($contact_id)){
    header('location: '.BASE.'/index.php');
    exit(0);
}


?>



<?php include 'includes/1tagsnlinks.php'; ?>
<link rel="stylesheet" href="styles/profile.css?<?php echo time(); ?>">
<title>SwfitCom | <?php echo $contact_details['user_username']; ?></title>

</head>

<body>


    <section class="myprofile">


        <?php include 'includes/2swiftcom.php'; ?>

        <div class="main_tab">

            <div class="top">
                <i class="fas fa-chevron-left"></i>
                <h1><a
                        href="_3chat.php?contact_id=<?php echo $contact_details['user_id']; ?>"><?php echo $contact_details['user_fullname']; ?></a>
                </h1>
            </div>
            <div class="mid">
                <div class="clip"></div>
                <img class="profilepic" src="user_images/profiles/<?php echo $contact_details['profile_pic'];?>" alt="">
                <div class="overlay_icon">
                    <img src="images/icons/edit.svg" alt="">
                </div>
            </div>
            <div class="bottom">
                <div>
                    <h1>Full Name :</h1>
                    <h2><?php echo $contact_details['user_fullname']; ?></h2>
                </div>
                <div>
                    <h1>Username :</h1>
                    <h2><?php echo $contact_details['user_username']; ?></h2>
                </div>
                <div>
                    <h1>Email :</h1>
                    <h2><?php echo $contact_details['user_email']; ?></h2>
                </div>
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


    // to trigger the back button
    $(".fa-chevron-left").click(function() {
        window.history.back();
    })
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {

        gsap.from(".main", {
            scale: 1.1,
            duration: 0.2,
            ease: "power2.inOut"
        })
    });
    </script>
</body>

</html>