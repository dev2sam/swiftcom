<?php

include 'connect.php';

// for sending location
if (isset($_POST['latitude'])){
        
    if (!in_array($_POST['receiverid'], $array_blocked)){
    
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $sender = $_POST['sender'];
        $receiver = $_POST['receiver'];

        $coordinates = ($latitude .", ". $longitude);
        
        $sql = "INSERT INTO `chats` (`timed`, `sender_username`, `receiver_username`, `textmsg`, `read_status`, `is_img`) VALUES (current_timestamp(), '$sender', '$receiver', '$coordinates', 0, 5);";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    
    }

} 


?>