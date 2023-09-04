<?php
 
session_start();
$username_session = $_SESSION['username'];


// checking if session exists
if (empty($_SESSION['username'])){
    header('location: '.BASE.'/_1login.php');
    exit(0);
}

// disconnet session if user closes tab
if (isset($_POST['end'])){
    $status_sql = "UPDATE `users` SET user_status='offline' WHERE `user_id`=$logged_user_id";
    mysqli_query($conn, $status_sql);
}

// reconnet session if user open tab
if (isset($_POST['started'])){
    $status_sql = "UPDATE `users` SET user_status='online' WHERE `user_id`=$logged_user_id";
    mysqli_query($conn, $status_sql);
}




// ---------------------------------------fetch user info---------------------------------------
$sql = "SELECT * FROM `users` WHERE `user_username` = '$username_session'";
$result = mysqli_query($conn,$sql);
$userdetails = mysqli_fetch_assoc($result);

$logged_user_id = $userdetails['user_id'];
$logged_username = $userdetails['user_username'];
$logged_fullname = $userdetails['user_fullname'];
$logged_email = $userdetails['user_email'];

// array of contacts list
$logged_usercontacts = trim($userdetails['user_contacts']);
$array_contacts = explode(" ", $logged_usercontacts);

// array of blocked contacts list
$logged_userblocked = trim($userdetails['blocked_contacts']);
$array_blocked = explode(" ", $logged_userblocked);



// ---------------------------------------Delete chat automatically---------------------------------------
$sql_delete = "DELETE FROM chats WHERE timed < NOW() -  INTERVAL 1 HOUR";
mysqli_query($conn,$sql_delete);




// ---------------------------------------Delete files automatically---------------------------------------
$files_to_del = glob(BASE.'/user_images/chat/*'); 
foreach($files_to_del as $file_del){ 
    if(is_file($file_del)) {
        if ((time()-filectime($file_del)) > 3600) {  // in seconds
            unlink($file_del);
        }
    }
}
?>