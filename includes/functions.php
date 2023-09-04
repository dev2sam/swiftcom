<?php

// ---------------------------------------Get ID info---------------------------------------
function getIdDetails($contact_id){

    global $conn;
    global $sql_contact;
    global $result_contact;
    global $contacts_array;
    global $list_contacts;
    global $contact_blocked;
    global $list_blocked;

    
    $sql_contact = "SELECT * FROM `users` WHERE `user_id`= $contact_id";

    if ($result_contact = mysqli_query($conn, $sql_contact)){
        
        $result_contact = mysqli_fetch_assoc($result_contact);
        
        // array of contacts list
        $contacts_array= trim($result_contact['user_contacts']);
        $list_contacts = explode(" ", $contacts_array);
        
        // array of blocked contacts list
        $contact_blocked = trim($result_contact['blocked_contacts']);
        $list_blocked = explode(" ", $contact_blocked);
    }    
}


// ---------------------------------------Get username info---------------------------------------
function getUsernameInfo($contact_username){

    global $conn;
    global $sql_info;
    global $info;
    global $contacts_list;
    global $array_contacts;
    global $contacts_blocked;
    global $array_blocked;

    
    $sql_info = "SELECT * FROM `users` WHERE `user_username`= '$contact_username'";

    if ($info = mysqli_query($conn, $sql_info)){
        
        $info = mysqli_fetch_assoc($info);

        // array of contacts list
        $contacts_list= trim($info['user_contacts']);
        $array_contacts = explode(" ", $contacts_list);
        
        // array of blocked contacts list
        $contacts_blocked = trim($info['blocked_contacts']);
        $array_blocked = explode(" ", $contacts_blocked);
    }
}



// ---------------------------------------for deleting contact---------------------------------------
if (isset($_POST['delete_user'])){

    $to_delete = $_POST['delete_user'];
    
    if (($del_val = array_search($to_delete, $array_contacts)) !== false) {
        unset($array_contacts[$del_val]);
    }

    $array_contacts = implode(" ", $array_contacts);
    $sql3 = "UPDATE `users` SET `user_contacts`='$array_contacts' WHERE `user_id`=$logged_user_id";
    mysqli_query($conn, $sql3);
        
    ob_start();
    header('Location: '.BASE.'/index.php');
    ob_end_flush();
    exit(0);
}



// ---------------------------------------for blocking contact---------------------------------------
if (isset($_POST['to_block'])){
        
    //block
    $to_block = $_POST['to_block'];
    if (!in_array($_POST['to_block'], $array_blocked)){
        $logged_userblocked = $logged_userblocked .' '. $to_block;
        $sql_block = "UPDATE `users` SET `blocked_contacts`='$logged_userblocked' WHERE `user_id`=$logged_user_id";
        mysqli_query($conn, $sql_block);
    }

    // delete from contacts
    if (($block_val = array_search($to_block, $array_contacts)) !== false) {
        unset($array_contacts[$block_val]);
    }
    $array_contacts = implode(" ", $array_contacts);
    $sql3 = "UPDATE `users` SET `user_contacts`='$array_contacts' WHERE `user_id`=$logged_user_id";
    mysqli_query($conn, $sql3);
    
        
    ob_start();
    header('Location: '.BASE.'/index.php');
    ob_end_flush();
    exit(0);
}


//  ---------------------------------------Unblocking contact---------------------------------------
if (isset($_POST['unblock'])){

    $to_unblock = $_POST['unblock'];

    if (($unblock_val = array_search($to_unblock, $array_blocked)) !== false) {
        unset($array_blocked[$unblock_val]);
    }

    $array_blocked = implode(" ", $array_blocked);
    $sql_unblock = "UPDATE `users` SET `blocked_contacts`='$array_blocked' WHERE `user_id`=$logged_user_id";
    mysqli_query($conn, $sql_unblock);

    
    // adding contact
    if (!in_array($_POST['unblock'], $array_contacts)){
        $logged_usercontacts = $logged_usercontacts .' '. $_POST['unblock'];
        $sql2 = "UPDATE `users` SET `user_contacts`='$logged_usercontacts' WHERE `user_id`=$logged_user_id";
        mysqli_query($conn, $sql2);
        mysqli_close();
    }
}


// ---------------------------------------Deleting messages from database---------------------------------------
if (isset($_POST['delete_messages'])){

    $messages_del = array();
    $messages_del = $_POST['delete_messages'];
   
    foreach($messages_del as $msg_del){
        
        $chat_del = "DELETE FROM `chats` WHERE chat_id=$msg_del";
        mysqli_query($conn, $chat_del);
        mysqli_close();
    }
    
}


