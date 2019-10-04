<?php
    require("database.php");
    $username = base64_decode($_POST["username"]);
    $password = md5(base64_decode($_POST["password"]));

    $check_username = "SELECT username FROM users WHERE username = '$username'";

    $response = $db->query($check_username);

    if($response->num_rows != 0){
        $check_password = "SELECT username, user_password FROM users WHERE username = '$username' AND user_password = '$password'";
        $response_password = $db->query($check_password);
        if($response_password->num_rows != 0){
            $check_status = "SELECT status FROM users WHERE username = '$username' AND user_password = '$password' AND status = 'active'";
            $response_status = $db->query($check_status);
            if($response_status->num_rows != 0){
                echo "Login success";
            }
            else{
                echo "Login pending";
            }
        }else{
            echo "Wrong password";
        }
    }
    else{
        echo "User not found!";
    }
?>