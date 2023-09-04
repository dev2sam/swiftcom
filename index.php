<?php 
        
    require '_0path.php';
    require ROOTPATH.'/includes/permanent.php';
    require ROOTPATH.'/includes/functions.php';
        
?>


<?php include 'includes/1tagsnlinks.php'; ?>
<link rel="stylesheet" href="styles/index.css?<?php echo time(); ?>">
<title>SwfitCom | Messages</title>

</head>

<body>


    <section class="contacts_screen">

        <?php include 'includes/2swiftcom.php'; ?>

        <div class="main_tab">
            <div class="main">

                <div class="jnj"></div>

                <div class="top">
                    <div class="left">
                        <h1>Messages</h1>
                        <i class="fas fa-ellipsis-v"></i>
                    </div>
                    <div class="right">
                        <div class="search"><i class="fas fa-search"></i><input type="text" class="search_contact"
                                placeholder="search">
                        </div>
                        <div class="top_menu">
                            <ul>
                                <li class="logout">Log out</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mid chats">
                    <?php 
                    
                    if (count($array_contacts) > 0):
                        
                        foreach ($array_contacts as $contact):

                            // getting details of contacts in array
                            $sql_for_contacts = "SELECT * FROM `users` WHERE `user_id` = $contact";
                            $result_for_contacts = mysqli_query($conn,$sql_for_contacts);

                            if ($result_for_contacts):
                            if (mysqli_num_rows($result_for_contacts) > 0):
                                
                            $get_contact = mysqli_fetch_assoc($result_for_contacts);

                            // counting the number of unread messages
                            $receiverr = $get_contact['user_username'];
                            $sql_count_read = "SELECT sender_username FROM `chats` WHERE sender_username='$receiverr' AND receiver_username='$logged_username' AND read_status=0";
                            $read_status = mysqli_query($conn, $sql_count_read);

                            $unread_count = 0;
                            while ($get_status = mysqli_fetch_assoc($read_status)){
                                $unread_count = $unread_count + 1;
                            }
                            
                    ?>

                    <a href="_3chat.php?contact_id=<?php echo $get_contact['user_id']; ?>">
                        <div class="contact">
                            <div class="left">
                                <img class="<?php echo $get_contact['user_status']; ?>"
                                    src="user_images/profiles/<?php echo $get_contact['profile_pic'];?>">
                            </div>
                            <div class="right">
                                <div class="info">
                                    <div class="inner-info">
                                        <h1><?php echo $get_contact['user_fullname']; ?></h1>
                                        <h2>@<?php echo $get_contact['user_username']; ?></h2>
                                    </div>

                                    <?php if ($unread_count > 0): ?>
                                    <span>
                                        <h3><?php echo $unread_count; ?></h3>
                                    </span>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </a>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <h3 class="add_contact"><a href="_2search.php">Add contacts →</a></h3>
                    <?php endif; ?>

                </div>
            </div>

            <div class="bottom bottombar">
                <?php include 'includes/3bottombar.php'; ?>
            </div>
        </div>

    </section>



    <?php include 'includes/4scripts.php'; ?>

    <script>
    // refreshing to update section every second
    var refreshchat = setInterval(refreshh, 1000);

    function refreshh() {
        $(".chats").load(" .chats > *");
    }



    // logout user
    $(".logout").click(function() {
        $.post("index.php", {
            logout: "yes"
        });
    })



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
        gsap.from(".contact", {
            y: 100,
            stagger: 0.05,
            ease: "power2.inOut"
        })
    });
    // window.addEventListener("beforeunload", function(event) {
    //     event.returnValue = null;
    // });



    // triggring top menu options
    $(".fa-ellipsis-v").click(function() {
        $(".top_menu").slideToggle(200);
    })



    // for search
    $(".search_contact").keyup(function() {

        clearInterval(refreshchat);

        var searchinput = document.querySelector('.search_contact').value
        searchinput = searchinput.toUpperCase();
        var contactlist = document.querySelectorAll(".contact")

        contactlist.forEach(function(contact) {

            var name = contact.querySelector("h1").innerText
            name = name.toUpperCase()

            if (name.includes(searchinput)) {
                contact.style.display = ''

            } else {
                contact.style.display = 'none'
            }
        })
    })
    </script>
</body>

</html>