// ---------------------------------------inserting message to database---------------------------------------
if (isset($_POST['text_msg'])){

    
    if (!in_array($_POST['receiverid'], $array_blocked)){
        $text_msg = $_POST['text_msg'];
        $sender = $_POST['sender'];
        $receiver = $_POST['receiver'];

        $sql = "INSERT INTO `chats` (`timed`, `sender_username`, `receiver_username`, `textmsg`, `read_status`, `is_img`) VALUES (current_timestamp(), '$sender', '$receiver', '$text_msg', 0, 0);";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    }
}


// ---------------------------------------inserting file message (forwared) to database---------------------------------------
if (isset($_POST['file_msg'])){
    
    if (!in_array($_POST['receiverid'], $array_blocked)){
        $text_msg = $_POST['file_msg'];
        $sender = $_POST['sender'];
        $receiver = $_POST['receiver'];

        $sql = "INSERT INTO `chats` (`timed`, `sender_username`, `receiver_username`, `textmsg`, `read_status`, `is_img`) VALUES (current_timestamp(), '$sender', '$receiver', '$text_msg', 0, 3);";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    }
}


// ---------------------------------------inserting voice message to database---------------------------------------
if (isset($_POST['voice_msg'])){

    if (!in_array($_POST['receiverid'], $array_blocked)){
        $voice_msg = $_POST['voice_msg'];
        $sender = $_POST['sender'];
        $receiver = $_POST['receiver'];
        
        $sql = "INSERT INTO `chats` (`timed`, `sender_username`, `receiver_username`, `textmsg`, `read_status`, `is_img`) VALUES (current_timestamp(), '$sender', '$receiver', '$voice_msg', 0, 6);";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    }

}



// ---------------------------------------Re-indexing it so it appears on top---------------------------------------
if (isset($_POST['reindex_receiver'])){

    getIdDetails($_POST['reindex_receiver']);
    
    if ((!in_array($_POST['reindex_receiver'], $array_blocked)) && (!in_array($logged_user_id, $list_blocked))){

        $reindex_sender = $logged_user_id;
        $reindex_receiver = $_POST['reindex_receiver'];

        // reindexing logged user
        $reindex_key_in_array = array_search($reindex_receiver,$array_contacts);
        unset($array_contacts[$reindex_key_in_array]);
        array_unshift($array_contacts,$reindex_receiver);
        $array_contacts = implode(" ", $array_contacts);
        
        $sql_reindex_me = "UPDATE `users` SET `user_contacts`='$array_contacts' WHERE `user_id`=$logged_user_id";
        mysqli_query($conn, $sql_reindex_me);


        // reindexing the contact
        $get_contact = "SELECT * FROM `users` WHERE `user_id` = '$reindex_receiver'";
        $result_contact = mysqli_query($conn,$get_contact);
        $contactdetails = mysqli_fetch_assoc($result_contact);
        
        $contact_usercontacts = trim($contactdetails['user_contacts']);
        $arra_contacts2 = explode(" ", $contact_usercontacts);
    
        $reindex_key_in_array2 = array_search($reindex_sender,$arra_contacts2);
        unset($arra_contacts2[$reindex_key_in_array2]);
        array_unshift($arra_contacts2,$reindex_sender);    
        $arra_contacts2 = implode(" ", $arra_contacts2);
        
        $sql_reindex_contact = "UPDATE `users` SET `user_contacts`='$arra_contacts2' WHERE `user_id`=$reindex_receiver";
        mysqli_query($conn, $sql_reindex_contact);

    }
}


// ---------------------------------------logging out user---------------------------------------
if (isset($_POST['logout'])){
        
    $status_sql = "UPDATE `users` SET user_status='offline' WHERE `user_id`=$logged_user_id";
    mysqli_query($conn, $status_sql);

    header('location: '.BASE.'/_1login.php');
    unset($_SESSION['username']);
    session_destroy();
    exit(0);
}

    
// ---------------------------------------for adding contact---------------------------------------
if (isset($_POST['newContact'])){
    if (!in_array($_POST['newContact'], $array_contacts)){
        $logged_usercontacts = $logged_usercontacts .' '. $_POST['newContact'];
        $sql2 = "UPDATE `users` SET `user_contacts`='$logged_usercontacts' WHERE `user_id`=$logged_user_id";
        mysqli_query($conn, $sql2);
        mysqli_close();
    }
}



