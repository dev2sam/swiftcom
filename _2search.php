<?php

require '_0path.php';
require ROOTPATH.'/includes/permanent.php';
require ROOTPATH.'/includes/functions.php';

    

?>


<?php include 'includes/1tagsnlinks.php'; ?>
<title>SwfitCom | Find friends</title>
<link rel="stylesheet" href="styles/search.css?<?php echo time(); ?>">

</head>

<body>


    <section class="search_contacts">

        <?php include 'includes/2swiftcom.php'; ?>

        <div class="main_tab">

            <div class="main">

                <div class="jnj"></div>

                <div class="top">
                    <h1>Find Contacts</h1>
                </div>

                <div class="mid">
                    <form action="_2search.php" method="POST">
                        <div class="srchdiv">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="search" name="search">
                        </div>
                        <div class="options">
                            <label for="search_contact_by">Search by</label>
                            <select name="search_contact_by">
                                <option value="name" selected>Full name</option>
                                <option value="username">Username</option>
                                <option value="email">Email</option>
                            </select>
                        </div>
                        <button name="search_btn"></button>
                    </form>
                </div>

                <div class="bottom">
                    <div class="results">

                        <img class="initial" src="images/searching.svg" alt="">

                        <?php // for searching
                        if (isset($_POST['search_btn'])):
                            
                            unset($_POST['search_btn']);
                            $search = trim($_POST['search']);
                            $methodby = $_POST['search_contact_by'];
                            
                            if ($methodby == "username"){
                                $sql = "SELECT * FROM `users` WHERE `user_username` LIKE '%$search%'";
                                $search_results = mysqli_query($conn, $sql);
                            }
                            else if ($methodby == "email"){
                                $sql = "SELECT * FROM `users` WHERE `user_email` LIKE '%$search%'";
                                $search_results = mysqli_query($conn, $sql);
                            }
                            else {
                                $sql = "SELECT * FROM `users` WHERE `user_fullname` LIKE '%$search%'";
                                $search_results = mysqli_query($conn, $sql);
                            }
                            
                        ?>

                        <?php if (mysqli_num_rows($search_results) < 1 ): ?>
                        <script>
                        document.querySelector(".initial").style.display = "none";
                        </script>
                        <div class="nothing_found">
                            <span>No results found</span>
                            <a href="#">
                                <p>Invite a friend →</p>
                            </a>
                        </div>
                        <?php endif; ?>


                        <?php foreach($search_results as $search_result): ?>
                        <script>
                        document.querySelector(".initial").style.display = "none";
                        </script>
                        <div class="search_result">
                            <div class="left">
                                <img src="user_images/profiles/<?php echo $search_result['profile_pic'];?>">
                            </div>
                            <div class="right">
                                <div class="info">
                                    <div class="inner-info">
                                        <h1><?php echo $search_result['user_fullname']; ?></h1>
                                        <h2>@<?php echo $search_result['user_username']; ?></h2>
                                        <input class="contact_id" type="hidden"
                                            value="<?php echo $search_result['user_id']; ?>">
                                    </div>

                                    <?php if (in_array($search_result['user_id'], $array_contacts)):?>
                                    <button class="addbtn added">Added</button>
                                    <?php elseif (in_array($search_result['user_id'], $array_blocked)): ?>
                                    <button class="blockedbtn"
                                        value="<?php echo $search_result['user_id']; ?>">Blocked</button>
                                    <?php else: ?>
                                    <button class="addbtn add"
                                        value="<?php echo $search_result['user_id']; ?>">Add</button>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>

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
    // adding new contact
    $(".addbtn").click(function() {
        var contact_id = $(this).val();
        $.post("_2search.php", {
            newContact: contact_id
        });

        $(this).removeClass('add')
        $(this).text('Added !')
        $(this).addClass('added')
    });


    // unblocking contact
    $(".blockedbtn").click(function() {

        var confrim_unblock = confirm("Are you sure you want to unblock this contact?");

        if (confrim_unblock === true) {
            var contact_id = $(this).val();
            $.post("_3chat.php", {
                unblock: contact_id
            });

            $(this).removeClass('blockedbtn')
            $(this).text('Unblocked !')
            $(this).addClass('added')
        }
    });



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
    document.addEventListener("DOMContentLoaded", function() {

        gsap.from(".main", {
            scale: 1.2,
            duration: 0.3
        })
        gsap.from(".search_result", {
            y: 100,
            stagger: 0.05,
            ease: "power2.inOut"
        })
    });
    </script>
</body>

</html>