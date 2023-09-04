<?php

include 'connect.php';

// for images---------------------------------

if (isset($_FILES['image'])){

    if (!in_array($_POST['rec_id'], $array_blocked)){
        
        $sender_name = $_POST['sender_name'];
        $rec_name = $_POST['rec_name'];

        $allowed_img = array('gif', 'png', 'jpg', 'jpeg', 'svg');
        $allowed_vid = array('mp4', 'mov', 'wmv', 'avi');
        $allowed_voice = array('mp4a', '3ga', 'mp3', 'flac', 'wav', 'aac', 'wma', 'm4a', 'aa', 'aax', 'webm');

        
        if (!empty($_FILES['image']['name'])){

            $filename = $_FILES['image']['name'];
            $checkextension = pathinfo($filename, PATHINFO_EXTENSION);
            
            if ($_FILES['image']['size'] <= 30000000){

                if (in_array($checkextension, $allowed_vid)) {

                    $image_name = 'SwiftCom' . '_' . time() . '_' . $_FILES['image']['name'];
                    $destination = ("../user_images/chat/" . $image_name);
                    $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                
                    if ($result){
                        $_POST['image'] = $image_name;
                        $img_upload = $_POST['image'];
                        
                        $sql = "INSERT INTO `chats` (`timed`, `sender_username`, `receiver_username`, `textmsg`, `read_status`, `is_img`) VALUES (current_timestamp(), '$sender_name', '$rec_name', '$img_upload', 0, 2);";
                        mysqli_query($conn, $sql);
                        mysqli_close($conn);
                        
                        echo "Video has ben send";
                        
                    } else {
                        echo "error occured while sending video";
                    }        
                    
                    

                } elseif (in_array($checkextension, $allowed_voice)) {
                    
                    $image_name = 'SwiftCom' . '_' . time() . '_' . $_FILES['image']['name'];
                    $destination = ("../user_images/chat/" . $image_name);
                    $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                
                    if ($result){
                        $_POST['image'] = $image_name;
                        $img_upload = $_POST['image'];
                        
                        $sql = "INSERT INTO `chats` (`timed`, `sender_username`, `receiver_username`, `textmsg`, `read_status`, `is_img`) VALUES (current_timestamp(), '$sender_name', '$rec_name', '$img_upload', 0, 4);";
                        mysqli_query($conn, $sql);
                        mysqli_close($conn);
                        
                        echo "audio has ben send";
                        
                    } else {
                        echo "error occured while sending audio";
                    } 
                    

                } elseif (in_array($checkextension, $allowed_img)) {

                    $image_name = 'SwiftCom' . '_' . time() . '_' . $_FILES['image']['name'];
                    $destination = ("../user_images/chat/" . $image_name);
                    $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                
                    if ($result){
                        $_POST['image'] = $image_name;
                        $img_upload = $_POST['image'];
                        
                        $sql = "INSERT INTO `chats` (`timed`, `sender_username`, `receiver_username`, `textmsg`, `read_status`, `is_img`) VALUES (current_timestamp(), '$sender_name', '$rec_name', '$img_upload', 0, 1);";
                        mysqli_query($conn, $sql);
                        mysqli_close($conn);
                        
                        echo "Image send";
                        
                    } else {
                        echo "Error occured while sending image";
                    }    
                
                } else {

                    $image_name = 'SwiftCom' . '_' . time() . '_' . $_FILES['image']['name'];
                    $destination = ("../user_images/chat/" . $image_name);
                    $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                
                    if ($result){
                        $_POST['image'] = $image_name;
                        $img_upload = $_POST['image'];
                        
                        $sql = "INSERT INTO `chats` (`timed`, `sender_username`, `receiver_username`, `textmsg`, `read_status`, `is_img`) VALUES (current_timestamp(), '$sender_name', '$rec_name', '$img_upload', 0, 3);";
                        mysqli_query($conn, $sql);
                        mysqli_close($conn);
                        
                        echo "file sent";
                        
                    } else {
                        echo "error occured while sending file";
                    } 
                    
                }
                
            } else {

                echo "file must be less than 30mb";
                // echo '<script>alert("file must be less than 30mb")</script>'; 
            }
            
        } else {
            echo "error occured; none";
        }
    }
}



?>