// ---------------------------------------Delete account---------------------------------------
if (isset($_POST['delete'])){

    $pass = password_verify($_POST['delete'], $userdetails['user_password']);

    if ($pass === true){

        $existing2 = $userdetails['profile_pic'];
        if ($existing2 !== "user.png"){
            unlink(ROOTPATH."/user_images/profiles/".$existing2);
        }

        $del_sql = "DELETE FROM `users` WHERE user_username='$username_session'";
        mysqli_query($conn, $del_sql);

        unset($_SESSION['username']);
        session_destroy();
        header('Location: '.BASE.'/index.php');
        exit(0);
        
    } else {
        echo '<script type="text/javascript">alert("Password does not match, please try again");</script>';
    }
}



// ---------------------------------------Setting the profile picture---------------------------------------
if (isset($_FILES['profile_pic'])){

    $username = $_POST['profile_user'];

    if (!empty($_FILES['profile_pic']['name'])){

        $filename = $_FILES['profile_pic']['name'];
        $checkextension = pathinfo($filename, PATHINFO_EXTENSION);

        $image_name = 'SwiftCom' . '_' . $username . time() . '_' . $_FILES['profile_pic']['name'];
        $destination = (ROOTPATH."/user_images/profiles/" . $image_name);

        $result = move_uploaded_file($_FILES['profile_pic']['tmp_name'], $destination);

            
        if ($result){
            
            $_POST['profile_pic'] = $image_name;
            $img_upload = $_POST['profile_pic'];

            // delete old one
            $existing = $userdetails['profile_pic'];
            if ($existing !== "user.png"){
                unlink(ROOTPATH."/user_images/profiles/".$existing);
            }

            //add new one
            $sql_upload = "UPDATE `users` SET profile_pic='$image_name' WHERE user_username='$username'";
            mysqli_query($conn, $sql_upload);
            mysqli_close($conn);
        

            // ----------------resizing image--------------------
            $img_name =  ROOTPATH.'/user_images/profiles/'.$image_name;
            $img_extension = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_extension = strtoupper($img_extension);
            if ($img_extension == 'JPG' || $img_extension == 'JPEG'){
                $img = imagecreatefromjpeg($img_name);
            } 
            else if ($img_extension == 'PNG'){
                $img = imagecreatefrompng($img_name);
            }
            $ratio = 150 / imagesx($img);
            $height = imagesy($img) * $ratio;
            $new_image = imagecreatetruecolor(150, $height);
            imagecopyresampled($new_image, $img, 0, 0, 0, 0, 150, $height, imagesx($img), imagesy($img));
            $img = $new_image;
            imagejpeg($img, ROOTPATH.'/user_images/profiles/'.$image_name);
            // ----------------resizing image--------------------
            

            header('Location: profile.php');
            
        } else {
            echo '<script>alert("error occured")</script>';
        }    
            
    } else {
        echo '<script>alert("error occured")</script>';
    }
}



// ---------------------------------------Changing Password---------------------------------------
if (isset($_POST['sub_change_pass'])){

    unset($_POST['sub_change_pass']);

    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $conf_pass = $_POST['conf_pass'];

    if (password_verify($old_pass, $userdetails['user_password'])){

        if ($new_pass === $conf_pass){

            $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
            $sql_change_pass = "UPDATE `users` SET `user_password`='$new_pass' WHERE `user_username`='$username_session'";

            if (mysqli_query($conn, $sql_change_pass)){

                echo '<script>alert("Password updated successfully")</script>';
                mysqli_close($conn);
                
            } else {
                echo '<script>alert("Error occured")</script>';
            }

        } else {
            echo '<script>alert("New password and confirm password does not match")</script>';
        }
        
    } else {
        echo '<script>alert("You entered incorrect old password")</script>';
    }
}


