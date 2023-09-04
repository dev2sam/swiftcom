<?php 

require '_0path.php';
require ROOTPATH.'/includes/permanent.php';
require ROOTPATH.'/includes/functions.php';


$contact_id = $_GET['contact_id'];

// checking if contact is set
if (!isset($_GET['contact_id'])){
    header('location: '.BASE.'/index.php');
    exit(0);
}

getIdDetails($contact_id);


?>




<?php include 'includes/1tagsnlinks.php'; ?>
<title>SwfitCom | <?php echo $result_contact['user_fullname']; ?></title>
<link rel="stylesheet" href="styles/chat.css?<?php echo time(); ?>">

</head>

<body>

    <section class="chat-screen">

        <?php include 'includes/2swiftcom.php'; ?>

        <div class="main_tab">
            <div class="top">
                <div class="info">
                    <div class="img">
                        <i class="fas fa-chevron-left"></i>
                        <img src="user_images/profiles/<?php echo $result_contact['profile_pic'];?>" alt="">
                    </div>
                    <a class="identity-wrapper" href="_3contactprofile.php?contact_profile=<?php echo $contact_id; ?>">
                        <div class="identity top_bar">
                            <h1><?php echo $result_contact['user_fullname']; ?></h1>
                            <h2><?php echo $result_contact['user_status']; ?> -
                                <span>@<?php echo $result_contact['user_username']; ?></span>
                            </h2>
                        </div>
                    </a>
                </div>
                <div class="icons">
                    <div class="non_highlighted">
                        <img src="images/icons/call.svg" alt="">
                        <img src="images/icons/video call.svg" alt="">
                        <img src="images/icons/dots.svg" alt="" class="menu_trigger">
                    </div>
                    <div class="highlighted">
                        <div class="wrap">
                            <img src="images/icons/delete.svg" alt="" class="delete_msg">
                            <img src="images/icons/forward.svg" alt="" class="forward_msg">
                        </div>
                    </div>
                </div>
                <div class="top_menu">
                    <ul>
                        <li><a href="_3contactprofile.php?contact_profile=<?php echo $contact_id; ?>">View profile</a>
                        </li>
                        <li class="block_contact" value="<?php echo $result_contact['user_id']; ?>">Block contact</li>
                        <li class="delete_contact" value="<?php echo $result_contact['user_id']; ?>">Delete contact</li>
                    </ul>
                </div>
            </div>


            <div class="middle">
                <div class="wrapper chat_screen" id="chat_screen">
                    <!-- messages appear here -->
                </div>
            </div>

            <div class="menuoption">
                <div class="wrappermenu">
                    <div class="filebtn"><img src="images/icons/image.svg" alt=""></div>
                    <div class="locationbtn"><img src="images/icons/location.svg" alt=""></div>
                    <div class="speakbtn">
                        <img src="images/icons/speakmsg.svg" alt="" class="speakimg">
                        <i class="fas fa-times speakicn"></i>
                    </div>
                    <div class="filebtn"><img src="images/icons/file.svg" alt=""></div>
                    <div class="takephoto"><img src="images/icons/takephoto.svg" alt=""></div>
                    <div class="takevideo"><img src="images/icons/takevideo.svg" alt=""></div>
                </div>

                <form method="POST" enctype="multipart/form-data" class="image_form">
                    <i class="fas fa-times closebar"></i>

                    <input type="file" class="input_doc" name="image">

                    <input type="hidden" value="<?php echo $userdetails['user_username']; ?>" name="sender_name">
                    <input type="hidden" value="<?php echo $result_contact['user_username']; ?>" name="rec_name">
                    <input type="hidden" value="<?php echo $result_contact['user_id']; ?>" name="rec_id">

                    <div class="atrea">
                        <h1 class="file-name"> <span>Add files</span> </h1>
                    </div>
                    <button type="submit" value="submit" name="send_img" class="send_img">Send</button>
                </form>
            </div>

            <div class="bottom">
                <?php if(in_array($result_contact['user_id'], $array_blocked)): // if other person is in my block list?>

                <div class="input">
                    <h1 class="blocked_wraning">You have blocked this user !</h1>
                </div>

                <?php else: ?>

                <div class="input">
                    <i class="fas fa-circle-notch"></i>
                    <i class="fas fa-microphone"></i>
                    <textarea type="text" name="input_msg" class="input_msg" id="input_msg" placeholder="type message"
                        rows="1"></textarea>
                    <textarea type="text" name="input_voice" class="input_voice" id="input_voice"
                        placeholder="type message" rows="1"></textarea>
                    <i class="send_msg fas fa-paper-plane" id="send_msg"></i>
                </div>

                <?php endif; ?>
            </div>

        </div>


        <div class="toast" id="toast">
        </div>


    </section>



    <?php include 'includes/4scripts.php'; ?>


    <script>
    // to trigger the back button
    $(".fa-chevron-left").click(function() {
        // window.history.back();
        window.location.href = "index.php";
    })



    // refreshing to update status every second
    function refreshh() {
        $(".top_bar").load(" .top_bar > *");
    }
    setInterval(refreshh, 1000);



    // to submit via enter button
    var input = document.getElementById("input_msg");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("send_msg").click();
        }
    });


    // submitting message
    $(".send_msg").click(function() {
        var sendmsg = $(".input_msg").val();
        sendmsg = sendmsg.trim();

        if (sendmsg.length > 0) {
            $.post("_3chat.php", {
                text_msg: sendmsg,
                sender: "<?php echo $userdetails['user_username']; ?>",
                receiver: "<?php echo $result_contact['user_username']; ?>",
                receiverid: "<?php echo $result_contact['user_id']; ?>"
            });

            $.post("index.php", {
                reindex_receiver: "<?php echo $result_contact['user_id']; ?>"
            })

            $(".input_msg").val("");
        }

        // scrolling to bottom
        var chatScreen = document.getElementById("chat_screen");
        chatScreen.scrollTop = chatScreen.scrollHeight;
    });


    // submitting image
    $(".send_img").click(function(event) {
        event.preventDefault();
        var form = $('.image_form')[0];
        var data_img = new FormData(form);

        $(".send_img").prop("disabled", true);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "php/sendImage.php",
            data: data_img,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                console.log(data);
                $('.input_doc').val("");
                $(".send_img").prop("disabled", false);
            },
            error: function(e) {
                console.log(e);
                $(".send_img").prop("disabled", false);
            }
        });

        $.post("_3chat.php", {
            reindex_receiver: "<?php echo $result_contact['user_id']; ?>"
        });

    });


    // for sending current location
    $(".locationbtn").click(function() {
        var locationPromt = confirm("Send location?");
        if (locationPromt == true) {
            navigator.geolocation.getCurrentPosition(
                function(data) {

                    var latitude = data.coords.latitude
                    var longitude = data.coords.longitude

                    $.post("php/sendLocation.php", {
                        latitude: latitude,
                        longitude: longitude,
                        sender: "<?php echo $userdetails['user_username']; ?>",
                        receiver: "<?php echo $result_contact['user_username']; ?>",
                        receiverid: "<?php echo $result_contact['user_id']; ?>"
                    })

                    $.post("index.php", {
                        reindex_receiver: "<?php echo $result_contact['user_id']; ?>"
                    })

                },
                function(error) {
                    alert("Access denied")
                }, {
                    enableHighAccuracy: true
                }
            )
        }
        var chatScreen = document.getElementById("chat_screen");
        chatScreen.scrollTop = chatScreen.scrollHeight;
        $(".menuoption").slideToggle(200)
    })


    // blocking a contact
    $(".block_contact").click(function() {
        var confrim_block = confirm("Are you sure you want to block this contact?");
        if (confrim_block === true) {
            $.post("_3chat.php", {
                to_block: $(this).val()
            })
        }
    })


    // recording audio message
    $(".fa-microphone").click(function() {

        $(".input_msg").hide()
        $(".input_voice").show()

        $(".fa-microphone").css("background", "var(--danger)")

        //start the timer
        var sec = 0
        var min = 0
        setInterval(function() {
            sec++
            if (sec >= 60) {
                sec = 0
                min++
            }
            if (min >= 10) {
                recorder.stop()
                $(".send_msg").trigger("click");
                $(".fa-microphone").css("background", "var(--accent)")

                $(".input_msg").show()
                $(".input_voice").hide()
            }
            $(".input_voice").text(`${min}:${sec}`)
        }, 1000);


        // recording the actual audio
        var device = navigator.mediaDevices.getUserMedia({
            audio: true
        })
        var items = [];
        device.then(function(stream) {
            var recorder = new MediaRecorder(stream)
            recorder.ondataavailable = function(e) {
                items.push(e.data)
                if (recorder.state == 'inactive') {
                    var blob = new Blob(items, {
                        type: 'audio/mp4'
                    })

                    var voicemsg = URL.createObjectURL(blob)

                    $.post("_3chat.php", {
                        voice_msg: voicemsg,
                        sender: "<?php echo $userdetails['user_username']; ?>",
                        receiver: "<?php echo $result_contact['user_username']; ?>",
                        receiverid: "<?php echo $result_contact['user_id']; ?>"
                    });

                    $.post("index.php", {
                        reindex_receiver: "<?php echo $result_contact['user_id']; ?>"
                    })
                }
            }
            recorder.start(100)

            $(".send_msg").click(function() {
                $(".fa-microphone").css("background", "var(--accent)")
                recorder.stop();
                $(".input_msg").show()
                $(".input_voice").hide()
            })
        })


    })


    // deleting contact
    $(".delete_contact").click(function() {
        var confirm_delete = confirm("Are you sure, you want to delete this contact?")
        if (confirm_delete == true) {
            $.post("index.php", {
                delete_user: $(this).val()
            });
        }
    })


    // tell php to make user offline when it closes tab
    $(window).bind('unload', function() {
        $.post("_3chat.php", {
            end: "yes"
        });
    });
    $(window).bind('load', function() {
        $.post("index.php", {
            started: "yes"
        });
    });



    // for checking adding specifc gaps between it and me chat
    document.querySelectorAll(".chat").forEach(function(childelement) {
        if (childelement.classList.contains('me')) {
            if (childelement.nextElementSibling) {
                if (childelement.nextElementSibling.classList.contains('it')) {
                    childelement.style.marginBottom = "1.5em";
                }
            }
        } else if (childelement.classList.contains('it')) {
            if (childelement.nextElementSibling) {
                if (childelement.nextElementSibling.classList.contains('me')) {
                    childelement.style.marginBottom = "1.5em";

                }
            }
        }
    })


    // triggring top menu options
    $(".menu_trigger").click(function() {
        $(".top_menu ").slideToggle(200)
    })


    // for toggling the menu options capsule
    $(".fa-circle-notch").click(function() {
        $(".menuoption").slideToggle(200)
    })


    // hide the menu if clicked anywhere in middle
    $(".middle").click(function() {
        $(".menuoption").slideUp(200)
        $(".top_menu").slideUp(200)
    })


    // for togglind menus and additional options
    $(".filebtn").click(function() {
        $('.input_doc').removeAttr("accept capture");

        $(".wrappermenu").slideToggle(200)
        $(".image_form").slideToggle(200)
    })
    $(".closebar").click(function() {
        $(".wrappermenu").slideToggle(200)
        $(".image_form").slideToggle(200)
    })



    // for input files and images
    $(".atrea").click(function() {
        $(".input_doc").trigger('click');
    })
    $(".input_doc").change(function() {
        $(".file-name > span").replaceWith("<span>" + $(".input_doc").val() + "</span>")
        $(".send_img").fadeIn(100)
    })
    $(".send_img").click(function() {
        $(".file-name > span").replaceWith("<span>Add files</span>")
        $(".send_img").fadeOut(100)
    })



    // for capturing live photo
    $(".takephoto").click(function() {
        $('.input_doc').attr({
            'accept': 'image/*',
            'capture': 'user'
        });
        $(".input_doc").trigger('click');

        $(".wrappermenu").slideToggle(200)
        $(".image_form").slideToggle(200)
    })

    // for capturing live video
    $(".takevideo").click(function() {
        $('.input_doc').attr({
            'accept': 'video/*',
            'capture': 'user'
        });
        $(".input_doc").trigger('click');

        $(".wrappermenu").slideToggle(200)
        $(".image_form").slideToggle(200)
    })



    // ---------------------------------------------------------------------
    // speak message feature ------------------------------------
    $(".speakbtn").click(function() {

        $(this).toggleClass('speak')
        $(".speakimg").toggle()
        $(".speakicn").toggle()


        window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition || window
            .mozSpeechRecognition || window.msSpeechRecognition;

        const recognition = new SpeechRecognition();
        recognition.interimResults = true;
        recognition.lang = 'en-IN';

        let pText = document.createElement('p');
        const pTextp = document.getElementById('toast');
        pTextp.appendChild(pText)

        const inputwords = document.getElementById('input_msg');


        recognition.addEventListener('result', e => {
            const transcript = Array.from(e.results)
                .map(result => result[0])
                .map(result => result.transcript)
                .join('');

            const poopScript = transcript.replace(/tatti|tati|taatti|taati/gi, '💩');
            pTextp.textContent = poopScript;

            if (e.results[0].isFinal) {
                pText = document.createElement('p');
                pTextp.appendChild(pText)
                inputwords.value += (pTextp.textContent + " ");
            }
        });

        recognition.addEventListener('end', recognition.start);
        recognition.start();


        $(".speakicn").click(function(event) {
            event.preventDefault();
            recognition.abort();
        })
    })


    // ---------------------------------------------------------------------
    // extracting all messages at start
    setTimeout(() => {
        $.post("php/extract_chat.php", {
                sender_id: "<?php echo $userdetails['user_username']; ?>",
                receiver_id: "<?php echo $result_contact['user_username']; ?>",
                receiver_idid: "<?php echo $result_contact['user_id']; ?>"
            },
            function(data, status) {
                document.getElementsByClassName("chat_screen")[0].innerHTML = data;
            }
        )
    }, 100);

    // extracting message
    setInterval(() => {
        $.post("php/extract_chat_copy.php", {
                sender_id: "<?php echo $userdetails['user_username']; ?>",
                receiver_id: "<?php echo $result_contact['user_username']; ?>",
                receiver_idid: "<?php echo $result_contact['user_id']; ?>"
            },
            function(data, status) {
                $(".chat_screen").append(data)
            }
        )
    }, 400)
    // ---------------------------------------------------------------------


    // highlighting the message and stroing value in array to perform operations
    var chat_ids = []
    var chat_id;

    $('.chat_screen').on('click', '.chat', function() {

        $(this).toggleClass("highlight")

        if ($(this).is(".highlight")) {

            $(".non_highlighted").slideUp(200)
            $(".highlighted").slideDown(200)

        } else {
            $(".non_highlighted").slideDown(200)
            $(".highlighted").slideUp(200)
        }

        chat_id = $(this).attr('id')
        if ($(this).is(".highlight")) {

            if (!chat_ids.includes(chat_id)) {
                chat_ids.push(chat_id)
            }

        } else {
            const remove_index = chat_ids.indexOf(chat_id);
            if (remove_index > -1) {
                chat_ids.splice(remove_index, 1);
            }
        }

    })

    // Forward a message
    $(".forward_msg").click(function() {

        var forward_url = '?';
        chat_ids.forEach(function(id_forward) {
            forward_url += ("chatid[]=" + id_forward + "&")
        })

        forward_url = forward_url.substr(0, forward_url.length - 1)
        window.location.href = "_3forward_msg.php" + forward_url;
    })

    // Delete a message
    $(".delete_msg").click(function() {

        var confrim_del_chat = confirm("This message will be deleted");
        if (confrim_del_chat === true) {
            $.post("_3chat.php", {
                delete_messages: chat_ids
            })
            location.reload();
        }
    })
    </script>
</body>

</html>