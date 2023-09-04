<?php

    require '../_0path.php'; 
    require 'connect.php';
    require ROOTPATH.'/includes/functions.php';

    session_start();
    $username_session = $_SESSION['username'];
    $me_id = $username_session;


    
    function flagMsgSender($chat_id){

        global $conn;
        global $status_flag;
        
        $status_flag = "UPDATE chats SET senderflag=1 WHERE chat_id=". $chat_id;
        mysqli_query($conn, $status_flag);
    }
    
  
    function flagMsgReceiver($chat_id){

        global $conn;
        global $status_flag;
        
        $status_flag = "UPDATE chats SET receiverflag=1 WHERE chat_id=". $chat_id;
        mysqli_query($conn, $status_flag);
    }


    
    $res = "";
    
    getUsernameInfo($username_session);

    if (isset($_POST['sender_id'])){

        $get_sender = $_POST['sender_id'];
        $get_receiver = $_POST['receiver_id'];
        $get_receiverid = $_POST['receiver_idid'];

        if (!in_array($get_receiverid, $array_blocked)){
            
            $sql_extract_msg = "SELECT * FROM `chats` WHERE `sender_username`= '$get_sender' AND `receiver_username`= '$get_receiver' OR `receiver_username`= '$get_sender' AND `sender_username`= '$get_receiver'";
            $result_extract_msg = mysqli_query($conn, $sql_extract_msg);
            
            
            if (mysqli_num_rows($result_extract_msg) > 0){
                
                while ($get_msg = mysqli_fetch_assoc($result_extract_msg))
                {

                    if ($get_msg["is_img"] == 1){    //if it is an image

                        if ($me_id == $get_msg['sender_username']){

                            if ($get_msg['senderflag'] == 0){
                            
                                $res = $res . '<div class="chat me">';
                                $res = $res . '<div class="image_msg">';
                                $res = $res . '<a href="user_images/chat/' . $get_msg["textmsg"] . '" download>';
                                $res = $res . '<img src="user_images/chat/' . $get_msg["textmsg"] . '" alt="" class="image">';
                                $res = $res . '</a>';
                                if ($get_msg["read_status"] == 1){ $res = $res . '<img src="images/icons/tick.svg" alt="" class="msg_red">'; }
                                $res = $res . '</div>';
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';

                                
                                flagMsgSender($get_msg['chat_id']);
                            }
                            
                        } else {

                            if ($get_msg['receiverflag'] == 0){

                                $status_update = "UPDATE chats SET read_status=1 WHERE chat_id=". $get_msg['chat_id'];
                                mysqli_query($conn, $status_update);
                                
                                $res = $res . '<div class="chat it">';
                                $res = $res . '<div class="image_msg">';
                                $res = $res . '<a href="user_images/chat/' . $get_msg["textmsg"] . '" download>';
                                $res = $res . '<img src="user_images/chat/' . $get_msg["textmsg"] . '" alt="" class="image">';
                                $res = $res . '</a>';
                                $res = $res . '</div>';
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';

                              
                                flagMsgReceiver($get_msg['chat_id']);
                            }
                            
                        }
                        

                        
                    } elseif ($get_msg["is_img"] == 2) {     // if it is a video


                        if ($me_id == $get_msg['sender_username']){
                            
                            if ($get_msg['senderflag'] == 0){

                                $res = $res . '<div class="chat me">';
                                $res = $res . '<div class="file_msg">';
                                $res = $res . '<a href="user_images/chat/' . $get_msg["textmsg"] . '" download>';
                                $res = $res . '<div class="file">';
                                $res = $res . '<img src="images/icons/pause.svg" alt="">';
                                $res = $res . '<h5>'.$get_msg["textmsg"].'</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</a>';
                                if ($get_msg["read_status"] == 1){ $res = $res . '<img src="images/icons/tick.svg" alt="" class="msg_red">'; }
                                $res = $res . '</div>';
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';

                                
                                flagMsgSender($get_msg['chat_id']);
                            }
                            
                        } else {

                            if ($get_msg['receiverflag'] == 0){

                                $status_update = "UPDATE chats SET read_status=1 WHERE chat_id=". $get_msg['chat_id'];
                                mysqli_query($conn, $status_update);
                                
                                $res = $res . '<div class="chat it">';
                                $res = $res . '<div class="file_msg">';
                                $res = $res . '<a href="user_images/chat/' . $get_msg["textmsg"] . '" download>';
                                $res = $res . '<div class="file">';
                                $res = $res . '<img src="images/icons/pause.svg" alt="">';
                                $res = $res . '<h5>'.$get_msg["textmsg"].'</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</a>';
                                $res = $res . '</div>';
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';

                              
                                flagMsgReceiver($get_msg['chat_id']);
                            }
                            
                        }

                        
                        
                    } elseif ($get_msg["is_img"] == 4) {     // if it is a audio file


                        if ($me_id == $get_msg['sender_username']){
                            
                            if ($get_msg['senderflag'] == 0){
                                
                                $res = $res . '<div class="chat me">';
                                $res = $res . '<div class="voice_msg">';
                                $res = $res . '<div class="voice">';
                                $res = $res . '<a href="user_images/chat/' . $get_msg["textmsg"] . '" download>';
                                $res = $res . '<audio controls>';
                                $res = $res . '<source src="user_images/chat/'.$get_msg["textmsg"].'">';
                                $res = $res . '</audio>';
                                $res = $res . '</a>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';
                                if ($get_msg["read_status"] == 1){ $res = $res . '<img src="images/icons/tick.svg" alt="" class="msg_red">'; }
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';

                                
                                flagMsgSender($get_msg['chat_id']);
                            }
                            
                        } else {

                            if ($get_msg['receiverflag'] == 0){
                                
                                $status_update = "UPDATE chats SET read_status=1 WHERE chat_id=". $get_msg['chat_id'];
                                mysqli_query($conn, $status_update);
                                
                                $res = $res . '<div class="chat it">';
                                $res = $res . '<div class="voice_msg">';
                                $res = $res . '<div class="voice">';
                                $res = $res . '<a href="user_images/chat/' . $get_msg["textmsg"] . '" download>';
                                $res = $res . '<audio controls>';
                                $res = $res . '<source src="user_images/chat/'.$get_msg["textmsg"].'">';
                                $res = $res . '</audio>';
                                $res = $res . '</a>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';

                              
                                flagMsgReceiver($get_msg['chat_id']);
                            }
                            
                        }
                        
                        
                        
                    } elseif ($get_msg["is_img"] == 6) {     // if it is a voice msg


                        if ($me_id == $get_msg['sender_username']){
                            
                            if ($get_msg['senderflag'] == 0){
                                
                                $res = $res . '<div class="chat me">';
                                $res = $res . '<div class="voice_msg">';
                                $res = $res . '<div class="voice">';
                                $res = $res . '<a href="' . $get_msg["textmsg"] . '" download>';
                                $res = $res . '<audio controls>';
                                $res = $res . '<source src="'.$get_msg["textmsg"].'">';
                                $res = $res . '</audio>';
                                $res = $res . '</a>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';
                                if ($get_msg["read_status"] == 1){ $res = $res . '<img src="images/icons/tick.svg" alt="" class="msg_red">'; }
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';

                                
                                flagMsgSender($get_msg['chat_id']);
                            }
                            
                        } else {

                            if ($get_msg['receiverflag'] == 0){
                                
                                $status_update = "UPDATE chats SET read_status=1 WHERE chat_id=". $get_msg['chat_id'];
                                mysqli_query($conn, $status_update);
                                
                                $res = $res . '<div class="chat it">';
                                $res = $res . '<div class="voice_msg">';
                                $res = $res . '<div class="voice">';
                                $res = $res . '<a href="' . $get_msg["textmsg"] . '" download>';
                                $res = $res . '<audio controls>';
                                $res = $res . '<source src="'.$get_msg["textmsg"].'">';
                                $res = $res . '</audio>';
                                $res = $res . '</a>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';

                              
                                flagMsgReceiver($get_msg['chat_id']);
                            }
                            
                        }
                        
                        
                        
                    } elseif ($get_msg["is_img"] == 5) {     // if it is a location msg


                        if ($me_id == $get_msg['sender_username']){
                            
                            if ($get_msg['senderflag'] == 0){

                                $res = $res . '<div class="chat me">';
                                $res = $res . '<div class="location_msg">';
                                $res = $res . '<div class="location">';
                                $res = $res . '<div class="openmaps">';
                                $res = $res . '<img src="images/icons/coordinates.svg" alt="">';
                                $res = $res . '<a target="_blank" href="https://maps.google.com/?q='.$get_msg["textmsg"].'">';
                                $res = $res . '<p>Open →</p>';
                                $res = $res . '</a>';
                                $res = $res . '</div>';
                                $res = $res . '<p>'.$get_msg["textmsg"].'</p>';
                                $res = $res . '</div>';
                                if ($get_msg["read_status"] == 1){ $res = $res . '<img src="images/icons/tick.svg" alt="" class="msg_red">'; }
                                $res = $res . '</div>';
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';

                                
                                flagMsgSender($get_msg['chat_id']);
                            }
                            
                            
                        } else {

                            if ($get_msg['receiverflag'] == 0){

                                $status_update = "UPDATE chats SET read_status=1 WHERE chat_id=". $get_msg['chat_id'];
                                mysqli_query($conn, $status_update);
                                
                                $res = $res . '<div class="chat it">';
                                $res = $res . '<div class="location_msg">';
                                $res = $res . '<div class="location">';
                                $res = $res . '<div class="openmaps">';
                                $res = $res . '<img src="images/icons/coordinates.svg" alt="">';
                                $res = $res . '<a target="_blank" href="https://maps.google.com/?q='.$get_msg["textmsg"].'">';
                                $res = $res . '<p>Open →</p>';
                                $res = $res . '</a>';
                                $res = $res . '</div>';
                                $res = $res . '<p>'.$get_msg["textmsg"].'</p>';
                                $res = $res . '</div>';
                                $res = $res . '<img src="images/icons/tick.svg" alt="" class="msg_red">';
                                $res = $res . '</div>';
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';

                                
                                flagMsgReceiver($get_msg['chat_id']);
                            }
                            
                        }

                        
                        
                    } elseif ($get_msg["is_img"] == 3) {     // if it is a file


                        if ($me_id == $get_msg['sender_username']){
                            
                            if ($get_msg['senderflag'] == 0){

                                $res = $res . '<div class="chat me">';
                                $res = $res . '<div class="file_msg">';
                                $res = $res . '<a href="user_images/chat/' . $get_msg["textmsg"] . '" download>';
                                $res = $res . '<div class="file">';
                                $res = $res . '<img src="images/icons/file.svg" alt="">';
                                $res = $res . '<h5>'.$get_msg["textmsg"].'</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</a>';
                                if ($get_msg["read_status"] == 1){ $res = $res . '<img src="images/icons/tick.svg" alt="" class="msg_red">'; }
                                $res = $res . '</div>';
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';
                                
                                
                                flagMsgSender($get_msg['chat_id']);
                            }
                            
                        } else {

                            if ($get_msg['receiverflag'] == 0){

                                $status_update = "UPDATE chats SET read_status=1 WHERE chat_id=". $get_msg['chat_id'];
                                mysqli_query($conn, $status_update);
                                
                                $res = $res . '<div class="chat it">';
                                $res = $res . '<div class="file_msg">';
                                $res = $res . '<a href="user_images/chat/' . $get_msg["textmsg"] . '" download>';
                                $res = $res . '<div class="file">';
                                $res = $res . '<img src="images/icons/file.svg" alt="">';
                                $res = $res . '<h5>'.$get_msg["textmsg"].'</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</a>';
                                $res = $res . '</div>';
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';

                                
                                flagMsgReceiver($get_msg['chat_id']);
                            }
                            
                        }
                        

                        
                        
                    } else {            // if it is a text msg

                        

                        if ($me_id == $get_msg['sender_username']){
                            
                            if ($get_msg['senderflag'] == 0){

                                $res = $res . '<div class="chat me">';
                                $res = $res . '<div class="text">';
                                $res = $res . '<p>' . $get_msg["textmsg"] . '</p>';
                                if ($get_msg["read_status"] == 1){ $res = $res . '<img src="images/icons/tick.svg" alt="" class="msg_red">'; }
                                $res = $res . '</div>';
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';
                                
                                
                                // echo "<script>var sendaudio = new Audio('system_audio/send.mp3')</script>";
                                // echo "<script>sendaudio.play()</script>";
                                
                                flagMsgSender($get_msg['chat_id']);

                            }

                        } else {

                            if ($get_msg['receiverflag'] == 0){
                                
                                $status_update = "UPDATE chats SET read_status=1 WHERE chat_id=". $get_msg['chat_id'];
                                mysqli_query($conn, $status_update);
                                
                                $res = $res . '<div class="chat it">';
                                $res = $res . '<div class="text">';
                                $res = $res . '<p>' . $get_msg["textmsg"] . '</p>';
                                $res = $res . '</div>';
                                $res = $res . '<div class="time">';
                                $date = new DateTime($get_msg["timed"]);
                                $res = $res . '<h5>' . $date->format('g:ia') . '</h5>';
                                $res = $res . '</div>';
                                $res = $res . '</div>';

                                // echo "<script>var recaudio = new Audio('system_audio/receive.mp3')</script>";
                                // echo "<script>recaudio.play()</script>";
                                
                                flagMsgReceiver($get_msg['chat_id']);
                                
                            }
                            
                        }
                        
                    }
                    
                }
            }

            echo $res;
            
        }
    }


?>