// ---------------------------------------Forgot Password---------------------------------------
if (isset($_POST['sub_forgot_pass1'])){

    unset($_POST['sub_forgot_pass1']);
    $email_forgot = $_POST['email_forgot'];

    $sql_check = "SELECT * FROM `users` WHERE `user_email`='$email_forgot'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0){
        
        $result_check = mysqli_fetch_assoc($result_check);
        
        $f_fullname = $result_check['user_fullname'];
        $f_email = $result_check['user_email'];
        $f_username = $result_check['user_username'];

        // generating random
        $ingredients = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*';
        $randarray = array();
        $ingredientslen = strlen($ingredients) - 1;
        for ($i = 0; $i < 20; $i++) {
            $n = rand(0, $ingredientslen);
            $pass_link[] = $ingredients[$n];
        }
        $randomnumber = implode($pass_link);

        // setting random number to database
        $sql_random = "UPDATE `users` SET `password_reset`='$randomnumber' WHERE `user_username`='$f_email'";
        mysqli_query($conn, $sql_random);
        mysqli_close($conn);
        
        $emailmsg = "This email has been sent to you by SwiftCom forget password service. If you did not made such kind of request, we recommend you to login at your SwiftCom account and change the password, in case of any privacy and security concerns.\n If you made such request, you may click the link below in order to reset your password. Granted that these are your account details:\n Full Name: $f_fullname\n Username: $f_username\n Email: $f_email \n\n <a href='".BASE."/_2settings/passwordreset.php?pass_key=".$randomnumber."'>Click here to change password</a>";


        $headers = "From: swifttcom@gmail.com" . "\r\n" . "Reply-To: swifttcom@gmail.com";
        
        // $emailmsg = wordwrap($emailmsg, 70);
        // $headers = "MIME-Version: 1.0" . "\r\n";
        // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        mail($result_check['user_email'], 'SwiftCom | Forget Password', $emailmsg, $headers);        

        echo '<script>alert("A link has been sent to your email, you may follow it to reset your password")</script>';
        
    } else {
        echo '<script>alert("This email does not exist")</script>';
    }
    
}
if (isset($_POST['sub_forgot_pass2'])){

    unset($_POST['sub_forgot_pass2']);
    $username_forgot = $_POST['username_forgot'];

    $sql_check = "SELECT * FROM `users` WHERE `user_username`='$username_forgot'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0){
        
        $result_check = mysqli_fetch_assoc($result_check);
        
        $f_fullname = $result_check['user_fullname'];
        $f_email = $result_check['user_email'];
        $f_username = $result_check['user_username'];

        // generating random
        $ingredients = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*';
        $randarray = array();
        $ingredientslen = strlen($ingredients) - 1;
        for ($i = 0; $i < 20; $i++) {
            $n = rand(0, $ingredientslen);
            $pass_key[] = $ingredients[$n];
        }
        $randomnumber = implode($pass_key);

        // setting random number to database 
        $sql_random = "UPDATE `users` SET `password_reset`='$randomnumber' WHERE `user_username`='$f_email'";
        mysqli_query($conn, $sql_random);
        mysqli_close($conn);
        
        $emailmsg = "This email has been sent to you by SwiftCom forget password service. If you did not made such kind of request, we recommend you to login at your SwiftCom account and change the password, in case of any privacy and security concerns.\n If you made such request, you may click the link below in order to reset your password. Granted that these are your account details:\n Full Name: $f_fullname\n Username: $f_username\n Email: $f_email \n\n <a href='".BASE."/_2settings/passwordreset.php?pass_key=".$randomnumber."'>Click here to change password</a>";

        $headers = "From: swifttcom@gmail.com" . "\r\n" . "Reply-To: swifttcom@gmail.com";
        
        // $emailmsg = wordwrap($emailmsg, 70);
        // $headers = "MIME-Version: 1.0" . "\r\n";
        // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        mail($result_check['user_email'], 'SwiftCom | Forget Password', $emailmsg, $headers);        

        echo '<script>alert("A link has been sent to your email, you may follow it to reset your password")</script>';
        
    } else {
        echo '<script>alert("This username does not exist")</script>';
    } 
}

// ---------------------------------------Reseting password, after forgot password---------------------------------------
if (isset($_POST['reset_pass_btn'])){

    unset($_POST['reset_pass_btn']);

    $new_r_pass = $_POST['reset_password'];
    $new_cr_pass = $_POST['conf_reset_password'];
    $pass_keyy = $_POST['pass_keyy'];

    if ($new_r_pass === $new_cr_pass){

        $new_r_pass = password_hash($new_r_pass, PASSWORD_DEFAULT);
        $sql_reset_pass = "UPDATE `users` SET `user_password`='$new_r_pass' WHERE `password_reset`='$pass_keyy'";

        if (mysqli_query($conn, $sql_reset_pass)){

            echo '<script>alert("Password updated successfully")</script>';
            mysqli_close($conn);
            header('location: '.BASE.'/_1login.php');
            exit(0);
            
        } else {
            echo '<script>alert("Error occured")</script>';
        }

    } else {
        echo '<script>alert("New password and confirm password does not match")</script>';
    }
}


?>