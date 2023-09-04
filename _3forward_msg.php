<?php 
        
    require '_0path.php';
    require ROOTPATH.'/includes/permanent.php';
    require ROOTPATH.'/includes/functions.php';
        

    $chatArray = array();
    
    if (isset($_GET['chatid'])){
        
        $forward_msgs = array();
        $forward_msgs = $_GET['chatid'];
        
        foreach($forward_msgs as $forward_msg){
            
            $sql_get = "SELECT * FROM `chats` WHERE chat_id=$forward_msg";
            $chat = mysqli_query($conn, $sql_get);

            if (mysqli_num_rows($chat)>0){
                $chat = mysqli_fetch_assoc($chat);
                $chat = $chat['textmsg'];

                array_push($chatArray, $chat);
            }
            
        }
        
    }

    // checking if any messages are set
    if (!isset($forward_msgs)){
        header('location: '.BASE.'/index.php');
        exit(0);
    }


?>


<?php include 'includes/1tagsnlinks.php'; ?>
<link rel="stylesheet" href="styles/forward.css?<?php echo time(); ?>">
<title>SwfitCom | Forward Message</title>

</head>

<body>


    <section class="contacts_screen">

        <?php include 'includes/2swiftcom.php'; ?>

        <div class="main_tab">
            <div class="main">

                <div class="top">
                    <i class="fas fa-chevron-left"></i>
                    <h1>Forward To</h1>
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
                    ?>
                    <div class="contact" id="<?php echo $get_contact['user_username']; ?>"
                        value="<?php echo $get_contact['user_id']; ?>">
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
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>


                    <button class="forwardbtn">Send</button>
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


    // highlighting the contacts
    var contact_details = []
    var contact_detail

    $('.mid').on('click', '.contact', function() {

        $(this).toggleClass("highlight")

        if ($(this).is(".highlight")) {

            $(".forwardbtn").show(200)

        } else {
            $(".forwardbtn").hide(200)
        }


        // making objects
        contact_detail = {
            id: $(this).attr('value'),
            username: $(this).attr('id')
        }

        if ($(this).is(".highlight")) {

            if (!contact_details.includes(contact_details)) {
                contact_details.push(contact_detail)
            }

        } else {

            const remove_detail = contact_details.indexOf(contact_detail);
            if (remove_detail > -1) {
                contact_details.splice(remove_detail, 1);
            }
        }

    })


    // to forward messages
    $(".forwardbtn").click(function() {

        contact_details.forEach(function(person) {
            "<?php foreach($chatArray as $tofwdchat): ?>"

            // if it is any image or file
            if ((("<?php echo $tofwdchat; ?>").substr(0, 9)) == "SwiftCom_") {

                $.post("_3forward_msg.php", {
                    file_msg: "<?php echo $tofwdchat; ?>",
                    sender: "<?php echo $userdetails['user_username']; ?>",
                    receiver: person.username,
                    receiverid: person.id
                })
                $.post("index.php", {
                    reindex_receiver: person.id
                })

            } else if ((("<?php echo $tofwdchat; ?>").substr(0, 5)) == "blob:") { //voicemsg

                $.post("_3forward_msg.php", {
                    voice_msg: "<?php echo $tofwdchat; ?>",
                    sender: "<?php echo $userdetails['user_username']; ?>",
                    receiver: person.username,
                    receiverid: person.id
                })
                $.post("index.php", {
                    reindex_receiver: person.id
                })

            } else { // if it is any text

                $.post("_3forward_msg.php", {
                    text_msg: "<?php echo $tofwdchat; ?>",
                    sender: "<?php echo $userdetails['user_username']; ?>",
                    receiver: person.username,
                    receiverid: person.id
                })
                $.post("index.php", {
                    reindex_receiver: person.id
                })

            }

            "<?php endforeach; ?>"
        })
        window.location.href = "index.php"
    })
    </script>
</body>

</html>